<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Role;

class CheckRoutePermission
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $userRole = strtolower(trim($user->role ?? ''));
        if ($userRole === 'admin') {
            return $next($request);
        }

        $routeName = $request->route()?->getName();

        if (!$routeName) {
            return $this->deny($request);
        }
        if ($routeName === 'dashboard') {
            return $next($request);
        }

        $parts = explode('.', $routeName);
        $action = end($parts);
        if ($action === 'index') {
            return $next($request);
        }
        $actionMap = [
            'show'    => 'show',
            'create'  => 'create',
            'store'   => 'create',
            'edit'    => 'edit',
            'update'  => 'edit',
            'destroy' => 'destroy',
        ];
        if (!isset($actionMap[$action]) || count($parts) < 2) {
            return $this->deny($request);
        }

        $module = $parts[count($parts) - 2];

        $permissionName = $module . '.' . $actionMap[$action];
        $role = Role::findByName($userRole, 'web');
        if (!$role->hasPermissionTo($permissionName, 'web')) {
            return $this->deny($request);
        }

        return $next($request);
    }

    private function deny(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'You do not have permission to perform this action.',
            ], 403);
        }

        return redirect()->route('dashboard')->with('error', 'អ្នកមិនមានសិទ្ធិចូលប្រើមុខងារនេះទេ!');
    }
}
