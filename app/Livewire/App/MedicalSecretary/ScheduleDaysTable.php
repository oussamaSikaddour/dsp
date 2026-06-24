<?php

namespace App\Livewire\App\MedicalSecretary;

use App\Models\Schedule;
use App\Models\ScheduleDay;
use App\Traits\Core\Common\GeneralTrait;
use App\Traits\Core\Common\TableTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ScheduleDaysTable extends Component
{
    use WithPagination;
    use TableTrait;
    use GeneralTrait;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    #[Url]
    public string $dayAt = '';

    #[Url]
    public string $appointmentDuration = '';

    public int $scheduleId;

    public Schedule $schedule;


    public bool $showGenerateSlotsForAllButton = false;

    protected array $filterable = [
        'dayAt',
        'appointmentDuration',
    ];

    protected array $validationRules = [
        'dayAt' => ['nullable', 'date'],
        'appointmentDuration' => ['nullable', 'integer', 'min:1'],
    ];

    /*
    |--------------------------------------------------------------------------
    | Lifecycle
    |--------------------------------------------------------------------------
    */

    public function mount(): void
    {
        $this->sortBy="day_at";
              $this->dispatch('init-tooltips');
        $this->schedule = $this->schedule ?? Schedule::findOrFail($this->scheduleId);

        $this->showGenerateSlotsForAllButton =
            $this->schedule->state === Schedule::STATE_NOT_PUBLISHED
            && $this->schedule->hasAnyScheduleDay()
            && $this->schedule->hasAtLeastOneUnlockedScheduleDay();
    }
    public function updated(string $property): void
    {
        if (
            in_array($property, $this->filterable, true)
            || $property === 'perPage'
        ) {
            $this->resetPage();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

    public function resetFilters(): void
    {
        $this->reset([
            'dayAt',
            'appointmentDuration',
        ]);

        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Queries
    |--------------------------------------------------------------------------
    */

    #[Computed]
    public function scheduleDays()
    {
        return $this->buildScheduleDaysQuery()
            ->paginate($this->perPage);
    }

    protected function buildScheduleDaysQuery()
    {
        return ScheduleDay::query()
            ->where('schedule_id', $this->scheduleId)

            ->when(
                filled($this->dayAt),
                fn($query) => $query->whereDate(
                    'day_at',
                    $this->dayAt
                )
            )

            ->when(
                filled($this->appointmentDuration),
                fn($query) => $query->where(
                    'appointment_duration',
                    $this->appointmentDuration
                )
            )

            ->withCount('slots')

            ->orderBy(
                $this->sortBy,
                $this->sortDirection
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Dialogs
    |--------------------------------------------------------------------------
    */

    public function openDeleteDialog(
        ScheduleDay $scheduleDay
    ): void {

        $key = "delete.schedule_day";
        $this->openDialog(
            question: $key,
            details: [
                $key,
                $scheduleDay->day_at->format('d/m/Y'),
            ],
            event: 'delete-schedule-day',
            parameters: $scheduleDay->id,
        );
    }

    public function openGenerateSlotsForOneDialog(
        ScheduleDay $scheduleDay
    ): void {

        $key = "schedule.generate_slots.one";
        $this->openDialog(
            question: $key,
            details: [
                $key,
                $scheduleDay->day_at->format('d/m/Y'),
            ],
            event: 'generate-slots-for-one',
            parameters: $scheduleDay->id,
        );
    }

    public function openGenerateSlotsForAllDialog(): void
    {

        $key = "schedule.generate_slots.all";
        $this->openDialog(
            question: $key,
            details: [
                $key,
                $this->schedule->localized_name,
            ],
            event: 'generate-slots-for-all',
        );
    }

    protected function openDialog(
        string $question,
        array $details,
        string $event,
        mixed $parameters = null
    ): void {


        $this->dispatch(
            'open-dialog',
            [
                'question' => $question,
                'details' => $details,
                'actionEvent' => [
                    'event' => $event,
                    'parameters' => $parameters,
                ],
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */

    #[On('delete-schedule-day')]
    public function deleteScheduleDay(
        ScheduleDay $scheduleDay
    ): void {
        try {
            $scheduleDay->delete();

            $this->refreshTable();

            $this->dispatch(
                'open-toast',
                __('messages.schedule_day.deleted')
            );
        } catch (\Throwable $e) {
            $this->handleError(
                'Error deleting schedule day',
                $e
            );
        }
    }

    #[On('generate-slots-for-all')]
    public function generateSlotsForAll(): void
    {
        try {
            $this->schedule->generateSlots();

            $this->refreshTable();


            $this->dispatch(
                'open-toast',
                __('tables.schedule_days.success.slots_for_all')
            );

            $this->dispatch('update-schedule-days-table');
        } catch (\Throwable $e) {
            $this->handleError(
                'Error generating slots for all',
                $e,
                true
            );
        }
    }

    #[On('generate-slots-for-one')]
    public function generateSlotsForOne(
        ScheduleDay $scheduleDay
    ): void {
        try {
            $scheduleDay->generateSlots();


            $this->refreshTable();


            $this->dispatch(
                'open-toast',
                __('tables.schedule_days.success.slot_for_one')
            );
            $this->dispatch('update-schedule-days-table');
        } catch (\Throwable $e) {
            $this->handleError(
                'Error generating slots for one',
                $e,
                true
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    protected function refreshTable(): void
    {
        $this->dispatch(
            'update-schedule-days-table'
        );
    }

    protected function handleError(
        string $message,
        \Throwable $e,
        bool $showExceptionMessage = false
    ): void {
        Log::error(
            $message,
            [
                'message' => $e->getMessage(),
            ]
        );

        $this->dispatch(
            'open-errors',
            $showExceptionMessage
                ? $e->getMessage()
                : __('forms.common.errors.default')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Rendering
    |--------------------------------------------------------------------------
    */

    public function render()
    {


        return view(
            'livewire.app.medical-secretary.schedule-days-table'
        );
    }
}
