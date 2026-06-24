<?php

namespace App\Livewire\Forms\Core\User;

use App\Models\Role;
use App\Models\User;
use App\Traits\Core\Common\ModelFileTrait;
use App\Traits\Core\Common\ModelImageTrait;
use App\Traits\Core\Web\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AddForm extends Form
{
    use ResponseTrait, ModelImageTrait, ModelFileTrait;

    public $name;
    public $last_name;
    public $first_name;
    public $email;
    public $password;
    public $avatar;

    public $managerable_id;
    public $managerable_type;
    public $establishment_id;

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'last_name' => ['required', 'string', 'min:3', 'max:100'],
            'first_name' => ['required', 'string', 'min:3', 'max:100'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],

            'password' => ['required', 'string', 'min:8', 'max:255'],

            'avatar' => [
                'nullable',
                'file',
                'mimes:jpeg,png,gif,ico,webp',
                'max:10000',
            ],
        ];
    }

    /**
     * Localized attribute names.
     */
    public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes('user', [
            'avatar',
            'name',
            'last_name',
            'first_name',
            'password',
            'email',
        ]);
    }

    /**
     * Store the user inside a database transaction.
     */
    public function save()
    {
        try {
            $data = $this->validate();

            return DB::transaction(function () use ($data) {

                $data['password'] = Hash::make($data['password']);

                $data['managerable_id'] = $this->managerable_id;
                $data['managerable_type'] = $this->managerable_type;
                $data['establishment_id'] = $this->establishment_id;

                $user = User::create($data);

                $this->assignDefaultRole($user);

                $this->uploadImage($user);

                return $this->response(
                    true,
                    message: __('forms.user.responses.add_success')
                );
            });
        } catch (\Illuminate\Validation\ValidationException $e) {

            return $this->response(
                false,
                errors: $e->validator->errors()->all()
            );

        } catch (\Throwable $e) {

            Log::error('AddForm User creation error', [
                'message' => $e->getMessage(),
                'managerable_id' => $this->managerable_id,
                'managerable_type' => $this->managerable_type,
            ]);

            return $this->response(
                false,
                errors: __('forms.common.errors.default')
            );
        }
    }

    /**
     * Upload user avatar.
     */
    protected function uploadImage(User $user): void
    {
        if ($this->avatar) {
            $this->uploadAndCreateImage(
                $this->avatar,
                $user->id,
                User::class,
                'avatar'
            );
        }
    }

    /**
     * Assign default role to user.
     */
    private function assignDefaultRole(User $user): void
    {
        $defaultRoleSlug = config('defaultRole.default_role_slug', 'user');

        $defaultRole = Role::where('slug', $defaultRoleSlug)->first();

        if (!$defaultRole) {
            Log::warning(
                "Default role '{$defaultRoleSlug}' not found for new user."
            );

            return;
        }

        $user->roles()->attach($defaultRole->id);
    }
}
