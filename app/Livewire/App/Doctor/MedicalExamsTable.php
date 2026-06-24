<?php

namespace App\Livewire\App\Doctor;

use App\Models\File;
use App\Models\Image;
use App\Models\MedicalExam;
use App\Models\User;
use App\Models\exam;
use App\Models\FieldSpecialty;
use App\Traits\Core\Common\GeneralTrait;
use App\Traits\Core\Common\ModelFileTrait;
use App\Traits\Core\Common\ModelImageTrait;
use App\Traits\Core\Common\TableTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class MedicalExamsTable extends Component
{
    use WithPagination, TableTrait, GeneralTrait, ModelImageTrait, ModelFileTrait;

    #[Url]
    public ?int $doctorId = null;


    #[Url]
    public string $patient = '';

    #[Url]
    public string $patientCode = '';

    public ?int $patientId = null;
    public ?int $specialtyId=null;
    public string $locale = 'fr';
    public array $doctorsOptions = [];
    public array $specialtiesOptions = [];

    public bool $detailedView =false;
    protected array $filterable = [
        'doctorId',
        'patient',
        'patientCode',
        'specialtyId'
    ];

    protected array $rules = [
        'doctorId' => ['nullable', 'integer', 'exists:users,id'],
        'specialtyId' => ['nullable', 'integer', 'exists:field_specialties,id'],
        'patient' => ['nullable', 'string', 'max:255'],
        'patientCode' => ['nullable', 'string', 'max:50'],
    ];

    /* -------------------------------------------------------------------------- */
    /*                               Helper Methods                               */
    /* -------------------------------------------------------------------------- */

    protected function localFrAndArOnly(): string
    {
        return in_array($this->locale, ['fr', 'ar'], true) ? $this->locale : 'fr';
    }

    /* -------------------------------------------------------------------------- */
    /*                               Lifecycle Hooks                              */
    /* -------------------------------------------------------------------------- */

    public function mount(): void
    {




        $this->locale = app()->getLocale();


                $this->specialtiesOptions = $this->populateSelectorOption(
            $this->specialties(),
            'id',
            'designation_' . $this->locale,
            __('selectors.default.specialties')
        );

        $this->doctorsOptions = $this->populateSelectorOption(
            $this->getDoctors(),
            'id',
            "full_name",
            __('selectors.default.doctors')
        );
    }

    /* -------------------------------------------------------------------------- */
    /*                               Computed Data                                */
    /* -------------------------------------------------------------------------- */

    #[Computed]
    public function medicalExams()
    {
        return $this->buildMedicalExamsQuery()
            ->paginate($this->perPage);
    }

    protected function buildMedicalExamsQuery()
    {
        $lang = $this->localFrAndArOnly();

        return MedicalExam::query()
            ->leftJoin('patients', 'patients.id', '=', 'medical_exams.patient_id')
            ->leftJoin('users', 'users.id', '=', 'medical_exams.doctor_id')
            ->leftJoin('field_specialties', 'field_specialties.id', '=', 'medical_exams.specialty_id')
            ->when($this->specialtyId, fn($q) =>
            $q->where('medical_exams.specialty_id', $this->specialtyId)
        )
            ->when(
                filled($this->patientId),
                fn($q) => $q->where('medical_exams.patient_id', $this->patientId)
            )
            ->when(
                filled($this->doctorId),
                fn($q) => $q->where('medical_exams.doctor_id', $this->doctorId)
            )
            ->when(
                filled($this->patientCode),
                fn($q) => $q->where('patients.code', 'like', "%{$this->patientCode}%")
            )
            ->when(
                filled($this->patient),
                function ($q) use ($lang) {
                    $containsArabic = preg_match('/\p{Arabic}/u', $this->patient);

                    if ($containsArabic) {
                        $q->where(function ($query) use ($lang) {
                            $query->where('patients.last_name_ar', 'like', "%{$this->patient}%")
                                ->orWhere('patients.first_name_ar', 'like', "%{$this->patient}%");
                        });
                    } else {
                        $q->where(function ($query) use ($lang) {
                            $query->where("patients.last_name_{$lang}", 'like', "%{$this->patient}%")
                                ->orWhere("patients.first_name_{$lang}", 'like', "%{$this->patient}%");
                        });
                    }
                }
            )
            ->select([
                'medical_exams.id',
                'medical_exams.created_at',
                'patients.id AS patient_id',
                'patients.code AS patient_code',
                'patients.tel AS patient_tel',
                'patients.birth_date AS patient_birth_date',
                "field_specialties.designation_{$this->locale} as specialty",
                DB::raw("CONCAT(patients.last_name_{$lang}, ' ', patients.first_name_{$lang}) AS patient_name"),
                DB::raw("CONCAT(users.last_name, ' ', users.first_name) AS doctor_name"),


            ])
            ->orderBy($this->sortBy, $this->sortDirection);
    }




        #[Computed]
    public function specialties()
    {
        return FieldSpecialty::query()
            ->whereHas('field', fn($q) => $q->where('acronym', 'F_MED'))
            ->get(['id', 'designation_' . $this->locale]);
    }



#[Computed]
public function getDoctors()
{
    return User::query()
        ->where('establishment_id', Auth::user()->establishment_id)

        // only doctors
        ->whereHas('roles', function ($q) {
            $q->where('slug', 'doctor');
        })

        // alphabetical order
        ->orderBy('last_name')
        ->orderBy('first_name')

        ->get(['id', 'first_name', 'last_name'])

        ->map(fn ($user) => [
            'id' => $user->id,
            'full_name' => trim(
                ($user->last_name ?? '') . ' ' . ($user->first_name ?? '')
            ) ?: 'Unknown Doctor',
        ]);
}
    /* -------------------------------------------------------------------------- */
    /*                                   Actions                                  */
    /* -------------------------------------------------------------------------- */

    public function resetFilters(): void
    {
        $this->reset([
            'doctorId',
            'patient',
            'patientCode',
        ]);

        $this->resetPage();
    }

    public function openDeleteDialog(MedicalExam $exam): void
    {
        $createdAt = Carbon::parse($exam->created_at)->format('Y-m-d');

        $this->dispatch('open-dialog', [
            'question' => 'delete.medical_exam',
            'details' => [
                'delete.medical_exam',
                "{$exam->patient_name} - {$createdAt}",
            ],
            'actionEvent' => [
                'event' => 'delete-exam',
                'parameters' => $exam->id,
            ],
        ]);
    }

    /* -------------------------------------------------------------------------- */
    /*                               CRUD Listeners                               */
    /* -------------------------------------------------------------------------- */

    #[On('delete-exam')]
    public function deleteVisit(MedicalExam $exam): void
    {
        try {
            // Delete associated images
            $images = Image::where([
                ['imageable_id', $exam->id],
                ['imageable_type', MedicalExam::class],
            ])->get();

            if ($images->isNotEmpty()) {
                $this->deleteImages($images);
            }

            // Delete associated files
            $files = File::where([
                ['fileable_id', $exam->id],
                ['fileable_type', MedicalExam::class],
            ])->get();

            if ($files->isNotEmpty()) {
                $this->deleteFiles($files);
            }

            $exam->delete();

            $this->dispatch('update-patient-medical-exams-table');

            $this->dispatch(
                'open-toast',
                __('messages.medical_exam.deleted')
            );

        } catch (\Throwable $e) {
            Log::error('Error deleting exam', [
                'visit_id' => $exam->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch(
                'open-errors',
                __('forms.common.errors.default')
            );
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                                   Hooks                                    */
    /* -------------------------------------------------------------------------- */

    public function updated(string $property): void
    {
        if (
            in_array($property, $this->filterable, true)
            || $property === 'perPage'
        ) {
            $this->resetPage();
        }

        if (array_key_exists($property, $this->rules)) {
            try {
                $this->validateOnly($property, $this->rules);
            } catch (ValidationException $e) {
                $this->dispatch(
                    'open-errors',
                    $e->validator->errors()->all()
                );
            }
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                                   Render                                   */
    /* -------------------------------------------------------------------------- */

    public function render()
    {
        return view('livewire.app.doctor.medical-exams-table');
    }
}
