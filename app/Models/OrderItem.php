<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'campus_id',
        'order_id',
        'product_id',
        'unit_id',
        'product_name',
        'unit_symbol',
        'quantity',
        'conversion_factor',
        'width',
        'height',
        'area',
        'unit_price',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:3',
            'conversion_factor' => 'decimal:6',
            'width' => 'decimal:3',
            'height' => 'decimal:3',
            'area' => 'decimal:3',
            'unit_price' => 'decimal:3',
            'total' => 'decimal:3',
        ];
    }

    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
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
