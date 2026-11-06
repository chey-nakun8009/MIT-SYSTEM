<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Product;

class ProductVariantController extends Controller
{
    public function index()
    {
        $variants = ProductVariant::where('store_id', auth()->user()->store_id)
            ->oldest()
            ->paginate(10);
        if (request()->ajax()) {
            return view('admin.unit.partials._content', compact('variants'));
        }
        return view('admin.product-variants.index', compact('variants'));
    }
    public function create()
    {
        $products = Product::where('store_id', auth()->user()->store_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        return view('admin.product-variants.create', [
            'products' => $products,
            'page' => request('page', 1),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'sku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('product_variants', 'sku')
                    ->where(fn($query) => $query->where(
                        'store_id',
                        auth()->user()->store_id
                    )),
            ],
            'price' => ['nullable', 'numeric', 'min:0'],
            'attributes' => ['required', 'json'],
            'weight_kg' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'product_id.required' => __('variant.validation.product_required'),
            'sku.required' => __('variant.validation.sku_required'),
            'sku.unique' => __('variant.validation.sku_unique'),
            'price.numeric' => __('variant.validation.price_numeric'),
            'attributes.required' => __('variant.validation.attributes_required'),
            'attributes.json' => 'Attributes must be valid JSON.',
            'weight_kg.numeric' => __('variant.validation.weight_numeric'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => __('validation.failed'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $product = Product::where('id', $request->product_id)
            ->where('store_id', auth()->user()->store_id)
            ->first();

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => __('variant.validation.product_required'),
            ], 422);
        }

        $attributes = json_decode($request->input('attributes'), true);
        if (!is_array($attributes)) {
            return response()->json([
                'status' => false,
                'message' => __('variant.validation.attributes_required'),
                'errors' => [
                    'attributes' => ['Attributes must be a valid JSON object.'],
                ],
            ], 422);
        }
        ProductVariant::create([
            'store_id' => auth()->user()->store_id,
            'product_id' => $product->id,
            'sku' => $request->input('sku'),
            'price' => $request->input('price'),
            'attributes' => $attributes,
            'weight_kg' => $request->input('weight_kg'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return response()->json([
            'status' => true,
            'message' => __('variant.created_successfully'),
            'redirect' => route('product-variants.index'),
        ]);
    }

    public function edit(ProductVariant $productVariant)
    {
        abort_unless(
            $productVariant->store_id === auth()->user()->store_id,
            403
        );

        $productVariant->load('product');

        $products = Product::where('store_id', auth()->user()->store_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.product-variants.edit', [
            'variant' => $productVariant,
            'products' => $products,
            'page' => request('page', 1),
        ]);
    }
    public function update(Request $request, ProductVariant $productVariant)
    {
        abort_unless(
            $productVariant->store_id === auth()->user()->store_id,
            403
        );

        $validator = Validator::make($request->all(), [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'sku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('product_variants', 'sku')
                    ->ignore($productVariant->id)
                    ->where(fn($query) => $query->where(
                        'store_id',
                        auth()->user()->store_id
                    )),
            ],
            'price' => ['nullable', 'numeric', 'min:0'],
            'attributes' => ['required', 'json'],
            'weight_kg' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'product_id.required' => __('variant.validation.product_required'),
            'sku.required' => __('variant.validation.sku_required'),
            'sku.unique' => __('variant.validation.sku_unique'),
            'price.numeric' => __('variant.validation.price_numeric'),
            'attributes.required' => __('variant.validation.attributes_required'),
            'attributes.json' => 'Attributes must be valid JSON.',
            'weight_kg.numeric' => __('variant.validation.weight_numeric'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => __('validation.failed'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $product = Product::where('id', $request->input('product_id'))
            ->where('store_id', auth()->user()->store_id)
            ->first();

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => __('variant.validation.product_required'),
            ], 422);
        }

        $attributes = json_decode(
            $request->input('attributes'),
            true
        );

        if (!is_array($attributes)) {
            return response()->json([
                'status' => false,
                'message' => __('variant.validation.attributes_required'),
                'errors' => [
                    'attributes' => [
                        'Attributes must be a valid JSON object.'
                    ],
                ],
            ], 422);
        }

        $productVariant->update([
            'product_id' => $product->id,
            'sku' => $request->input('sku'),
            'price' => $request->input('price'),
            'attributes' => $attributes,
            'weight_kg' => $request->input('weight_kg'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return response()->json([
            'status' => true,
            'message' => __('variant.updated_successfully'),
            'redirect' => route('product-variants.index', [
                'page' => $request->input('page', 1),
            ]),
        ]);
    }
}
