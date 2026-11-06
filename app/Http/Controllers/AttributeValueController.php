<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AttributeValueController extends Controller
{
    public function index(Attribute $attribute)
    {
        abort_unless(
            $attribute->store_id === auth()->user()->store_id,
            403
        );
        $values = $attribute->values()
            ->orderBy('sort_order')
            ->oldest()
            ->paginate(3);
        if (request()->ajax()) {
            return view('admin.attribute-value.partials._content', compact(
                'attribute',
                'values'
            ));
        }
        return view('admin.attribute-value.index', compact(
            'attribute',
            'values'
        ));
    }

    public function create(Attribute $attribute)
    {
        abort_unless(
            $attribute->store_id === auth()->user()->store_id,
            403
        );
        return view('admin.attribute-value.create', [
            'attribute' => $attribute,
            'page' => request('page', 1),
        ]);
    }

    public function store(Request $request, Attribute $attribute)
    {
        abort_unless(
            $attribute->store_id === auth()->user()->store_id,
            403
        );

        $validator = Validator::make($request->all(), [
            'value' => [
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
            'value.required' => __('attribute_value.validation.value_required'),
            'value.max' => __('attribute_value.validation.value_max'),
            'sort_order.integer' => __('attribute_value.validation.sort_order_integer'),
            'sort_order.min' => __('attribute_value.validation.sort_order_min'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => __('validation.failed'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $slug = Str::slug($request->input('value'));

        $originalSlug = $slug;
        $counter = 1;

        while (
            AttributeValue::where('attribute_id', $attribute->id)
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        AttributeValue::create([
            'attribute_id' => $attribute->id,
            'value' => $request->input('value'),
            'slug' => $slug,
            'sort_order' => $request->input('sort_order', 0),
            'is_active' => $request->boolean('is_active'),
        ]);

        return response()->json([
            'success' => true,
            'message' => __('attribute_value.created_successfully'),
            'redirect' => route('attributes.values.index', [
                'attribute' => $attribute->id,
                'page' => $request->input('page', 1),
            ]),
        ]);
    }

    public function edit(Attribute $attribute, AttributeValue $value)
    {
        abort_unless(
            $attribute->store_id === auth()->user()->store_id,
            403
        );

        abort_unless(
            $value->attribute_id === $attribute->id,
            404
        );
        return view('admin.attribute-value.edit', [
            'attribute' => $attribute,
            'value' => $value,
            'page' => request('page', 1),
        ]);
    }

    public function update(
        Request $request,
        Attribute $attribute,
        AttributeValue $value
    ) {
        abort_unless(
            $attribute->store_id === auth()->user()->store_id,
            403
        );

        abort_unless(
            $value->attribute_id === $attribute->id,
            404
        );

        $validator = Validator::make($request->all(), [
            'value' => ['required', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'value.required' => __('attribute_value.validation.value_required'),
            'value.max' => __('attribute_value.validation.value_max'),
            'sort_order.integer' => __('attribute_value.validation.sort_order_integer'),
            'sort_order.min' => __('attribute_value.validation.sort_order_min'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => __('validation.failed'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $slug = Str::slug($request->input('value'));

        $originalSlug = $slug;
        $counter = 1;

        while (
            AttributeValue::where('attribute_id', $attribute->id)
            ->where('slug', $slug)
            ->where('id', '!=', $value->id)
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $value->update([
            'value' => $request->input('value'),
            'slug' => $slug,
            'sort_order' => $request->input('sort_order', 0),
            'is_active' => $request->boolean('is_active'),
        ]);

        return response()->json([
            'success' => true,
            'message' => __('attribute_value.updated_successfully'),
            'redirect' => route('attributes.values.index', [
                'attribute' => $attribute->id,
                'page' => $request->input('page', 1),
            ]),
        ]);
    }

    public function destroy(
        Attribute $attribute,
        AttributeValue $value
    ) {
        abort_unless(
            $attribute->store_id === auth()->user()->store_id,
            403
        );

        abort_unless(
            $value->attribute_id === $attribute->id,
            404
        );

        $value->delete();

        $currentPage = (int) request('page', 1);
        $perPage = 3;

        $total = AttributeValue::where('attribute_id', $attribute->id)->count();

        $lastPage = max(1, (int) ceil($total / $perPage));

        $page = min($currentPage, $lastPage);

        return response()->json([
            'success' => true,
            'message' => __('attribute_value.deleted_successfully'),
            'redirect' => route('attributes.values.index', [
                'attribute' => $attribute->id,
                'page' => $page,
            ]),
        ]);
    }
}
