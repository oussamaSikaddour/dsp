<?php

namespace App\Livewire\App\Admin;

use App\Livewire\Forms\App\Establishment\ManageTypesForm;
use App\Models\Establishment;
use App\Traits\Core\Common\GeneralTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;

class EstablishmentTypesManager extends Component
{
    use GeneralTrait;

    public ManageTypesForm $form;
    public ?int $establishmentId = null;
    public ?Establishment $establishment = null;
    public $existingTypes =[];
    public $local="fr";

    /**
     * Mount the component and load establishment data.
     */
    public function mount(): void
    {

        $this->local = app()->getLocale();
        if (!$this->establishmentId) {
            return;
        }
        $this->existingTypes = config('core.options.ESTABLISHMENT_TYPES')[$this->local] ;

        try {
            $this->establishment = Establishment::findOrFail($this->establishmentId);

            // Convert JSON types to array if needed
            $this->form->types = is_array($this->establishment->types)
                ? $this->establishment->types
                : json_decode($this->establishment->types, true) ?? [];
        } catch (ModelNotFoundException $e) {
            Log::error('Establishment not found: ' . $e->getMessage());
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }


    /**
     * Add new type dynamically (e.g., on keydown).
     */
    public function updatetypesOnKeydownEvent($value): void
    {
        if (!isset($this->form->types)) {
            $this->form->types = [];
        }
        $this->checkAndUpdateArray($this->form->types, $value);
    }

    /**
     * Handle form submission.
     */
    public function handleSubmit(): void
    {
        $response = $this->form->save($this->establishment);

        if ($response['status']) {
            $this->dispatch('open-toast', $response['message'] ?? __('forms.establishment.responses.manage_success'));
        } else {
            $this->dispatch('open-errors', $response['errors'] ?? [__('forms.common.errors.default')]);
        }
    }

    public function render()
    {
        return view('livewire.app.admin.establishment-types-manager');
    }
}
