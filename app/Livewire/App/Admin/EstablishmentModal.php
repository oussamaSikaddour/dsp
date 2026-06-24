<?php

namespace App\Livewire\App\Admin;

use App\Livewire\Forms\App\Establishment\AddForm;
use App\Livewire\Forms\App\Establishment\UpdateForm;
use App\Models\Daira;
use App\Models\Establishment;
use App\Traits\Core\Common\DateAndTimeTrait;
use App\Traits\Core\Common\GeneralTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class EstablishmentModal extends Component
{
    use GeneralTrait, DateAndTimeTrait;

    public AddForm $addForm;
    public UpdateForm $updateForm;

    public Establishment $establishment;

    public $id;
    public $form = 'addForm';

    public $local = 'fr';
    public $dairatesOptions = [];

    // Optional preview states (like ArticleModal)
    public $descriptionFr = '';
    public $descriptionAr = '';
    public $descriptionEn = '';

    /* ---------------- Computed ---------------- */

    #[Computed]
    public function formEntity()
    {
        return $this->id ? $this->updateForm : $this->addForm;
    }

    #[Computed]
    public function dairates()
    {
        return Daira::query()
            ->whereHas('wilaya', fn ($q) => $q->where('code', '13'))
            ->get(['id', 'designation_' . $this->local]);
    }

    /* ---------------- Mount ---------------- */

    public function mount()
    {

        $this->local = app()->getLocale();

        $this->dispatch('initialize-tiny-mce');

        $this->dairatesOptions = $this->populateSelectorOption(
            $this->dairates(),
            'id',
            'designation_' . $this->local,
            __('selectors.default.dairates')
        );

        if ($this->id) {
            $this->form = 'updateForm';

            try {
                $this->loadEstablishmentData();
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $this->handleMountError($e);
            }
        }
    }

    /* ---------------- Load Data ---------------- */

    protected function loadEstablishmentData()
    {
        $this->establishment = Establishment::findOrFail($this->id);

        $this->fillUpdateForm();
    }

    protected function fillUpdateForm()
    {
        $this->updateForm->fill([
            'id' => $this->id,
            'acronym' => $this->establishment->acronym,
            'email' => $this->establishment->email,

            'name_ar' => $this->establishment->name_ar,
            'name_fr' => $this->establishment->name_fr,
            'name_en' => $this->establishment->name_en,

            'address_ar' => $this->establishment->address_ar,
            'address_fr' => $this->establishment->address_fr,
            'address_en' => $this->establishment->address_en,

            'description_ar' => $this->establishment->description_ar,
            'description_fr' => $this->establishment->description_fr,
            'description_en' => $this->establishment->description_en,

            'tel' => $this->establishment->tel,
            'fax' => $this->establishment->fax,

            'daira_id' => $this->establishment->daira_id,
            'longitude' => $this->establishment->longitude,
            'latitude' => $this->establishment->latitude,
        ]);

        // preview state (like ArticleModal)
        $this->descriptionFr = $this->establishment->description_fr ?? '';
        $this->descriptionAr = $this->establishment->description_ar ?? '';
        $this->descriptionEn = $this->establishment->description_en ?? '';
    }

    /* ---------------- Submit ---------------- */

    public function handleSubmit()
    {
        $response = $this->id
            ? $this->updateForm->save($this->establishment)
            : $this->addForm->save();

        if ($response['status']) {
            $this->dispatch('update-establishments-table');
            $this->dispatch('open-toast', $response['message']);

            if (!$this->id) {
                $this->addForm->reset();
            }
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }

    /* ---------------- TinyMCE Events ---------------- */

    #[On('set-description-fr')]
    public function setDescriptionFr($description)

    {

        $this->formEntity->fill(['description_fr' => $description]);
    }

    #[On('set-description-en')]
    public function setDescriptionEn($description)
    {
        $this->formEntity->fill(['description_en' => $description]);
    }

    #[On('set-description-ar')]
    public function setDescriptionAr($description)
    {
        $this->formEntity->fill(['description_ar' => $description]);
    }

    /* ---------------- Error Handling ---------------- */

    protected function handleMountError($exception)
    {
        Log::error('Error in EstablishmentModal mount:', [
            'message' => $exception->getMessage(),
            'exception' => $exception,
            'establishment_id' => $this->id,
        ]);

        $this->dispatch('open-errors', __('forms.common.errors.default'));
    }

    /* ---------------- Render ---------------- */

    public function render()
    {
        return view('livewire.app.admin.establishment-modal');
    }
}
