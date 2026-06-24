<?php

namespace App\Livewire\Forms\App\Establishment;

use App\Models\Establishment;
use App\Rules\Core\LandLineNumberExist;
use App\Traits\Core\Web\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AddForm extends Form
{
    use ResponseTrait;

    // Public form fields
    public $acronym = "";
    public $name_fr = "";
    public $name_ar = "";
    public $name_en = "";
    public $email = "";
    public $description_fr = "";
    public $description_ar = "";
    public $description_en = "";
    public $address_fr = "";
    public $address_en = "";
    public $address_ar = "";
    public $type = "";
    public $tel = "";
    public $fax = "";
    public $daira_id="";
    public $longitude = '';
    public $latitude = '';


    /**
     * Define validation rules.
     */
    public function rules()
    {
        // Common unique rule helper (ignores soft deletes)
        $unique = fn($column) =>
            Rule::unique('establishments', $column)
                ->whereNull('deleted_at');

        // Localized fields share the same rule
        $localizedStringRules = [
            'required', 'string', 'min:5', 'max:255', $unique('name_fr') // applies unique on name_fr; adjust if needed
        ];
        $nullableLocalizedStringRules = [
            'nullable', 'string', 'min:5', 'max:255', $unique('name_fr') // applies unique on name_fr; adjust if needed
        ];

        // Build rules dynamically
        $rules = [
            'daira_id' => ['required', 'exists:dairates,id'],
            'acronym' => ['required', 'string', 'max:10', $unique('acronym')],
            'tel' => ['required', 'digits:9', new LandLineNumberExist(new Establishment())],
            'fax' => ['nullable', 'digits:9', new LandLineNumberExist(new Establishment())],

            // Coordinates: validate as numeric (more correct)
            'latitude' => [
                'required', 'numeric', 'between:-90,90',
                Rule::unique('establishments')
                    ->where('longitude', $this->longitude)
                    ->whereNull('deleted_at'),
            ],
            'longitude' => [
                'required', 'numeric', 'between:-180,180',
                Rule::unique('establishments')
                    ->where('latitude', $this->latitude)
                    ->whereNull('deleted_at'),
            ],
        ];

        // Add all localized fields with shared rules
        foreach ([
            'name_fr', 'name_ar', 'name_en',
        ] as $field) {
            $rules[$field] = $localizedStringRules;
        }
        foreach ([
            'address_fr', 'address_ar', 'address_en',
            'description_fr', 'description_ar', 'description_en'
        ] as $field) {
            $rules[$field] = $nullableLocalizedStringRules;
        }

        // Optional: add email rule if needed
        if (!empty($this->email)) {
            $rules['email'] = ['nullable', 'email', 'max:255', $unique('email')];
        }

        return $rules;
    }

    /**
     * Define attribute names for validation messages.
     */
    public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes('establishment', [
            "acronym", "name_fr", "name_en", "name_ar", "email",
            "address_fr", "address_ar", "address_en",
            "description_fr", "description_en", "description_ar",
            "tel", "fax", "longitude", "latitude",'daira_id'
        ]);
    }

    /**
     * Save the establishment.
     */
    public function save()
    {
        try {
            $data = $this->validate();

            $establishment = Establishment::create($data);

            return $this->response(true, data: $establishment, message: __("forms.establishment.responses.add_success"));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Exception $e) {
            Log::error('Error in Establishment AddForm save method: ' . $e->getMessage());
            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }
}
