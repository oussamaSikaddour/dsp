<?php

namespace App\Livewire\Forms\App\Appointment;

use App\Models\Appointment;
use App\Models\ScheduleDay;
use App\Models\ScheduleSlot;
use App\Traits\Core\Common\ModelImageTrait;
use App\Traits\Core\Web\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Form;
use Carbon\Carbon;

class BookForm extends Form
{
    use ResponseTrait, ModelImageTrait;

    // --------------------
    // FORM FIELDS
    // --------------------

    public ?int $patient_id = null;
    public ?int $schedule_slot_id = null;
    public ?int $schedule_day_id = null;
    public ?int $specialty_id = null; // ✅ NEW

    public ?ScheduleDay $scheduleDay = null;
    public ?ScheduleSlot $scheduleSlot = null;

    public string $type = 'initial';
    public string $initiator = 'patient';

    public $referral_letter;

    // --------------------
    // VALIDATION
    // --------------------

    protected function appointmentAttributesList(): array
    {
        return [
            'patient_id',
            'schedule_slot_id',
            'schedule_day_id',
            'specialty_id',
            'type',
            'initiator',
            'referral_letter'
        ];
    }

    public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes(
            'appointment',
            $this->appointmentAttributesList()
        );
    }
    public function rules(): array
    {
        $rules = [
            'patient_id' => ['required', 'exists:patients,id'],
            'schedule_slot_id' => ['required', 'exists:schedule_slots,id'],
            'schedule_day_id' => ['required', 'exists:schedule_days,id'],
            'specialty_id' => ['required', 'exists:field_specialties,id'], // ✅ REQUIRED
        ];

        if ($this->type === 'initial') {
            $rules['referral_letter'] = [
                'required',
                'file',
                'mimes:jpeg,png,gif,ico',
                'max:10000'
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => __("forms.appointment.errors.not_found.patient"),
            'schedule_slot_id.required' => __("forms.appointment.errors.not_found.schedule_slot"),
            'schedule_day_id.required' => __("forms.appointment.errors.not_found.schedule_day"),
            'specialty_id.required' => __("forms.appointment.errors.not_found.specialty"),
        ];
    }

    // --------------------
    // MAIN SAVE
    // --------------------

    public function save(): array
    {


        try {
            $this->validate();

            return DB::transaction(function () {

                $this->scheduleDay = ScheduleDay::findOrFail($this->schedule_day_id);

                $this->scheduleSlot = ScheduleSlot::with('scheduleDay.schedule.service')
                    ->findOrFail($this->schedule_slot_id);

                // Ensure slot belongs to selected day
                if ($this->scheduleSlot->schedule_day_id !== $this->scheduleDay->id) {
                    throw ValidationException::withMessages([
                        'schedule_slot_id' => __('forms.appointment.errors.invalid_slot_day_match'),
                    ]);
                }

                $service = $this->scheduleSlot->scheduleDay->schedule->service;

                // GAP RULE (still service-based, correct)
                if ($this->type === 'initial') {
                    $this->checkSpecialtyBookingGap(
                        $this->patient_id,
                        $service->specialty_id,
                        $this->scheduleDay->day_at
                    );
                }

                // OPTIONAL SAFETY CHECK (recommended)
                if ($this->specialty_id !== $service->specialty_id) {
                    throw ValidationException::withMessages([
                        'specialty_id' => __('forms.appointment.errors.invalid_specialty_for_service'),
                    ]);
                }


                // ✅ SINGLE SOURCE OF TRUTH (now includes specialty)
                $appointment = $this->scheduleSlot->book([
                    'patient_id' => $this->patient_id,
                    'type' => $this->type,
                    'initiator' => $this->initiator,
                    'specialty_id' => $this->specialty_id,
                ]);


                // FILE UPLOAD
                if ($this->referral_letter) {
                    $this->uploadImage($appointment);
                }

                return $this->response(
                    true,
                    message: __("forms.appointment.responses.add_success")
                );
            });
        } catch (ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Exception $e) {
            Log::error('Appointment creation error: ' . $e->getMessage());

            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }

    // --------------------
    // SPECIALTY GAP CHECK
    // --------------------

    protected function checkSpecialtyBookingGap(
        int $patientId,
        int $specialtyId,
        string $newDayAt,
        int $minDays = 15
    ): void {
        $lastAppointment = Appointment::query()
            ->where('patient_id', $patientId)
            ->where('specialty_id', $specialtyId)
            ->latest('day_at')
            ->first();

        if (!$lastAppointment) {
            return;
        }

        $lastDate = Carbon::parse($lastAppointment->day_at);
        $newDate  = Carbon::parse($newDayAt);

        if ($lastDate->diffInDays($newDate) < $minDays) {
            throw ValidationException::withMessages([
                'schedule_day_id' => __('forms.appointment.errors.min_gap_days', [
                    'days' => $minDays,
                    'date' => $newDate->translatedFormat('d F Y'),
                    'last' => $lastDate->translatedFormat('d F Y'),
                ]),
            ]);
        }
    }

    // --------------------
    // FILE UPLOAD
    // --------------------

    protected function uploadImage(Appointment $appointment): void
    {
        $this->uploadAndCreateImage(
            $this->referral_letter,
            $appointment->id,
            Appointment::class,
            "referral_letter"
        );
    }
}
