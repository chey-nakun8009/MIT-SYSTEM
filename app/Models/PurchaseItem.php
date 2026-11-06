<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseItem extends Model
{
    protected $fillable = [
        'store_id',
        'purchase_id',
        'product_id',
        'unit_id',
        'product_name',
        'unit_symbol',
        'quantity',
        'conversion_factor',
        'unit_cost',
        'total',
        'width',
        'height',
        'area',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:3',
            'conversion_factor' => 'decimal:6',
            'unit_cost' => 'decimal:3',
            'total' => 'decimal:3',
            'width' => 'decimal:3',
            'height' => 'decimal:3',
            'area' => 'decimal:3',
        ];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
