<?php

return [
    'title' => '产品设置',
    'product_settings' => '产品设置',

    'default_product_type' => '默认产品类型',
    'default_unit' => '默认单位',
    'no_default_unit' => '不设置默认单位',

    'standard' => '标准产品',
    'glass' => '玻璃',

    'decimal_places' => '小数位数',
    'enter_decimal_places' => '输入小数位数',

    'low_stock_threshold' => '低库存阈值',
    'enter_low_stock_threshold' => '输入低库存阈值',

    'stock_settings' => '库存设置',

    'allow_negative_stock' => '允许负库存',
    'allow_negative_stock_help' => '允许在可用库存达到零时继续销售产品。',

    'allow_inactive_sales' => '允许销售停用产品',
    'allow_inactive_sales_help' => '允许在 POS 中选择和销售已停用的产品。',

    'sku_settings' => 'SKU 设置',

    'require_sku' => '要求 SKU',
    'require_sku_help' => '要求每个产品都必须有 SKU。',

    'auto_generate_sku' => '自动生成 SKU',
    'auto_generate_sku_help' => '创建产品时自动生成 SKU。',

    'form_actions' => '表单操作',
    'enter_information' => '配置您商店的默认产品、库存和 SKU 设置。',

    'save' => '保存设置',

    'updated_successfully' => '产品设置更新成功。',

    'validation' => [
        'default_product_type_required' => '请选择默认产品类型。',
        'default_product_type_invalid' => '所选择的产品类型无效。',

        'default_unit_invalid' => '所选择的默认单位无效。',

        'decimal_places_required' => '请输入小数位数。',
        'decimal_places_integer' => '小数位数必须是有效数字。',
        'decimal_places_min' => '小数位数不能为负数。',
        'decimal_places_max' => '小数位数不能超过 6 位。',

        'low_stock_threshold_required' => '请输入低库存阈值。',
        'low_stock_threshold_numeric' => '低库存阈值必须是有效数字。',
        'low_stock_threshold_min' => '低库存阈值不能为负数。',

        'sku_settings_invalid' => '自动生成 SKU 需要启用 SKU。'
    ],
];
