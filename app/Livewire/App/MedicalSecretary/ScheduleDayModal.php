<?php

namespace App\Livewire\App\MedicalSecretary;

use App\Livewire\Forms\App\ScheduleDay\AddForm;
use App\Livewire\Forms\App\ScheduleDay\UpdateForm;
use App\Models\ScheduleDay;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ScheduleDayModal extends Component
{
    public AddForm $addForm;
    public UpdateForm $updateForm;

    public ?ScheduleDay $scheduleDay = null;

    public ?int $scheduleDayId = null;
    public ?int $scheduleId = null;

    public string $locale="fr";

    public string $form = 'addForm';
        public array $appointmentDurationOptions = [];

    public function mount(): void
    {

      $this->locale = app()->getLocale();
          $this->appointmentDurationOptions =
            config('core.options.APPOINTMENT_DURATIONS.' . $this->locale, []);
        if ($this->scheduleDayId) {
            $this->form = 'updateForm';

            // ✅ ONLY QUERY HERE (single source of truth)
            $this->scheduleDay = ScheduleDay::findOrFail($this->scheduleDayId);

            $this->loadScheduleDay();
        } else {
            $this->initializeForm();
        }
    }

    /**
     * Initialize ADD form
     */
    protected function initializeForm(): void
    {
        $this->addForm->fill([
            'schedule_id' => $this->scheduleId,
            'day_at' => now()->toDateString(),
            'appointment_duration' => 30,

            // reuse defaults only when no scheduleDay exists
            'working_periods' => [
                ['start' => '08:30', 'end' => '12:00'],
                ['start' => '13:00', 'end' => '16:00'],
            ],

            'appointments_locations' => [],

            'locked' => false,
        ]);
    }

    /**
     * Load UPDATE form (NO DB QUERY HERE)
     */
    protected function loadScheduleDay(): void
    {
        try {
            $this->updateForm->fill([
                'id' => $this->scheduleDay->id,
                'schedule_id' => $this->scheduleDay->schedule_id,
                'day_at' => $this->scheduleDay->day_at->format('Y-m-d'),
                'appointment_duration' => $this->scheduleDay->appointment_duration,

                'working_periods' => $this->scheduleDay->working_periods ?? [],
                'appointments_locations' => $this->scheduleDay->appointments_locations ?? [],

                'locked' => $this->scheduleDay->locked,
            ]);

        } catch (ModelNotFoundException $e) {
            Log::error('ScheduleDay not found: ' . $e->getMessage());
            $this->dispatch('open-errors', __('Not found'));
        }
    }

    /**
     * Submit handler
     */
    public function handleSubmit(): void
    {
        $this->dispatch('form-submitted');

        $response = $this->scheduleDayId
            ? $this->updateForm->save($this->scheduleDay)
            : $this->addForm->save();

        if ($response['status']) {
            $this->dispatch('update-schedule-days-table');
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
        return view('livewire.app.medical-secretary.schedule-day-modal');
    }
}
