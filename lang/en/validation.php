<?php

return [

    'accepted'        => 'The :attribute field must be accepted.',
    'active_url'      => 'The :attribute field must be a valid URL.',
    'after'           => 'The :attribute field must be a date after :date.',
    'alpha'           => 'The :attribute field must only contain letters.',
    'array'           => 'The :attribute field must be an array.',
    'exists'          => 'The selected :attribute is invalid.',
    'numeric'         => 'The :attribute field must be a number.',
    'required'        => 'The :attribute field is required.',
    'string'          => 'The :attribute field must be a string.',
    'unique'          => 'The :attribute has already been taken.',

    'failed' => 'Validation failed.',

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'name' => 'ឈ្មោះទំនិញ',
        'category_id' => 'ប្រភេទ',
        'type' => 'ប្រភេទផលិតផល',
        'base_unit_id' => 'ខ្នាតមូលដ្ឋាន',
        'unit_options.0.price' => 'តម្លៃលក់',


        'store_id'           => 'assigned store',
        'first_name'         => 'first name',
        'last_name'          => 'last name',
        'profile'            => 'profile bio',
        'email'              => 'email address',
        'password'           => 'password',
        'phone'              => 'phone number',
        'avatar'             => 'avatar image',
        'role'               => 'role',
        'status'             => 'status',
        'preferred_currency' => 'preferred currency',
        'locale'             => 'locale',
        'language'           => 'language',
    ],

];
