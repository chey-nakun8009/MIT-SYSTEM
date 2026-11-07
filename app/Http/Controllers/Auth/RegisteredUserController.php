<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterRequest;
use Spatie\Permission\Models\Role;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $roleName = ($validated['email'] === 'chey.nakun8009@gmail.com') ? 'admin' : 'customer';
        $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        $hasCampuses = Campus::exists();
        $user = User::create([
            // 'campus_id'     => $hasCampuses ? Campus::first()?->id : null, បើចង់ឲ្យUser ដែលRegister account ខ្លួនឯងAuto​ចូលក្នុងសាលាដំបូងគេ ្just uncomment 
            'campus_id'     => null,
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

        if (!$hasCampuses) {
            return redirect()->route('auth.campus.create')->with('status', 'សូមស្វាគមន៍ អ្នកជាអ្នកប្រើប្រើដំបូងគេ សូមបង្កើតសាខាសាលាដែលអ្នកគ្រប់គ្រង.');
        }
        $redirectTo = route('dashboard', absolute: false);
        return redirect()->intended($redirectTo)->with('status', 'សូមស្វាគមន៍ គណនីរបស់លោកអ្នកបង្កើតបានជោគជ័យ');
    }
}
