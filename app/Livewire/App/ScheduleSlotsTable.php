<?php

namespace App\Livewire\App;

use App\Models\ScheduleDay;
use App\Models\ScheduleSlot;
use App\Traits\Core\Common\GeneralTrait;
use App\Traits\Core\Common\TableTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ScheduleSlotsTable extends Component
{
    use WithPagination;
    use TableTrait;
    use GeneralTrait;

    /*
    |---------------------------------------
    | FILTER STATE
    |---------------------------------------
    */

    #[Url]
    public string $status = '';

    #[Url]
    public string $startAt = '';

    #[Url]
    public string $endAt = '';

    #[Url]
    public $scheduleDayId = null;

    #[Url]
    public string $scheduleDayDate = '';

    public string $locale = 'fr';

    public array $statusOptions = [];

    /*
    |---------------------------------------
    | CONFIG
    |---------------------------------------
    */

    protected array $filterable = [
        'status',
        'startAt',
        'endAt',
        'scheduleDayDate',
    ];

    protected array $rules = [
        'status' => ['nullable', 'in:available,booked,blocked'],
        'startAt' => ['nullable', 'date_format:H:i'],
        'endAt' => ['nullable', 'date_format:H:i'],
        'scheduleDayDate' => ['nullable', 'date', 'date_format:Y-m-d'],
    ];

    /*
    |---------------------------------------
    | INIT
    |---------------------------------------
    */

    public function mount(): void
    {
        $this->dispatch('init-tooltips');

        $this->sortBy = 'start_at';
        $this->locale = app()->getLocale();

        $this->statusOptions = config(
            'core.options.SLOTS_STATUS.' . $this->locale,
            []
        );

        if ($this->scheduleDayId) {
            $this->scheduleDayDate = Carbon::parse(
                ScheduleDay::find($this->scheduleDayId)?->day_at
            )->format('Y-m-d');
        }
    }

    /*
    |---------------------------------------
    | RESET FILTERS
    |---------------------------------------
    */

    public function resetFilters(): void
    {
        $this->reset([
            'status',
            'startAt',
            'endAt',
            'scheduleDayDate',
        ]);

        $this->resetPage();
    }

    /*
    |---------------------------------------
    | DATA
    |---------------------------------------
    */

    #[Computed]
    public function scheduleSlots()
    {
        return $this->buildScheduleSlotsQuery()
            ->paginate($this->perPage);
    }

    /*
    |---------------------------------------
    | QUERY BUILDER
    |---------------------------------------
    */

    protected function buildScheduleSlotsQuery()
    {
        return ScheduleSlot::query()
            ->join(
                'schedule_days',
                'schedule_days.id',
                '=',
                'schedule_slots.schedule_day_id'
            )
            ->leftJoin(
                'establishments',
                'establishments.id',
                '=',
                'schedule_slots.establishment_id'
            )
            ->leftJoin(
                'dairates',
                'dairates.id',
                '=',
                'establishments.daira_id'
            )
            ->leftJoin(
                'field_specialties',
                'field_specialties.id',
                '=',
                'schedule_days.specialty_id'
            )
            ->when(
                $this->scheduleDayDate,
                fn($query) => $query->whereDate(
                    'schedule_days.day_at',
                    $this->scheduleDayDate
                )
            )
            ->when(
                $this->scheduleDayId,
                fn($query) => $query->where(
                    'schedule_slots.schedule_day_id',
                    $this->scheduleDayId
                )
            )
            ->when(
                filled($this->status),
                fn($query) => $query->where(
                    'schedule_slots.status',
                    $this->status
                )
            )
            ->when(
                filled($this->startAt),
                fn($query) => $query->where(
                    'schedule_slots.start_at',
                    '>=',
                    $this->startAt
                )
            )
            ->when(
                filled($this->endAt),
                fn($query) => $query->where(
                    'schedule_slots.end_at',
                    '<=',
                    $this->endAt
                )
            )
            ->select([
                'schedule_slots.id',
                'schedule_slots.schedule_day_id',
                'schedule_slots.start_at',
                'schedule_slots.end_at',
                'schedule_slots.status',
                'schedule_slots.created_at',
                'schedule_days.day_at',
                "field_specialties.designation_{$this->locale} as specialty",
                "establishments.name_{$this->locale} as appointments_location",
                'establishments.longitude',
                'establishments.latitude',
                'establishments.tel as appointments_location_tel',
            ])
            ->orderBy($this->sortBy, $this->sortDirection);
    }

    /*
    |---------------------------------------
    | ACTIONS
    |---------------------------------------
    */

    public function openBlockDialog(int $slotId): void
    {
        $slot = ScheduleSlot::findOrFail($slotId);

        $this->dispatch('open-dialog', [
            'question' => 'slot.block',
            'details' => [
                'slot.block',
                $slot->start_at . ' - ' . $slot->end_at,
            ],
            'actionEvent' => [
                'event' => 'block-slot',
                'parameters' => $slot->id,
            ],
        ]);
    }

    public function openUnblockDialog(int $slotId): void
    {
        $slot = ScheduleSlot::findOrFail($slotId);

        $this->dispatch('open-dialog', [
            'question' => 'slot.unblock',
            'details' => [
                'slot.unblock',
                $slot->start_at . ' - ' . $slot->end_at,
            ],
            'actionEvent' => [
                'event' => 'unblock-slot',
                'parameters' => $slot->id,
            ],
        ]);
    }

    #[On('block-slot')]
    public function blockSlot(int $slotId): void
    {
        try {
            ScheduleSlot::findOrFail($slotId)->block();

            $this->dispatch('update-schedule-slots-table');
            $this->dispatch('open-toast', __('messages.slot.blocked'));
        } catch (\Throwable $e) {
            Log::error('Error blocking slot', [
                'message' => $e->getMessage(),
            ]);

            $this->dispatch(
                'open-errors',
                __('forms.common.errors.default')
            );
        }
    }

    #[On('unblock-slot')]
    public function unblockSlot(int $slotId): void
    {
        try {
            ScheduleSlot::findOrFail($slotId)->unblock();

            $this->dispatch('update-schedule-slots-table');
            $this->dispatch('open-toast', __('messages.slot.unblocked'));
        } catch (\Throwable $e) {
            Log::error('Error unblocking slot', [
                'message' => $e->getMessage(),
            ]);

            $this->dispatch(
                'open-errors',
                __('forms.common.errors.default')
            );
        }
    }

    /*
    |---------------------------------------
    | UPDATED HOOK
    |---------------------------------------
    */

    public function updated(string $property): void
    {
        if (in_array($property, $this->filterable, true)) {
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

    /*
    |---------------------------------------
    | RENDER
    |---------------------------------------
    */

    public function render()
    {
        return view('livewire.app.schedule-slots-table');
    }
}
