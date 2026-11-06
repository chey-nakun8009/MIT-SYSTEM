<?php

return [
    'title' => '品牌',
    'name' => '品牌名称',
    'slug' => 'Slug',
    'description' => '描述',
    'image' => '图片',
    'is_active' => '状态',
    'sort_order' => '排序',
    'action' => '操作',

    'create' => '添加品牌',
    'edit' => '编辑品牌',

    'enter_name' => '输入品牌名称',
    'enter_slug' => '输入品牌 Slug',
    'enter_description' => '输入品牌描述',
    'select_image' => '选择品牌图片',
    'enter_sort_order' => '输入排序',

    'active' => '启用',
    'inactive' => '停用',

    'new_brand' => '新品牌',
    'details' => '详细信息',
    'created' => '创建时间',
    'last_updated' => '最后更新时间',
    'enter_information' => '请输入品牌信息并保存表单。',

    'form_actions' => '表单操作',
    'save' => '保存品牌',
    'update' => '更新品牌',
    'cancel' => '取消',

    'created_successfully' => '品牌创建成功。',
    'updated_successfully' => '品牌更新成功。',
    'deleted_successfully' => '品牌删除成功。',

    'no_brand' => '未找到品牌',
    'no_brand_description' => '目前没有可用的品牌。',

    'validation' => [
        'name_required' => '请输入品牌名称。',
        'name_max' => '品牌名称不能超过 100 个字符。',
        'slug_unique' => '此品牌 Slug 已被使用。',
        'description_string' => '描述必须是有效文本。',
        'image_image' => '所选文件必须是图片。',
        'image_mimes' => '图片必须是 JPG、JPEG、PNG 或 WEBP 格式。',
        'image_max' => '图片大小不能超过 2 MB。',
        'sort_order_integer' => '排序必须是有效数字。',
        'sort_order_min' => '排序不能为负数。',
    ],
];
