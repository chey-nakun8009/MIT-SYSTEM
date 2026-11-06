<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (!isset($user->role)) {
            auth()->logout();

            return redirect()->route('login')
                ->with('error', 'Invalid session state. Please try again.');
        }

        $userRole = strtolower(trim($user->role));

        $allowedRoles = array_map(
            fn($role) => strtolower(trim($role)),
            $roles
        );

        if (!in_array($userRole, $allowedRoles, true)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthorized access.',
                ], 403);
            }

            return redirect()
                ->route('dashboard')
                ->with('error', 'អ្នកមិនមានសិទ្ធិចូលប្រើមុខងារនេះទេ!');
        }

        return $next($request);
    }
}
