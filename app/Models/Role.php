<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * In-memory cache for current request.
     */
    protected static array $memoryCache = [];

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Hidden attributes.
     */
    protected $hidden = [
        'pivot',
        'deleted_at',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Many-to-many relationship with users.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }

    /**
     * Get role by slug with memory + persistent cache.
     */
    public static function bySlug(string $slug): ?self
    {
        // Memory cache (same request)
        if (array_key_exists($slug, static::$memoryCache)) {
            return static::$memoryCache[$slug];
        }

        // Persistent cache
        $role = Cache::rememberForever(
            "role:slug:{$slug}",
            fn () => static::query()
                ->where('slug', $slug)
                ->first()
        );

        // Save in memory cache
        static::$memoryCache[$slug] = $role;

        return $role;
    }

    /**
     * SUPER ADMIN role.
     */
    public static function superAdmin(): ?self
    {
        return static::bySlug('super_admin');
    }

    /**
     * ADMIN role.
     */
    public static function admin(): ?self
    {
        return static::bySlug('admin');
    }

    /**
     * USER role.
     */
    public static function user(): ?self
    {
        return static::bySlug('user');
    }

    /**
     * DOCTOR role.
     */
    public static function doctor(): ?self
    {
        return static::bySlug('doctor');
    }

    /**
     * MEDICAL SECRETARY role.
     */
    public static function medicalSecretary(): ?self
    {
        return static::bySlug('medical_secretary');
    }

    /**
     * ESTABLISHMENT ADMINISTRATOR role.
     */
    public static function establishmentAdmin(): ?self
    {
        return static::bySlug('establishment_admin');
    }

    /**
     * APPOINTMENTS LOCATIONS AGENT role.
     */
    public static function appointmentsLocationsAgent(): ?self
    {
        return static::bySlug('appointments_locations_agent');
    }

    /**
     * SERVICE COORDINATOR role.
     */
    public static function coordinator(): ?self
    {
        return static::bySlug('service_coordinator');
    }

    /**
     * Clear cache when role changes.
     */
    protected static function booted(): void
    {
        static::saved(function (self $role) {
            static::forgetRoleCache($role->slug);
        });

        static::deleted(function (self $role) {
            static::forgetRoleCache($role->slug);
        });

        static::restored(function (self $role) {
            static::forgetRoleCache($role->slug);
        });
    }

    /**
     * Forget role cache.
     */
    protected static function forgetRoleCache(string $slug): void
    {
        unset(static::$memoryCache[$slug]);

        Cache::forget("role:slug:{$slug}");
    }
}
