<?php

namespace App\Livewire\Forms\App\AppointmentsLocationAgent;

use App\Models\Establishment;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use App\Traits\Core\Web\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Form;

class ManageForm extends Form
{
    use ResponseTrait;
    public $appointments_location_id = null;
    public $user_id = null;

    public function rules()
    {
        return [
            'appointments_location_id'   => ['required', 'exists:establishments,id'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }

        public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes('appointments_location_agent', [
          "appointments_location_id","user_id"
        ]);
    }


    public function save()
    {
        try {
            $data = $this->validate();

            // Find the user by user_id
            $user = User::findOrFail($data['user_id']);

            // Attach the coordinator role (if not already attached)
            $appointmentsLocationsAgentRole = Role::appointmentsLocationsAgent();
            if ($appointmentsLocationsAgentRole) {
                $user->roles()->syncWithoutDetaching([$appointmentsLocationsAgentRole->id]);
            }

            $user->managerable_id = $data['appointments_location_id'];
            $user->managerable_type = Establishment::class;
            $user->save();

            return $this->response(
                true,
                message: __('forms.appointments_location_agent.responses.add_success')
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Exception $e) {
            Log::error('Error in ManageForm@save: ' . $e->getMessage());
            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }
}
