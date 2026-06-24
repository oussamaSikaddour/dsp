<?php

use App\Enum\Core\Web\RoutesNames;
use App\Http\Controllers\Web\App\ServiceCoordinatorController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'auth',
        'maintenance',
        'web.account.active',
        'can:service-coordinator-access'
    ]
], function () {

    Route::get('/Service', [ServiceCoordinatorController::class, 'manageServicePage'])
        ->name(RoutesNames::MANAGE_SERVICE_ROUTE->value);

});
