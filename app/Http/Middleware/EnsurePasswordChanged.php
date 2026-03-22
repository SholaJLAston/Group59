<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordChanged
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || $request->user()->role !== 'admin' || $request->user()->password_changed) {
            return $next($request);
        }

        // Following routes are needed to allow password change
        if (
            $request->routeIs('profile.edit', 'profile.update', 'admin.settings', 'admin.settings.update', 'password.update', 'logout')
            || $request->is('confirm-password')
        ) {
            return $next($request);
        }

        return redirect()
            ->route('admin.settings')
            ->with('error', 'Please change your password before continuing.');
    }
}
