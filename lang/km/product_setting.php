<?php

return [
    'title' => 'ការកំណត់ផលិតផល',
    'product_settings' => 'ការកំណត់ផលិតផល',

    'default_product_type' => 'ប្រភេទផលិតផលលំនាំដើម',
    'default_unit' => 'ឯកតាលំនាំដើម',
    'no_default_unit' => 'មិនកំណត់ឯកតាលំនាំដើម',

    'standard' => 'ផលិតផលធម្មតា',
    'glass' => 'កញ្ចក់',

    'decimal_places' => 'ចំនួនខ្ទង់ទសភាគ',
    'enter_decimal_places' => 'បញ្ចូលចំនួនខ្ទង់ទសភាគ',

    'low_stock_threshold' => 'កម្រិតស្តុកទាប',
    'enter_low_stock_threshold' => 'បញ្ចូលកម្រិតស្តុកទាប',

    'stock_settings' => 'ការកំណត់ស្តុក',

    'allow_negative_stock' => 'អនុញ្ញាតឱ្យស្តុកអវិជ្ជមាន',
    'allow_negative_stock_help' => 'អនុញ្ញាតឱ្យលក់ផលិតផលនៅពេលស្តុកដែលមានឈានដល់សូន្យ។',

    'allow_inactive_sales' => 'អនុញ្ញាតឱ្យលក់ផលិតផលអសកម្ម',
    'allow_inactive_sales_help' => 'អនុញ្ញាតឱ្យជ្រើសរើស និងលក់ផលិតផលដែលបានបិទសកម្មភាពនៅក្នុង POS។',

    'sku_settings' => 'ការកំណត់ SKU',

    'require_sku' => 'ទាមទារ SKU',
    'require_sku_help' => 'ទាមទារឱ្យផលិតផលគ្រប់មុខមាន SKU។',

    'auto_generate_sku' => 'បង្កើត SKU ដោយស្វ័យប្រវត្តិ',
    'auto_generate_sku_help' => 'បង្កើត SKU ដោយស្វ័យប្រវត្តិនៅពេលបង្កើតផលិតផល។',

    'form_actions' => 'សកម្មភាពទម្រង់',
    'enter_information' => 'កំណត់ផលិតផល ស្តុក និងការកំណត់ SKU លំនាំដើមសម្រាប់ហាងរបស់អ្នក។',

    'save' => 'រក្សាទុកការកំណត់',

    'updated_successfully' => 'បានធ្វើបច្ចុប្បន្នភាពការកំណត់ផលិតផលដោយជោគជ័យ។',

    'validation' => [
        'default_product_type_required' => 'សូមជ្រើសរើសប្រភេទផលិតផលលំនាំដើម។',
        'default_product_type_invalid' => 'ប្រភេទផលិតផលដែលបានជ្រើសរើសមិនត្រឹមត្រូវ។',

        'default_unit_invalid' => 'ឯកតាលំនាំដើមដែលបានជ្រើសរើសមិនត្រឹមត្រូវ។',

        'decimal_places_required' => 'សូមបញ្ចូលចំនួនខ្ទង់ទសភាគ។',
        'decimal_places_integer' => 'ចំនួនខ្ទង់ទសភាគត្រូវតែជាលេខត្រឹមត្រូវ។',
        'decimal_places_min' => 'ចំនួនខ្ទង់ទសភាគមិនអាចអវិជ្ជមានបានទេ។',
        'decimal_places_max' => 'ចំនួនខ្ទង់ទសភាគមិនអាចលើសពី ៦ បានទេ។',

        'low_stock_threshold_required' => 'សូមបញ្ចូលកម្រិតស្តុកទាប។',
        'low_stock_threshold_numeric' => 'កម្រិតស្តុកទាបត្រូវតែជាលេខត្រឹមត្រូវ។',
        'low_stock_threshold_min' => 'កម្រិតស្តុកទាបមិនអាចអវិជ្ជមានបានទេ។',

        'sku_settings_invalid' => 'ការបង្កើត SKU ដោយស្វ័យប្រវត្តិត្រូវការឱ្យបើកការទាមទារ SKU។',
    ],
];
