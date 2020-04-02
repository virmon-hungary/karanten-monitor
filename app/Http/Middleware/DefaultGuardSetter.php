<?php

namespace App\Http\Middleware;

use Closure;

class DefaultGuardSetter
{
    public function handle($request, Closure $next, $group = null)
    {
        if ($group === 'patient') {
            auth()->setDefaultDriver('patient');
            config()->set('session.cookie', 'virmon_patient_session');
        }
        else {
            auth()->setDefaultDriver('web');
        }

        return $next($request);
    }
}
