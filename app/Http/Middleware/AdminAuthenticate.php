<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;


class AdminAuthenticate extends Middleware
{
    /**
     * Handle an incoming request.
     */
    protected function redirectTo($request): ?string
    {
        return $request->expectsJson() ? null : route('admin_login');
    }

    protected function authenticate($request, array $guards)
    {
        if ($this->auth->guard('admin')->check()) {
            return $this->auth->shouldUse('admin');
        }

        $this->unauthenticated($request, ['admin']);
    }
}
