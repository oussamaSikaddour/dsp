<?php

namespace App\Livewire\App\ServiceCoordinator;

use App\Livewire\Forms\App\MedicalSecretary\ManageForm;
use App\Models\Role;
use App\Models\User;
use App\Traits\Core\Common\GeneralTrait;
use App\Traits\Core\Common\TableTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class MedicalSecretariesModal extends Component
{
    use TableTrait, GeneralTrait;

    public ManageForm $manageForm;

    public $establishmentId;
    public $serviceId;

    public string $local = 'fr';

    public array $personalOptions = [];

    public function mount(): void
    {
        $this->local = app()->getLocale();

        $this->refreshPersonalOptions();

        $this->manageForm->fill([
            'service_id' => $this->serviceId,
        ]);
    }

    /**
     * =====================================================
     * AVAILABLE USERS (CAN BECOME SECRETARIES)
     * =====================================================
     */
    #[Computed]
    public function personal()
    {
        return User::query()
            ->where('establishment_id', $this->establishmentId)

            // ❌ exclude already assigned service roles
            ->whereDoesntHave('roles', function ($q) {
                $q->whereIn('slug', [
                    'doctor',
                    'service_coordinator',
                    'medical_secretary',
                    'establishment_admin',
                   'appointments_locations_agent'
                ]);
            })

            // ✅ alphabetical order
            ->orderBy('last_name')
            ->orderBy('first_name')

            ->get(['id', 'first_name', 'last_name'])
            ->map(fn($user) => [
                'id' => $user->id,
                'full_name' => trim(
                    ($user->last_name ?? '') . ' ' . ($user->first_name ?? '')
                ) ?: 'Unknown User',
            ]);
    }

    /**
     * =====================================================
     * ASSIGNED MEDICAL SECRETARIES
     * =====================================================
     */
    #[Computed]
    public function secretaries()
    {
        return User::query()
            ->where('establishment_id', $this->establishmentId)
            ->whereHas('roles', fn($q) => $q->where('slug', 'medical_secretary'))

            ->select([
                'id',
                'email',
                'created_at',
                \DB::raw("CONCAT(last_name, ' ', first_name) as name"),
            ])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->get();
    }

    /**
     * =====================================================
     * REFRESH DROPDOWN
     * =====================================================
     */
    private function refreshPersonalOptions(): void
    {
        $this->manageForm->user_id = null;

        $this->personalOptions = $this->populateSelectorOption(
            $this->personal(),
            'id',
            'full_name',
            __('selectors.default.medicalSecretaries')
        );
    }

    /**
     * =====================================================
     * ASSIGN SECRETARY ROLE
     * =====================================================
     */
    public function handleSubmit()
    {
        $this->dispatch('form-submitted');

        $response = $this->manageForm->save();

        if ($response['status']) {

            $this->refreshPersonalOptions();

            $this->dispatch('update-medical-secretaries-table');
            $this->dispatch('open-toast', $response['message']);

            return;
        }

        $this->dispatch('open-errors', $response['errors']);
    }

    /**
     * =====================================================
     * OPEN DETACH DIALOG
     * =====================================================
     */


public function openManageSecretaryDialog(array $secretary): void
{
    $key = 'roles.detach.medical_secretary';

    $this->dispatch('open-dialog', [
        'question' => $key,
        'details' => [
            $key,
            $secretary['name'],
        ],
        'actionEvent' => [
            'event' => 'remove-medical-secretary',
            'parameters' => $secretary,
        ],
    ]);
}

/**
 * =====================================================
 * DETACH SECRETARY ROLE
 * =====================================================
 */
#[On('remove-medical-secretary')]
public function removeMedicalSecretary(User $secretary): void
{
    try {
        DB::transaction(function () use ($secretary) {

            if ($role = Role::medicalSecretary()) {
                $secretary->roles()->detach($role->id);
            }

                        $secretary->update([
                'managerable_id' => null,
                'managerable_type' => null,
            ]);
        });

        $this->refreshPersonalOptions();

        $this->dispatch('update-medical-secretaries-table');

        $this->dispatch(
            'open-toast',
            __('forms.common.messages.updated')
        );
    } catch (\Throwable $e) {

        Log::error('Error removing medical secretary', [
            'secretary_id' => $secretary->id,
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        $this->dispatch(
            'open-errors',
            __('forms.common.errors.default')
        );
    }
}
    /**
     * =====================================================
     * VIEW
     * =====================================================
     */
    public function render()
    {
        return view('livewire.app.service-coordinator.medical-secretaries-modal');
    }
}
