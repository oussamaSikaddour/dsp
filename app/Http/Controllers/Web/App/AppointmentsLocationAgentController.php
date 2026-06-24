<?php

namespace App\Http\Controllers\Web\App;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use Illuminate\Http\Request;

class AppointmentsLocationAgentController extends Controller
{
    public function showManageAppointmentsPage()
    {
        $appointmentsLocationId = session('establishment_id');

        abort_if(
            !$appointmentsLocationId,
            404,
            __('pages.common.errors.missing_parameters')
        );

        $establishment = Establishment::findOrFail($appointmentsLocationId);

        $name = $establishment->localized_name;

        $title = __('pages.appointments.name', ['name' => $name]);

        $breadcrumbLinks = [
            ['route' => 'dashboard', 'label' => __('pages.dashboard.name')],
            ['route' => 'appointments_route', 'label' => __('pages.appointments.name', ['name' => $name])],
        ];

        $isForServicePersonnel = true;

        return view(
            'pages.app.appointments-location-agent.appointments',
            compact(
                'isForServicePersonnel',
                'name',
                'title',
                'breadcrumbLinks',
                'appointmentsLocationId'
            )
        );
    }

    public function showManagePatientsPage(Request $request)
    {
        $appointmentsLocationId = session('establishment_id');

        abort_if(
            !$appointmentsLocationId,
            404,
            __('pages.common.errors.missing_parameters')
        );

        $user = $request->user();

        abort_if(!$user, 403);

        $title = __('pages.manage_patients.name');

        $breadcrumbLinks = [
            ['route' => 'dashboard', 'label' => __('pages.dashboard.name')],
            ['route' => 'manage_patients_route', 'label' => __('pages.manage_patients.name')],
        ];

        $modalTitle = __('modals.patient.actions.add.patient');

        $modalContent = [
            'name' => 'app.patient-modal',
            'parameters' => [
                'isForServicePersonnel' => true,
            ],
        ];

        $isForServicePersonnel = true;

        return view(
            'pages.app.appointments-location-agent.patients',
            compact(
                'isForServicePersonnel',
                'user',
                'title',
                'breadcrumbLinks',
                'modalTitle',
                'modalContent',
                'appointmentsLocationId'
            )
        );
    }
}
