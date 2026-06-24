<?php

use App\Enum\Core\Web\RoutesNames;
use App\Http\Controllers\Web\Core\SuperAdminController;
use Illuminate\Support\Facades\Route;

// ==================================================================
// ⚙️ Unprotected Site Parameter Route (should likely be protected?)
// ==================================================================
Route::get('/siteParameters', [SuperAdminController::class, 'showSiteParametersPage'])
    ->name(RoutesNames::SITE_PARAMETERS->value);

// ===========================================================================================
// 🛡️ Super Admin Routes (Accessible only to authenticated super-admin users)
// Middleware:
//   - auth                  → user must be authenticated
//   - maintenance           → disabled if app is in maintenance mode
//   - can:super-admin-access → user must have 'super-admin-access' permission
// ===========================================================================================
Route::group(['middleware' => ['auth', 'maintenance', 'web.account.active', 'can:super-admin-access']], function () {





    // ✉️ Message Center
    Route::get('/messages', [SuperAdminController::class, 'showMessagesPage'])
        ->name(RoutesNames::MESSAGES->value);

    // 📋 General Infos Page
    Route::get('/generalInfos', [SuperAdminController::class, 'showGeneralInfosPage'])
        ->name(RoutesNames::GENERAL_INFOS->value);



    // 🎨 Landing Page Scene Routes (Grouped under a prefix)
    Route::prefix('landing-page-scenes')->group(function () {

        // Hero Section
        Route::get('/hero', [SuperAdminController::class, 'showManageHeroScene'])
            ->name(RoutesNames::MANAGE_HERO->value);


        // About Us Section
        Route::get('/about-us', [SuperAdminController::class, 'showManageAboutUsScene'])
            ->name(RoutesNames::MANAGE_ABOUT_US->value);
    });
});
