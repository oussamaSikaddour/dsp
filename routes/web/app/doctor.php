<?php

use App\Enum\Core\Web\RoutesNames;
use App\Http\Controllers\Web\App\DoctorController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth',
    'maintenance',
    'web.account.active',
])->group(function () {

    Route::get('/servicePatients', [DoctorController::class, 'showServicePatientsPage'])
        ->name(RoutesNames::SERVICE_PATIENTS_ROUTE);

    Route::middleware('can:doctor-access')->group(function () {

        Route::get('/doctorAppointments', [DoctorController::class, 'showDoctorAppointmentsPage'])
            ->name(RoutesNames::DOCTOR_APPOINTMENTS_ROUTE);

        Route::get('/MedicalExams', [DoctorController::class, 'showMedicalExamsPage'])
            ->name(RoutesNames::MEDICAL_EXAMS_ROUTE);
    });
});
