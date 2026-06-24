<?php

namespace App\Livewire\App;

use App\Livewire\Forms\App\Appointment\BookForm;
use App\Models\Daira;
use App\Models\Establishment;
use App\Models\FieldSpecialty;
use App\Models\Patient;
use App\Models\ScheduleDay;
use App\Models\ScheduleSlot;
use App\Traits\Core\Common\GeneralTrait;
use App\Traits\Core\Common\TableTrait;
use App\Traits\Core\Web\ResponseTrait;
use App\Traits\Core\Common\TextAndPdfTrait;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class bookSlotModal extends Component
{
    use WithFileUploads, WithPagination, TableTrait, GeneralTrait, ResponseTrait, TextAndPdfTrait;

    /*
    |--------------------------------------------------------------------------
    | FORMS
    |--------------------------------------------------------------------------
    */
    public BookForm $bookForm;

    public $temporaryImageUrl;
    public $patientId;
    public Patient $patient;



    /*
    |--------------------------------------------------------------------------
    | FILTER STATE
    |--------------------------------------------------------------------------
    */
    public string $status = '';
    public string $startAt = '';
    public string $endAt = '';
    public string $appointmentType = 'initial';

    public ?int $scheduleDayId = null;
    public ?int $dairaId = null;
    public ?int $appointmentsLocationId = null;

    public ?string $scheduleDayDate = null; // FIXED (was string causing crash)
    public int $year;

    public string $locale = 'fr';

    /*
    |--------------------------------------------------------------------------
    | OPTIONS
    |--------------------------------------------------------------------------
    */
    public array $monthsOptions = [];
    public array $scheduleDaysOptions = [];
    public array $dairatesOptions = [];
    public array $specialtiesOptions = [];
    public array $statusOptions = [];
    public array $appointmentsLocationsOptions = [];

    /*
    |--------------------------------------------------------------------------
    | FILTERABLE
    |--------------------------------------------------------------------------
    */
    protected array $filterable = [
        'status',
        'startAt',
        'endAt',
        'scheduleDayDate',
        'dairaId',
        'appointmentsLocationId',
    ];

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */
    protected function validationRules(): array
    {
        return [
            'status' => ['nullable', 'in:available,booked,blocked'],
            'startAt' => ['nullable', 'date_format:H:i'],
            'endAt' => ['nullable', 'date_format:H:i'],

            'scheduleDayDate' => [
                'nullable',
                'date',
                'date_format:Y-m-d',
                'after_or_equal:' . now()->format('Y-m-d'),
            ],

            'dairaId' => ['nullable', 'exists:dairates,id'],
            'appointmentsLocationId' => ['nullable', 'exists:establishments,id'],
            'specialtyId' => ['nullable', 'exists:field_specialties,id'],
            'serviceId' => ['nullable', 'exists:services,id'],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | INIT
    |--------------------------------------------------------------------------
    */
    public function mount(): void
    {
        $this->dispatch('init-table');
        $this->dispatch('init-tooltip');


        $this->year = now()->year;
        $this->locale = app()->getLocale();

        $this->patient = Patient::with(['commune'])->find($this->patientId);

        $this->loadSelectorsOptions();
    }

    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */
    public function resetFilters(): void
    {
        $this->reset([
            'status',
            'startAt',
            'endAt',
            'scheduleDayDate',
            'dairaId',
            'appointmentsLocationId',
            'scheduleDayId',
        ]);
    }

    public function resetForm(): void
    {
        $this->bookForm->reset();
        $this->temporaryImageUrl = null;
    }

    /*
    |--------------------------------------------------------------------------
    | COMPUTED
    |--------------------------------------------------------------------------
    */

    #[Computed]
    public function scheduleDays()
    {
        return ScheduleDay::query()
            ->whereYear('day_at', $this->year)
            ->when(
                $this->bookForm->specialty_id,
                fn($q) =>
                $q->where('specialty_id', $this->bookForm->specialty_id)
            )
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
            ->when(
                $this->dairaId,
                fn($q) =>
                $q->where('daira_id', $this->dairaId)
            )
            ->get(['id', 'name_' . $this->locale]);
    }

    #[Computed]
    public function scheduleSlots()
    {
        return $this->buildScheduleSlotsQuery()
            ->paginate($this->perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    protected function resolveScheduleDayDate(): string
    {
        if ($this->scheduleDayDate) {
            return $this->scheduleDayDate;
        }

        $closestDay = ScheduleDay::query()
            ->where('specialty_id', $this->bookForm->specialty_id)
            ->whereDate('day_at', '>=', today())
            ->orderBy('day_at')
            ->first();

        return $closestDay?->day_at?->format('Y-m-d') ?? now()->format('Y-m-d');
    }

    /*
    |--------------------------------------------------------------------------
    | QUERY
    |--------------------------------------------------------------------------
    */

    protected function buildScheduleSlotsQuery()
    {
        $date = $this->resolveScheduleDayDate();

        $startDate = Carbon::parse($date)->startOfDay();
        $endDate = $startDate->copy()->addDays(10)->endOfDay();

        return ScheduleSlot::query()
            ->where('schedule_slots.status', 'available')

            ->join('schedule_days', 'schedule_days.id', '=', 'schedule_slots.schedule_day_id')
            ->leftJoin('schedules', 'schedule_days.schedule_id', '=', 'schedules.id')
            ->leftJoin('establishments', 'establishments.id', '=', 'schedule_slots.establishment_id')
            ->leftJoin('dairates', 'dairates.id', '=', 'establishments.daira_id')
            ->leftJoin('field_specialties', 'field_specialties.id', '=', 'schedule_days.specialty_id')

            ->where('schedules.state', 'published')
            ->where('schedule_days.specialty_id', $this->bookForm->specialty_id)

            ->whereBetween('schedule_days.day_at', [
                $startDate->toDateString(),
                $endDate->toDateString(),
            ])

            ->when(
                $this->scheduleDayId,
                fn($q) =>
                $q->where('schedule_slots.schedule_day_id', $this->scheduleDayId)
            )

            ->when(
                $this->dairaId,
                fn($q) =>
                $q->where('establishments.daira_id', $this->dairaId)
            )

            ->when(
                $this->appointmentsLocationId,
                fn($q) =>
                $q->where('schedule_slots.establishment_id', $this->appointmentsLocationId)
            )

            ->when(
                filled($this->status),
                fn($q) =>
                $q->where('schedule_slots.status', $this->status)
            )

            ->when(
                filled($this->startAt),
                fn($q) =>
                $q->where('schedule_slots.start_at', '>=', $this->startAt)
            )

            ->when(
                filled($this->endAt),
                fn($q) =>
                $q->where('schedule_slots.end_at', '<=', $this->endAt)
            )

            ->select([
                'schedule_slots.id',
                'schedule_slots.schedule_day_id',
                'schedule_slots.establishment_id',
                'schedule_slots.start_at',
                'schedule_slots.end_at',
                'schedule_slots.status',
                'schedule_slots.created_at',
                'schedule_days.day_at',

                "field_specialties.designation_{$this->locale} as specialty",
                "establishments.name_{$this->locale} as appointments_location",
                "dairates.designation_{$this->locale} as daira",

                'establishments.longitude',
                'establishments.latitude',
                'establishments.tel as appointments_location_tel',
            ])

            // ✅ correct ordering
            ->orderBy('schedule_days.day_at', 'asc')
            ->orderBy('schedule_slots.start_at', 'asc');
    }
    /*
    |--------------------------------------------------------------------------
    | VALIDATION HELPERS
    |--------------------------------------------------------------------------
    */

    private function validateFilter(string $property): void
    {
        $rules = $this->validationRules()[$property] ?? null;

        if (!$rules) return;

        try {
            validator([$property => $this->$property], [$property => $rules])
                ->validate();
        } catch (ValidationException $e) {
            $this->dispatch('open-errors', $e->validator->errors()->all());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATED
    |--------------------------------------------------------------------------
    */

    public function updated(string $property): void
    {
        if (str_contains($property, 'referral_letter')) {
            try {
                $this->temporaryImageUrl = $this->bookForm->referral_letter->temporaryUrl();
            } catch (\Exception) {
                $this->dispatch('open-errors', __('forms.common.errors.img.not_img'));
            }
            return;
        }

        if (in_array($property, $this->filterable, true) || $property === 'perPage') {
            $this->resetPage();
        }

        if (in_array($property, $this->filterable, true)) {
            $this->validateFilter($property);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | OPTIONS
    |--------------------------------------------------------------------------
    */

    protected function loadSelectorsOptions(): void
    {
        $this->monthsOptions = config('core.date.MONTHS_OPTIONS')[$this->locale] ?? [];
        $this->statusOptions = config('core.options.SLOTS_STATUS.' . $this->locale, []);

        $this->scheduleDaysOptions = $this->selectorOptions($this->scheduleDays(), 'day_at', 'day_at', 'dates');
        $this->dairatesOptions = $this->selectorOptions($this->dairates(), 'id', 'designation_' . $this->locale, __('selectors.default.dairates'));
        $this->appointmentsLocationsOptions = $this->selectorOptions($this->appointmentsLocations(), 'id', 'name_' . $this->locale, __('selectors.default.appointments_locations'));
        $this->specialtiesOptions = $this->selectorOptions($this->specialties(), 'id', 'designation_' . $this->locale, __('selectors.default.specialties'));
    }

    protected function selectorOptions($items, $valueKey, $labelKey, $placeholder): array
    {
        return $this->populateSelectorOption($items, $valueKey, $labelKey, $placeholder);
    }

    /*
    |--------------------------------------------------------------------------
    | ACTIONS
    |--------------------------------------------------------------------------
    */

    public function openBookDialog(int $slotId): void
    {
        $slot = ScheduleSlot::with('scheduleDay')->findOrFail($slotId);

        $date = Carbon::parse($slot->scheduleDay->day_at)->format('d/m/Y');
        $start = Carbon::parse($slot->start_at)->format('H:i');

        $this->bookForm->fill([
            'type' => $this->appointmentType,
            'patient_id' => $this->patientId,
            'schedule_slot_id' => $slot->id,
            'schedule_day_id' => $slot->scheduleDay->id,
            'initiator' => 'patient',
        ]);

        $this->dispatch('open-dialog', [
            'question' => 'slot.book',
            'details' => [
                'slot.book',
                [
                    "date" => $date,
                    "start_at" => $start,
                ]
            ],
            'actionEvent' => [
                'event' => 'book-slot',
                'parameters' => [],
            ],
        ]);
    }

    #[On('book-slot')]
    public function handleBooking(): void
    {
        $response = $this->bookForm->save();

        if (! $response['status']) {
            $this->dispatch('open-errors', $response['errors']);

            return;
        }

        $this->bookForm->reset();
        $this->dispatch('update-appointments-table');
        $this->dispatch('open-toast', $response['message']);
    }

    /*
    |--------------------------------------------------------------------------
    | RENDER
    |--------------------------------------------------------------------------
    */
    public function render()
    {
        return view('livewire.app.book-slot-modal');
    }
}
