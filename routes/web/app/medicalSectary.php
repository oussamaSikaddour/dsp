<?php

use App\Enum\Core\Web\RoutesNames;
use App\Http\Controllers\Web\App\MedicalSecretaryController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'auth',
        'maintenance',
        'web.account.active',
        'can:medical-secretary-access'
    ]
], function () {

    Route::get('/Schedules', [MedicalSecretaryController::class, 'manageSchedulesPage'])
        ->name(RoutesNames::MANAGE_SCHEDULES_ROUTE->value);
    Route::get('/Schedule', [MedicalSecretaryController::class, 'manageSchedulePage'])
        ->name(RoutesNames::MANAGE_SCHEDULE_ROUTE->value);

});
