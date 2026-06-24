<?php

use App\Enum\Core\Web\RoutesNames;
use App\Http\Controllers\Web\App\UserController;
use Illuminate\Support\Facades\Route;


// 🔐 Routes that require both authentication and maintenance check
Route::middleware(['auth', 'maintenance', 'web.account.active'])->group(function () {


    Route::get('/patient', [UserController::class, 'showManagePatientPage'])
        ->name(RoutesNames::PATIENT_ROUTE);
});
