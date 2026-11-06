<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::where('store_id', auth()->user()->store_id)
            ->orderBy('sort_order')
            ->oldest()
            ->paginate(6);
        if (request()->ajax()) {
            return view('admin.attribute.partials._content', compact('attributes'));
        }

        return view('admin.attribute.index', compact('attributes'));
    }

    public function create()
    {
        return view('admin.attribute.create', [
            'page' => request('page', 1),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ], [
            'name.required' => __('attribute.validation.name_required'),
            'name.max' => __('attribute.validation.name_max'),
            'sort_order.integer' => __('attribute.validation.sort_order_integer'),
            'sort_order.min' => __('attribute.validation.sort_order_min'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => __('validation.failed'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $storeId = auth()->user()->store_id;

        $slug = Str::slug($request->input('name'));

        $originalSlug = $slug;
        $counter = 1;

        while (
            Attribute::where('store_id', $storeId)
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        Attribute::create([
            'store_id' => $storeId,
            'name' => $request->input('name'),
            'slug' => $slug,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->input('sort_order', 0),
        ]);

        return response()->json([
            'success' => true,
            'message' => __('attribute.created_successfully'),
            'redirect' => route('attributes.index', [
                'page' => $request->input('page', 1),
            ]),
        ]);
    }

    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);
        if ($attribute->store_id !== auth()->user()->store_id) {
            abort(403);
        }
        return view('admin.attribute.edit', [
            'attribute' => $attribute,
            'page' => request('page', 1),
        ]);
    }
    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);

        if ($attribute->store_id !== auth()->user()->store_id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot update an attribute from another store.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:100',
            ],
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ], [
            'name.required' => __('attribute.validation.name_required'),
            'name.max' => __('attribute.validation.name_max'),
            'sort_order.integer' => __('attribute.validation.sort_order_integer'),
            'sort_order.min' => __('attribute.validation.sort_order_min'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => __('validation.failed'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $storeId = auth()->user()->store_id;

        $slug = Str::slug($request->input('name'));

        $originalSlug = $slug;
        $counter = 1;

        while (
            Attribute::where('store_id', $storeId)
            ->where('slug', $slug)
            ->where('id', '!=', $attribute->id)
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $attribute->update([
            'name' => $request->input('name'),
            'slug' => $slug,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->input('sort_order', 0),
        ]);

        return response()->json([
            'success' => true,
            'message' => __('attribute.updated_successfully'),
            'redirect' => route('attributes.index', [
                'page' => $request->input('page', 1),
            ]),
        ]);
    }

    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);

        if ($attribute->store_id !== auth()->user()->store_id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete an attribute from another store.',
            ], 403);
        }

        $attribute->delete();

        $currentPage = (int) request('page', 1);
        $perPage = 3;

        $total = Attribute::where(
            'store_id',
            auth()->user()->store_id
        )->count();

        $lastPage = max(1, (int) ceil($total / $perPage));

        $page = min($currentPage, $lastPage);

        return response()->json([
            'success' => true,
            'message' => __('attribute.deleted_successfully'),
            'redirect' => route('attributes.index', [
                'page' => $page,
            ]),
        ]);
    }
}
