<?php

return [
    'title' => 'Brands',
    'name' => 'Brand Name',
    'slug' => 'Slug',
    'description' => 'Description',
    'image' => 'Image',
    'is_active' => 'Status',
    'sort_order' => 'Sort Order',
    'action' => 'Action',

    'create' => 'Add Brand',
    'edit' => 'Edit Brand',

    'enter_name' => 'Enter brand name',
    'enter_slug' => 'Enter brand slug',
    'enter_description' => 'Enter brand description',
    'select_image' => 'Select brand image',
    'enter_sort_order' => 'Enter sort order',

    'active' => 'Active',
    'inactive' => 'Inactive',

    'new_brand' => 'New Brand',
    'details' => 'Details',
    'created' => 'Created',
    'last_updated' => 'Last Updated',
    'enter_information' => 'Enter the brand information and save the form.',

    'form_actions' => 'Form Actions',
    'save' => 'Save Brand',
    'update' => 'Update Brand',
    'cancel' => 'Cancel',

    'created_successfully' => 'Brand created successfully.',
    'updated_successfully' => 'Brand updated successfully.',
    'deleted_successfully' => 'Brand deleted successfully.',

    'no_brand' => 'No brand found',
    'no_brand_description' => 'There are no brands available at the moment.',

    'validation' => [
        'name_required' => 'Please enter the brand name.',
        'name_max' => 'The brand name may not be greater than 100 characters.',
        'slug_unique' => 'This brand slug is already in use.',
        'description_string' => 'The description must be valid text.',
        'image_image' => 'The selected file must be an image.',
        'image_mimes' => 'The image must be a JPG, JPEG, PNG, or WEBP file.',
        'image_max' => 'The image may not be greater than 2 MB.',
        'sort_order_integer' => 'The sort order must be a valid number.',
        'sort_order_min' => 'The sort order cannot be negative.',
    ],
];
