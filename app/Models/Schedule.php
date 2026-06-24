<?php

namespace App\Models;

use App\Traits\Core\Common\DateAndTimeTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class Schedule extends Model
{
    use HasFactory, SoftDeletes, DateAndTimeTrait;

    public const STATE_NOT_PUBLISHED = 'not_published';
    public const STATE_PUBLISHED = 'published';

    protected $fillable = [
        'year',
        'month',
        'name_fr',
        'name_ar',
        'name_en',
        'description_fr',
        'description_ar',
        'description_en',
        'state',
        'service_id',
        'opened_by',
        'days_off',
        'working_days',
        'working_periods',
        'appointments_locations',
        'appointment_duration',
        'locked',
    ];

    protected $casts = [
        'year' => 'integer',
        'month' => 'integer',
        'days_off' => 'array',
        'working_days' => 'array',
        'working_periods' => 'array',
        'appointments_locations' => 'array',
        'locked' => 'boolean',
    ];


 protected $attributes = [
        'appointment_duration' => 30,
        'locked' => false,
    ];
    protected static function booted()
    {
        static::creating(function ($schedule) {

            $schedule->state ??= self::STATE_NOT_PUBLISHED;

            $schedule->working_days ??= [0, 1, 2, 3, 4];
            $schedule->days_off ??= [];
            $schedule->appointments_locations ??= [];
            $schedule->locked ??= false;
            $schedule->appointment_duration ??=30;

            $schedule->working_periods ??= [
                ['start' => '08:30', 'end' => '12:00', 'label' => 'Morning'],
                ['start' => '13:00', 'end' => '16:00', 'label' => 'Afternoon'],
            ];
        });
    }

    /*
    |---------------------------------------
    | RELATIONS
    |---------------------------------------
    */

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function scheduleDays(): HasMany
    {
        return $this->hasMany(ScheduleDay::class);
    }

    /*
    |---------------------------------------
    | STATE
    |---------------------------------------
    */

    public function isDraft(): bool
    {
        return $this->state === self::STATE_NOT_PUBLISHED;
    }

    public function isPublished(): bool
    {
        return $this->state === self::STATE_PUBLISHED;
    }

    /*
    |---------------------------------------
    | LOCK SYSTEM
    |---------------------------------------
    */

    public function isLocked(): bool
    {
        return (bool) $this->locked;
    }

    public function lock(): void
    {
        $this->updateQuietly([
            'locked' => true,
        ]);
    }

    /*
    |---------------------------------------
    | PUBLISH (LOCK ADDED)
    |---------------------------------------
    */

    public function publish(): bool
    {
        if ($this->isPublished()) {
            throw ValidationException::withMessages([
                'schedule' => __('tables.schedules.errors.published'),
            ]);
        }

        if (!$this->year || !$this->month) {
            throw ValidationException::withMessages([
                'schedule' => __('tables.schedules.errors.missing_year_month'),
            ]);
        }

        return DB::transaction(function () {

            $schedule = self::whereKey($this->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($schedule->scheduleDays()->count() === 0) {
                throw ValidationException::withMessages([
                    'schedule' => __('tables.schedules.errors.no_days_found'),
                ]);
            }

            if ($schedule->scheduleDays()->whereDoesntHave('slots')->exists()) {
                throw ValidationException::withMessages([
                    'schedule' => __('tables.schedules.errors.missing_slots'),
                ]);
            }

            $schedule->update([
                'state' => self::STATE_PUBLISHED,
            ]);

            return true;
        });
    }

    /*
    |---------------------------------------
    | GENERATE DAYS (NO GLOBAL LOCK)
    |---------------------------------------
    */

    public function generateDays(bool $force = false): void
    {
        if ($this->isPublished()) {
            throw ValidationException::withMessages([
                'schedule' => __('tables.schedules.errors.published'),
            ]);
        }

        if ($this->isLocked() && !$force) {
            throw ValidationException::withMessages([
                'schedule' => __('tables.schedules.errors.locked'),
            ]);
        }

        if (!$this->year || !$this->month) {
            throw ValidationException::withMessages([
                'schedule' => __('tables.schedules.errors.missing_year_month'),
            ]);
        }

        if (!$this->service?->specialty_id) {
            throw ValidationException::withMessages([
                'schedule' => __('tables.schedules.errors.missing_specialty'),
            ]);
        }

        $start = Carbon::createFromDate($this->year, $this->month, 1);
        $end = $start->copy()->endOfMonth();

        $workingDays = $this->working_days ?? [];
        $daysOff = $this->days_off ?? [];
        $specialtyId = $this->service->specialty_id;

        $workingPeriods = $this->working_periods ?? [];
        $appointmentsLocations = $this->appointments_locations ?? [];

        $minimumDate = now()->addDays(3)->startOfDay();

        $rows = [];

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {

            if ($date->lt($minimumDate)) {
                continue;
            }

            $dateString = $date->toDateString();

            if (!$this->isAvailableWorkingDay($dateString, $workingDays, $daysOff)) {
                continue;
            }

            $rows[] = [
                'schedule_id' => $this->id,
                'day_at' => $dateString,
                'specialty_id' => $specialtyId,
                'working_periods' => json_encode($workingPeriods),
                'appointments_locations' => json_encode($appointmentsLocations),
                'appointment_duration'=>$this->appointment_duration,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (empty($rows)) {
            throw ValidationException::withMessages([
                'schedule' => __('tables.schedules.errors.no_days_generated'),
            ]);
        }

        ScheduleDay::upsert(
            $rows,
            ['schedule_id', 'day_at'],
            [
                'specialty_id',
                'working_periods',
                'appointments_locations',
                'updated_at',
            ]
        );
    }

    /*
    |---------------------------------------
    | GENERATE SLOTS (SCHEDULE LOCK ADDED)
    |---------------------------------------
    */

    public function generateSlots(bool $force = false): void
    {
        if ($this->isPublished()) {
            throw ValidationException::withMessages([
                'schedule' => __('tables.schedules.errors.published'),
            ]);
        }

        if (!$this->scheduleDays()->exists()) {
            throw ValidationException::withMessages([
                'schedule' => __('tables.schedules.errors.no_days_found'),
            ]);
        }

        DB::transaction(function () use ($force) {

            $schedule = self::whereKey($this->id)
                ->lockForUpdate()
                ->firstOrFail();

            $schedule->scheduleDays()
                ->with('slots')
                ->chunkById(50, function ($days) use ($force) {

                    foreach ($days as $day) {

                        if ($day->isLocked() && !$force) {
                            continue;
                        }

                        $day->generateSlots($force);
                    }
                });
        });
    }

    /*
    |---------------------------------------
    | HELPERS
    |---------------------------------------
    */

    public function hasAnyScheduleDay(): bool
    {
        return $this->scheduleDays()->exists();
    }

    public function hasAtLeastOneUnlockedScheduleDay(): bool
    {
        return $this->scheduleDays()
            ->where('locked', false)
            ->exists();
    }

    /*
    |---------------------------------------
    | LOCALIZATION
    |---------------------------------------
    */

    public function getLocalizedNameAttribute(): string
    {
        $locale = app()->getLocale();
        $key = "name_{$locale}";

        return $this->$key ?? $this->name_fr ?? $this->name_en ?? '';
    }

    public function getLocalizedDescriptionAttribute(): string
    {
        $locale = app()->getLocale();
        $key = "description_{$locale}";

        return $this->$key ?? $this->description_fr ?? $this->description_en ?? '';
    }
}
