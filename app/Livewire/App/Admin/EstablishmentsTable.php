<?php

namespace App\Livewire\App\Admin;

use App\Models\Daira;
use App\Models\Establishment;
use App\Traits\Core\Common\GeneralTrait;
use App\Traits\Core\Common\TableTrait;
use App\Traits\Core\Common\TextAndPdfTrait;
use App\Traits\Core\Web\ResponseTrait as WebResponseTrait;
use App\Traits\Web\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class EstablishmentsTable extends Component
{

          use WithPagination, TableTrait, GeneralTrait,WithFileUploads, WebResponseTrait, TextAndPdfTrait;

    #[Url()]
    public $name = "";
    #[Url()]
    public $acronym = "";
    #[Url()]
    public $daira = "";

    public $local = "fr";
    public array $dairasOptions = [];

    protected array $filterable = ['name', 'acronym','daira'];

    protected array $validationRules = [
        'name' => ['nullable', 'string', 'max:255'],
        'acronym' => ['nullable', 'string', 'max:255'],
        'daira' => ['nullable', 'string', 'max:255'],
    ];


#[Computed]
public function dairates()
{
    return Daira::query()
        ->whereHas('wilaya', fn ($q) =>
            $q->where('code', '13')
        )
        ->get(['id', 'designation_' . $this->local]);
}


    public function mount()
    {

        $this->local = app()->getLocale();

        $this->dairasOptions =  $this->populateSelectorOption($this->dairates(),  'id','designation_'.$this->local, __('selectors.default.dairates'));

    }

    public function resetFilters()
    {
        $this->reset(['name', 'acronym', 'daira']);
        $this->resetPage();
    }

#[Computed()]
public function establishments()
{
    // fallback locale to fr if missing
    $local = in_array($this->local, ['fr', 'en']) ? $this->local : 'fr';

    return Establishment::query()
        ->select([
            'establishments.*',
            "dairates.designation_{$this->local} as daira_name"
        ])
        ->leftJoin('dairates', 'dairates.id', '=', 'establishments.daira_id')
        ->when(!empty($this->name), function ($q) use($local) {
            $containsArabic = preg_match('/\p{Arabic}/u', $this->name);
            $column = $containsArabic ? 'name_ar' : "name_{$local}";
            $q->where($column, 'like', "%{$this->name}%");
        })
        ->when(!empty($this->daira), function ($q) {
            $q->where("dairates.id", $this->daira);
        })
        ->where('acronym', 'like', "%{$this->acronym}%")
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
}





    #[On("delete-establishment")]
    public function deleteEstablishment(Establishment $establishment)
    {
        try {
            $establishment->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting establishment: ' . $e->getMessage());
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }


public function openDeleteEstablishmentDialog(array $establishment): void
{
    $key = 'delete.establishment';

    $this->dispatch('open-dialog', [
        'question' => $key,

        'details' => [
            $key,
            $establishment['name_' . $this->local] ?? '',
        ],

        'actionEvent' => [
            'event' => 'delete-establishment',
            'parameters' => $establishment,
        ],
    ]);
}




    public function updated(string $property): void
    {

         if($property ==="excelFile"){
            $errorsFileData= $this->whenExcelFileUploaded("App\EstablishmentsImport",__('tables.establishments.excel.upload.success') );

            if(is_array($errorsFileData) ){
            $this->dispatch('errors-file-data', errorsFileData: $errorsFileData);
        }
    }
        if (in_array($property, $this->filterable) || $property === 'perPage') {
            $this->resetPage();
        }

        if (array_key_exists($property, $this->validationRules)) {
            try {
                $this->validateOnly($property, $this->validationRules);
            } catch (ValidationException $e) {
                $this->dispatch('open-errors', $e->validator->errors()->all());
            }
        }
    }


    public function render()
    {
        return view('livewire.app.admin.establishments-table');
    }




        #[On('errors-file-data')]
    public function downloadEstablishmentsErrorsTextFile($errorsFileData)
    {

        return $this->streamFileDownload($errorsFileData['filePath'], $errorsFileData['fileName']);
    }

    public function generateEmptyEstablishmentsExcel()
    {
        return $this->generateEmptyExcelWithHeaders("establishments",
        [
            "Acronym",
            "Nom (français)",
            "Nom (arabe)",
            "Nom (anglais)",
            'Email',
            'Téléphone',
            'Fax',
            'Lieu de consultations',
            'Longitude',
            'Latitude',
            'daira',
        ]
        );
    }

        public function generateEstablishmentsExcel()
    {
        $locale = app()->getLocale();
        return $this->generateExcel(fn() => $this->establishments()->map(fn($est) => [
            __("tables.establishments.acronym") => $est->acronym,
            __("tables.establishments.name_fr") => $est->name_fr,
            __("tables.establishments.name_ar") => $est->name_ar,
            __("tables.establishments.name_en") => $est->name_en,
            __("tables.establishments.email") => $est->email,
            __("tables.establishments.tel") => $est->tel,
            __("tables.establishments.fax") => $est->fax,
            __("tables.establishments.longitude") => $est->longitude,
            __("tables.establishments.latitude") => $est->latitude,
            __("tables.establishments.created_at") => $est->created_at->format('d-m-Y'),
            __("tables.establishments.daira") => config('constants.DAIRAS')[$this->local][
                $est->daira
            ],

        ])->toArray(), "establishments");
    }
public function openGoogleMap($latitude, $longitude)
{
    $url = "https://www.google.com/maps/search/?api=1&query={$latitude},{$longitude}";
    $this->dispatch('open-google-map', $url);
}

}
