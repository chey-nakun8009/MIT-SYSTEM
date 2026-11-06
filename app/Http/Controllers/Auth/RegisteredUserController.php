<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Http\Requests\Auth\RegisterRequest;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $roleName = ($validated['email'] === 'chey.nakun8009@gmail.com') ? 'admin' : 'customer';
        $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        $user = User::create([
            'campus_id'     => $validated['campus_id'] ?? 1,
            'first_name'    => $validated['first_name'],
            'last_name'     => $validated['last_name'] ?? null,
            'email'         => $validated['email'],
            'phone'         => $validated['phone'] ?? "+855",
            'password'      => Hash::make($validated['password']),
            'status'        => 'active',
            'last_login_at' => now(),
        ]);
        $user->assignRole($role);
        event(new Registered($user));
        Auth::login($user);
        $redirectTo = route('dashboard', absolute: false);
        return redirect()->intended($redirectTo)->with('status', 'Welcome! Your account has been created successfully.');
    }
}
