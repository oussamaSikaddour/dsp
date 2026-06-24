<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class GeneralSetting extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Cached instance for current request.
     */
    protected static ?self $currentInstance = null;

    protected $fillable = [
        'app_name',
        'acronym',
        'email',
        'phone',
        'landline',
        'fax',
        'address_fr',
        'address_ar',
        'address_en',
        'map',
        'maintenance',
        'theme_color',
        'inaugural_year',
        'youtube',
        'facebook',
        'linkedin',
        'github',
        'instagram',
        'tiktok',
        'twitter',
        'threads',
        'snapchat',
        'pinterest',
        'reddit',
        'telegram',
        'whatsapp',
        'discord',
        'twitch',
    ];

    protected $casts = [
        'maintenance' => 'boolean',
        'social_links' => 'array',
        'deleted_at' => 'datetime',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    protected $appends = [
        'logo_url',
        'address',
        'has_logo',
        'formatted_phone',
        'theme_color_class',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function bankingInformation(): MorphMany
    {
        return $this->morphMany(BankingInformation::class, 'bankable');
    }

    public function logo(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')
            ->where('use_case', 'avatar');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getLogoUrlAttribute(): string
    {
        $logo = $this->getRelationValue('logo');

        return $logo?->url
            ?? asset('assets/app/images/Logo.png');
    }

    public function getThemeColorClassAttribute(): string
    {
        return $this->theme_color !== 'default'
            ? $this->theme_color
            : '';
    }

    public function getHasLogoAttribute(): bool
    {
        return $this->getRelationValue('logo') !== null;
    }

    public function getAddressAttribute(): string
    {
        $field = 'address_' . app()->getLocale();

        return $this->{$field}
            ?? $this->address_fr
            ?? '';
    }

    public function getAllAddressesAttribute(): array
    {
        return [
            'fr' => $this->address_fr,
            'ar' => $this->address_ar,
            'en' => $this->address_en,
        ];
    }

    public function getFormattedPhoneAttribute(): ?string
    {
        return $this->phone
            ? preg_replace('/(\d{2})(?=\d)/', '$1 ', $this->phone)
            : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Static Helpers
    |--------------------------------------------------------------------------
    */

    public static function current(): self
    {
        if (static::$currentInstance !== null) {
            return static::$currentInstance;
        }

        $locale = app()->getLocale();
        $cacheKey = "general_settings_{$locale}";

        return static::$currentInstance = Cache::remember(
            $cacheKey,
            now()->addHours(6),
            fn () => static::query()
                ->with('logo')
                ->firstOrCreate()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Cache Management
    |--------------------------------------------------------------------------
    */

    public function clearCache(): void
    {
        foreach (['fr', 'ar', 'en'] as $locale) {
            Cache::forget("general_settings_{$locale}");
        }

        static::$currentInstance = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Model Events
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::saved(function (self $model) {
            $model->clearCache();
        });

        static::deleted(function (self $model) {
            $model->clearCache();
        });

        static::deleting(function (self $model): void {
            $model->logo()->withoutEvents(function () use ($model) {
                $model->logo?->delete();
            });
        });
    }
}
