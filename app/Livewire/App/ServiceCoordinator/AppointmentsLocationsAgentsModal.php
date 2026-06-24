<?php

namespace App\Livewire\App\ServiceCoordinator;

use App\Livewire\Forms\App\AppointmentsLocationAgent\ManageForm;
use App\Models\Daira;
use App\Models\Establishment;
use App\Models\Role;
use App\Models\User;
use App\Traits\Core\Common\GeneralTrait;
use App\Traits\Core\Common\TableTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class AppointmentsLocationsAgentsModal extends Component
{
    use TableTrait, GeneralTrait;

    // =====================================================
    // STATE
    // =====================================================
    public ManageForm $manageForm;

    public $establishmentId;
    public $dairaId = null;

    public string $local = 'fr';

    public array $personalOptions = [];
    public array $dairatesOptions = [];
    public array $appointmentsLocationsOptions = [];

    // =====================================================
    // MOUNT
    // =====================================================
    public function mount(): void
    {
        $this->local = app()->getLocale();

        $this->refreshPersonalOptions();

        $this->appointmentsLocationsOptions = $this->populateSelectorOption(
            $this->appointmentsLocations(),
            'id',
            'name_' . $this->local,
            __('selectors.default.appointments_locations')
        );

        $this->dairatesOptions = $this->populateSelectorOption(
            $this->dairates(),
            'id',
            'designation_' . $this->local,
            __('selectors.default.dairates')
        );
    }

    // =====================================================
    // DAIRAS
    // =====================================================
    #[Computed]
    public function dairates()
    {
        return Daira::query()
            ->whereHas('wilaya', fn($q) => $q->where('code', '13'))
            ->get(['id', 'designation_' . $this->local]);
    }

    // =====================================================
    // APPOINTMENT LOCATIONS
    // =====================================================
    #[Computed]
    public function appointmentsLocations()
    {
        return Establishment::query()
            ->whereJsonContains('types', 'appointment_locations')
            ->when($this->dairaId, fn($q) => $q->where('daira_id', $this->dairaId))
            ->get(['id', 'name_' . $this->local]);
    }

    // =====================================================
    // AVAILABLE USERS
    // =====================================================
    #[Computed]
    public function personal()
    {
        return User::query()
            ->where('users.establishment_id', $this->establishmentId)
            ->whereDoesntHave('roles', function ($q) {
                $q->whereIn('slug', [
                    'doctor',
                    'service_coordinator',
                    'medical_secretary',
                    'establishment_admin',
                    'appointments_locations_agent'
                ]);
            })
            ->orderBy('users.last_name')
            ->orderBy('users.first_name')
            ->get(['users.id', 'users.first_name', 'users.last_name'])
            ->map(fn($user) => [
                'id' => $user->id,
                'full_name' => trim(
                    ($user->last_name ?? '') . ' ' . ($user->first_name ?? '')
                ) ?: 'Unknown User',
            ]);
    }

    // =====================================================
    // ASSIGNED AGENTS (FIXED SQL AMBIGUITY)
    // =====================================================
    #[Computed]
    public function AppointmentsLocationsAgents()
    {
        return User::query()
            ->leftJoin('establishments', 'establishments.id', '=', 'users.managerable_id')
            ->where('users.establishment_id', $this->establishmentId)
            ->whereHas('roles', fn($q) => $q->where('slug', 'appointments_locations_agent'))
            ->select([
                'users.id',
                'users.email',
                "establishments.name_{$this->local} as appointments_location",
                'users.created_at',
                DB::raw("CONCAT(users.last_name, ' ', users.first_name) as name"),
            ])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->get();
    }

    // =====================================================
    // REFRESH OPTIONS
    // =====================================================
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

    // =====================================================
    // SUBMIT
    // =====================================================
    public function handleSubmit()
    {
        $this->dispatch('form-submitted');

        $response = $this->manageForm->save();

        if ($response['status']) {

            $this->refreshPersonalOptions();

            $this->dispatch('update-appointments-locations-agents-table');
            $this->dispatch('open-toast', $response['message']);

            return;
        }

        $this->dispatch('open-errors', $response['errors']);
    }

    // =====================================================
    // REMOVE CONFIRMATION
    // =====================================================
    public function openDetachAppointmentsLocationAgentDialog(array $secretary): void
    {
        $key = 'roles.detach.appointments_location_agent';

        $this->dispatch('open-dialog', [
            'question' => $key,
            'details' => [
                $key,
                $secretary['name'],
            ],
            'actionEvent' => [
                'event' => 'remove-appointments-location-agent',
                'parameters' => $secretary,
            ],
        ]);
    }

    // =====================================================
    // REMOVE AGENT
    // =====================================================
    #[On('remove-appointments-location-agent')]
    public function removeAppointLocationsAgent(User $user): void
    {
        try {
            DB::transaction(function () use ($user) {

                if ($role = Role::appointmentsLocationsAgent()) {
                    $user->roles()->detach($role->id);
                }

                $user->update([
                    'managerable_id' => null,
                    'managerable_type' => null,
                ]);
            });

            $this->refreshPersonalOptions();

            $this->dispatch('update-medical-secretaries-table');

            $this->dispatch('open-toast', __('forms.common.messages.updated'));

        } catch (\Throwable $e) {

            Log::error('Error removing medical secretary', [
                'user_id' => $user->id,
                'message' => $e->getMessage(),
            ]);

            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    // =====================================================
    // LIVEWIRE UPDATES
    // =====================================================
    public function updated(string $property): void
    {
        if ($property === 'dairaId') {
            $this->appointmentsLocationsOptions = $this->populateSelectorOption(
                $this->appointmentsLocations(),
                'id',
                'name_' . $this->local,
                __('selectors.default.appointments_locations')
            );
        }
    }

    // =====================================================
    // VIEW
    // =====================================================
    public function render()
    {
        return view('livewire.app.service-coordinator.appointments-locations-agents-modal');
    }
}
