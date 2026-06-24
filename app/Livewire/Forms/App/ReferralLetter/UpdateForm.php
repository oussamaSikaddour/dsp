<?php

namespace App\Livewire\Forms\App\ReferralLetter;

use App\Models\Appointment;
use App\Traits\Core\Common\GeneralTrait;
use App\Traits\Core\Common\ModelImageTrait;
use App\Traits\Core\Web\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class UpdateForm extends Form
{
    use ResponseTrait, ModelImageTrait, GeneralTrait;

    public $referral_letter = null;

    public function rules(): array
    {
        return [
            'referral_letter' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:10000',
        ];
    }

    public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes('appointment', [
            'referral_letter',
        ]);
    }

    public function save(Appointment $appointment): array
    {
        try {
            $this->validate();

            return DB::transaction(function () use ($appointment) {

                if ($this->referral_letter) {
                    $this->uploadAndUpdateImage(
                        $this->referral_letter,
                        $appointment->id,
                        Appointment::class,
                        'referral_letter'
                    );
                }

                return $this->response(
                    true,
                    message: __('forms.appointment.responses.update_success')
                );
            });

        } catch (ValidationException $e) {
            return $this->response(
                false,
                errors: $e->validator->errors()->all()
            );

        } catch (\Throwable $e) {
            Log::error('Error in Appointment ReferralLetter UpdateForm', [
                'message' => $e->getMessage(),
                'appointment_id' => $appointment->id ?? null,
            ]);

            return $this->response(
                false,
                errors: __('forms.common.errors.default')
            );
        }
    }
}
