<?php

namespace App\Http\Controllers\Web\App;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MedicalSecretaryController extends Controller
{
    public function manageSchedulesPage(): View
    {
        $serviceId = session('service_id');

        abort_if(
            ! $serviceId,
            404,
            __('pages.common.errors.missing_parameters')
        );

        $service = Service::findOrFail($serviceId);



        $user = Auth::user();

        $title = __('pages.manage_schedules.name');

        $breadcrumbLinks = [
            ['route' => 'dashboard', 'label' => __('pages.dashboard.name')],
            ['route' => 'manage_schedules_route', 'label' => __('pages.manage_schedules.name')],
        ];

        /* =========================================================
         * DOCTORS MODAL
         * ========================================================= */
        $modalTitleOptions = ['name' => $service->localized_name];
        $modalTitle = __('modals.doctors.actions.manage');

        $modalContent = [
            'name' => 'app.medical-secretary.schedule-modal',
            'parameters' => [
                'establishmentId' => $service->establishment_id,
                'serviceId' => $serviceId,
            ],
        ];



        return view('pages.app.medical-secretary.schedules', compact(
            'service',
            'serviceId',
            'title',
            'modalTitle',
            'modalTitleOptions',
            'modalContent',
            'breadcrumbLinks',
            'user'
        ));
    }
    public function manageSchedulePage(Request $request): View
    {


        $scheduleId = $request->integer('id');

        abort_unless(
            $scheduleId,
            404,
            __('pages.common.errors.missing_parameters')
        );

        $schedule = Schedule::with('service')->findOrFail($scheduleId);

        $title = __('pages.manage_schedule.name', ['name' =>  $schedule->localized_name]);

        $breadcrumbLinks = [
            [
                'route' => 'dashboard',
                'label' => __('pages.dashboard.name'),
            ],
            [
                'route' => 'manage_schedules_route',
                'label' => __('pages.manage_schedules.name'),
            ],
            [
                'route' => 'manage_schedule_route',
                'label' => __('pages.manage_schedule.name', [
                    'name'    => $schedule->localized_name,
                ]),
            ],
        ];

        $user = Auth::user();

        return view(
            'pages.app.medical-secretary.schedule',
            compact(
                'schedule',
                'scheduleId',
                'title',
                'breadcrumbLinks',
                'user'
            )
        );
    }
}
