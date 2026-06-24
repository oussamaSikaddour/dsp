<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ScheduleDay extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'schedule_id',
        'day_at',
        'specialty_id',
        'appointment_duration',
        'working_periods',
        'appointments_locations',
        'locked',
    ];

    protected $casts = [
        'day_at' => 'date',
        'schedule_id' => 'integer',
        'specialty_id' => 'integer',
        'appointment_duration' => 'integer',
        'working_periods' => 'array',
        'appointments_locations' => 'array',
        'locked' => 'boolean',
    ];

    protected $attributes = [
        'appointment_duration' => 30,
        'locked' => false,
    ];

    /*
    |---------------------------------------
    | RELATIONS
    |---------------------------------------
    */

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(ScheduleSlot::class);
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

    public function unlock(): void
    {
        $this->updateQuietly([
            'locked' => false,
        ]);
    }

    /*
    |---------------------------------------
    | SLOT GENERATION (LOCKED SAFE VERSION)
    |---------------------------------------
    */

    public function generateSlots(bool $force = false): void
    {
        DB::transaction(function () use ($force) {

            /**
             * 🔒 LOCK THIS DAY ROW (prevents concurrent slot generation)
             */
            $day = self::whereKey($this->id)
                ->lockForUpdate()
                ->firstOrFail();

            /**
             * 🔒 ALSO LOCK PARENT SCHEDULE (prevents publish/generation conflicts)
             */
            $schedule = Schedule::whereKey($day->schedule_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($schedule->isPublished()) {
                throw ValidationException::withMessages([
                    'schedule_day' => __('tables.schedule.errors.published'),
                ]);
            }

            if ($day->isLocked() && !$force) {
                throw ValidationException::withMessages([
                    'schedule_day' => __('tables.schedule_days.errors.locked'),
                ]);
            }

            // 🔒 lock once (prevents double generation)
            $day->lock();

            $periods = $day->working_periods;
            $locations = $day->appointments_locations;

            if (is_string($periods)) {
                $periods = json_decode($periods, true) ?? [];
            }

            if (is_string($locations)) {
                $locations = json_decode($locations, true) ?? [];
            }

            if (empty($periods) || empty($locations)) {
                throw ValidationException::withMessages([
                    'schedule_day' => __('tables.schedule_days.errors.missing_periods_or_locations'),
                ]);
            }

            foreach ($periods as $period) {

                if (!isset($period['start'], $period['end'])) {
                    continue;
                }

                $start = Carbon::createFromFormat('H:i', $period['start']);
                $end = Carbon::createFromFormat('H:i', $period['end']);

                while ($start->copy()->addMinutes($day->appointment_duration)->lte($end)) {

                    $slotStart = $start->copy();
                    $slotEnd = $start->copy()->addMinutes($day->appointment_duration);

                    foreach ($locations as $location) {

                        if (!isset($location['location_id'], $location['capacity'])) {
                            continue;
                        }

                        for ($i = 1; $i <= (int) $location['capacity']; $i++) {

                            ScheduleSlot::firstOrCreate(
                                [
                                    'schedule_day_id' => $day->id,
                                    'establishment_id' => $location['location_id'],
                                    'doctor_index' => $i,
                                    'start_at' => $slotStart->format('H:i'),
                                    'end_at' => $slotEnd->format('H:i'),
                                ],
                                [
                                    'status' => ScheduleSlot::STATUS_AVAILABLE,
                                ]
                            );
                        }
                    }

                    $start->addMinutes($day->appointment_duration);
                }
            }
        });
    }
}
