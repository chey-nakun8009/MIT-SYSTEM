<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $query = Brand::with('campus')->where('campus_id', auth()->user()->campus_id);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $brands = $query->orderBy('sort_order')->oldest()->paginate(15)->withQueryString();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('admin.brand.partials._row', compact('brands'))->render(),
                'pagination' => $brands->links('vendor.pagination.bootstrap-5')->render(),
            ]);
        }

        return view('admin.brand.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brand.create', [
            'page' => request('page', 1),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => __('brand.validation.name_required'),
            'name.max' => __('brand.validation.name_max'),
            'description.string' => __('brand.validation.description_string'),
            'image.image' => __('brand.validation.image_image'),
            'image.mimes' => __('brand.validation.image_mimes'),
            'image.max' => __('brand.validation.image_max'),
            'sort_order.integer' => __('brand.validation.sort_order_integer'),
            'sort_order.min' => __('brand.validation.sort_order_min'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => __('validation.failed'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $campusId = auth()->user()->campus_id;
        $slug = Str::slug($request->input('name'));
        $originalSlug = $slug;
        $counter = 1;

        while (
            Brand::where('campus_id', $campusId)
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $image = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = $slug . '.' . $extension;
            $file->storeAs('uploads/brands', $fileName, 'public');
            $image = $fileName;
        }

        Brand::create([
            'campus_id' => $campusId,
            'name' => $request->input('name'),
            'slug' => $slug,
            'description' => $request->input('description'),
            'img' => $image,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->input('sort_order', 0),
        ]);

        return response()->json([
            'status' => true,
            'message' => __('brand.created_successfully'),
            'redirect' => route('brands.index', [
                'page' => $request->input('page', 1),
            ]),
        ]);
    }

    public function edit(Brand $brand)
    {
        abort_unless(
            $brand->campus_id === auth()->user()->campus_id,
            403
        );

        return view('admin.brand.edit', [
            'brand' => $brand,
            'page' => request('page', 1),
        ]);
    }

    public function update(Request $request, Brand $brand)
    {
        abort_unless(
            $brand->campus_id === auth()->user()->campus_id,
            403
        );

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.required' => __('brand.validation.name_required'),
            'name.max' => __('brand.validation.name_max'),
            'description.string' => __('brand.validation.description_string'),
            'image.image' => __('brand.validation.image_image'),
            'image.mimes' => __('brand.validation.image_mimes'),
            'image.max' => __('brand.validation.image_max'),
            'sort_order.integer' => __('brand.validation.sort_order_integer'),
            'sort_order.min' => __('brand.validation.sort_order_min'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => __('validation.failed'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $campusId = auth()->user()->campus_id;
        $slug = Str::slug($request->input('name'));
        $originalSlug = $slug;
        $counter = 1;

        while (
            Brand::where('campus_id', $campusId)
            ->where('slug', $slug)
            ->where('id', '!=', $brand->id)
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $image = $brand->img;
        if ($request->hasFile('image')) {
            if ($brand->img) {
                $oldImagePath = 'uploads/brands/' . $brand->img;
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = $slug . '.' . $extension;
            $file->storeAs('uploads/brands', $fileName, 'public');
            $image = $fileName;
        }

        $brand->update([
            'name' => $request->input('name'),
            'slug' => $slug,
            'description' => $request->input('description'),
            'img' => $image,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->input('sort_order', 0),
        ]);

        return response()->json([
            'status' => true,
            'message' => __('brand.updated_successfully'),
            'redirect' => route('brands.index', [
                'page' => $request->input('page', 1),
            ]),
        ]);
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand->campus_id !== auth()->user()->campus_id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete a brand from another campus.',
            ], 403);
        }

        if ($brand->img) {
            $imagePath = 'uploads/brands/' . $brand->img;
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $brand->delete();
        $currentPage = (int) request('page', 1);
        $perPage = 15;
        $total = Brand::where('campus_id', auth()->user()->campus_id)->count();
        $lastPage = max(1, (int) ceil($total / $perPage));
        $page = min($currentPage, $lastPage);

        return response()->json([
            'success' => true,
            'message' => __('brand.deleted_successfully'),
            'redirect' => route('brands.index', [
                'page' => $page,
            ]),
        ]);
    }
}
