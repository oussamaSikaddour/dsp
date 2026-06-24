<?php

namespace App\Livewire\Forms\App\MedicalExam;

use App\Models\Appointment;
use App\Models\MedicalExam;
use App\Traits\Core\Common\ModelImageTrait;
use App\Traits\Core\Web\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AddForm extends Form
{
    use ResponseTrait, ModelImageTrait;

    public $patient_id;
    public $doctor_id;
    public $specialty_id;
    public $report_fr;
    public $report_ar;
    public $report_en;


    /**
     * Define validation rules.
     */
    public function rules()
    {


        return [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'specialty_id' => 'required|exists:field_specialties,id',
            'report_ar' =>[
            'nullable',
            'string',
            'min:20',
            'max:2000',
            Rule::unique('medical_exams')
                ->whereNull('deleted_at')
        ],
            'report_fr' =>[
            'required',
            'string',
            'min:20',
            'max:2000',
            Rule::unique('medical_exams')
                ->whereNull('deleted_at')
        ],
            'report_en' => [
            'nullable',
            'string',
            'min:20',
            'max:2000',
            Rule::unique('medical_exams')
                ->whereNull('deleted_at')
        ]

        ];
    }

    /**
     * Define attribute names for validation messages.
     */
    public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes('medical_exam', [
            'patient_id',
            'doctor_id',
            'report_fr',
            'report_en',
            'report_ar',
            'specialty_id'
        ]);
    }

    /**
     * Save the medical exam.
     */
public function save(?int $appointmentId)
{
    try {
        $data = $this->validate();

        DB::transaction(function () use ($data, $appointmentId) {

            MedicalExam::create($data);

            if ($appointmentId) {
                Appointment::find($appointmentId)?->update([
                    'doctor_id' => Auth::id(),
                ]);
            }
        });

        return $this->response(
            true,
            message: __("forms.medical_exam.responses.add_success")
        );

    } catch (\Illuminate\Validation\ValidationException $e) {
        return $this->response(
            false,
            errors: $e->validator->errors()->all()
        );
    } catch (\Exception $e) {
        Log::error('Medical exam creation error: ' . $e->getMessage());

        return $this->response(
            false,
            errors: __('forms.common.errors.default')
        );
    }
}
}
