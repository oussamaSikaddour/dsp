<?php

namespace App\Livewire\App\EstablishmentAdmin;

use App\Models\FieldSpecialty;
use App\Models\Service;
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

class ServicesTable extends Component
{
    use WithPagination;
    use TableTrait;
    use GeneralTrait;
    use WithFileUploads;
    use WebResponseTrait;
    use TextAndPdfTrait;

    #[Url]
    public string $name = '';

    #[Url]
    public string $type = '';

    #[Url]
    public string $specialtyId = '';

    #[Url]
    public string $headOfService = '';

    public string $local = 'fr';

    public ?int $establishmentId = null;

    public array $serviceTypesOptions = [];
    public array $serviceSpecialtiesOptions = [];

    protected array $filterable = [
        'name',
        'type',
        'headOfService',
        'specialtyId',
    ];

    protected array $validationRules = [
        'name' => ['nullable', 'string', 'max:255'],
        'headOfService' => ['nullable', 'string', 'max:255'],
        'type' => ['nullable', 'in:administration,health'],
        'specialtyId' => ['nullable'],
    ];

    public function mount(): void
    {
        $this->local = app()->getLocale();

        $this->serviceTypesOptions =
            config('core.options.SERVICE_TYPE.' . $this->local) ?? [];

        $this->serviceSpecialtiesOptions =
            $this->populateSelectorOption(
                $this->specialties(),
                'id',
                'designation_' . $this->local,
                __('selectors.default.field_specialties')
            );
    }

    #[Computed]
    public function specialties()
    {
        return FieldSpecialty::query()
            ->whereHas('field', fn($q) => $q->where('acronym', 'F_MED'))
            ->get([
                'id',
                'designation_' . $this->local,
            ]);
    }

    public function resetFilters(): void
    {
        $this->reset(
            'name',
            'type',
            'headOfService',
            'specialtyId'
        );

        $this->resetPage();
    }

    protected function servicesQuery()
    {
        $local = in_array($this->local, ['fr', 'en']) ? $this->local : 'fr';

        $containsArabic = preg_match('/\p{Arabic}/u', $this->name ?? '');

        $searchColumn = $containsArabic
            ? 'services.name_ar'
            : "services.name_{$local}";

        return Service::query()

            ->select([
                'services.id',
                'services.type',
                'services.specialty_id',
                'services.head_of_service_id',
                'services.name_ar',
                'services.name_fr',
                'services.name_en',
                'services.establishment_id',

                // ✅ FIX: force created_at from services ONLY
                'services.created_at as created_at',
            ])

            ->leftJoin('users as heads', 'services.head_of_service_id', '=', 'heads.id')
            ->leftJoin('field_specialties', 'services.specialty_id', '=', 'field_specialties.id')

            ->addSelect([
                'heads.id as head_service_id',
                \DB::raw("CONCAT(heads.last_name, ' ', heads.first_name) as head_service"),
                "field_specialties.designation_{$local} as specialty",
            ])

            ->where('services.establishment_id', $this->establishmentId)

            ->when(filled($this->name), function ($q) use ($searchColumn) {
                $q->where($searchColumn, 'like', "%{$this->name}%");
            })

            ->when(filled($this->type), function ($q) {
                $q->where('services.type', $this->type);
            })

            ->when(filled($this->headOfService), function ($q) {
                $q->whereRaw(
                    "CONCAT(heads.last_name, ' ', heads.first_name) LIKE ?",
                    ["%{$this->headOfService}%"]
                );
            })

            ->when(filled($this->specialtyId), function ($q) {
                $q->where('services.specialty_id', $this->specialtyId);
            });
    }
    #[Computed]
    public function services()
    {
        return $this->servicesQuery()
            ->orderBy(
                $this->sortBy,
                $this->sortDirection
            )
            ->paginate($this->perPage);
    }

    #[On('delete-service')]
    public function deleteService(Service $service): void
    {
        try {
            $service->delete();

            $this->dispatch('update-services-table');
        } catch (\Throwable $e) {
            Log::error(
                'Error deleting service: ' .
                    $e->getMessage()
            );

            $this->dispatch(
                'open-errors',
                __('forms.common.errors.default')
            );
        }
    }

    public function openDeleteDialog(array $service): void
    {

    $key="delete.service";
        $this->dispatch('open-dialog', [
            'question' => $key,
            'details' => [
                  $key,
                $service['name_' . $this->local],
            ],
            'actionEvent' => [
                'event' => 'delete-service',
                'parameters' => $service['id'],
            ],
        ]);
    }

    public function updated(string $property): void
    {
        if ($property === 'excelFile') {
            $errorsFileData =
                $this->whenExcelFileUploaded(
                    'App\ServicesImport',
                    __('tables.services.excel.upload.success'),
                    [$this->establishmentId]
                );

            if (is_array($errorsFileData)) {
                $this->dispatch(
                    'errors-file-data',
                    errorsFileData: $errorsFileData
                );
            }
        }

        if (
            in_array($property, $this->filterable) ||
            $property === 'perPage'
        ) {
            $this->resetPage();
        }

        if (
            array_key_exists(
                $property,
                $this->validationRules
            )
        ) {
            try {
                $this->validateOnly(
                    $property,
                    $this->validationRules
                );
            } catch (ValidationException $e) {
                $this->dispatch(
                    'open-errors',
                    $e->validator
                        ->errors()
                        ->all()
                );
            }
        }
    }

    public function generateEmptyServicesExcel()
    {
        return $this->generateEmptyExcelWithHeaders(
            'services_vide',
            [
                'Nom (français)',
                'Nom (arabe)',
                'Nom (anglais)',
                'Chef de service',
                'Type',
                'Spécialité',
                'Téléphone',
                'Fax',
            ]
        );
    }

    public function generateServicesExcel()
    {
        return $this->generateExcel(
            fn() => $this->services()
                ->map(fn($service) => [
                    __('tables.services.name_fr') =>
                    $service->name_fr,

                    __('tables.services.name_ar') =>
                    $service->name_ar,

                    __('tables.services.name_en') =>
                    $service->name_en,

                    __('tables.services.type') =>
                    $this->serviceTypesOptions[$service->type]
                        ?? $service->type,

                    __('tables.services.specialty') =>
                    $service->specialty,

                    __('tables.services.tel') =>
                    $service->tel,

                    __('tables.services.fax') =>
                    $service->fax,

                    __('tables.services.created_at') =>
                    $service->created_at->format('d/m/Y'),
                ])
                ->toArray(),
            'services'
        );
    }

    #[On('errors-file-data')]
    public function downloadServicesErrorsTextFile(
        array $errorsFileData
    ) {
        return $this->streamFileDownload(
            $errorsFileData['filePath'],
            $errorsFileData['fileName']
        );
    }

    public function render()
    {
        return view(
            'livewire.app.establishment-admin.services-table'
        );
    }
}
