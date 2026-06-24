<?php

namespace App\Http\Controllers\Web\Core;

use App\Http\Controllers\Controller;
use App\Traits\Core\Common\GeneralTrait;
use Illuminate\Contracts\View\View;



class SuperAdminController extends Controller
{
    use GeneralTrait;
    /**
     * Display the Site Parameters Page.
     *
     * @return View
     */
    public function showSiteParametersPage(): View
    {
        $title = __("pages.site_parameters.name"); // Localized title for site parameters
        return view('pages.core.site-parameters', compact('title'));
    }







    /**
     * Show the Messages Page.
     *
     * @return View
     */
    public function showMessagesPage(): View
    {
        $title = __("pages.messages.name"); // Localized messages page title
        return view('pages.core.super-admin.messages', compact('title'));
    }

    /**
     * Show the Landing Scene General Info Page.
     *
     * @return View
     */
    public function showGeneralInfosPage(): View
    {

        $breadcrumbLinks = [

            ['route' => 'dashboard', 'label' => __('pages.dashboard.name')],
            ['route' => 'general_infos', 'label' => __('pages.general_infos.name')],

        ];
        $title = __("pages.general_infos.name"); // Localized general info title
        return view('pages.core.super-admin.general-infos', compact('title', 'breadcrumbLinks'));
    }

    /**
     * Show the Hero Scene Management Page.
     *
     * @return View
     */
    public function showManageHeroScene(): View
    {

        $breadcrumbLinks = [

            ['route' => 'dashboard', 'label' => __('pages.dashboard.name')],
            ['route' => 'manage_hero', 'label' => __('pages.manage_hero.name')],

        ];
        $title = __("pages.manage_hero.name"); // Localized hero section title
        return view('pages.core.super-admin.manage-section-hero', compact('title', 'breadcrumbLinks'));
    }

    /**
     * Show the About Us Scene Management Page.
     *
     * @return View
     */
    public function showManageAboutUsScene(): View
    {

        $breadcrumbLinks = [

            ['route' => 'dashboard', 'label' => __('pages.dashboard.name')],
            ['route' => 'manage_about_us', 'label' => __('pages.manage_about_us.name')],

        ];
        $title = __("pages.manage_about_us.name"); // Localized about-us section title
        return view('pages.core.super-admin.manage-section-about-us', compact('title', 'breadcrumbLinks'));
    }

    /**
     * Show the "Our Qualities" Section Management Page.
     *
     * @return View
     */
    public function showManageMyWorksScene(): View
    {
        $title = __("pages.manage_my_works.name"); // Localized qualities section title

        // Modal configuration for adding a new quality
        $modalTitle = "modals.my_work.actions.add";
        $modalContent = [
            "name" => 'app.super-admin.my-work-modal',
            "parameters" => [],
        ];

        $breadcrumbLinks = [

            ['route' => 'dashboard', 'label' => __('pages.dashboard.name')],
            ['route' => 'manage_my_works', 'label' => __('pages.manage_my_works.name')],

        ];
        return view('pages.core.super-admin.manage-section-my-works', compact('title', 'modalTitle', 'modalContent', 'breadcrumbLinks'));
    }
}
