<?php

namespace App\Livewire\Forms\App\Doctor;

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
            'service_id' => ['required', 'exists:services,id'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }


            public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes('doctor', [
       "user_id"
        ]);
    }


    public function save()
    {
        try {

            $data = $this->validate();

            $user = User::findOrFail($data['user_id']);

            $doctorRole = Role::doctor();

            if ($doctorRole) {
                $user->roles()->syncWithoutDetaching([
                    $doctorRole->id,
                ]);
            }

            $user->managerable_id = $data['service_id'];
            $user->managerable_type = Service::class;
            $user->save();

            return $this->response(
                true,
                message: __('forms.doctor.responses.add_success')
            );

        } catch (\Illuminate\Validation\ValidationException $e) {

            return $this->response(
                false,
                errors: $e->validator->errors()->all()
            );

        } catch (\Exception $e) {

            Log::error(
                'Error in Doctor ManageForm@save: ' .
                $e->getMessage()
            );

            return $this->response(
                false,
                errors: __('forms.common.errors.default')
            );
        }
    }
}
