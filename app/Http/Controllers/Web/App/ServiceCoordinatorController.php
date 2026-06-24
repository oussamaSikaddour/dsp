<?php

namespace App\Http\Controllers\Web\App;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ServiceCoordinatorController extends Controller
{
public function manageServicePage(): View
{
    $serviceId = session('service_id');

    abort_if(
        ! $serviceId,
        404,
        __('pages.common.errors.missing_parameters')
    );

    $service = Service::findOrFail($serviceId);

    $user = Auth::user();

    $title = __('pages.manage_service.name');

    $breadcrumbLinks = [
        ['route' => 'dashboard', 'label' => __('pages.dashboard.name')],
        ['route' => 'manage_service_route', 'label' => __('pages.manage_service.name')],
    ];

    /* =========================================================
     * DOCTORS MODAL
     * ========================================================= */
    $doctorsModalTitleOptions = ['name' => $service->localized_name];
    $doctorsModalTitle = __('modals.doctors.actions.manage');

    $doctorsModalContent = [
        'name' => 'app.service-coordinator.doctors-modal',
        'parameters' => [
            'establishmentId' => $service->establishment_id,
            'serviceId' => $serviceId,
        ],
    ];

    /* =========================================================
     * MEDICAL SECRETARIES MODAL
     * ========================================================= */
    $medicalSecretariesModalTitleOptions = ['name' => $service->localized_name];
    $medicalSecretariesModalTitle = __('modals.medical_secretaries.actions.manage');

    $medicalSecretariesModalContent = [
        'name' => 'app.service-coordinator.medical-secretaries-modal',
        'parameters' => [
            'establishmentId' => $service->establishment_id,
            'serviceId' => $serviceId,
        ],
    ];

    /* =========================================================
     * APPOINTMENTS LOCATION AGENTS MODAL (NEW)
     * ========================================================= */
    $appointmentsLocationAgentsModalTitleOptions = ['name' => $service->localized_name];
    $appointmentsLocationAgentsModalTitle = __('modals.appointments_locations_agents.actions.manage');

    $appointmentsLocationAgentsModalContent = [
        'name' => 'app.service-coordinator.appointments-locations-agents-modal',
        'parameters' => [
            'establishmentId' => $service->establishment_id,
        ],
    ];

    return view('pages.app.service-coordinator.service', compact(
        'service',
        'serviceId',
        'title',

        // doctors
        'doctorsModalTitle',
        'doctorsModalTitleOptions',
        'doctorsModalContent',

        // medical secretaries
        'medicalSecretariesModalTitle',
        'medicalSecretariesModalTitleOptions',
        'medicalSecretariesModalContent',

        // appointments location agents
        'appointmentsLocationAgentsModalTitle',
        'appointmentsLocationAgentsModalTitleOptions',
        'appointmentsLocationAgentsModalContent',

        'breadcrumbLinks',
        'user'
    ));
}
}
