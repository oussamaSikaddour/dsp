<?php

namespace App\Livewire\App;

use App\Models\Commune;
use App\Models\Patient;
use App\Traits\Core\Common\GeneralTrait;
use App\Traits\Core\Common\TableTrait;
use App\Traits\Core\Common\TextAndPdfTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PatientsTable extends Component
{
    use WithPagination, TableTrait, GeneralTrait, TextAndPdfTrait;



    public $openedBy;
    #[Url]
    public string $code = '';

    #[Url]
    public string $name = '';

    #[Url]
    public string $gender = '';

    #[Url]
    public string $tel = '';

    #[Url]
    public ?int $communeId = null;
    public ?int $serviceId = null;

    public string $locale = 'fr';

    public array $communesOptions = [];
    public array $genderOptions = [];

    public bool $isForServicePersonnel = false;
    public string $patientsTableInfoText = "";
    public string $patientsTableNotFoundText = "";

    protected array $filterable = [
        'code',
        'name',
        'gender',
        'tel',
        'communeId',
    ];

    protected array $rules = [
        'code' => ['nullable', 'string', 'max:50'],
        'name' => ['nullable', 'string', 'max:255'],
        'gender' => ['nullable', 'in:male,female,other'],
        'tel' => ['nullable', 'string', 'max:30'],
        'communeId' => ['nullable', 'exists:communes,id'],
    ];

    public function mount(): void
    {

        $mode = $this->isForServicePersonnel ? 'patients' : 'relatives';

        $this->patientsTableInfoText = __("tables.patients.info.$mode");
        $this->patientsTableNotFoundText = __("tables.patients.not_found.$mode");
        $this->dispatch('init-tooltips');
        $this->locale = app()->getLocale();

        $this->genderOptions = config(
            'core.options.GENDER.' . $this->locale,
            []
        );

        $this->communesOptions = $this->populateSelectorOption(
            Commune::query()
                ->orderBy('designation_' . $this->locale)
                ->get(),
            'id',
            'designation_' . $this->locale,
            __('selectors.default.communes')
        );
    }

    public function resetFilters(): void
    {
        $this->reset([
            'code',
            'name',
            'gender',
            'tel',
            'communeId',
        ]);

        $this->resetPage();
    }

    #[Computed]
    public function patients()
    {
        return $this->buildPatientsQuery()
            ->paginate($this->perPage);
    }

    protected function buildPatientsQuery()
    {
        $containsArabic = preg_match('/\p{Arabic}/u', $this->name);

        return Patient::query()
            ->leftJoin('communes', 'communes.id', '=', 'patients.commune_id')
            ->leftJoin('users', 'users.id', '=', 'patients.opened_by')
            ->when(
                filled($this->serviceId),
                fn($q) => $q->whereHas(
                    'appointments',
                    fn($appointmentQuery) => $appointmentQuery->where('service_id', $this->serviceId)
                )
            )
            ->when(
                filled($this->openedBy),
                fn($q) => $q->where('opened_by', $this->openedBy)
            )
            ->when(
                filled($this->code),
                fn($q) => $q->where('code', 'like', "%{$this->code}%")
            )

            ->when(
                filled($this->name),
                function ($q) use ($containsArabic) {

                    if ($containsArabic) {

                        $q->where(function ($query) {
                            $query
                                ->where('patients.first_name_ar', 'like', "%{$this->name}%")
                                ->orWhere('patients.last_name_ar', 'like', "%{$this->name}%");
                        });
                    } else {

                        $q->where(function ($query) {
                            $query
                                ->where('patients.first_name_fr', 'like', "%{$this->name}%")
                                ->orWhere('patients.last_name_fr', 'like', "%{$this->name}%");
                        });
                    }
                }
            )

            ->when(
                filled($this->gender),
                fn($q) => $q->where('patients.gender', $this->gender)
            )

            ->when(
                filled($this->tel),
                fn($q) => $q->where('patients.tel', 'like', "%{$this->tel}%")
            )

            ->when(
                filled($this->communeId),
                fn($q) => $q->where('patients.commune_id', $this->communeId)
            )

            ->select([
                'patients.*',
                'users.was_generated_by_appointments_location_agent as auto_generated',
                "communes.designation_{$this->locale} as commune_name",
            ])

            ->orderBy($this->sortBy, $this->sortDirection);
    }

    public function openDeleteDialog(Patient $patient): void
    {
        $this->dispatch('open-dialog', [
            'question' => 'delete.patient',
            'details' => [
                'delete.patient',
                $patient->localized_full_name,
            ],
            'actionEvent' => [
                'event' => 'delete-patient',
                'parameters' => $patient->id,
            ],
        ]);
    }

    #[On('delete-patient')]
    public function deletePatient(Patient $patient): void
    {
        try {

            $patient->delete();

            $this->dispatch('update-patients-table');

            $this->dispatch(
                'open-toast',
                __('messages.patient.deleted')
            );
        } catch (\Throwable $e) {

            Log::error($e->getMessage());

            $this->dispatch(
                'open-errors',
                __('forms.common.errors.default')
            );
        }
    }

    public function updated(string $property): void
    {
        if (
            in_array($property, $this->filterable, true)
            || $property === 'perPage'
        ) {
            $this->resetPage();
        }

        if (array_key_exists($property, $this->rules)) {

            try {
                $this->validateOnly($property);
            } catch (ValidationException $e) {
                $this->dispatch(
                    'open-errors',
                    $e->validator->errors()->all()
                );
            }
        }
    }


    public function generatePatientPdf(Patient $patient)
    {
        try {

            $patient->load([
                'openedBy.roles',
                'commune',
            ]);

            $openedBy = $patient->openedBy;

            $data = [
                'patient_code' => $patient->code,
                'patient_name' => $patient->localized_full_name,
                'patient_tel' => $patient->tel,
                'gender' => $patient->gender,

                'birth_date' => $patient->birth_date
                    ? Carbon::parse($patient->birth_date)->format('d-m-Y')
                    : '-',

                'commune' => $patient->commune?->{'designation_' . $this->locale} ?? '-',

                /*
            |---------------------------------------
            | OPENED BY ACCOUNT INFO
            |---------------------------------------
            */
                'opened_by' => $openedBy ? [
                    'name' => $openedBy->name,
                    'email' => $openedBy->email,
                    'is_auto_generated' => (bool) $openedBy->was_generated_by_appointments_location_agent,
                    'password' => $openedBy->was_generated_by_appointments_location_agent
                        ? '12345678'
                        : null,
                ] : null,

                'generated_at' => now()->format('d/m/Y H:i'),
            ];

            return $this->generateAndDownloadPdf(
                "pdfs.{$this->locale}.patient-profile",
                $data,
                'patient-' . $patient->code . '.pdf'
            );
        } catch (\Throwable $e) {

            Log::error('Patient PDF Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch(
                'open-errors',
                __('forms.common.errors.default')
            );
        }
    }
    public function render()
    {

        return view('livewire.app.patients-table');
    }
}
