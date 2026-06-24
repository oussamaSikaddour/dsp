<?php

namespace App\Livewire\Forms\App\MedicalExam;


use App\Traits\Core\Common\ModelImageTrait;
use App\Traits\Core\Web\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Form;

class UpdateForm extends Form
{
    use ResponseTrait, ModelImageTrait;

    public $id;
    public $patient_id;
    public $doctor_id;
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
            'report_ar' => [
                'nullable',
                'string',
                'min:20',
                'max:2000',
                Rule::unique('medical_exams')
                    ->whereNull('deleted_at')
                    ->ignore($this->id)
            ],
            'report_fr' => [
                'required',
                'string',
                'min:20',
                'max:2000',
                Rule::unique('medical_exams')
                    ->whereNull('deleted_at')
                    ->ignore($this->id)
            ],
            'report_en' => [
                'nullable',
                'string',
                'min:20',
                'max:2000',
                Rule::unique('medical_exams')
                    ->whereNull('deleted_at')
                    ->ignore($this->id)
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
            'report_ar'
        ]);
    }

    /**
     * Save the medical exam.
     */
    public function save($medicalExam)
    {
        try {
            $data = $this->validate();


            $medicalExam->update($data);

            return $this->response(true, message: __("forms.medical_exam.responses.update_success"));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Exception $e) {
            Log::error('Medical exam update error: ' . $e->getMessage());
            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }
}
