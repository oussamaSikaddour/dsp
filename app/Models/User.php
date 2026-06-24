<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'first_name',
        'email',
        'password',
        'is_active',
        'establishment_id',
        'managerable_id',
        'managerable_type',
        'was_generated_by_appointments_location_agent'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array<int, string>
     */
    protected $with = ['roles'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /*
    |---------------------------------------
    | Relationships
    |---------------------------------------
    */

    /**
     * Get the establishment that the user belongs to.
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Get the roles assigned to the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Get the parent managerable model (service or establishment).
     */
    public function managerable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user's avatar image.
     */
    public function avatar(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')
            ->where('use_case', 'avatar');
    }

    /*
    |---------------------------------------
    | Role Helpers
    |---------------------------------------
    */

    /**
     * Check if the user has a specific role.
     */
    public function hasRole(string $slug): bool
    {
        return $this->roles()->where('slug', $slug)->exists();
    }

    /**
     * Check if the user has any of the given roles.
     */
    public function hasAnyRole(array $slugs): bool
    {
        return $this->roles()
            ->whereIn('slug', $slugs)
            ->exists();
    }

    /**
     * Check if the user has all of the given roles.
     */
    public function hasAllRoles(array $slugs): bool
    {
        $userRoleSlugs = $this->roles->pluck('slug')->toArray();
        return !array_diff($slugs, $userRoleSlugs);
    }

    /**
     * Check if the user is a super admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    /**
     * Check if the user is a doctor.
     */
    public function isDoctor(): bool
    {
        return $this->hasRole('doctor');
    }

    /**
     * Assign a role to the user.
     */
    public function assignRole(string|Role $role): self
    {
        $roleId = $role instanceof Role ? $role->id : Role::where('slug', $role)->firstOrFail()->id;
        $this->roles()->syncWithoutDetaching([$roleId]);
        return $this;
    }

    /**
     * Remove a role from the user.
     */
    public function removeRole(string|Role $role): self
    {
        $roleId = $role instanceof Role ? $role->id : Role::where('slug', $role)->firstOrFail()->id;
        $this->roles()->detach([$roleId]);
        return $this;
    }

    /**
     * Sync multiple roles to the user (replaces all existing roles).
     */
    public function syncRoles(array $roles): self
    {
        $roleIds = collect($roles)->map(function ($role) {
            return $role instanceof Role ? $role->id : Role::where('slug', $role)->firstOrFail()->id;
        })->toArray();

        $this->roles()->sync($roleIds);
        return $this;
    }

    /**
     * Check if the user has more than one role.
     */
    public function hasManyRoles(): Attribute
    {
        return Attribute::get(function (): bool {
            if ($this->relationLoaded('roles')) {
                return $this->roles->count() > 1;
            }

            return $this->roles()->count() > 1;
        });
    }

    /*
    |---------------------------------------
    | Scopes
    |---------------------------------------
    */

    /**
     * Scope a query to only include super admins.
     */
    public function scopeSuperAdmins(Builder $query): Builder
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('slug', 'super_admin');
        });
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include users with a specific role.
     */
    public function scopeWithRole(Builder $query, string $roleSlug): Builder
    {
        return $query->whereHas('roles', function ($q) use ($roleSlug) {
            $q->where('slug', $roleSlug);
        });
    }

    /*
    |---------------------------------------
    | Business Logic
    |---------------------------------------
    */

    /**
     * Check if the user manages a specific model.
     */
    public function manages(Model $model): bool
    {
        return $this->managerable_type === get_class($model)
            && (int) $this->managerable_id === (int) $model->id;
    }

    /**
     * Check if the user manages a specific type of resource.
     */
    public function managesType(string $type): bool
    {
        return $this->managerable_type === $type;
    }

    /**
     * Get the current managerable model (service or establishment).
     */
    public function getCurrentManagerable(): ?Model
    {
        if (!$this->managerable_type || !$this->managerable_id) {
            return null;
        }

        return match ($this->managerable_type) {
            Service::class => Service::find($this->managerable_id),
            Establishment::class => Establishment::find($this->managerable_id),
            default => null,
        };
    }

    /*
    |---------------------------------------
    | Session Binding
    |---------------------------------------
    */

    /**
     * Set session keys based on the user's managerable type.
     */
    public function setSessionKey(): void
    {
        session()->forget(['service_id', 'establishment_id']);

        match ($this->managerable_type) {
            Service::class => session(['service_id' => $this->managerable_id]),
            Establishment::class => session(['establishment_id' => $this->managerable_id]),
            default => null,
        };
    }

    /**
     * Get the current context (service or establishment) from session.
     */
    public function getCurrentContext(): ?Model
    {
        if (session()->has('service_id')) {
            return Service::find(session('service_id'));
        }

        if (session()->has('establishment_id')) {
            return Establishment::find(session('establishment_id'));
        }

        return $this->getCurrentManagerable();
    }

    /*
    |---------------------------------------
    | Accessors & Mutators
    |---------------------------------------
    */

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return trim($this->last_name . ' ' . $this->first_name);
    }

    /**
     * Get the user's initials.
     */
    public function getInitialsAttribute(): string
    {
        $firstNameInitial = $this->first_name ? strtoupper($this->first_name[0]) : '';
        $lastNameInitial = $this->last_name ? strtoupper($this->last_name[0]) : '';

        return $firstNameInitial . $lastNameInitial;
    }

    /**
     * Get the user's display name (prefers full name, falls back to name field).
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->full_name) {
            return $this->full_name;
        }

        return $this->name ?? $this->email;
    }

    /*
    |---------------------------------------
    | Additional Helpers
    |---------------------------------------
    */

    /**
     * Check if the user account is active.
     */
    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    /**
     * Activate the user account.
     */
    public function activate(): self
    {
        $this->update(['is_active' => true]);
        return $this;
    }

    /**
     * Deactivate the user account.
     */
    public function deactivate(): self
    {
        $this->update(['is_active' => false]);
        return $this;
    }

    /**
     * Get the user's role names as a string.
     */
    public function getRoleNamesAttribute(): string
    {
        return $this->roles->pluck('name')->implode(', ');
    }

    /**
     * Get the user's role slugs as an array.
     */
    public function getRoleSlugsAttribute(): array
    {
        return $this->roles->pluck('slug')->toArray();
    }
}
