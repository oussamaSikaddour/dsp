<?php

use App\Enum\Core\Web\RoutesNames;
use App\Http\Controllers\Web\App\EstablishmentAdminController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'auth',
        'maintenance',
        'web.account.active',
        'can:establishment-admin-access'
    ]
], function () {

    Route::get('/establishmentUsers', [EstablishmentAdminController::class, 'manageEstablishmentUsersPage'])
        ->name(RoutesNames::ESTABLISHMENT_USERS_ROUTE->value);
    Route::get('/establishmentServices', [EstablishmentAdminController::class, 'manageEstablishmentServicesPage'])
        ->name(RoutesNames::ESTABLISHMENT_SERVICES_ROUTE->value);
});
