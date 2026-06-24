<?php

use App\Enum\Core\Web\RoutesNames;
use App\Http\Controllers\Web\App\SuperAdminController;
use Illuminate\Support\Facades\Route;



// ===========================================================================================
Route::group(['middleware' => ['auth', 'maintenance', 'web.account.active', 'can:super-admin-access']], function () {


    Route::get('/wilayates', [SuperAdminController::class, 'showWilayatesPage'])
        ->name(RoutesNames::WILAYATES->value);
    Route::get('/dairates', [SuperAdminController::class, 'showWilayaPage'])
        ->name(RoutesNames::WILAYA->value);
    Route::get('/fields', [SuperAdminController::class, 'showOccupationsFieldsPage'])
        ->name(RoutesNames::OCCUPATION_FIELDS->value);

});
