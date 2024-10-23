<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            \Log::info('Redirecting user based on authentication state.');

            if (Auth::guard('web')->check()) {
                \Log::info('User is authenticated with web guard.');
                return route('dashboard.index'); 
            }

            if (Auth::guard('user-technical')->check()) {
                \Log::info('User is authenticated with user-technical guard.');
                return route('user-technical.dashboard'); 
            }

            \Log::info('User is not authenticated, redirecting to login.');
            return route('user.login');
        }
    }
}
