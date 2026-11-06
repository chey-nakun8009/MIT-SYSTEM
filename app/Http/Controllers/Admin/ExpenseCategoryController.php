<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Validator;
use App\Traits\WithPagination;

class ExpenseCategoryController extends Controller
{
    use WithPagination;

    public function index(Request $request)
    {
        $campusId = auth()->user()->campus_id;
        $perPage = $this->getPerPage($request);

        $expenseCategories = ExpenseCategory::where('campus_id', $campusId)
            ->paginate($perPage)
            ->appends($request->query());

        return view('admin.expense-category.index', compact('expenseCategories', 'perPage'));
    }

    public function create()
    {
        return view('admin.expense-category.create');
    }

    public function edit(ExpenseCategory $expenseCategory)
    {
        $campusId = auth()->user()->campus_id;

        if ($expenseCategory->campus_id !== $campusId) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.expense-category.edit', compact('expenseCategory'));
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

        $expenseCategory = ExpenseCategory::create([
            'campus_id' => $campusId,
            'name' => $request->name,
            'active' => $request->active,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Expense category created successfully!',
            'redirect' => route('expense-categories.index'),
            'expense_category' => $expenseCategory
        ], 200);
    }

    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        $campusId = auth()->user()->campus_id;

        if ($expenseCategory->campus_id !== $campusId) {
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

        $expenseCategory->update([
            'name' => $request->name,
            'active' => $request->active,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Expense category updated successfully!',
            'redirect' => route('expense-categories.index'),
            'expense_category' => $expenseCategory
        ], 200);
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        $campusId = auth()->user()->campus_id;

        if ($expenseCategory->campus_id !== $campusId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action.',
            ], 403);
        }

        $expenseCategory->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Expense category deleted successfully!',
        ], 200);
    }

    public function copy(ExpenseCategory $expenseCategory)
    {
        $campusId = auth()->user()->campus_id;

        if ($expenseCategory->campus_id !== $campusId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action.',
            ], 403);
        }

        $baseName = preg_replace('/\s*\(Copy(\s*\d+)?\)$/u', '', $expenseCategory->name);

        $existingCount = ExpenseCategory::where('campus_id', $campusId)
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

        $duplicatedCategory = $expenseCategory->replicate();
        $duplicatedCategory->campus_id = $campusId;
        $duplicatedCategory->name = $newName;
        $duplicatedCategory->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Expense category copied successfully!',
            'redirect' => route('expense-categories.index'),
            'expense_category' => $duplicatedCategory
        ], 200);
    }
}
