<?php

namespace App\Livewire\App\MedicalSecretary;

use App\Models\Schedule;
use App\Traits\Core\Common\GeneralTrait;
use App\Traits\Core\Common\TableTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SchedulesTable extends Component
{
    use WithPagination, TableTrait, GeneralTrait;

    #[Url]
    public string $name = '';

    #[Url]
    public string $state = '';

    #[Url]
    public string $year = '';

    #[Url]
    public string $month = '';

    public ?int $serviceId = null;

    public string $locale = 'fr';

    public array $yearsOptions = [];
    public array $monthsOptions = [];
    public array $statesOptions = [];

    protected array $filterable = [
        'name',
        'state',
        'year',
        'month',
    ];

    protected array $validationRules = [
        'name' => ['nullable', 'string', 'max:255'],
        'year' => ['nullable', 'integer', 'digits:4', 'between:2025,2050'],
        'month' => ['nullable', 'integer', 'between:1,12'],
    ];

    public function mount(): void
    {
          $this->dispatch('init-tooltips');
        $this->locale = app()->getLocale();

        $this->yearsOptions = config('core.dates.YEARS', []);
        $this->monthsOptions = config('core.dates.MONTHS_OPTIONS')[$this->locale] ?? [];
        $this->statesOptions = config('core.options.PUBLISHING_STATE')[$this->locale] ?? [];
    }

    public function resetFilters(): void
    {
        $this->reset([
            'name',
            'state',
            'year',
            'month',
        ]);

        $this->resetPage();
    }

    #[Computed]
    public function schedules()
    {
        return $this->buildScheduleQuery()
            ->paginate($this->perPage);
    }

    protected function buildScheduleQuery()
    {
        $containsArabic = preg_match('/\p{Arabic}/u', $this->name ?? '');

        $searchColumn = $containsArabic
            ? 'schedules.name_ar'
            : "schedules.name_{$this->locale}";

        return Schedule::query()
            ->where('service_id', $this->serviceId)

            ->when(
                filled($this->name),
                fn($query) => $query->where(
                    $searchColumn,
                    'like',
                    "%{$this->name}%"
                )
            )

            ->when(
                filled($this->state),
                fn($query) => $query->where('state', $this->state)
            )

            ->when(
                filled($this->year),
                fn($query) => $query->where('year', $this->year)
            )

            ->when(
                filled($this->month),
                fn($query) => $query->where('month', $this->month)
            )

            ->orderBy($this->sortBy, $this->sortDirection);
    }

    public function openDeleteDialog(Schedule $schedule): void
    {

        $key = "delete.schedule";
        $data = [
            'question' => $key,
            'details' => [
                $key,
                $schedule->{'name_' . $this->locale},
            ],
            'actionEvent' => [
                'event' => 'delete-schedule',
                'parameters' => $schedule->id,
            ],
        ];

        $this->dispatch('open-dialog', $data);
    }

    public function openPublishDialog(Schedule $schedule): void
    {
        $key="schedule.publish";
        $data = [
            'question' => $key,
            'details' => [
                $key,
                $schedule->{'name_' . $this->locale},
            ],
            'actionEvent' => [
                'event' => 'publish-schedule',
                'parameters' => $schedule->id,
            ],
        ];

        $this->dispatch('open-dialog', $data);
    }

    #[On('delete-schedule')]
    public function deleteSchedule(Schedule $schedule): void
    {
        try {

            $schedule->delete();

            $this->dispatch('update-schedules-table');

            $this->dispatch(
                'open-toast',
                __('messages.schedule.deleted')
            );
        } catch (\Throwable $e) {

            Log::error('Error deleting schedule', [
                'message' => $e->getMessage(),
            ]);

            $this->dispatch(
                'open-errors',
                __('forms.common.errors.default')
            );
        }
    }

    #[On('publish-schedule')]
    public function publishSchedule(Schedule $schedule): void
    {
        try {

            $schedule->publish();
            $this->dispatch('update-schedules-table');

            $this->dispatch(
                'open-toast',
                __('messages.schedule.published')
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

    public function updated(string $property): void
    {
        if (
            in_array($property, $this->filterable, true)
            || $property === 'perPage'
        ) {
            $this->resetPage();
        }

        if (array_key_exists($property, $this->validationRules)) {

            try {

                $this->validateOnly(
                    $property,
                    $this->validationRules
                );
            } catch (ValidationException $e) {

                $this->dispatch(
                    'open-errors',
                    $e->validator->errors()->all()
                );
            }
        }
    }

    public function render()
    {


        return view(
            'livewire.app.medical-secretary.schedules-table'
        );
    }
}
