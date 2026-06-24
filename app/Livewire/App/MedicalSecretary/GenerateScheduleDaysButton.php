<?php

namespace App\Livewire\App\MedicalSecretary;

use App\Models\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;

class GenerateScheduleDaysButton extends Component
{
    public Schedule $schedule;

    public string $locale = 'fr';

    public function mount(): void
    {
        $this->locale = app()->getLocale();
    }

    public function openGenerateScheduleDaysDialog(): void
    {

        $key = "schedule.generate_days";
        $this->dispatch(
            'open-dialog',
            [
                'question' => $key,
                'details' => [
                    $key,
                    $this->schedule->{'name_' . $this->locale},
                ],
                'actionEvent' => [
                    'event' => 'generate-schedule-days',
                    'parameters' => $this->schedule->id,
                ],
            ]
        );
    }



    #[On('generate-schedule-days')]
    public function generateScheduleDays(int $scheduleId): void
    {
        if ($scheduleId !== $this->schedule->id) {
            return;
        }

        try {
            $this->schedule->generateDays();

            // ✅ FIX: persist lock properly
            $this->schedule->lock();

            // reload fresh data AFTER saving
            $this->schedule->refresh();


            $this->dispatch('update-schedule-days-table');
            $this->dispatch('update-schedules-table');
            $this->dispatch(
                'open-toast',
                __("tables.schedules.success.generate", [
                    'name' => $this->schedule->localized_name
                ])
            );
        } catch (ValidationException $exception) {

            $this->dispatch(
                'open-errors',
                $exception->validator->errors()->all()
            );
        } catch (\Throwable $exception) {

            Log::error('Failed to generate schedule days.', [
                'schedule_id' => $this->schedule->id,
                'error' => $exception->getMessage(),
            ]);

            $this->dispatch(
                'open-errors',
                __('forms.common.errors.default')
            );
        }
    }

    public function render()
    {
        return view(
            'livewire.app.medical-secretary.generate-schedule-days-button'
        );
    }
}
