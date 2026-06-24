<?php

namespace App\Livewire\Forms\App;

use App\Enum\Core\Web\RoutesNames;
use App\Models\Role;
use App\Models\User;
use App\Models\Patient;
use App\Traits\Core\Web\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Livewire\Form;

class RegisterForm extends Form
{
    use ResponseTrait;

    public string $name = '';
    public string $email = '';
    public string $password = '';

    public string $first_name = '';
    public string $last_name = '';

    public bool $agree_terms = false;

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:3', 'max:100'],
            'last_name'  => ['required', 'string', 'min:3', 'max:100'],

            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('users', 'name')->whereNull('deleted_at'),
            ],

            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],

            'password' => ['required', 'string', 'min:8', 'max:255'],
            'agree_terms' => ['accepted'],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'first_name' => __('forms.user.first_name'),
            'last_name'  => __('forms.user.last_name'),
            'name'       => __('forms.user.name'),
            'email'      => __('forms.register.email'),
            'password'   => __('forms.register.password'),
            'agree_terms'=> __('forms.register.agree_terms'),
        ];
    }

    public function save()
    {
        $rateLimiterKey = 'register:' . request()->ip();

        if (RateLimiter::tooManyAttempts($rateLimiterKey, 5)) {
            return $this->response(
                false,
                errors: [__('forms.register.errors.too_many_attempts')]
            );
        }

        try {
            $data = $this->validate();

            return DB::transaction(function () use ($data, $rateLimiterKey) {

                // 1. Create User
                $user = User::create([
                    'name'       => $data['name'],
                    'first_name' => $data['first_name'],
                    'last_name'  => $data['last_name'],
                    'email'      => $data['email'],
                    'password'   => Hash::make($data['password']),
                ]);

                // 2. Assign role
                $role = Role::where('slug', config('defaultRole.default_role_slug', 'user'))->first();

                if ($role) {
                    $user->roles()->attach($role->id);
                }



                // 4. Auth
                Auth::login($user);
                session()->regenerate();

                if (method_exists($user, 'setSessionKey')) {
                    $user->setSessionKey();
                }

                RateLimiter::clear($rateLimiterKey);

                return $this->response(
                    true,
                    data: ['route' => RoutesNames::DASHBOARD->value],
                    message: __('forms.register.responses.success')
                );
            });

        } catch (\Illuminate\Validation\ValidationException $e) {

            RateLimiter::hit($rateLimiterKey);

            return $this->response(false, errors: $e->validator->errors()->all());

        } catch (\Throwable $e) {

            RateLimiter::hit($rateLimiterKey);

            Log::error('Register error', [
                'message' => $e->getMessage()
            ]);

            return $this->response(
                false,
                errors: __('forms.common.errors.default')
            );
        }
    }
}
