<?php

namespace App\Http\Controllers\Web\App;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class UserController extends Controller
{



    public function showManagePatientPage(Request $request)
    {
        $patientId      = $request->query('id');

        $isForAppointmentsLocationAgent = $request->query('isForAppointmentsLocationAgent') ?? false;

        abort_if(! $patientId, 404, __('errors.patient.missing_parameters'));

        $patient = Patient::findOrFail($patientId);


        $name = $patient->localized_full_name;
        $modalTitleOptions = ['name' => $name];

        $title  = __('pages.patient.name', $modalTitleOptions);


        // Breadcrumbs
        $breadcrumbLinks =  [
            ['route' => 'dashboard',      'label' => __('pages.dashboard.name')],
            [
                'route' => 'patient_route',
                'label' => __('pages.patient.name', $modalTitleOptions),
            ],
        ];

        // Article modal
        $modalTitle = __('modals.appointment.actions.book');
        $modalContent = [
            'name'       => 'app.book-slot-modal',
            'parameters' => [
                'patientId' => $patient->id,
            ],
        ];




        return view(
            'pages.app.user.patient',
            compact(
                'isForAppointmentsLocationAgent',
                'name',
                'patient',
                'patientId',
                'title',
                'modalTitle',
                'modalContent',
                'modalTitleOptions',
                'breadcrumbLinks'
            )
        );
    }
}
