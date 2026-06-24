<?php

namespace App\Http\Controllers\Web\App;

use App\Http\Controllers\Controller;
use App\Traits\Core\Common\GeneralTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


class SuperAdminController extends Controller
{
    use GeneralTrait;

    /**
     * Show the Super Admin Dashboard.
     *
     * @return View
     */
    public function showOccupationsFieldsPage(): View
    {
        $title = __("pages.occupation_fields.name"); // Localized dashboard title

        // Modal configuration to add a user
        $modalTitle = "modals.field.actions.new";
        $modalContent = [
            "name" => 'core.super-admin.field-modal',
            "parameters" => [],
        ];

        return view('pages.app.super-admin.occupations-fields', compact('title', 'modalTitle', 'modalContent'));
    }





        /**
     * Show the Super Admin Dashboard.
     *
     * @return View
     */
    public function showWilayatesPage(): View
    {
        $title = __("pages.wilayates.name"); // Localized dashboard title

        // Modal configuration to add a user
        $modalTitle = "modals.wilaya.actions.new";
        $modalContent = [
            "name" => 'core.super-admin.wilaya-modal',
            "parameters" => [],
        ];

        return view('pages.app.super-admin.wilayates', compact('title', 'modalTitle', 'modalContent'));
    }
    /**
     * Show the Super Admin Dashboard.
     *
     * @return View
     */
    public function showWilayaPage(Request $request)
    {
        $parameters = $request->query(); // Get all query parameters

        // Check for required slider parameters
        if (array_key_exists('id', $parameters) && array_key_exists('name', $parameters)) {
            // Generate localized title using slider name
            $title = __("pages.wilaya.name", [
                "name" => $parameters['name'],
            ]);


            $breadcrumbLinks = [

                ['route' => 'wilayates', 'label' => __('pages.wilayates.name')],
                ['route' => 'wilaya', 'label' => __('pages.wilaya.name',['name'=>$parameters['name']])],

            ];
            // Modal configuration for adding a slide to the slider
            $modalTitle = "modals.daira.actions.add";
            $modalContent = [
                "name" => 'core.super-admin.daira-modal',
                "parameters" => [
                    'wilayaId' => $parameters['id']
                ],
            ];

            // Return the slides view with editor and modal config
            return view('pages.app.super-admin.wilaya', compact('title', 'modalTitle', 'modalContent', 'parameters','breadcrumbLinks'));
        }
    }




}
