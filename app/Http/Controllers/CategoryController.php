<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('campus_id', auth()->user()->campus_id)
            ->orderBy('sort_order')
            ->latest()
            ->paginate(10);

        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        $campusId = auth()->user()->campus_id;
        $categories = Category::where('campus_id', $campusId)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $category = new Category();

        return view('admin.category.create', [
            'categories' => $categories,
            'category' => $category,
        ]);
    }

    public function store(Request $request)
    {
        $campusId = auth()->user()->campus_id;

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->where('campus_id', $campusId)
            ],
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id')->where('campus_id', $campusId)
            ],
            'description' => ['nullable', 'string'],
            'img' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'is_active' => ['required', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);
        if (empty($slug)) {
            $slug = Str::slug($request->name) ?: 'category-' . time();
        }

        $slugExists = Category::where('campus_id', $campusId)->where('slug', $slug)->exists();
        if ($slugExists) {
            $slug = $slug . '-' . uniqid();
        }

        $imagePath = null;
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $extension = $file->getClientOriginalExtension();
            $fileName = $slug . '.' . $extension;
            $file->storeAs('uploads/categories', $fileName, 'public');
            $imagePath = $fileName;
        }

        Category::create([
            'campus_id' => $campusId,
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'img' => $imagePath,
            'is_active' => $request->is_active,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        $campusId = auth()->user()->campus_id;

        if ($category->campus_id != $campusId) {
            abort(404);
        }

        $categories = Category::where('campus_id', $campusId)
            ->where('id', '!=', $category->id)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.category.edit', [
            'category' => $category,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $campusId = auth()->user()->campus_id;

        if ($category->campus_id !== $campusId) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')
                    ->where('campus_id', $campusId)
                    ->ignore($category->id),
            ],
            'parent_id' => [
                'nullable',
                'integer',
                function ($attribute, $value, $fail) use ($category, $campusId) {
                    if ((int) $value === (int) $category->id) {
                        $fail('A category cannot be its own parent.');
                    }
                    if ($value && !Category::where('id', $value)->where('campus_id', $campusId)->exists()) {
                        $fail('The selected parent category is invalid.');
                    }
                },
            ],
            'description' => ['nullable', 'string'],
            'img' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $slug = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);
        if (empty($slug)) {
            $slug = Str::slug($request->name) ?: 'category-' . time();
        }

        $slugExists = Category::where('campus_id', $campusId)
            ->where('slug', $slug)
            ->where('id', '!=', $category->id)
            ->exists();

        if ($slugExists) {
            $slug = $slug . '-' . uniqid();
        }

        $imagePath = $category->img;
        if ($request->hasFile('img')) {
            if ($category->img) {
                $oldImagePath = 'uploads/categories/' . $category->img;
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }
            $file = $request->file('img');
            $extension = $file->getClientOriginalExtension();
            $fileName = $slug . '.' . $extension;
            $file->storeAs('uploads/categories', $fileName, 'public');
            $imagePath = $fileName;
        }

        $category->update([
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'img' => $imagePath,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $campusId = auth()->user()->campus_id;
        if ($category->campus_id !== $campusId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }
        if ($category->img) {
            $imagePath = 'uploads/categories/' . $category->img;
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }
        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully!',
            'redirect' => route('categories.index')
        ]);
    }
}
