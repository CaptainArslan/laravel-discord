<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class LogUnauthorizedAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check() || !Auth::user()->hasRole($role)) {
            // Log the unauthorized access attempt
            activity()
                ->causedBy(Auth::user())
                ->withProperties([
                    'page' => $request->path(),
                    'action' => 'Access Denied',
                    'ip' => $request->ip(),
                    'url' => $request->fullUrl(),
                    'message' => 'User tried to access admin page without permission'
                ])
                ->log('Unauthorized access attempt');

            // Optionally, flash an error message
            return abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
