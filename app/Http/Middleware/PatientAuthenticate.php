<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class PatientAuthenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (auth()->getDefaultDriver() !== 'patient') {
            auth()->setDefaultDriver('patient');
        }
        $this->authenticate($request, $guards);

        return $next($request);
    }

    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('patient.login');
        }
    }
}
