<?php

namespace App\Livewire\App;

use App\Livewire\Forms\App\ReferralLetter\UpdateForm;
use App\Models\Appointment;
use App\Traits\Core\Common\DateAndTimeTrait;
use App\Traits\Core\Common\GeneralTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ReferralLetterModal extends Component
{
    use WithFileUploads, GeneralTrait, DateAndTimeTrait;

    public UpdateForm $updateForm;

    public ?Appointment $appointment = null;

    public ?int $appointmentId = null;

 public bool $isForAppointmentsLocationAgent =true;
    // ✅ this holds DB image
    public ?string $existingImageUrl = null;

    public function mount()
    {


        $this->loadAppointment();
    }

    public function render()
    {
        return view('livewire.app.referral-letter-modal');
    }

    protected function loadAppointment(): void
    {
        try {
            $this->appointment = Appointment::with([
                'referralLetter' => fn ($q) => $q->where('use_case', 'referral_letter')
            ])->findOrFail($this->appointmentId);

            // ✅ FIX: ensure correct URL format
            $this->existingImageUrl = $this->appointment?->referralLetter?->url;

        } catch (\Throwable $e) {
            $this->logModelError($e, 'appointment');
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    public function handleSubmit(): void
    {
        $response = $this->updateForm->save($this->appointment);

        if ($response['status'] ?? false) {
            $this->dispatch('open-toast', $response['message']);
            return;
        }

        $this->dispatch('open-errors', $response['errors'] ?? __('forms.common.errors.default'));
    }

    public function updated($property): void
    {
        if ($property === 'updateForm.referral_letter') {
            $this->updateTemporaryPreview();
        }
    }

    protected function updateTemporaryPreview(): void
    {
        try {
            if ($this->updateForm->referral_letter) {
                $this->existingImageUrl = $this->updateForm->referral_letter->temporaryUrl();
            }
        } catch (\Throwable $e) {
            $this->dispatch('open-errors', __('forms.common.errors.img.not_img'));
        }
    }

    protected function logModelError(\Throwable $exception, string $model): void
    {
        Log::error("ReferralLetterModal: {$model} not found", [
            'message' => $exception->getMessage(),
            'appointment_id' => $this->appointmentId,
        ]);
    }
}
