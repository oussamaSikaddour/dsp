<?php

namespace App\Livewire\App;

use App\Livewire\Forms\App\Patient\AddForm;
use App\Livewire\Forms\App\Patient\UpdateForm;
use App\Models\Commune;
use App\Models\Daira;
use App\Models\Patient;
use App\Traits\Core\Common\GeneralTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PatientModal extends Component
{
    use GeneralTrait;

    public AddForm $addForm;
    public UpdateForm $updateForm;

    public ?Patient $patient = null;

    public ?int $patientId = null;
    public ?int $dairaId = null;


    public string $form = 'addForm';
    public string $locale;



    public array $dairatesOptions = [];
    public array $communesOptions = [];
    public array $motherOptions = [];
    public array $fatherOptions = [];
    public array $gendersOptions = [];

    public bool $isForServicePersonnel=false;


    protected function localFrAndArOnly(): string
    {
        return in_array($this->locale, ['fr', 'ar']) ? $this->locale : 'fr';
    }


    protected function baseParentsQuery(string $gender)
    {
        return Patient::query()
            ->where('opened_by', auth()->id())
            ->where('gender', $gender);
    }

    #[Computed()]
    public function dairates()
    {
        return Daira::query()
            ->whereHas('wilaya', fn($q) => $q->where('code', '13'))
            ->get(['id', 'designation_' . $this->locale]);
    }

    #[Computed]
    public function communes()
    {
        return Commune::query()
            ->when($this->dairaId, fn($q) => $q->where('daira_id', $this->dairaId))
            ->get(['id', 'designation_' . $this->locale]);
    }


    #[Computed]
    public function fathers()
    {
        $locale = $this->localFrAndArOnly();

        $lastNameColumn = "last_name_{$locale}";
        $firstNameColumn = "first_name_{$locale}";

        return $this->baseParentsQuery('male')
            ->orderBy($lastNameColumn)
            ->orderBy($firstNameColumn)
            ->get(['id', $firstNameColumn, $lastNameColumn])
            ->map(function ($patient) use ($firstNameColumn, $lastNameColumn) {
                $firstName = $patient->{$firstNameColumn} ?? '';
                $lastName  = $patient->{$lastNameColumn} ?? '';

                return [
                    'id' => $patient->id,
                    'full_name' => trim("$lastName $firstName") ?: 'Unknown User',
                ];
            });
    }



    #[Computed]
    public function mothers()
    {
        $locale = $this->localFrAndArOnly();

        $lastNameColumn = "last_name_{$locale}";
        $firstNameColumn = "first_name_{$locale}";

        return $this->baseParentsQuery('female')
            ->orderBy($lastNameColumn)
            ->orderBy($firstNameColumn)
            ->get(['id', $firstNameColumn, $lastNameColumn])
            ->map(function ($patient) use ($firstNameColumn, $lastNameColumn) {
                $firstName = $patient->{$firstNameColumn} ?? '';
                $lastName  = $patient->{$lastNameColumn} ?? '';

                return [
                    'id' => $patient->id,
                    'full_name' => trim("$lastName $firstName") ?: 'Unknown User',
                ];
            });
    }





    /*
    |---------------------------------------
    | OPTIONS
    |---------------------------------------
    */

    protected function loadOptions(): void
    {
        $this->gendersOptions = config('core.options.GENDER.' . $this->locale, []);



        $this->dairatesOptions = $this->selectorOptions($this->dairates(), 'id', 'designation_' . $this->locale, __('selectors.default.dairates'));
        $this->communesOptions = $this->selectorOptions($this->communes(), 'id', 'designation_' . $this->locale, __('selectors.default.communes'));
        $this->fatherOptions = $this->populateSelectorOption(
            $this->fathers(),
            'id',
            'full_name',
            __('selectors.default.fathers')
        );
        $this->motherOptions = $this->populateSelectorOption(
            $this->mothers(),
            'id',
            'full_name',
            __('selectors.default.mothers')
        );
    }


    public function updatedDairaId()
    {
        $this->communesOptions = $this->selectorOptions(
            $this->communes(),
            'id',
            'designation_' . $this->locale,
            __('selectors.default.communes')
        );
    }


    public function mount(): void
    {

        $this->locale = app()->getLocale();
        $this->loadOptions();

        if ($this->patientId) {
            $this->form = 'updateForm';
            $this->loadPatient();
        } else {
            $this->initializeForm();
        }
    }


    protected function initializeForm(): void
    {
        $this->addForm->fill([
            'opened_by' => auth()->id(),
        ]);
    }

protected function loadPatient(): void
{
    try {
        $this->patient = Patient::findOrFail($this->patientId);

        $this->updateForm->fill([
            'id' => $this->patient->id,
            'code'=>$this->patient->code,
            'first_name_fr' => $this->patient->first_name_fr,
            'first_name_ar' => $this->patient->first_name_ar,
            'last_name_fr'  => $this->patient->last_name_fr,
            'last_name_ar'  => $this->patient->last_name_ar,

            'gender' => $this->patient->gender??'',

            // ✅ FIX: format for HTML date input
            'birth_date' => optional($this->patient->birth_date)?->format('Y-m-d'),

            'birth_place_fr' => $this->patient->birth_place_fr,
            'birth_place_ar' => $this->patient->birth_place_ar,
            'birth_place_en' => $this->patient->birth_place_en,

            'address_fr' => $this->patient->address_fr,
            'address_ar' => $this->patient->address_ar,
            'address_en' => $this->patient->address_en,

            'commune_id' => $this->patient->commune_id,

            'father_id' => $this->patient->father_id,
            'mother_id' => $this->patient->mother_id,

            'tel' => $this->patient->tel,
            'insurance_number' => $this->patient->insurance_number,

            'opened_by' => auth()->id(),
        ]);

    } catch (ModelNotFoundException $e) {

        Log::error('Patient not found: ' . $e->getMessage());

        $this->dispatch('open-errors', __('Not found'));
    }
}

    public function handleSubmit(): void
    {
        $this->dispatch('form-submitted');

        $response = $this->patientId
            ? $this->updateForm->save($this->patient)
            : $this->addForm->save($this->isForServicePersonnel);

        if ($response['status']) {

            $this->dispatch('update-patients-table');
            $this->dispatch('open-toast', $response['message']);

            if ($this->form === 'addForm') {
                $this->addForm->reset();
                $this->initializeForm();
            }

            return;
        }

        $this->dispatch('open-errors', $response['errors']);
    }

    public function render()
    {
        return view('livewire.app.patient-modal');
    }

    protected function selectorOptions($items, $valueKey, $labelKey, $placeholder): array
    {
        return $this->populateSelectorOption($items, $valueKey, $labelKey, $placeholder);
    }
}
