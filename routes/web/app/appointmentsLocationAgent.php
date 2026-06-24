<?php

use App\Enum\Core\Web\RoutesNames;
use App\Http\Controllers\Web\App\AppointmentsLocationAgentController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'auth',
        'maintenance',
        'web.account.active',
        'can:appointments-locations-agent-access'
    ]
], function () {

    Route::get('/Appointments', [AppointmentsLocationAgentController::class, 'showManageAppointmentsPage'])
        ->name(RoutesNames::APPOINTMENTS_ROUTE);
    Route::get('/managePatients', [AppointmentsLocationAgentController::class, 'showManagePatientsPage'])
        ->name(RoutesNames::MANAGE_PATIENTS_ROUTE);

});
