<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('guard_name', 'web')
            ->withCount('permissions')
            ->oldest()
            ->paginate(10);

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'name' => strtolower(trim($request->input('name', ''))),
        ]);
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-Z0-9_-]+$/',
                Rule::unique('roles', 'name')->where('guard_name', 'web'),
            ],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);
            $defaultPermissions = Permission::where('guard_name', 'web')
                ->where(function ($query) {
                    $query->where('name', 'like', '%.index')->orWhere('name', 'like', '%.show');
                })->get();
            if ($defaultPermissions->isNotEmpty()) {
                $role->givePermissionTo($defaultPermissions);
            }
            app(PermissionRegistrar::class)->forgetCachedPermissions();
            return redirect()->route('roles.index')->with('success', 'Role created successfully with default view permissions!');
        } catch (\Exception $e) {
            Log::error('Error creating role: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', "Couldn't create this role right now!");
        }
    }

    public function edit(Role $role)
    {
        abort_unless($role->guard_name === 'web', 404);

        $permissionGroups = config('permissions', []);

        foreach ($permissionGroups as $module => $actions) {
            foreach ($actions as $action => $label) {
                Permission::firstOrCreate([
                    'name' => $module . '.' . $action,
                    'guard_name' => 'web',
                ]);
            }
        }

        $assignedPermissions = $role->permissions()
            ->pluck('name')
            ->toArray();

        return view('admin.roles.edit', compact(
            'role',
            'permissionGroups',
            'assignedPermissions'
        ));
    }

    public function update(Request $request, Role $role)
    {
        abort_unless($role->guard_name === 'web', 404);

        $permissionGroups = config('permissions', []);

        foreach ($permissionGroups as $module => $actions) {
            foreach ($actions as $action => $label) {
                Permission::firstOrCreate([
                    'name' => $module . '.' . $action,
                    'guard_name' => 'web',
                ]);
            }
        }

        $validator = Validator::make($request->all(), [
            'permissions' => ['nullable', 'array'],
            'permissions.*' => [
                'required',
                'string',
                'distinct',
                Rule::exists('permissions', 'name')
                    ->where('guard_name', 'web'),
            ],
        ], [
            'permissions.*.exists' => 'The selected permission ":input" is invalid.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $role->syncPermissions($request->input('permissions', []));

            app(PermissionRegistrar::class)->forgetCachedPermissions();

            return redirect()
                ->route('roles.index')
                ->with('success', 'Role permissions updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating role permissions: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', "Couldn't update role permissions right now!");
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::where('guard_name', 'web')->findOrFail($id);
            if ($role->name === 'admin') {
                $errorMessage = 'អ្នកមិនអាចលុបRole Adminបានទេ!';
                if (request()->wantsJson() || request()->ajax()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $errorMessage,
                    ], 422);
                }
                return redirect()->back()->with('error', $errorMessage);
            }

            $isAssigned = DB::table(config('permission.table_names.model_has_roles'))->where('role_id', $role->id)->exists();
            if ($isAssigned) {
                $errorMessage = 'អ្នកមិនអាចលុបRoleនេះបានទេ ដោយសារមានអ្នកប្រើប្រាស់បានស្ថិតក្នុងRoleនេះ!';
                if (request()->wantsJson() || request()->ajax()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $errorMessage,
                    ], 422);
                }
                return redirect()->back()->with('error', $errorMessage);
            }
            $role->delete();
            app(PermissionRegistrar::class)->forgetCachedPermissions();
            $successMessage = 'Roleត្រូវបានលុបបានជោកជ័យ!';
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => $successMessage,
                    'redirect' => route('admin.roles.index'),
                ], 200);
            }
            return redirect()->route('admin.roles.index')->with('success', $successMessage);
        } catch (\Exception $e) {
            $errorMessage = "Couldn't delete this role right now!";
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $errorMessage,
                ], 500);
            }
            return redirect()->back()->with('error', $errorMessage);
        }
    }
}
