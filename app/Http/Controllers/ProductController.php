<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductUnitOption;
use App\Models\ProductVariant;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'baseUnit', 'inventory', 'images'])
            ->where('campus_id', auth()->user()->campus_id)
            ->oldest()
            ->paginate(15);

        if (request()->ajax()) {
            return view('admin.product.partials._content', compact('products'));
        }

        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $campusId = auth()->user()->campus_id;

        $categories = Category::where('campus_id', $campusId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $brands = Brand::where('campus_id', $campusId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $units = Unit::where('campus_id', $campusId)
            ->orderBy('name')
            ->get();

        return view('admin.product.create', compact(
            'categories',
            'brands',
            'units'
        ));
    }

    public function store(Request $request)
    {
        $campusId = auth()->user()->campus_id;
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'brand_id' => ['nullable', 'integer', 'exists:brands,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'type' => ['required', 'in:standard,glass'],
            'base_unit_id' => ['required', 'integer', 'exists:units,id'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'unit_options' => ['required', 'array', 'min:1'],
            'unit_options.*.unit_id' => ['required', 'integer', 'exists:units,id'],
            'unit_options.*.conversion_factor' => ['required', 'numeric', 'min:0.000001'],
            'unit_options.*.price' => ['required', 'numeric', 'min:0'],
            'unit_options.*.is_default' => ['nullable', 'boolean'],
            'unit_options.*.is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please check the form.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        if (!Category::where('id', $validated['category_id'])->where('campus_id', $campusId)->exists()) {
            return response()->json(['status' => false, 'message' => 'Invalid category.'], 422);
        }
        if (!empty($validated['brand_id'])) {
            if (!Brand::where('id', $validated['brand_id'])->where('campus_id', $campusId)->exists()) {
                return response()->json(['status' => false, 'message' => 'Invalid brand.'], 422);
            }
        }
        if (!Unit::where('id', $validated['base_unit_id'])->where('campus_id', $campusId)->exists()) {
            return response()->json(['status' => false, 'message' => 'Invalid base unit.'], 422);
        }
        try {
            DB::beginTransaction();

            $product = Product::create([
                'campus_id' => $campusId,
                'brand_id' => $validated['brand_id'] ?? null,
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'type' => $validated['type'],
                'base_unit_id' => $validated['base_unit_id'],
                'is_active' => $request->boolean('is_active'),
            ]);
            $product->update([
                'sku' => 'PRD-' . str_pad($product->id, 6, '0', STR_PAD_LEFT),
            ]);
            foreach ($validated['unit_options'] as $unitOption) {
                ProductUnitOption::create([
                    'campus_id' => $campusId,
                    'product_id' => $product->id,
                    'unit_id' => $unitOption['unit_id'],
                    'conversion_factor' => $unitOption['conversion_factor'],
                    'price' => $unitOption['price'],
                    'is_default' => !empty($unitOption['is_default']),
                    'is_active' => !empty($unitOption['is_active']),
                ]);
            }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = Str::slug($product->sku) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/products', $fileName, 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $fileName,
                    'is_primary' => true,
                    'sort_order' => 0,
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Product created successfully.',
                'redirect' => route('products.index'),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Failed to create product.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Product $product)
    {
        $campusId = auth()->user()->campus_id;

        if ($product->campus_id !== $campusId) {
            abort(404);
        }

        $product->load([
            'brand',
            'category',
            'baseUnit',
            'unitOptions.unit',
            'images',
        ]);

        return view('admin.product.show', compact('product'));
    }
    public function edit(Product $product)
    {
        $campusId = auth()->user()->campus_id;
        if ($product->campus_id !== $campusId) {
            abort(403);
        }
        $categories = Category::where('campus_id', $campusId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        $brands = Brand::where('campus_id', $campusId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $units = Unit::where('campus_id', $campusId)
            ->orderBy('name')
            ->get();
        $product->load(['unitOptions', 'images']);

        return view('admin.product.edit', compact(
            'product',
            'categories',
            'brands',
            'units'
        ));
    }

    public function update(Request $request, Product $product)
    {
        $campusId = auth()->user()->campus_id;

        if ($product->campus_id !== $campusId) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized action.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'brand_id' => ['nullable', 'integer', 'exists:brands,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'type' => ['required', 'in:standard,glass'],
            'base_unit_id' => ['required', 'integer', 'exists:units,id'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'unit_options' => ['required', 'array', 'min:1'],
            'unit_options.*.unit_id' => ['required', 'integer', 'exists:units,id'],
            'unit_options.*.conversion_factor' => ['required', 'numeric', 'min:0.000001'],
            'unit_options.*.price' => ['required', 'numeric', 'min:0'],
            'unit_options.*.is_default' => ['nullable', 'boolean'],
            'unit_options.*.is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please check the form.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        // Verify Category belongs to campus
        if (!Category::where('id', $validated['category_id'])->where('campus_id', $campusId)->exists()) {
            return response()->json(['status' => false, 'message' => 'Invalid category.'], 422);
        }

        // Verify Brand belongs to campus
        if (!empty($validated['brand_id'])) {
            if (!Brand::where('id', $validated['brand_id'])->where('campus_id', $campusId)->exists()) {
                return response()->json(['status' => false, 'message' => 'Invalid brand.'], 422);
            }
        }

        // Verify Base Unit belongs to campus
        if (!Unit::where('id', $validated['base_unit_id'])->where('campus_id', $campusId)->exists()) {
            return response()->json(['status' => false, 'message' => 'Invalid base unit.'], 422);
        }

        try {
            DB::beginTransaction();

            $product->update([
                'brand_id' => $validated['brand_id'] ?? null,
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
                'type' => $validated['type'],
                'base_unit_id' => $validated['base_unit_id'],
                'is_active' => $request->boolean('is_active'),
            ]);

            // Sync Unit Options: Delete old options and re-create submitted ones
            $product->unitOptions()->delete();

            foreach ($validated['unit_options'] as $unitOption) {
                ProductUnitOption::create([
                    'campus_id' => $campusId,
                    'product_id' => $product->id,
                    'unit_id' => $unitOption['unit_id'],
                    'conversion_factor' => $unitOption['conversion_factor'],
                    'price' => $unitOption['price'],
                    'is_default' => !empty($unitOption['is_default']),
                    'is_active' => !empty($unitOption['is_active']),
                ]);
            }

            // Handle New Image Upload (replacing primary image)
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = Str::slug($product->sku) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/products', $fileName, 'public');

                // Delete old primary images from storage & DB
                foreach ($product->images as $oldImage) {
                    if ($oldImage->image && Storage::disk('public')->exists('uploads/products/' . $oldImage->image)) {
                        Storage::disk('public')->delete('uploads/products/' . $oldImage->image);
                    }
                    $oldImage->delete();
                }

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $fileName,
                    'is_primary' => true,
                    'sort_order' => 0,
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Product updated successfully.',
                'redirect' => route('products.index'),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Failed to update product.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function destroy(Product $product)
    {
        $campusId = auth()->user()->campus_id;

        if ($product->campus_id !== $campusId) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete a product from another campus.',
            ], 403);
        }

        try {
            DB::beginTransaction();

            foreach ($product->images as $image) {
                if ($image->image && Storage::disk('public')->exists('uploads/products/' . $image->image)) {
                    Storage::disk('public')->delete('uploads/products/' . $image->image);
                }
            }

            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully!',
                'redirect' => route('products.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to delete product: ' . $e->getMessage()
            ], 500);
        }
    }
}
