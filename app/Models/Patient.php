<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'patients';

    protected $casts = [
        'deleted_at' => 'datetime',
        'birth_date' => 'date',
    ];

    protected $withCount = ['appointments'];

    protected $fillable = [
        'code',

        'last_name_fr',
        'first_name_fr',
        'last_name_ar',
        'first_name_ar',

        'gender',

        'birth_place_fr',
        'birth_place_ar',
        'birth_place_en',

        'birth_date',

        'address_fr',
        'address_ar',
        'address_en',

        'commune_id',

        'father_id',
        'mother_id',

        'tel',
        'insurance_number',

        'opened_by',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | BOOTED (AUTO CODE GENERATION)
    |--------------------------------------------------------------------------
    */
    protected static function booted()
    {
        static::creating(function ($patient) {

            // prevent override if manually set
            if (!empty($patient->code)) {
                return;
            }

            $genderMap = [
                'male' => 'M',
                'female' => 'F',
                'other' => 'O',
            ];

            $genderCode = $genderMap[strtolower($patient->gender)] ?? 'O';

            $year = now()->format('y');
            $month = now()->format('m');

            // get last patient of this month/year
            $lastPatient = self::whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            if ($lastPatient && !empty($lastPatient->code)) {
                $lastNumber = (int) substr($lastPatient->code, -6);
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            $numberPart = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

            $patient->code = $genderCode . $year . $month . $numberPart;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

        public function referralLetter(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }


    public function openedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }

    public function father(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'father_id');
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'mother_id');
    }

    public function childrenAsFather(): HasMany
    {
        return $this->hasMany(Patient::class, 'father_id');
    }

    public function childrenAsMother(): HasMany
    {
        return $this->hasMany(Patient::class, 'mother_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function medicalExams(): HasMany
    {
        return $this->hasMany(MedicalExam::class, 'patient_id');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getLocalizedFirstNameAttribute(): string
    {
        return app()->getLocale() === 'ar'
            ? ($this->first_name_ar ?: $this->first_name_fr ?: '')
            : ($this->first_name_fr ?: '');
    }

    public function getLocalizedLastNameAttribute(): string
    {
        return app()->getLocale() === 'ar'
            ? ($this->last_name_ar ?: $this->last_name_fr ?: '')
            : ($this->last_name_fr ?: '');
    }

    public function getLocalizedFullNameAttribute(): string
    {
        return trim(
            $this->localized_last_name . ' ' .
            $this->localized_first_name
        );
    }

    public function getChildrenAttribute()
    {
        return $this->childrenAsFather
            ->merge($this->childrenAsMother)
            ->unique('id')
            ->values();
    }


}
