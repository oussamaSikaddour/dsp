<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ScheduleSlot extends Model
{
    use HasFactory;

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_BOOKED = 'booked';
    public const STATUS_BLOCKED = 'blocked';

    protected $fillable = [
        'schedule_day_id',
        'establishment_id',
        'doctor_index',
        'start_at',
        'end_at',
        'status',
    ];

    protected $casts = [
        'schedule_day_id' => 'integer',
        'establishment_id' => 'integer',
        'doctor_index' => 'integer',

    'start_at' => 'datetime:H:i',
    "end_at"=> 'datetime:H:i'
];

    protected $attributes = [
        'status' => self::STATUS_AVAILABLE,
    ];

    /*
    |---------------------------------------
    | RELATIONS
    |---------------------------------------
    */

    public function scheduleDay(): BelongsTo
    {
        return $this->belongsTo(ScheduleDay::class);
    }

    public function appointment(): HasOne
    {
        return $this->hasOne(Appointment::class, 'schedule_slot_id');
    }

    /*
    |---------------------------------------
    | STATE HELPERS
    |---------------------------------------
    */

    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    public function isBooked(): bool
    {
        return $this->status === self::STATUS_BOOKED;
    }

    public function isBlocked(): bool
    {
        return $this->status === self::STATUS_BLOCKED;
    }

    public function canBeBooked(): bool
    {
        return $this->isAvailable();
    }

    public function assertAvailable(): void
    {
        if (!$this->isAvailable()) {
            throw ValidationException::withMessages([
                'slot' => __('schedule.errors.slot_not_available'),
            ]);
        }
    }

    public function assertNotBooked(): void
    {
        if ($this->isBooked()) {
            throw ValidationException::withMessages([
                'slot' => __('schedule.errors.slot_already_booked'),
            ]);
        }
    }

    /*
    |---------------------------------------
    | SAFE BOOKING (ATOMIC + CONSISTENT)
    |---------------------------------------
    */

public function book(array $data): Appointment
{
    return DB::transaction(function () use ($data) {

        $slot = self::query()
            ->whereKey($this->id)
            ->lockForUpdate()
            ->with('scheduleDay.schedule.service')
            ->first();

        if (!$slot) {
            throw ValidationException::withMessages([
                'schedule_slot_id' => __('schedule.errors.slot_not_found'),
            ]);
        }

        $slot->assertAvailable();

        if (
            !isset(
                $data['patient_id'],
                $data['type'],
                $data['initiator']
            )
        ) {
            throw ValidationException::withMessages([
                'schedule_slot_id' => __('schedule.errors.invalid_booking_data'),
            ]);
        }

                if ($slot->appointment()->exists()) {
            throw ValidationException::withMessages([
                'schedule_slot_id' => __('schedule.errors.slot_already_booked'),
            ]);
        }

        $service = $slot->scheduleDay->schedule->service;

        $appointment = Appointment::create([
            'patient_id' => $data['patient_id'],
            'appointments_location_id' => $slot->establishment_id,
            'schedule_slot_id' => $slot->id,
            'service_id' => $service->id,
            'specialty_id' => $service->specialty_id,
            'day_at' => $slot->scheduleDay->day_at,
            'start_at' => $slot->start_at,
            'end_at' => $slot->end_at,
            'type' => $data['type'],
            'initiator' => $data['initiator'],
        ]);

        $slot->update([
            'status' => self::STATUS_BOOKED,
        ]);

        return $appointment;
    });
}
    /*
    |---------------------------------------
    | ADMIN ACTIONS
    |---------------------------------------
    */

    public function block(): void
    {
        $this->assertNotBooked();

        $this->update([
            'status' => self::STATUS_BLOCKED,
        ]);
    }

    public function unblock(): void
    {
        $this->assertNotBooked();

        $this->update([
            'status' => self::STATUS_AVAILABLE,
        ]);
    }

    /*
    |---------------------------------------
    | INTERNAL SAFETY HOOK
    |---------------------------------------
    */

    public function assertBookable(): void
    {
        $this->assertAvailable();
    }
}
