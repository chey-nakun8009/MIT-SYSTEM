<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('campus')->where('campus_id', auth()->user()->campus_id);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$search}%")
                    ->orWhere(DB::raw("CONCAT(last_name, ' ', first_name)"), 'like', "%{$search}%");
            });
        }

        $users = $query->oldest()->paginate(10)->withQueryString();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('admin.user.partials._row', compact('users'))->render(),
                'pagination' => $users->links('vendor.pagination.bootstrap-5')->render(),
            ]);
        }

        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $stores = Campus::all();
        $roles = Role::pluck('name', 'name')
            ->map(fn($name) => ucfirst($name))
            ->toArray();
        $user = new User();
        return view('admin.user.create', compact('stores', 'roles', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'campus_id' => 'nullable|exists:campuses,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:30',
            'role' => 'required|string|exists:roles,name',
            'status' => 'required|string|max:20',
            'preferred_currency' => 'required|string|size:3',
            'bio' => 'nullable|string|max:255',
            'locale' => 'required|string|max:10',
            'language' => 'required|string|max:10',
        ]);

        $image = null;
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $name = $validated['first_name'];
            if (!empty($validated['last_name'])) {
                $name .= '-' . $validated['last_name'];
            }
            $fileName = Str::slug($name) . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/users', $fileName, 'public');
            $image = $fileName;
        }

        $validated['profile'] = $image;
        $validated['password'] = Hash::make($validated['password']);
        $roleName = $validated['role'];
        unset($validated['role']);
        $user = User::create($validated);
        $user->assignRole($roleName);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully!',
            'redirect' => route('users.index'),
        ]);
    }

    public function edit(User $user)
    {
        $stores = Campus::all();
        $roles = Role::pluck('name', 'name')
            ->map(fn($name) => ucfirst($name))
            ->toArray();

        return view('admin.user.edit', compact('user', 'stores', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'campus_id' => 'nullable|exists:campuses,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:30',
            'role' => 'required|string|exists:roles,name',
            'status' => 'required|string|max:20',
            'preferred_currency' => 'required|string|size:3',
            'bio' => 'nullable|string|max:255',
            'locale' => 'required|string|max:10',
            'language' => 'required|string|max:10',
        ]);

        $image = $user->profile;
        if ($request->hasFile('profile')) {
            if ($user->profile) {
                $oldImagePath = 'uploads/users/' . $user->profile;
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }
            $file = $request->file('profile');
            $name = $validated['first_name'];
            if (!empty($validated['last_name'])) {
                $name .= '-' . $validated['last_name'];
            }
            $fileName = Str::slug($name) . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads/users', $fileName, 'public');
            $image = $fileName;
        }

        $validated['profile'] = $image;

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $roleName = $validated['role'];
        unset($validated['role']);

        $user->update($validated);
        $user->syncRoles([$roleName]);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!',
            'redirect' => route('users.index')
        ]);
    }

    public function destroy($id)
    {
        if (auth()->id() == $id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account!',
            ], 403);
        }

        $user = User::findOrFail($id);

        if ($user->profile) {
            $imagePath = 'uploads/users/' . $user->profile;
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully!',
            'redirect' => route('users.index'),
        ]);
    }
}
