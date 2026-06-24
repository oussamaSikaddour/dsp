<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Establishment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "acronym",
        "name_fr",
        "name_en",
        "name_ar",
        "email",
        "address_fr",
        "address_ar",
        "address_en",
        "description_fr",
        "description_en",
        "description_ar",
        "tel",
        "fax",
        "daira_id",
        "longitude",
        "latitude",
        "types",
    ];

    protected $casts = [
        'types' => 'array',
    ];

    /*
    |---------------------------------------
    | Relationships
    |---------------------------------------
    */

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function daira(): BelongsTo
    {
        return $this->belongsTo(Daira::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'appointments_location_id');
    }

    public function users()
    {
        return $this->morphMany(User::class, 'managerable');
    }

    public function administrators()
    {
        return $this->users()
            ->whereHas('roles', function ($q) {
                $q->where('slug', 'establishment_admin');
            });
    }

    /*
    |---------------------------------------
    | NEW: Schedule System (pivot)
    |---------------------------------------
    */

    public function scheduleDays(): BelongsToMany
    {
        return $this->belongsToMany(
            ScheduleDay::class,
            'establishment_schedule_day'
        )->withTimestamps();
    }

    /*
    |---------------------------------------
    | Business Logic
    |---------------------------------------
    */

    public function supportsAppointmentsLocations(): bool
    {
        return is_array($this->types)
            && in_array('appointments_locations', $this->types);
    }

    public function supportsScheduling(): bool
    {
        return $this->supportsAppointmentsLocations();
    }

    /*
    |---------------------------------------
    | Localization
    |---------------------------------------
    */

    public function getLocalizedNameAttribute(): string
    {
        $locale = app()->getLocale();

        return $this->{"name_$locale"}
            ?? $this->name_fr
            ?? '';
    }
}
