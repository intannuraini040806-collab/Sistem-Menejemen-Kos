<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!in_array($user->role, $roles, true)) {
            $dashboard = match ($user->role) {
                'admin' => 'admin.dashboard',
                'petugas' => 'petugas.dashboard',
                'penghuni' => 'penghuni.dashboard',
                default => 'home',
            };

            return redirect()
                ->route($dashboard)
                ->with('error', 'Kamu tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }
}
