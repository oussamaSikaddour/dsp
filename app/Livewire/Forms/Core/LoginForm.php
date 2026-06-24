<?php

namespace App\Livewire\Forms\Core;

use App\Enum\Core\Web\RoutesNames;
use App\Traits\Core\Web\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Form;

class LoginForm extends Form
{
    use ResponseTrait;

    public string $login = ''; // email or username
    public string $password = '';

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'min:8', 'max:255'],
        ];
    }

    /**
     * Custom attribute names.
     */
    public function validationAttributes(): array
    {
        return [
            'login' => __('forms.login.login'),
            'password' => __('forms.login.password'),
        ];
    }

    /**
     * Handle login.
     */
    public function save()
    {
        $requestIp = request()->ip();
        $rateLimiterKey = 'login:' . $requestIp . ':' . $this->login;

        // 🔒 Rate limiting
        if (RateLimiter::tooManyAttempts($rateLimiterKey, 5)) {
            return $this->response(
                false,
                errors: [__('forms.login.errors.too_many_attempts')]
            );
        }

        try {
            $data = $this->validate();

            // Detect email or username
            $field = filter_var($data['login'], FILTER_VALIDATE_EMAIL)
                ? 'email'
                : 'name'; // change to 'username' if your DB uses username

            $credentials = [
                $field => $data['login'],
                'password' => $data['password'],
                'is_active' => true,
            ];

            // ❌ Failed login
            if (!Auth::attempt($credentials)) {
                RateLimiter::hit($rateLimiterKey, 60); // decay: 60 seconds

                return $this->response(
                    false,
                    errors: [__('forms.login.errors.invalid_credentials')]
                );
            }

            // ✅ Success
            RateLimiter::clear($rateLimiterKey);

            session()->regenerate();

            /** @var \App\Models\User $user */
            $user = Auth::user();


            $user->update([
                'was_generated_by_appointments_location_agent' => false,
            ]);


            $user->setSessionKey();

            return $this->response(
                true,
                data: ['route' => RoutesNames::DASHBOARD->value]
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Throwable $e) {
            Log::error('Login form error: ' . $e->getMessage());

            return $this->response(
                false,
                errors: [__('forms.common.errors.default')]
            );
        }
    }
}
