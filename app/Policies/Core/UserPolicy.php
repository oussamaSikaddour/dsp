<?php

namespace App\Policies\Core;

use App\Models\User;

class UserPolicy
{
    /**
     * Role slugs.
     */
    private const SUPER_ADMIN = 'super_admin';
    private const ADMIN = 'admin';
    private const USER = 'user';
    private const DOCTOR = 'doctor';
    private const MEDICAL_SECRETARY = 'medical_secretary';
    private const ESTABLISHMENT_ADMINISTRATOR = 'establishment_administrator';
    private const SERVICE_COORDINATOR = 'service_coordinator';
    private const APPOINTMENTS_LOCATIONS_AGENT = 'appointments_locations_agent';

    /**
     * Check if the user owns the model.
     */
    protected function onlyOwner(User $user, User $model): bool
    {
        return $user->is($model);
    }

    /**
     * Check if the user has a specific role.
     */
    protected function hasRole(User $user, string $roleSlug): bool
    {
        return $user->roles->contains('slug', $roleSlug);
    }

    /**
     * Check if the user has any of the specified roles.
     */
    protected function hasAnyRole(User $user, array $roleSlugs): bool
    {
        return $user->roles
            ->pluck('slug')
            ->intersect($roleSlugs)
            ->isNotEmpty();
    }

    /**
     * Individual role checks.
     */
    public function isSuperAdmin(User $user): bool
    {
        return $this->hasRole($user, self::SUPER_ADMIN);
    }

    public function isAdmin(User $user): bool
    {
        return $this->hasRole($user, self::ADMIN);
    }

    public function isUser(User $user): bool
    {
        return $this->hasRole($user, self::USER);
    }

    public function isDoctor(User $user): bool
    {
        return $this->hasRole($user, self::DOCTOR);
    }

    public function isMedicalSecretary(User $user): bool
    {
        return $this->hasRole($user, self::MEDICAL_SECRETARY);
    }

    public function isEstablishmentAdministrator(User $user): bool
    {
        return $this->hasRole($user, self::ESTABLISHMENT_ADMINISTRATOR);
    }
    public function isAppointmentsLocationsAgent(User $user): bool
    {
        return $this->hasRole($user, self::APPOINTMENTS_LOCATIONS_AGENT);
    }

    public function isServiceCoordinator(User $user): bool
    {
        return $this->hasRole($user, self::SERVICE_COORDINATOR);
    }

    /**
     * Group checks.
     */
    public function isManagement(User $user): bool
    {
        return $this->hasAnyRole($user, [
            self::SUPER_ADMIN,
            self::ADMIN,
            self::ESTABLISHMENT_ADMINISTRATOR,
        ]);
    }

    public function isMedicalStaff(User $user): bool
    {
        return $this->hasAnyRole($user, [
            self::DOCTOR,
            self::MEDICAL_SECRETARY,
            self::SERVICE_COORDINATOR,
            self::APPOINTMENTS_LOCATIONS_AGENT
        ]);
    }

    public function isStaff(User $user): bool
    {
        return $this->hasAnyRole($user, [
            self::DOCTOR,
            self::MEDICAL_SECRETARY,
            self::SERVICE_COORDINATOR,
            self::ESTABLISHMENT_ADMINISTRATOR,
        ]);
    }

    public function isAdministrator(User $user): bool
    {
        return $this->hasAnyRole($user, [
            self::SUPER_ADMIN,
            self::ADMIN,
        ]);
    }
}
