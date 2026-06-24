<?php

namespace App\Livewire\App;

use App\Models\Appointment;
use App\Models\Daira;
use App\Models\Establishment;
use App\Models\FieldSpecialty;
use App\Models\User;
use App\Models\Patient;
use App\Models\ScheduleDay;
use App\Models\Service;
use App\Traits\Core\Common\GeneralTrait;
use App\Traits\Core\Common\ModelImageTrait;
use App\Traits\Core\Common\TableTrait;
use App\Traits\Core\Common\TextAndPdfTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AppointmentsTable extends Component
{
    use TableTrait, WithPagination, TextAndPdfTrait, GeneralTrait, ModelImageTrait;

    /* =========================
        PROPERTIES
    ========================= */

    #[Url] public ?int $year = null;
    #[Url] public ?int $month = null;

    #[Url] public string $patient = '';
    #[Url] public string $patientCode = '';

    public ?int $specialtyId = null;
    public ?int $patientId = null;
    public ?int $serviceId = null;
    public ?int $dairaId = null;
    public ?int $appointmentsLocationId = null;

    #[Url] public string $scheduleDayDate = '';

    public string $locale = 'fr';

    public array $yearsOptions = [];
    public array $monthsOptions = [];
    public array $scheduleDaysOptions = [];
    public array $dairatesOptions = [];
    public array $appointmentTypeOptions = [];
    public array $serviceOptions = [];
    public array $specialtiesOptions = [];
    public array $genderOptions = [];
    public array $appointmentsLocationsOptions = [];
    public array $appointmentTypes = [];
    public bool $isForServicePersonnel = false;

    protected array $filterable = [
        'patient',
        'patientCode',
        'year',
        'month',
        'scheduleDayDate',
        'specialtyId',
        'serviceId',
        'dairaId',
        'appointmentsLocationId',
    ];

    protected $rules = [
        'patient' => ['nullable', 'string', 'max:255'],
        'patientCode' => ['nullable', 'string', 'max:20'],
        'year' => ['nullable', 'integer', 'between:2023,2050'],
        'month' => ['nullable', 'integer', 'between:1,12'],
        'scheduleDayDate' => ['nullable', 'date', 'date_format:Y-m-d'],
        'dairaId' => ['nullable', 'exists:dairates,id'],
        'appointmentsLocationId' => ['nullable', 'exists:establishments,id'],
        'specialtyId' => ['nullable', 'exists:field_specialties,id'],
        'serviceId' => ['nullable', 'exists:services,id'],
    ];
    /* =========================
        LIFECYCLE
    ========================= */

    public function mount(): void
    {

        if ($this->isForServicePersonnel) {
            $this->year = now()->year;
            $this->month = now()->month;
        }
        $this->locale = app()->getLocale();
        $this->refreshOptions();
    }

    public function render()
    {
        return view('livewire.app.appointments-table');
    }

    /* =========================
        QUERY METHODS
    ========================= */

    #[Computed]
    public function scheduleSlots()
    {
        return $this->buildScheduleSlotsQuery()
            ->paginate($this->perPage);
    }

#[Computed]
public function confirmedAppointments()
{
    // FULL NAME (FR + AR)
    $fullNameFr = "CONCAT(patients.last_name_fr, ' ', patients.first_name_fr)";
    $fullNameAr = "CONCAT(patients.last_name_ar, ' ', patients.first_name_ar)";

    $fullNameDisplay = "
        COALESCE(
            NULLIF(CONCAT(patients.last_name_fr, ' ', patients.first_name_fr), ' '),
            CONCAT(patients.last_name_ar, ' ', patients.first_name_ar)
        )
    ";

    return Appointment::query()
        ->leftJoin('patients', 'patients.id', '=', 'appointments.patient_id')
        ->leftJoin('services', 'services.id', '=', 'appointments.service_id')
        ->leftJoin('establishments', 'establishments.id', '=', 'appointments.appointments_location_id')
        ->leftJoin('dairates', 'dairates.id', '=', 'establishments.daira_id')
        ->leftJoin('field_specialties', 'field_specialties.id', '=', 'appointments.specialty_id')

        ->when($this->year, fn($q) =>
            $q->whereYear('appointments.day_at', $this->year)
        )

        ->when($this->month, fn($q) =>
            $q->whereMonth('appointments.day_at', $this->month)
        )

        ->when($this->patientId, fn($q) =>
            $q->where('patients.id', $this->patientId)
        )

        ->when($this->patientCode, fn($q) =>
            $q->where('patients.code', 'like', "%{$this->patientCode}%")
        )

        // 🔎 SEARCH BOTH LANGUAGES
        ->when(
            filled($this->patient),
            fn($q) => $q->where(function ($sub) use ($fullNameFr, $fullNameAr) {
                $sub->whereRaw(
                    "LOWER($fullNameFr) LIKE ?",
                    ['%' . mb_strtolower($this->patient) . '%']
                )
                ->orWhereRaw(
                    "LOWER($fullNameAr) LIKE ?",
                    ['%' . mb_strtolower($this->patient) . '%']
                );
            })
        )

        ->when($this->scheduleDayDate, fn($q) =>
            $q->whereDate('appointments.day_at', $this->scheduleDayDate)
        )

        ->when($this->specialtyId, fn($q) =>
            $q->where('appointments.specialty_id', $this->specialtyId)
        )

        ->when($this->serviceId, fn($q) =>
            $q->where('appointments.service_id', $this->serviceId)
        )

        ->when($this->dairaId, fn($q) =>
            $q->where('establishments.daira_id', $this->dairaId)
        )

        ->when($this->appointmentsLocationId, fn($q) =>
            $q->where('appointments.appointments_location_id', $this->appointmentsLocationId)
        )

        ->select([
            'appointments.*',
            'patients.code as patient_code',
            'patients.tel as patient_tel',
            'patients.birth_date as patient_birth_date',

            // 🛟 DISPLAY NAME (FR fallback → AR)
            DB::raw("$fullNameDisplay as patient_name"),

            "field_specialties.designation_{$this->locale} as specialty",
            "services.name_{$this->locale} as service",
            "establishments.name_{$this->locale} as location_name",
            'establishments.longitude',
            'establishments.latitude',
        ])

        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
}



    /* =========================
        DATA SOURCES
    ========================= */

    #[Computed]
    public function scheduleDays()
    {
        return ScheduleDay::query()
            ->whereYear('day_at', $this->year)
            ->when($this->specialtyId, fn($q) => $q->where('specialty_id', $this->specialtyId))
            ->when($this->month, fn($q) => $q->whereMonth('day_at', $this->month))
            ->orderBy('day_at')
            ->get()
            ->map(fn($item) => $item->day_at->format('Y-m-d'))
            ->unique()
            ->values()
            ->map(fn($date) => [
                'day_at' => $date,
                'date' => $date,
            ]);
    }

    #[Computed]
    public function specialties()
    {
        return FieldSpecialty::query()
            ->whereHas('field', fn($q) => $q->where('acronym', 'F_MED'))
            ->get(['id', 'designation_' . $this->locale]);
    }

    #[Computed]
    public function dairates()
    {
        return Daira::query()
            ->whereHas('wilaya', fn($q) => $q->where('code', '13'))
            ->get(['id', 'designation_' . $this->locale]);
    }

    #[Computed]
    public function appointmentsLocations()
    {
        return Establishment::query()
            ->whereJsonContains('types', 'appointment_locations')
            ->when($this->dairaId, fn($q) => $q->where('daira_id', $this->dairaId))
            ->get(['id', 'name_' . $this->locale]);
    }

    #[Computed]
    public function services()
    {
        return Service::query()
            ->when($this->specialtyId, fn($q) => $q->where('specialty_id', $this->specialtyId))
            ->get(['id', 'name_' . $this->locale]);
    }

    /* =========================
        OPTIONS
    ========================= */

    protected function refreshOptions(): void
    {
        $this->yearsOptions = config('core.dates.YEAR_OPTIONS')[$this->locale] ?? [];
        $this->monthsOptions = config('core.dates.MONTHS_OPTIONS')[$this->locale] ?? [];
        $this->appointmentTypes = config('core.options.APPOINTMENT_TYPES')[$this->locale] ?? [];
        $this->genderOptions = config('core.options.GENDER')[$this->locale] ?? [];
        $this->appointmentTypeOptions = config('core.options.APPOINTMENT_TYPES')[$this->locale] ?? [];

        $this->specialtiesOptions = $this->selectorOptions(
            $this->specialties(),
            'id',
            'designation_' . $this->locale,
            __('selectors.default.specialties')
        );

        $this->serviceOptions = $this->selectorOptions(
            $this->services(),
            'id',
            'name_' . $this->locale,
            __('selectors.default.services')
        );

        $this->dairatesOptions = $this->selectorOptions(
            $this->dairates(),
            'id',
            'designation_' . $this->locale,
            __("selectors.default.dairates")
        );

        $this->appointmentsLocationsOptions = $this->selectorOptions(
            $this->appointmentsLocations(),
            'id',
            'name_' . $this->locale,
            __('selectors.default.appointments_locations')
        );
    }

    protected function selectorOptions($items, $valueKey, $labelKey, $placeholder): array
    {
        return $this->populateSelectorOption($items, $valueKey, $labelKey, $placeholder);
    }

    /* =========================
        HELPERS
    ========================= */

    protected function loc(): string
    {
        return in_array($this->locale, ['fr', 'ar']) ? $this->locale : 'fr';
    }

    protected function col(string $base): string
    {
        return $base . '_' . $this->loc();
    }

    /* =========================
        ACTIONS
    ========================= */

    public function resetFilters(): void
    {

        $this->reset(
            'patient',
            'patientCode',
            'year',
            'month',
            'scheduleDayDate',
            'specialtyId',
            'dairaId',
        );

        if(!$this->isForServicePersonnel && $this->serviceId){
              $this->serviceId = null;
        }
        if ((!$this->isForServicePersonnel && $this->appointmentsLocationId)) {
            $this->appointmentsLocationId = null;
        }
        if ($this->isForServicePersonnel) {
            $this->year = now()->year;
        }
        $this->resetPage();
    }
    public function openGoogleMap($lat, $lng)
    {
        if (!$lat || !$lng) {
            $this->dispatch('open-errors', __('tables.appointments.errors.missing_coordinates'));
            return;
        }
        $url = "https://www.google.com/maps/search/?api=1&query={$lat},{$lng}";
        $this->dispatch('open-google-map', $url);
    }


    public function openCancelDialog(Appointment $appointment): void
    {

        $data = [
            'question' => "appointment.cancel",
            'details' => [
                "appointment.cancel",
                ['date' => $appointment->day_at, 'start_at' => optional($appointment->start_at)->format('H:i')]
            ],
            'actionEvent' => [
                'event' => 'cancel-appointment',
                'parameters' => $appointment->id,
            ],
        ];

        $this->dispatch('open-dialog', $data);
    }



    #[On('cancel-appointment')]
    public function cancelAppointment(Appointment $appointment): void
    {
        try {

            $appointment->cancel();
            $this->dispatch(
                'open-toast',
                __('tables.appointments.success.cancel')
            );
        } catch (ValidationException $ve) {
            $this->dispatch('open-errors', $ve->validator->errors()->all());
        } catch (\Throwable $e) {
            Log::error('Error approving command: ' . $e->getMessage());

            $this->dispatch(
                'open-errors',
                __('forms.common.errors.default')
            );
        }
    }


    /* =========================
        EXPORT / PDF
    ========================= */

    public function generateAppointmentsPdf()
    {
        try {
            $datePart = $this->scheduleDayDate
                ? Carbon::parse($this->scheduleDayDate)->format('Y-m-d')
                : now()->format('Y-m-d');

            $fileName = "liste_attente_{$datePart}";

            if ($this->specialtyId) {
                $s = FieldSpecialty::find($this->specialtyId);
                if ($s?->acronym) {
                    $fileName .= "_" . Str::slug($s->acronym, '_');
                }
            }

            $appointments = $this->confirmedAppointments->getCollection()->sortBy('start_at');

            // Get location info from first appointment
            $firstAppointment = $appointments->first();
            $locationName = $firstAppointment?->location_name ?? null;
            $locationAddress = $firstAppointment?->address ?? null;

            // If no appointments, get location from filter
            if (!$locationName && $this->appointmentsLocationId) {
                $establishment = Establishment::find($this->appointmentsLocationId);
                $locationName = $establishment?->{'name_' . $this->locale};
                $locationAddress = $establishment?->address;
            }

            $data = [
                'appointments' => $appointments,
                'datePart' => $datePart,
                'specialty' => $this->specialtyId ? FieldSpecialty::find($this->specialtyId)?->{'designation_' . $this->locale} : null,
                'service' => $this->serviceId ? Service::find($this->serviceId)?->{'name_' . $this->locale} : null,
                'appointmentTypes' => $this->appointmentTypes,
                'generatedAt' => now()->format('d/m/Y H:i'),
                'totalCount' => $appointments->count(),
                'locationName' => $locationName,
                'locationAddress' => $locationAddress,
                'locale' => $this->locale,
                'flag_path' => 'assets/core/icons/flag.png',
                'logo_path' => 'assets/app/images/Logo.png',
            ];

            return $this->generateAndDownloadPdf(
                "pdfs.{$this->locale}.appointments-list",
                $data,
                $fileName . '.pdf'
            );
        } catch (\Throwable $e) {
            Log::error($e);

            $this->dispatch(
                'open-errors',
                __('forms.common.errors.default')
            );
        }
    }
    public function generateAppointmentConfirmationPdf($appointment)
    {
        try {
            if (is_numeric($appointment)) {
                $appointment = Appointment::with([
                    'patient',
                    'specialty',
                    'service',
                    'appointmentsLocation',
                ])->find($appointment);
            } elseif (is_array($appointment)) {
                $appointment = Appointment::with([
                    'patient',
                    'specialty',
                    'service',
                    'appointmentsLocation',
                ])->find($appointment['id']);
            }

            if (! $appointment) {
                throw new \Exception('Appointment not found');
            }

            $data = $appointment->toArray();

            $data['patient_code'] = $appointment->patient?->code ?? '-';
            $data['patient_name'] = $appointment->patient?->localized_fullname ?? '-';

            $data['birth_date'] = $appointment->patient?->birth_date
                ? Carbon::parse($appointment->patient->birth_date)->format('d-m-Y')
                : '-';

            $data['gender'] =    $this->genderOptions[$appointment->patient?->gender]
                ?? $appointment->patient?->gender
                ?? '-';

            $data['service_phone'] = $appointment->service?->tel ?? '-';
            $data['service_fax'] = $appointment->service?->fax ?? '-';

            $data['specialty_name'] = $appointment->specialty?->{'designation_' . $this->locale} ?? '-';

            $data['service_name'] = $appointment->service?->{'name_' . $this->locale} ?? '-';

            $data['formatted_date'] = Carbon::parse($appointment->day_at)->format('d-m-Y');

            $data['day_name'] = Carbon::parse($appointment->day_at)
                ->locale($this->locale)
                ->translatedFormat('l');

            $data['formatted_time'] = Carbon::parse($appointment->start_at)->format('H:i');

            $data['formatted_end_time'] = $appointment->end_at
                ? Carbon::parse($appointment->end_at)->format('H:i')
                : '-';

            $data['appointment_type'] = $this->appointmentTypes[$appointment->type]
                ?? $appointment->type;

            $data['location'] = $appointment->appointmentsLocation?->{'name_' . $this->locale}
                ?? '-';

            return $this->generateAndDownloadPdf(
                "pdfs.{$this->locale}.appointment-confirmation",
                $data,
                'confirmation-' . $appointment->id . '.pdf'
            );
        } catch (\Throwable $e) {
            Log::error($e);

            $this->dispatch(
                'open-errors',
                __('forms.common.errors.default')
            );
        }
    }

    /* =========================
        UPDATED HOOKS
    ========================= */

    public function updated(string $property): void
    {
        if (in_array($property, $this->filterable) || $property === 'perPage') {
            $this->resetPage();
        }

        if ($property === 'specialtyId' || $property === 'month') {
            $this->scheduleDaysOptions = $this->selectorOptions(
                $this->scheduleDays(),
                'day_at',
                'day_at',
                __("selectors.default.appointments_dates")
            );

            if (count($this->scheduleDaysOptions) === 1) {
                $this->scheduleDayDate = "";
            }
        }

        if ($property === 'dairaId') {
            $this->appointmentsLocationsOptions = $this->selectorOptions(
                $this->appointmentsLocations(),
                'id',
                'name_' . $this->locale,
                __('selectors.default.appointments_locations')
            );

            if (count($this->appointmentsLocationsOptions) === 1) {
                $this->appointmentsLocationId = null;
            }
        }

        if (array_key_exists($property, $this->rules)) {
            try {
                $this->validateOnly($property);
            } catch (ValidationException $e) {
                $this->dispatch('open-errors', $e->validator->errors()->all());
            }
        }
    }
}
