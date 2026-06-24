<?php

namespace App\Livewire\Forms\App\Patient;

use App\Models\Patient;
use App\Rules\App\MustHaveParentIfMinor;
use App\Rules\App\ValidInsuranceNumber;
use App\Traits\Core\Web\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class UpdateForm extends Form
{
    use ResponseTrait;

    public ?int $id = null;

    public string $code = "";
    public string $first_name_fr = '';
    public string $first_name_ar = '';
    public string $last_name_fr = '';
    public string $last_name_ar = '';

    public string $gender = '';

    public ?string $birth_place_fr = null;
    public ?string $birth_place_ar = null;
    public ?string $birth_place_en = null;

    public ?string $birth_date = null;

    public ?string $address_fr = null;
    public ?string $address_ar = null;
    public ?string $address_en = null;

    public ?int $commune_id = null;

    public ?int $father_id = null;
    public ?int $mother_id = null;

    public ?string $tel = null;
    public ?string $insurance_number = null;

    public ?int $opened_by = null;

    public function rules(): array
    {
        return [
            'first_name_fr' => ['required', 'string', 'min:3', 'max:100'],
            'first_name_ar' => ['nullable', 'string', 'min:3', 'max:100'],
            'last_name_fr'  => ['required', 'string', 'min:3', 'max:100'],
            'last_name_ar'  => ['nullable', 'string', 'min:3', 'max:100'],

            'gender' => ['required', 'in:male,female,other'],

            'birth_date' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after:1920-01-01',
                'beforeOrEqual:today',
                new MustHaveParentIfMinor(
                    $this->father_id,
                    $this->mother_id
                ),
            ],

            'birth_place_fr' => ['nullable', 'string', 'max:255'],
            'birth_place_ar' => ['nullable', 'string', 'max:255'],
            'birth_place_en' => ['nullable', 'string', 'max:255'],

            'address_fr' => ['nullable', 'string', 'min:5', 'max:255'],
            'address_ar' => ['nullable', 'string', 'min:5', 'max:255'],
            'address_en' => ['nullable', 'string', 'min:5', 'max:255'],

            'commune_id' => ['nullable', 'exists:communes,id'],

            'father_id' => ['required', 'exists:patients,id'],
            'mother_id' => ['nullable', 'exists:patients,id'],

            'tel' => [
                'nullable',
                'regex:/^(05|06|07)\d{8}$/',
                Rule::unique('patients', 'tel')
                    ->ignore($this->id)
                    ->whereNull('deleted_at')
                    ->where(fn($query) => $query->where('opened_by', '!=', $this->opened_by)),
            ],

            'insurance_number' => [
                'nullable',
                'string',
                'max:100',
                new ValidInsuranceNumber(
                    $this->father_id,
                    $this->mother_id,
                    $this->birth_date,
                    $this->id // ✅ ignore current patient
                ),
            ],

            'opened_by' => ['required', 'exists:users,id'],
        ];
    }

    protected function patientAttributesList(): array
    {
        return [
            'first_name_fr',
            'first_name_ar',
            'last_name_fr',
            'last_name_ar',
            'gender',
            'birth_place_fr',
            'birth_place_ar',
            'birth_place_en',
            'birth_date',
            'address_fr',
            'address_ar',
            'address_en',
            'commune_id',
            'father_id',
            'mother_id',
            'tel',
            'insurance_number',
            'opened_by',
        ];
    }

    public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes(
            'patient',
            $this->patientAttributesList()
        );
    }

    public function messages(): array
    {
        return [
            'tel.regex' => __("forms.common.errors.not_match.phone"),
        ];
    }

    public function save(Patient $patient)
    {
        try {
            $data = $this->validate();

            $patient->update($data);

            return $this->response(true, message: __("forms.patient.responses.update_success"));
        } catch (ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Exception $e) {
            Log::error('Patient UpdateForm Error', ['message' => $e->getMessage()]);

            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }
}
