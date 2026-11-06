<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSetting extends Model
{
    protected $fillable = [
        'store_id',
        'default_product_type',
        'default_unit_id',
        'decimal_places',
        'allow_negative_stock',
        'allow_inactive_sales',
        'require_sku',
        'auto_generate_sku',
        'low_stock_threshold',
    ];

    protected function casts(): array
    {
        return [
            'decimal_places' => 'integer',
            'allow_negative_stock' => 'boolean',
            'allow_inactive_sales' => 'boolean',
            'require_sku' => 'boolean',
            'auto_generate_sku' => 'boolean',
            'low_stock_threshold' => 'decimal:3',
        ];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function defaultUnit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'default_unit_id');
    }
}
