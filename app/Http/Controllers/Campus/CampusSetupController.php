<?php

namespace App\Http\Controllers\Campus;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CampusSetupController extends Controller
{
    public function create()
    {
        if (auth()->check() && auth()->user()->campus_id) {
            return redirect()->route('dashboard');
        }

        return view('auth.campus-setup');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:campuses,name',
            'slug' => 'nullable|string|max:255|unique:campuses,slug',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        $user = auth()->user();
        try {
            DB::transaction(function () use ($request, $validated, $user, &$campus) {
                if ($request->hasFile('logo')) {
                    $file = $request->file('logo');
                    $filename = $validated['slug'] . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $validated['logo_path'] = $file->storeAs('uploads/campuses', $filename, 'public');
                }
                $campus = Campus::create($validated);
                $user->update([
                    'campus_id' => $campus->id
                ]);
            });

            return redirect()->route('dashboard')->with('success', 'សាលាបង្កើតបានជោគជ័យ អ្នតមានសិទ្ធគ្រប់គ្រង់សាខានេះ!');
        } catch (\Exception $e) {
            if ($user) {
                if (isset($validated['logo_path']) && Storage::disk('public')->exists($validated['logo_path'])) {
                    Storage::disk('public')->delete($validated['logo_path']);
                }
                $user->delete();
                auth()->logout();
            }
            return redirect()->route('register')->withErrors([
                'name' => 'Campus creation failed: ' . $e->getMessage() . 'សូមព្យាយាមម្ដងទៀត.'
            ]);
        }
    }
}
