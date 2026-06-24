<?php

namespace App\Http\Middleware\Web\Core;

use App\Enum\Core\Web\RoutesNames;
use App\Models\GeneralSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        $settings = GeneralSetting::current();

        if ($settings->maintenance) {
            return redirect()->route(
                RoutesNames::IS_ON_MAINTENANCE_MODE->value
            );
        }

        return $next($request);
    }
}
