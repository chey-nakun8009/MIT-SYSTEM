<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RevenueCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\WithPagination;

class RevenueCategoryController extends Controller
{
    use WithPagination;

    public function index(Request $request)
    {
        $campusId = auth()->user()->campus_id;
        $perPage = $this->getPerPage($request);

        $revenueCategories = RevenueCategory::where('campus_id', $campusId)
            ->paginate($perPage)
            ->appends($request->query());

        return view('admin.revenue-category.index', compact('revenueCategories', 'perPage'));
    }

    public function create()
    {
        return view('admin.revenue-category.create');
    }

    public function edit(RevenueCategory $revenueCategory)
    {
        $campusId = auth()->user()->campus_id;

        if ($revenueCategory->campus_id !== $campusId) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.revenue-category.edit', compact('revenueCategory'));
    }

    public function store(Request $request)
    {
        $campusId = auth()->user()->campus_id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $revenueCategory = RevenueCategory::create([
            'campus_id' => $campusId,
            'name' => $request->name,
            'active' => $request->active,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Revenue category created successfully!',
            'redirect' => route('revenue-categories.index'),
            'revenue_category' => $revenueCategory
        ], 200);
    }

    public function update(Request $request, RevenueCategory $revenueCategory)
    {
        $campusId = auth()->user()->campus_id;

        if ($revenueCategory->campus_id !== $campusId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $revenueCategory->update([
            'name' => $request->name,
            'active' => $request->active,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Revenue category updated successfully!',
            'redirect' => route('revenue-categories.index'),
            'revenue_category' => $revenueCategory
        ], 200);
    }

    public function destroy(RevenueCategory $revenueCategory)
    {
        $campusId = auth()->user()->campus_id;

        if ($revenueCategory->campus_id !== $campusId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action.',
            ], 403);
        }

        $revenueCategory->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Revenue category deleted successfully!',
        ], 200);
    }

    public function copy(RevenueCategory $revenueCategory)
    {
        $campusId = auth()->user()->campus_id;

        if ($revenueCategory->campus_id !== $campusId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action.',
            ], 403);
        }

        $baseName = preg_replace('/\s*\(Copy(\s*\d+)?\)$/u', '', $revenueCategory->name);

        $existingCount = RevenueCategory::where('campus_id', $campusId)
            ->where(function ($query) use ($baseName) {
                $query->where('name', $baseName)
                    ->orWhere('name', 'LIKE', $baseName . ' (Copy%)');
            })
            ->count();

        if ($existingCount === 1) {
            $newName = $baseName . ' (Copy)';
        } else {
            $newName = $baseName . ' (Copy ' . ($existingCount - 1) . ')';
        }

        $duplicatedCategory = $revenueCategory->replicate();
        $duplicatedCategory->campus_id = $campusId;
        $duplicatedCategory->name = $newName;
        $duplicatedCategory->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Revenue category copied successfully!',
            'redirect' => route('revenue-categories.index'),
            'revenue_category' => $duplicatedCategory
        ], 200);
    }
}
