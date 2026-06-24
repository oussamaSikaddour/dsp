<?php

namespace App\Livewire\App\MedicalSecretary;

use App\Livewire\Forms\App\Schedule\AddForm;
use App\Livewire\Forms\App\Schedule\UpdateForm;
use App\Models\Schedule;
use App\Traits\Core\Common\GeneralTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ScheduleModal extends Component
{
    use GeneralTrait;

    public AddForm $addForm;
    public UpdateForm $updateForm;

    public ?Schedule $schedule = null;

    public ?int $scheduleId = null;
    public ?int $serviceId = null;

    public string $form = 'addForm';
    public string $locale;

    public array $yearsOptions = [];
    public array $monthsOptions = [];
    public array $statesOptions = [];
    public array $appointmentDurationOptions = [];
    public array $workingDaysOptions = [];

    public function mount(): void
    {

        $this->locale = app()->getLocale();
        $this->loadOptions();

        if ($this->scheduleId) {
            $this->form = 'updateForm';
            $this->loadSchedule();
        } else {
            $this->initializeForm();
        }
    }

    protected function loadOptions(): void
    {
        $this->yearsOptions = config('core.dates.YEAR_OPTIONS.'.$this->locale, []);



        $this->monthsOptions =
            config('core.dates.MONTHS_OPTIONS.' . $this->locale, []);

        $this->statesOptions =
            config('core.options.PUBLISHING_STATE.' . $this->locale, []);

        $this->workingDaysOptions =
            config('core.dates.WEEK_DAYS.' . $this->locale, []);
        $this->appointmentDurationOptions =
            config('core.options.APPOINTMENT_DURATIONS.' . $this->locale, []);

    }

    protected function initializeForm(): void
    {
        $this->addForm->fill([
            'service_id' => $this->serviceId,
            'opened_by'  => auth()->id(),

            'working_days' => [0,1,2,3,4],
            'days_off' => [],
            'working_periods' => [
                ['start' => '08:30', 'end' => '12:00'],
                ['start' => '13:00', 'end' => '16:00'],
            ],

            // ✅ NEW
            'appointments_locations' => [],
        ]);
    }

    protected function loadSchedule(): void
    {
        try {
            $this->schedule = Schedule::findOrFail($this->scheduleId);

            $this->updateForm->fill([
                'id'             => $this->schedule->id,
                'name_fr'        => $this->schedule->name_fr,
                'name_ar'        => $this->schedule->name_ar,
                'name_en'        => $this->schedule->name_en,
                'description_fr' => $this->schedule->description_fr,
                'description_ar' => $this->schedule->description_ar,
                'description_en' => $this->schedule->description_en,
                'state'          => $this->schedule->state,
                'year'           => $this->schedule->year,
                'month'          => $this->schedule->month,
                'service_id'     => $this->schedule->service_id,
                'opened_by'      => auth()->id(),

                'working_days'    => $this->schedule->working_days ?? [],
                'days_off'        => $this->schedule->days_off ?? [],
                'working_periods' => $this->schedule->working_periods ?? [],

                // ✅ NEW
                'appointments_locations' => $this->schedule->appointments_locations ?? [],
            ]);

        } catch (ModelNotFoundException $e) {
            Log::error('Schedule not found: ' . $e->getMessage());

            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    public function handleSubmit(): void
    {
        $this->dispatch('form-submitted');

        $response = $this->scheduleId
            ? $this->updateForm->save($this->schedule)
            : $this->addForm->save();

        if ($response['status']) {

            $this->dispatch('update-schedules-table');
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
        return view('livewire.app.medical-secretary.schedule-modal');
    }
}
