<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    public const TYPE_INITIAL = 'initial';
    public const TYPE_FOLLOW_UP = 'follow-up';

    public const INITIATOR_PATIENT = 'patient';
    public const INITIATOR_DOCTOR = 'doctor';

    protected $fillable = [
        'patient_id',
        'appointments_location_id',
                'schedule_slot_id',
        'service_id',
        'specialty_id',
         'doctor_id',
        'day_at',
        'start_at',
        'end_at',
        'type',
        'initiator',
    ];

    protected $casts = [
    'start_at' => 'datetime:H:i',
    "end_at"=> 'datetime:H:i'
];
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

        public function slot(): BelongsTo
    {
        return $this->belongsTo(ScheduleSlot::class, 'schedule_slot_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
    public function appointmentsLocation(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'appointments_location_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function specialty(): BelongsTo
    {
        return $this->belongsTo(FieldSpecialty::class, 'specialty_id');
    }



    public function referralLetter(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /*
    |--------------------------------------------------------------------------
    | CANCEL
    |--------------------------------------------------------------------------
    */


public function cancel(): void
{
    DB::transaction(function () {

        $appointmentDate = Carbon::parse($this->day_at);
        $now = Carbon::now();

        // difference in days (absolute is NOT what we want here)
        $daysUntilAppointment = $now->diffInDays($appointmentDate, false);

        if ($daysUntilAppointment < 3) {
            throw ValidationException::withMessages([
                'appointment' => __('tables.appointments.errors.cannot_cancel_less_than_3_days'),
            ]);
        }

        if ($this->slot) {
            $this->slot->update([
                'status' => ScheduleSlot::STATUS_AVAILABLE,
            ]);
        }

        $this->delete();
    });
}
}
