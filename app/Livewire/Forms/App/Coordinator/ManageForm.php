<?php

namespace App\Livewire\Forms\App\Coordinator;

use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use App\Traits\Core\Web\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Form;

class ManageForm extends Form
{
    use ResponseTrait;
    public $service_id = null;
    public $user_id = null;

    public function rules()
    {
        return [
            'service_id'   => ['required', 'exists:services,id'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }

        public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes('coordinator', [
          "service_id","user_id"
        ]);
    }


    public function save()
    {
        try {
            $data = $this->validate();

            // Find the user by user_id
            $user = User::findOrFail($data['user_id']);

            // Attach the coordinator role (if not already attached)
            $coordinatorRole = Role::coordinator();
            if ($coordinatorRole) {
                $user->roles()->syncWithoutDetaching([$coordinatorRole->id]);
            }

            $user->managerable_id = $data['service_id'];
            $user->managerable_type = Service::class;
            $user->save();

            return $this->response(
                true,
                message: __('forms.coordinator.responses.add_success')
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Exception $e) {
            Log::error('Error in ManageForm@save: ' . $e->getMessage());
            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }
}
