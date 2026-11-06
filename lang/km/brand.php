<?php

return [
    'title' => 'ម៉ាកផលិតផល',
    'name' => 'ឈ្មោះម៉ាក',
    'slug' => 'Slug',
    'description' => 'ការពិពណ៌នា',
    'image' => 'រូបភាព',
    'is_active' => 'ស្ថានភាព',
    'sort_order' => 'លំដាប់បង្ហាញ',
    'action' => 'សកម្មភាព',

    'create' => 'បន្ថែមម៉ាក',
    'edit' => 'កែម៉ាក',

    'enter_name' => 'បញ្ចូលឈ្មោះម៉ាក',
    'enter_slug' => 'បញ្ចូល Slug របស់ម៉ាក',
    'enter_description' => 'បញ្ចូលការពិពណ៌នាម៉ាក',
    'select_image' => 'ជ្រើសរើសរូបភាពម៉ាក',
    'enter_sort_order' => 'បញ្ចូលលំដាប់បង្ហាញ',

    'active' => 'សកម្ម',
    'inactive' => 'អសកម្ម',

    'new_brand' => 'ម៉ាកថ្មី',
    'details' => 'ព័ត៌មានលម្អិត',
    'created' => 'បានបង្កើត',
    'last_updated' => 'បានធ្វើបច្ចុប្បន្នភាពចុងក្រោយ',
    'enter_information' => 'បញ្ចូលព័ត៌មានម៉ាក ហើយរក្សាទុកទម្រង់។',

    'form_actions' => 'សកម្មភាពទម្រង់',
    'save' => 'រក្សាទុកម៉ាក',
    'update' => 'ធ្វើបច្ចុប្បន្នភាពម៉ាក',
    'cancel' => 'បោះបង់',

    'created_successfully' => 'បានបង្កើតម៉ាកដោយជោគជ័យ។',
    'updated_successfully' => 'បានធ្វើបច្ចុប្បន្នភាពម៉ាកដោយជោគជ័យ។',
    'deleted_successfully' => 'បានលុបម៉ាកដោយជោគជ័យ។',

    'no_brand' => 'រកមិនឃើញម៉ាក',
    'no_brand_description' => 'បច្ចុប្បន្នមិនមានម៉ាកផលិតផលទេ។',

    'validation' => [
        'name_required' => 'សូមបញ្ចូលឈ្មោះម៉ាក។',
        'name_max' => 'ឈ្មោះម៉ាកមិនអាចលើសពី ១០០ តួអក្សរ។',
        'slug_unique' => 'Slug របស់ម៉ាកនេះមានរួចហើយ។',
        'description_string' => 'ការពិពណ៌នាត្រូវតែជាអត្ថបទត្រឹមត្រូវ។',
        'image_image' => 'ឯកសារដែលបានជ្រើសរើសត្រូវតែជារូបភាព។',
        'image_mimes' => 'រូបភាពត្រូវតែជា JPG, JPEG, PNG ឬ WEBP។',
        'image_max' => 'រូបភាពមិនអាចលើសពី ២ MB បានទេ។',
        'sort_order_integer' => 'លំដាប់បង្ហាញត្រូវតែជាលេខត្រឹមត្រូវ។',
        'sort_order_min' => 'លំដាប់បង្ហាញមិនអាចជាលេខអវិជ្ជមានបានទេ។',
    ],
];
