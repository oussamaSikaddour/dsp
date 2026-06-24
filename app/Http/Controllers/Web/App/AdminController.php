<?php

namespace App\Http\Controllers\Web\App;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{


    public function showManageEstablishmentsPage(): View
    {
        $user = Auth::user(); // Retrieve the authenticated user (not used here)
        $title = __("pages.establishments.name"); // Localized title

        // Modal configuration for adding a menu
        $modalTitle = "modals.establishment.actions.add";
        $modalContent = [
            "name" => 'app.admin.establishment-modal',
            "parameters" => [],
        ];


        $breadcrumbLinks = [

            ['route' => 'dashboard', 'label' => __('pages.dashboard.name')],
            ['route' => 'suppliers_route', 'label' => __('pages.establishments.name')],

        ];
        // Return the services admin view
        return view('pages.app.admin.establishments', compact('title', 'modalTitle', 'modalContent', 'breadcrumbLinks'));
    }

    public function showManageEstablishmentPage(Request $request)
{
    $establishmentId      = $request->query('id');



    abort_if(! $establishmentId, 404, __('errors.service.missing_parameters'));

    $establishment = Establishment::findOrFail($establishmentId);

    // Polymorphic bindings
    $managerableId     = $establishment->id;
    $managerableType =Establishment::class;
    $establishmentName = $establishment->localized_name;


    $title           = __('pages.establishment.name',['name'=>$establishment->acronym]);


    // Breadcrumbs
    $breadcrumbLinks =  [
            ['route' => 'dashboard',      'label' => __('pages.dashboard.name')],
            ['route' => 'establishments_route', 'label' => __('pages.establishments.name')],
            [
                'route' => 'esblishment_route',
                'label' => __('pages.establishment.name', ['name' => $establishmentName]),
            ],
        ];

    // Article modal
    $modalTitle = __('modals.user.actions.add');
    $modalContent = [
        'name'       => 'core.user-modal',
        'parameters' => compact('managerableId', 'managerableType'),
    ];


    $modalTitleOptions = ['name' => $establishmentName];

    return view(
        'pages.app.admin.establishment',
        compact(
            'title',
            'modalTitle',
            'modalContent',
            'modalTitleOptions',
            'managerableId',
            'managerableType',
            'establishmentName',
            'establishmentId',
            'breadcrumbLinks'
        )
    );
}
}
