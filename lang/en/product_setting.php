<?php

return [
    'title' => 'Product Settings',
    'product_settings' => 'Product Settings',

    'default_product_type' => 'Default Product Type',
    'default_unit' => 'Default Unit',
    'no_default_unit' => 'No Default Unit',

    'standard' => 'Standard',
    'glass' => 'Glass',

    'decimal_places' => 'Decimal Places',
    'enter_decimal_places' => 'Enter decimal places',

    'low_stock_threshold' => 'Low Stock Threshold',
    'enter_low_stock_threshold' => 'Enter low stock threshold',

    'stock_settings' => 'Stock Settings',

    'allow_negative_stock' => 'Allow Negative Stock',
    'allow_negative_stock_help' => 'Allow products to be sold when available stock reaches zero.',

    'allow_inactive_sales' => 'Allow Inactive Product Sales',
    'allow_inactive_sales_help' => 'Allow inactive products to be selected and sold in POS.',

    'sku_settings' => 'SKU Settings',

    'require_sku' => 'Require SKU',
    'require_sku_help' => 'Require every product to have an SKU.',

    'auto_generate_sku' => 'Auto Generate SKU',
    'auto_generate_sku_help' => 'Automatically generate an SKU when creating a product.',

    'form_actions' => 'Form Actions',
    'enter_information' => 'Configure the default product, stock, and SKU settings for your store.',

    'save' => 'Save Settings',

    'updated_successfully' => 'Product settings updated successfully.',

    'validation' => [
        'default_product_type_required' => 'Please select a default product type.',
        'default_product_type_invalid' => 'The selected product type is invalid.',

        'default_unit_invalid' => 'The selected default unit is invalid.',

        'decimal_places_required' => 'Please enter the number of decimal places.',
        'decimal_places_integer' => 'Decimal places must be a valid number.',
        'decimal_places_min' => 'Decimal places cannot be negative.',
        'decimal_places_max' => 'Decimal places cannot be greater than 6.',

        'low_stock_threshold_required' => 'Please enter the low stock threshold.',
        'low_stock_threshold_numeric' => 'The low stock threshold must be a valid number.',
        'low_stock_threshold_min' => 'The low stock threshold cannot be negative.',

        'sku_settings_invalid' => 'Auto-generated SKU requires SKU to be enabled.',
    ],
];
