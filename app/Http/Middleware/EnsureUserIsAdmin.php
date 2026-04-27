<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        \Illuminate\Support\Facades\Log::info('Checking admin access', [
            'user' => $request->user()?->email,
            'is_admin' => $request->user()?->isAdmin(),
            'role' => $request->user()?->role,
        ]);

        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
