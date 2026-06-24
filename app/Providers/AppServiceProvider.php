<?php

namespace App\Providers;

use App\Enum\Core\Web\RoutesNames;
use App\Models\Establishment;
use App\Models\Service;
use App\Policies\Core\UserPolicy;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Authenticate::redirectUsing(
            fn () => route(RoutesNames::INDEX->value)
        );

        $this->definePolicyGates();
        $this->defineSessionBasedGates();
    }

    /*
    |--------------------------------------------------------------------------
    | Basic Role Gates
    |--------------------------------------------------------------------------
    */
    protected function definePolicyGates(): void
    {
        $gates = [
            'super-admin-access' => 'isSuperAdmin',
            'admin-access'       => 'isAdmin',
            'user-access'        => 'isUser',
        ];

        foreach ($gates as $gate => $method) {
            Gate::define($gate, [UserPolicy::class, $method]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Context-Based Gates
    |--------------------------------------------------------------------------
    */
    protected function defineSessionBasedGates(): void
    {
        $this->sessionMorphGate('establishment-admin-access', [
            'sessionKey' => 'establishment_id',
            'morphType'  => Establishment::class,
            'roles'      => ['establishment_admin'],
        ]);

        $this->sessionMorphGate('appointments-locations-agent-access', [
            'sessionKey' => 'establishment_id',
            'morphType'  => Establishment::class,
            'roles'      => ['appointments_locations_agent'],
        ]);

        $this->sessionMorphGate('establishment-and-appointments-locations-access', [
            'sessionKey' => 'establishment_id',
            'morphType'  => Establishment::class,
            'roles'      => ['appointments_locations_agent', 'establishment_admin'],
            'mustHaveAllRoles' => false,
            'featureCheck' => fn ($id) =>
                Establishment::find($id)?->supportsAppointmentsLocations() ?? false,
        ]);

        $this->sessionMorphGate('service-coordinator-access', [
            'sessionKey' => 'service_id',
            'morphType'  => Service::class,
            'roles'      => ['service_coordinator'],
        ]);
        $this->sessionMorphGate('doctor-access', [
            'sessionKey' => 'service_id',
            'morphType'  => Service::class,
            'roles'      => ['doctor'],
        ]);

        $this->sessionMorphGate('medical-secretary-access', [
            'sessionKey' => 'service_id',
            'morphType'  => Service::class,
            'roles'      => ['medical_secretary', 'service_coordinator'],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Core Gate Engine
    |--------------------------------------------------------------------------
    */
    protected function sessionMorphGate(string $gate, array $config): void
    {
        Gate::define($gate, function ($user) use ($config) {

            $sessionId = session($config['sessionKey']);


            if (!$sessionId) {
                return false;
            }


            /*
             * 1. Context ownership check
             */



            if ($user->managerable_type !== $config['morphType']) {
                return false;
            }



            if ((int) $user->managerable_id !== (int) $sessionId) {
                return false;
            }

            /*
             * 2. Role validation
             */
            $roles = $config['roles'] ?? [];

            $mustHaveAllRoles = $config['mustHaveAllRoles'] ?? false;

            if ($mustHaveAllRoles) {
                foreach ($roles as $role) {
                    if (!$user->hasRole($role)) {
                        return false;
                    }
                }
            } else {

               $user->hasAnyRole($roles);
                if (!$user->hasAnyRole($roles)) {
                    return false;
                }
            }

            /*
             * 3. Optional feature check (ONLY if defined)
             */
            if (isset($config['featureCheck']) && is_callable($config['featureCheck'])) {
                if (! $config['featureCheck']($sessionId)) {
                    return false;
                }
            }

            return true;
        });
    }
}
