<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    // Enables support for soft deletes and manages the deleted_at column
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "name_ar",
        "name_fr",
        "name_en",
        "head_of_service_id",
        "type",
        "specialty_id",
        'establishment_id',
        'tel',
        'fax'
    ];

    /**
     * The user responsible for the service.
     */
    public function headOfService(): BelongsTo
    {
        return $this->belongsTo(User::class, "head_of_service_id");
    }
    public function specialty(): BelongsTo
    {
        return $this->belongsTo(FieldSpecialty::class, "specialty_id");
    }



   public function administrator():BelongsTo
    {
            return $this->hasOne(User::class, 'admin_of')
                ->whereHas('roles', function ($q) {
                    $q->where('slug', 'service_admin');
                });
    }
    /**
     * Polymorphic relation to articles.
     */

    /**
     * Polymorphic relation to sliders.
     */
    public function sliders(): MorphMany
    {
        return $this->morphMany(Slider::class, 'sliderable');
    }


        public function Establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    public function schedules(): hasMany
    {
        return $this->hasMany(Schedule::class);
    }
    /**
     * Get the localized name based on the current app locale.
     */
    public function getLocalizedNameAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->{"name_$locale"} ?? $this->name_fr ?? '';
    }
}
