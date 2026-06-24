<?php

namespace App\Http\Controllers\Web\App;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EstablishmentAdminController extends Controller
{
    public function manageEstablishmentUsersPage(): View
    {
        // 1. Get establishment ID (from query or route)
        $establishmentId = session('establishment_id');


        abort_if(
            ! $establishmentId,
            404,
            __('pages.common.errors.missing_parameters')
        );

        // 2. Load model
        $establishment = Establishment::findOrFail($establishmentId);



        $user = Auth::user();

        $title = __('pages.manage_establishment_users.name');

        $breadcrumbLinks = [
            ['route' => 'dashboard', 'label' => __('pages.dashboard.name')],
            ['route' => 'establishment_users_route', 'label' => __('pages.manage_establishment_users.name')],
        ];


        $modalTitleOptions = ['name' => $establishment->name];
        $modalTitle = __('modals.user.actions.add');
        $modalContent = [
            'name'       => 'core.user-modal',
            'parameters' =>
            ['establishmentId' => $establishment->id,],
        ];



        return view('pages.app.establishment-admin.users', compact(
            'establishment',
            'establishmentId',
            'title',
            'modalTitle',
            'modalTitleOptions',
            'modalContent',
            'breadcrumbLinks',
            'user'
        ));
    }
    public function manageEstablishmentServicesPage(): View
    {
        // 1. Get establishment ID (from query or route)
        $establishmentId = session('establishment_id');


        abort_if(
            ! $establishmentId,
            404,
            __('pages.common.errors.missing_parameters')
        );

        // 2. Load model
        $establishment = Establishment::findOrFail($establishmentId);




        $user = Auth::user();

        $title = __('pages.manage_establishment_services.name');

        $breadcrumbLinks = [
            ['route' => 'dashboard', 'label' => __('pages.dashboard.name')],
            ['route' => 'establishment_services_route', 'label' => __('pages.manage_establishment_services.name',['name'=>$establishment->localized_name])],
        ];


        $modalTitleOptions = ['name' => $establishment->localized_name];
        $modalTitle = __('modals.service.actions.add');
        $modalContent = [
            'name'       => 'app.establishment-admin.service-modal',
            'parameters' =>
            ['establishmentId' => $establishment->id]
        ];



        return view('pages.app.establishment-admin.services', compact(
            'establishment',
            'establishmentId',
            'title',
            'modalTitle',
            'modalTitleOptions',
            'modalContent',
            'breadcrumbLinks',
            'user'
        ));
    }
}
