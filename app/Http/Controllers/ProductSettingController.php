<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductSetting;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;

class ProductSettingController extends Controller
{
    public function index()
    {
        $storeId = auth()->user()->store_id;

        $settings = ProductSetting::firstOrCreate(
            [
                'store_id' => $storeId,
            ],
            [
                'default_product_type' => 'standard',
                'default_unit_id' => null,
                'decimal_places' => 3,
                'allow_negative_stock' => false,
                'allow_inactive_sales' => false,
                'require_sku' => true,
                'auto_generate_sku' => false,
                'low_stock_threshold' => 0,
            ]
        );

        $units = Unit::where('store_id', $storeId)
            ->orderBy('name')
            ->get();

        if (request()->ajax()) {
            return view(
                'admin.product-setting.form',
                compact('settings', 'units')
            );
        }

        return view(
            'admin.product-setting.index',
            compact('settings', 'units')
        );
    }

    public function update(Request $request)
    {
        $storeId = auth()->user()->store_id;

        $settings = ProductSetting::where('store_id', $storeId)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'default_product_type' => [
                'required',
                'in:standard,glass',
            ],

            'default_unit_id' => [
                'nullable',
                'integer',
                'exists:units,id',
            ],

            'decimal_places' => [
                'required',
                'integer',
                'min:0',
                'max:6',
            ],

            'allow_negative_stock' => [
                'nullable',
                'boolean',
            ],

            'allow_inactive_sales' => [
                'nullable',
                'boolean',
            ],

            'require_sku' => [
                'nullable',
                'boolean',
            ],

            'auto_generate_sku' => [
                'nullable',
                'boolean',
            ],

            'low_stock_threshold' => [
                'required',
                'numeric',
                'min:0',
                'max:999999999.999',
            ],
        ], [
            'default_product_type.required' => __('product_setting.validation.default_product_type_required'),
            'default_product_type.in' => __('product_setting.validation.default_product_type_invalid'),

            'default_unit_id.integer' => __('product_setting.validation.default_unit_invalid'),
            'default_unit_id.exists' => __('product_setting.validation.default_unit_invalid'),

            'decimal_places.required' => __('product_setting.validation.decimal_places_required'),
            'decimal_places.integer' => __('product_setting.validation.decimal_places_integer'),
            'decimal_places.min' => __('product_setting.validation.decimal_places_min'),
            'decimal_places.max' => __('product_setting.validation.decimal_places_max'),

            'low_stock_threshold.required' => __('product_setting.validation.low_stock_threshold_required'),
            'low_stock_threshold.numeric' => __('product_setting.validation.low_stock_threshold_numeric'),
            'low_stock_threshold.min' => __('product_setting.validation.low_stock_threshold_min'),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => __('validation.failed'),
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->filled('default_unit_id')) {
            $unitExists = Unit::where('id', $request->input('default_unit_id'))
                ->where('store_id', $storeId)
                ->exists();

            if (!$unitExists) {
                return response()->json([
                    'success' => false,
                    'message' => __('product_setting.validation.default_unit_invalid'),
                    'errors' => [
                        'default_unit_id' => [
                            __('product_setting.validation.default_unit_invalid'),
                        ],
                    ],
                ], 422);
            }
        }

        if (
            $request->boolean('auto_generate_sku') &&
            !$request->boolean('require_sku')
        ) {
            return response()->json([
                'success' => false,
                'message' => __('product_setting.validation.sku_settings_invalid'),
                'errors' => [
                    'auto_generate_sku' => [
                        __('product_setting.validation.sku_settings_invalid'),
                    ],
                ],
            ], 422);
        }

        $settings->update([
            'default_product_type' => $request->input('default_product_type'),
            'default_unit_id' => $request->input('default_unit_id') ?: null,
            'decimal_places' => $request->input('decimal_places'),
            'allow_negative_stock' => $request->boolean('allow_negative_stock'),
            'allow_inactive_sales' => $request->boolean('allow_inactive_sales'),
            'require_sku' => $request->boolean('require_sku'),
            'auto_generate_sku' => $request->boolean('auto_generate_sku'),
            'low_stock_threshold' => $request->input('low_stock_threshold'),
        ]);

        return response()->json([
            'success' => true,
            'message' => __('product_setting.updated_successfully'),
            'redirect' => route('products.settings'),
        ]);
    }
}
