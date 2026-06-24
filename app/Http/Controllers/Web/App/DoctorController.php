<?php

namespace App\Http\Controllers\Web\App;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function showDoctorAppointmentsPage()
    {
        $serviceId = session('service_id');

        abort_if(
            !$serviceId,
            404,
            __('pages.common.errors.missing_parameters')
        );

        $service = Service::findOrFail($serviceId);

        $name = $service->localized_name;

        $title = __('pages.appointments.name', ['name' => $name]);

        $breadcrumbLinks = [
            ['route' => 'dashboard', 'label' => __('pages.dashboard.name')],
            ['route' => 'doctor_appointments_route', 'label' => __('pages.doctor_appointments.name', ['name' => $name])],
        ];

  $isForServicePersonnel = true;

        return view(
            'pages.app.doctor.appointments',
            compact(
                'isForServicePersonnel',
                'name',
                'title',
                'breadcrumbLinks',
                'serviceId'
            )
        );
    }


public function showMedicalExamsPage(Request $request)
{
    $patientId = $request->query('id');
    $serviceId = session('service_id');
    $appointmentId = $request->query('appointmentId');
    $fromAppointments = $request->boolean('isComingFromAppointmentTable');

    abort_if(
        ! $patientId || ! $serviceId,
        404,
        __('errors.patient.missing_parameters')
    );

    $patient = Patient::findOrFail($patientId);
    $service = Service::findOrFail($serviceId);

    $modalTitleOptions = [
        'name' => $patient->localized_full_name,
        'code' => $patient->code,
    ];

    $name = __('pages.medical_exams.name', $modalTitleOptions);

    $breadcrumbLinks = array_merge(
        [
            [
                'route' => 'dashboard',
                'label' => __('pages.dashboard.name'),
            ],
            [
                'route' => $fromAppointments
                    ? 'doctor_appointments_route'
                    : 'service_patients_route',
                'label' => $fromAppointments
                    ? __('pages.doctor_appointments.titles.main', [
                        'name' => $service->localized_name,
                    ])
                    : __('pages.service_patients.titles.main', [
                        'name' => $service->localized_name,
                    ]),
            ],
        ],
        [
            [
                'route' => 'medical_exams_route',
                'label' => $name,
            ],
        ]
    );

    $modalContent = [
        'name' => 'app.doctor.medical-exam-modal',
        'parameters' => [
            'patientId' => $patient->id,
            'specialtyId' => $service->specialty_id,
            'appointmentId' => $appointmentId,
        ],
    ];

    return view('pages.app.doctor.medical-exams', [
        'name' => $name,
        'title' => $name,
        'patientId' => $patient->id,
        'modalTitleOptions' => $modalTitleOptions, // ✅ kept
        'modalTitle' => __('modals.medical_exam.actions.add.detailed'),
        'modalContent' => $modalContent,
        'breadcrumbLinks' => $breadcrumbLinks,
        'containsTinyMce' => true,
        'specialtyId' => $service->specialty_id,
    ]);
}

public function showServicePatientsPage(Request $request)
{
    abort_unless(
        $request->user()?->canAny([
            'doctor-access',
            'coordinator-access',
            'medical-secretary-access',
        ]),
        403
    );

    $serviceId = session('service_id');

    abort_if(
        !$serviceId,
        404,
        __('pages.common.errors.missing_parameters')
    );

    $service = Service::findOrFail($serviceId);

    $name = $service->localized_name;

    $title = __('pages.service_patients.name', ['name' => $name]);

    $breadcrumbLinks = [
        ['route' => 'dashboard', 'label' => __('pages.dashboard.name')],
        ['route' => 'service_patients_route', 'label' => __('pages.service_patients.name', ['name' => $name])],
    ];

    $isForServicePersonnel = true;

    return view(
        'pages.app.doctor.patients',
        compact(
            'isForServicePersonnel',
            'serviceId',
            'name',
            'title',
            'breadcrumbLinks'
        )
    );
}
}
