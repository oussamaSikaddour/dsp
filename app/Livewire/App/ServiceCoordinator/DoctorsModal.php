<?php

namespace App\Livewire\App\ServiceCoordinator;

use App\Livewire\Forms\App\Doctor\ManageForm;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use App\Traits\Core\Common\GeneralTrait;
use App\Traits\Core\Common\TableTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class DoctorsModal extends Component
{
    use TableTrait, GeneralTrait;

    public ManageForm $manageForm;

    public $establishmentId;
    public $serviceId;

    public string $local = 'fr';

    public array $personalOptions = [];

    /**
     * INIT
     */
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
     * AVAILABLE USERS (CAN BECOME DOCTORS)
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
        ->map(fn ($user) => [
            'id' => $user->id,
            'full_name' => trim(
                ($user->last_name ?? '') . ' ' . ($user->first_name ?? '')
            ) ?: 'Unknown User',
        ]);
}

    /**
     * =====================================================
     * ASSIGNED DOCTORS (FOR TABLE)
     * =====================================================
     */
    #[Computed]
    public function doctors()
    {
        return User::query()
            ->where('establishment_id', $this->establishmentId)

            ->whereHas('roles', fn ($q) => $q->where('slug', 'doctor'))

            // 🔥 IMPORTANT: linked to service
            ->where('managerable_id', $this->serviceId)
            ->where('managerable_type', Service::class)

            ->select([
                'id',
                'email',
                'created_at',
                DB::raw("CONCAT(last_name, ' ', first_name) as name"),
            ])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->get();
    }

    /**
     * =====================================================
     * RESET DROPDOWN
     * =====================================================
     */
    private function refreshPersonalOptions(): void
    {
        $this->manageForm->user_id = null;

        $this->personalOptions = $this->populateSelectorOption(
            $this->personal(),
            'id',
            'full_name',
            __('selectors.default.doctors')
        );
    }

    /**
     * =====================================================
     * ATTACH DOCTOR
     * =====================================================
     */
    public function handleSubmit()
    {
        $this->dispatch('form-submitted');

        $response = $this->manageForm->save();

        if ($response['status']) {

            $this->refreshPersonalOptions();

            $this->dispatch('update-doctors-table');
            $this->dispatch('open-toast', $response['message']);

            return;
        }

        $this->dispatch('open-errors', $response['errors']);
    }

    /**
     * =====================================================
     * OPEN DETACH CONFIRMATION
     * =====================================================
     */

public function openManageDoctorDialog(array $doctor): void
{
    $key = 'roles.detach.doctor';

    $this->dispatch('open-dialog', [
        'question' => $key,
        'details' => [
            $key,
            $doctor['name'],
        ],
        'actionEvent' => [
            'event' => 'remove-doctor',
            'parameters' => $doctor,
        ],
    ]);
}

/**
 * =====================================================
 * DETACH DOCTOR ROLE
 * =====================================================
 */
#[On('remove-doctor')]
public function removeDoctor(User $doctor): void
{
    try {
        DB::transaction(function () use ($doctor) {

            if ($role = Role::doctor()) {
                $doctor->roles()->detach($role->id);
            }

            $doctor->update([
                'managerable_id' => null,
                'managerable_type' => null,
            ]);
        });

        $this->refreshPersonalOptions();

        $this->dispatch('update-doctors-table');

        $this->dispatch(
            'open-toast',
            __('forms.common.messages.updated')
        );
    } catch (\Throwable $e) {

        Log::error('Error removing doctor', [
            'doctor_id' => $doctor->id,
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
     * RENDER
     * =====================================================
     */
    public function render()
    {
        return view('livewire.app.service-coordinator.doctors-modal');
    }
}
