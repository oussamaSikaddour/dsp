<?php

namespace App\Http\Controllers\Web\Core;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show the user home (dashboard) page.
     *
     * @return View The view for the user home area
     */
public function showDashboard(Request $request)
{
    $user = $request->user();

    if (!$user) {
        abort(403);
    }

    $fullName = $user->full_name ?: $user->name;

    return view('pages.core.user.dashboard', [
        'user' => $user,

        'title' => __('pages.dashboard.name'),

        'modalTitleOptions' => [
            'name' => $fullName,
        ],

        'notASimpleUser' => $user->hasManyRoles ?? false,

        'modalTitle' => __('modals.patient.actions.add.relative'),

        'modalContent' => [
            'name' => 'app.patient-modal',
            'parameters' => [],
        ],
    ]);
}

public function showProfilePage(): View
{
    $user = Auth::user();

    abort_if(! $user, 403, __('errors.auth.unauthorized'));

    $userName = $user->full_name ?? $user->name;

    $title = __('pages.profile.name', [
        'name' => $userName,
    ]);

    $breadcrumbLinks = [
        [
            'route' => 'dashboard',
            'label' => __('pages.dashboard.name'),
        ],
        [
            'route' => 'profile_route',
            'label' => __('pages.profile.name', [
                'name' => $userName,
            ]),
        ],
    ];

    return view('pages.core.user.profile', [
        'userName' => $userName,
        'userId' => $user->id,
        'title' => $title,
        'breadcrumbLinks' => $breadcrumbLinks,
    ]);
}
    /**
     * Show the change password page.
     *
     * @return View The view for changing user password
     */
    public function showChangePasswordPage(): View
    {
        // Localized title for the change password page
        $title = __("pages.change_password.name");

        // Load the change password view
        return view('pages.core.user.change-password', compact('title'));
    }

    /**
     * Show the change email page.
     *
     * @return View The view for changing user email address
     */
    public function showChangeEmailPage(): View
    {
        // Localized title for the change email page
        $title = __("pages.change_email.name");

        // Load the change email view
        return view('pages.core.user.change-email', compact('title'));
    }
}
