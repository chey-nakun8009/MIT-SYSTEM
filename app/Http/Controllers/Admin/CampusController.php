<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Http\Requests\StoreCampusRequest;
use App\Http\Requests\UpdateCampusRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CampusController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $campuses = Campus::latest()->paginate(10);
        return view('admin.campuses.index', compact('campuses'));
    }
    public function create()
    {
        $campus = new Campus();
        return view('admin.campuses.create', compact('campus'));
    }

    public function store(StoreCampusRequest $request)
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $slugName = $data['slug'];
            $extension = $file->getClientOriginalExtension();
            $filename = $slugName . '.' . $extension;
            $data['logo_path'] = $file->storeAs('uploads/campuses', $filename, 'public');
        }
        Campus::create($data);
        return redirect()->route('campuses.index')->with('success', 'Campus created successfully.');
    }

    public function edit(Campus $campus)
    {
        return view('admin.campuses.edit', compact('campus'));
    }
    public function update(UpdateCampusRequest $request, Campus $campus)
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        if ($request->hasFile('logo')) {
            if ($campus->logo_path && Storage::disk('public')->exists($campus->logo_path)) {
                Storage::disk('public')->delete($campus->logo_path);
            }
            $file = $request->file('logo');
            $slugName = $data['slug'];
            $extension = $file->getClientOriginalExtension();
            $filename = $slugName . '.' . $extension;
            $data['logo_path'] = $file->storeAs('uploads/campuses', $filename, 'public');
        }
        $campus->update($data);
        return redirect()->route('campuses.index')->with('success', 'កែប្រែសាខាបានដោយជោគជ័យ');
    }

    public function destroy(Campus $campus)
    {
        $this->authorize('delete', $campus);
        $campus->delete();

        return response()->json([
            'success' => true,
            'message' => 'Campus deleted successfully!',
            'redirect' => route('campuses.index')
        ]);
    }
}
