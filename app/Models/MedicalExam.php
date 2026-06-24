<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class MedicalExam extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'medical_exams';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'report_fr',
        'report_ar',
        'report_en',
        'specialty_id'
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $hidden = [
        'deleted_at',
    ];


    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }



    public function specialty(): BelongsTo
    {
        return $this->belongsTo(FieldSpecialty::class, 'specialty_id');
    }
    /**
     * Patient (medical file) associated with the visit.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    /**
     * Doctor who performed the visit.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }



    /**
     * Get diagnostic based on current app locale.
     */
    public function getLocalizedReportAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->{"report_$locale"} ?? $this->report_fr ?? '';
    }
}
