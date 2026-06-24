<?php

namespace App\Livewire\Forms\App\Service;

use App\Models\Service;
use App\Rules\Core\LandLineNumberExist;
use App\Traits\Core\Web\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AddForm extends Form
{
    use ResponseTrait;

    public $name_fr = "";
    public $name_ar = "";
    public $name_en = "";
    public $type = "";
    public $establishment_id;
    public $head_of_service_id;
    public $tel = "";
    public $fax = "";
     public $specialty_id = ""; // if needed

    public function rules()
    {
        $localizedNameRules = [
            'required',
            'string',
            'min:5',
            'max:255',
            Rule::unique('services')
                ->where(fn($query) => $query->where('establishment_id', $this->establishment_id))
                ->whereNull('deleted_at'),
        ];

        return [
            'name_ar' => $localizedNameRules,
            'name_fr' => $localizedNameRules,
            'name_en' => $localizedNameRules,
             'specialty_id' => ['required', 'exists:field_specialties,id'],
            'head_of_service_id' => [
                'required',
                'integer',
                Rule::unique('services')
                    ->where(fn($query) => $query->where('establishment_id', $this->establishment_id))
                    ->whereNull('deleted_at'),
            ],
            'tel' => ['required', 'digits:9', new LandLineNumberExist(new Service())],
            'fax' => ['nullable', 'digits:9', new LandLineNumberExist(new Service())],
            'type' => 'required|in:administration,health',
            'establishment_id' => 'required|exists:establishments,id',
        ];
    }

    public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes('service', [
            "name_ar",
            "name_fr",
            "name_en",
            "head_of_service_id",
            "type",
            "tel",
            "fax",
            "establishment_id",
            "specialty_id",
        ]);
    }

    public function save()
    {
        try {
            $data = $this->validate();
            Service::create($data);
            return $this->response(true, message: __("forms.service.responses.add_success"));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Exception $e) {
            Log::error('Error in Service AddForm save method', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }
}
