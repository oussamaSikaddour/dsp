<?php

namespace App\Livewire\Forms\App\Establishment;

use App\Traits\Core\Web\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class ManageTypesForm extends Form
{
    use ResponseTrait;

    /**
     * @var array
     */
    public array $types = [];

    /**
     * Get validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'types'   => ['sometimes', 'array'],
            'types.*' => ['string', 'max:50'],
        ];
    }

    /**
     * Get custom attribute names for validation.
     *
     * @return array
     */
    public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes('establishment', [
            'types',
        ]);
    }

    /**
     * Update the establishment types.
     *
     * @param  \App\Models\Establishment  $establishment
     * @return array
     */
    public function save($establishment): array
    {
        try {
            $validated = $this->validate();

            $establishment->update($validated);

            return $this->response(
                true,
                data: $establishment,
                message: __('forms.establishment.responses.manage_success')
            );
        } catch (ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Throwable $e) {
            Log::error('Error in ManageTypesForm::save: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->response(false, errors: [__('forms.common.errors.default')]);
        }
    }
}
