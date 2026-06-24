<?php

namespace App\Livewire\App\EstablishmentAdmin;

use App\Livewire\Forms\App\Service\AddForm;
use App\Livewire\Forms\App\Service\UpdateForm;
use App\Models\FieldSpecialty;
use App\Models\Service;
use App\Models\User;
use App\Traits\Core\Common\GeneralTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ServiceModal extends Component
{
    use GeneralTrait;

    public AddForm $addForm;
    public UpdateForm $updateForm;

    public Service $service;

    public ?int $id = null;
    public ?int $establishmentId = null;

    public string $form = 'addForm';
    public string $local = 'fr';

    public array $serviceTypesOptions = [];
    public array $serviceSpecialtiesOptions = [];
    public array $headOfServiceOptions = [];

    public function mount(): void
    {

    // dd($this->establishmentId);
        $this->local = app()->getLocale();
        $this->initializeOptions();
        if ($this->isUpdating()) {
            $this->form = 'updateForm';
            $this->loadServiceDataSafe();
        } else {
            $this->initializeAddForm();
        }

    }

    protected function isUpdating(): bool
    {
        return !is_null($this->id);
    }

    protected function initializeAddForm(): void
    {
        $this->addForm->fill([
            'establishment_id' => $this->establishmentId,
            "type"=>"health"
        ]);
    }

    protected function initializeOptions(): void
    {
        $this->serviceTypesOptions =
            config('core.options.SERVICE_TYPE')[$this->local] ?? [];

        $this->serviceSpecialtiesOptions = $this->populateSelectorOption(
            $this->specialties(),
            'id',
            'designation_' . $this->local,
            __('selectors.default.field_specialties')
        );

        /**
         * ✅ FIXED: use full_name accessor
         */


        $this->headOfServiceOptions = $this->populateSelectorOption(
            $this->staff(),
            'id',
            'full_name',
            __('selectors.default.head_of_service')
        );
    }

    protected function loadServiceDataSafe(): void
    {
        try {
            $this->loadServiceData();
        } catch (ModelNotFoundException $e) {
            $this->handleLoadError($e);
        }
    }

    protected function loadServiceData(): void
    {
        $this->service = Service::findOrFail($this->id);

        $this->updateForm->fill([
            'id' => $this->service->id,
            'name_ar' => $this->service->name_ar,
            'name_fr' => $this->service->name_fr,
            'name_en' => $this->service->name_en,
            'head_of_service_id' => $this->service->head_of_service_id,
            'type' => $this->service->type,
            'tel' => $this->service->tel,
            'fax' => $this->service->fax,
            'specialty_id' => $this->service->specialty_id,
            'establishment_id' => $this->service->establishment_id,
        ]);
    }

    #[Computed]
    public function specialties()
    {
        return FieldSpecialty::query()
            ->whereHas('field', fn ($q) => $q->where('acronym', 'F_MED'))
            ->get([
                'id',
                'designation_' . $this->local
            ]);
    }

    /**
     * ✅ FIXED STAFF: full_name accessor (NO ARRAY MAP)
     */
    #[Computed]
    public function staff()
    {
        return User::query()
            ->where('establishment_id', $this->establishmentId)
            ->get(['id', 'first_name', 'last_name']);
    }

    public function handleSubmit(): void
    {
        $response = $this->isUpdating()
            ? $this->updateForm->save($this->service)
            : $this->addForm->save();

        if (! $response['status']) {
            $this->dispatch('open-errors', $response['errors']);
            return;
        }

        if (! $this->isUpdating()) {
            $this->resetAddForm();
        }

        $this->dispatch('update-services-table');
        $this->dispatch('open-toast', $response['message']);
    }

    protected function resetAddForm(): void
    {
        $this->addForm->reset();

        $this->addForm->fill([
            'establishment_id' => $this->establishmentId,
        ]);
    }

    protected function handleLoadError(\Throwable $exception): void
    {
        Log::error('Error loading service', [
            'message' => $exception->getMessage(),
            'service_id' => $this->id,
        ]);

        $this->dispatch(
            'open-errors',
            __('forms.common.errors.default')
        );
    }

    public function render()
    {
        return view('livewire.app.establishment-admin.service-modal');
    }
}
