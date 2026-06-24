<?php

namespace App\Livewire\Forms\App\Service;

use App\Models\Service;
use App\Rules\Core\LandLineNumberExist;
use App\Traits\Core\Web\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Form;

/**
 * Class UpdateForm
 *
 * @property int|null $id
 * @property string $name_fr
 * @property string $name_ar
 * @property string $name_en
 * @property string $type
 * @property int|null $establishment_id
 * @property int|null $head_of_service_id
 * @property string $specialty
 */
class UpdateForm extends Form
{
    use ResponseTrait;

    public $id;
    public $name_fr = "";
    public $name_ar = "";
    public $name_en = "";
    public $type = "";
    public $establishment_id;
    public $head_of_service_id;
     public $tel= "";
    public $fax = "";
    public $specialty_id = ""; // change to nullable if optional

    /**
     * Define validation rules.
     */
    public function rules(): array
    {
        if (!$this->establishment_id) {
            throw new \RuntimeException('establishment ID must be set before validation.');
        }

        $localizedNameRules = [
            'required',
            'string',
            'min:5',
            'max:255',
            Rule::unique('services')
                ->where(fn($query) => $query->where('establishment_id', $this->establishment_id))
                ->whereNull('deleted_at')
                ->ignore($this->id),
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
                    ->whereNull('deleted_at')
                    ->ignore($this->id),
            ],
            'tel' => ['required', 'digits:9', new LandLineNumberExist(new Service(), $this->id)],
            'fax' => ['nullable', 'digits:9', new LandLineNumberExist(new Service(), $this->id)],
            'type' => 'required|in:administration,health',
            'establishment_id' => 'required|exists:establishments,id',
        ];
    }

    /**
     * Custom validation attribute names for localization.
     */
    public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes('service', [
            "name_ar",
            "name_fr",
            "name_en",
            "head_of_service_id",
            "type",
            'tel',
            'fax',
            "establishment_id",
            "specialty",
        ]);
    }

    /**
     * Optional: custom validation messages.
     */
    public function messages(): array
    {
        return [
            // Example: 'name_ar.unique' => __('forms.service.errors.name_ar_unique'),
        ];
    }

    /**
     * Update the service with validated data.
     *
     * @param Service $service
     * @return array
     */
    public function save(Service $service): array
    {
        try {
            $data = $this->validate();
            $service->fill($data)->save();
            return $this->response(true, message: __("forms.service.responses.update_success"));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Exception $e) {
            Log::error('Error in Service UpdateForm save method: ' . $e->getMessage());
            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }
}
