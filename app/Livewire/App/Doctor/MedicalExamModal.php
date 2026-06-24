<?php

namespace App\Livewire\App\Doctor;

use App\Livewire\Forms\App\MedicalExam\AddForm;
use App\Livewire\Forms\App\MedicalExam\UpdateForm;
use App\Models\MedicalExam;
use App\Models\Service;
use App\Traits\Core\Common\DateAndTimeTrait;
use App\Traits\Core\Common\GeneralTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class MedicalExamModal extends Component
{
    use WithFileUploads, GeneralTrait, DateAndTimeTrait;

    /* --------------------------------
     | Forms
     -------------------------------- */
    public AddForm $addForm;
    public UpdateForm $updateForm;

    /* --------------------------------
     | Models
     -------------------------------- */
    public ?MedicalExam $medicalExam = null;


    /* --------------------------------
     | Identifiers
     -------------------------------- */
    public ?int $id = null;
    public ?int $patientId = null;
    public ?int $doctorId = null;
    public ?int $specialtyId = null;
    public ?int $appointmentId=null;

    /* --------------------------------
     | UI State
     -------------------------------- */
    public string $form = 'addForm';
    public string $local = 'fr';

    /* --------------------------------
     | Report Fields
     -------------------------------- */
    public string $reportFr = '';
    public string $reportAr = '';
    public string $reportEn = '';

    /* --------------------------------
     | Computed
     -------------------------------- */
    #[Computed]
    public function formEntity()
    {
        return $this->id ? $this->updateForm : $this->addForm;
    }

    /* --------------------------------
     | Load Data
     -------------------------------- */
    protected function loadMedicalExamData(): void
    {
        $this->medicalExam = MedicalExam::findOrFail($this->id);
        $this->fillUpdateForm();
    }

    protected function fillUpdateForm(): void
    {
        $this->reportFr = $this->medicalExam->report_fr??'';
        $this->reportAr = $this->medicalExam->report_ar??'';
        $this->reportEn = $this->medicalExam->report_en??'';

        $this->updateForm->fill([
            'id' => $this->id,
            'patient_id' => $this->medicalExam->patient_id,
            'doctor_id' => $this->medicalExam->doctor_id,
            'report_fr' => $this->medicalExam->report_fr,
            'report_ar' => $this->medicalExam->report_ar,
            'report_en' => $this->medicalExam->report_en,
        ]);
    }

    /* --------------------------------
     | Editor Events
     -------------------------------- */
    #[On('set-report-fr')]
    public function setReportFr($content)
    {
        $this->formEntity->fill(['report_fr' => $content]);
    }

    #[On('set-report-en')]
    public function setReportEn($content)
    {
        $this->formEntity->fill(['report_en' => $content]);
    }

    #[On('set-report-ar')]
    public function setReportAr($content)
    {
        $this->formEntity->fill(['report_ar' => $content]);
    }

    /* --------------------------------
     | Submit
     -------------------------------- */
    public function handleSubmit(): void
    {
        $response = $this->id
            ? $this->updateForm->save($this->medicalExam)
            : $this->addForm->save($this->appointmentId);

        if ($response['status']) {
            $this->dispatch('update-medical-exams-table');
            $this->dispatch('open-toast', $response['message']);

            if (!$this->id) {
                $this->addForm->reset();
            }

            return;
        }

        $this->dispatch('open-errors', $response['errors']);
    }

    /* --------------------------------
     | Lifecycle
     -------------------------------- */
    public function mount(): void
    {
        $this->local = app()->getLocale();



        $this->dispatch('initialize-tiny-mce');

        if ($this->id) {
            $this->form = 'updateForm';

            try {
                $this->loadMedicalExamData();
            } catch (ModelNotFoundException $e) {
                Log::error('MedicalExamModal mount error', [
                    'message' => $e->getMessage(),
                    'medical_exam_id' => $this->id,
                ]);

                $this->dispatch('open-errors', __('forms.common.errors.default'));
            }

            return;
        }

        $this->addForm->fill([
            'patient_id' => $this->patientId,
            'doctor_id' => auth()->id(),
            'specialty_id' => $this->specialtyId,
        ]);
    }

    /* --------------------------------
     | Render
     -------------------------------- */
    public function render()
    {
        return view('livewire.app.doctor.medical-exam-modal');
    }
}
