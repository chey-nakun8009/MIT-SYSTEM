<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InventoryTransaction extends Model
{
    use HasFactory;
    protected $table = 'inventory_transactions';

    protected $fillable = [
        'campus_id',
        'product_id',
        'unit_id',
        'quantity',
        'conversion_factor',
        'base_quantity',
        'cost_price',
        'reference_no',
        'note',
        'user_id',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'conversion_factor' => 'decimal:6',
        'base_quantity' => 'decimal:3',
        'cost_price' => 'decimal:3',
    ];

    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    // Optional relationship to retrieve the linked Expense via reference_no
    public function expense(): HasOne
    {
        return $this->hasOne(Expense::class, 'reference_no', 'reference_no')
            ->where('campus_id', $this->campus_id);
    }
}
