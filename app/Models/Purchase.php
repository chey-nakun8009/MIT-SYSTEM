<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'store_id',
        'supplier_id',
        'purchase_number',
        'supplier_invoice_number',
        'purchase_date',
        'status',
        'subtotal',
        'discount',
        'shipping_cost',
        'total',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'subtotal' => 'decimal:3',
            'discount' => 'decimal:3',
            'shipping_cost' => 'decimal:3',
            'total' => 'decimal:3',
        ];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(SupplierPayment::class);
    }

    public function getPaidAmountAttribute(): string
    {
        return (string) $this->payments()->sum('amount');
    }

    public function getBalanceAttribute(): string
    {
        return (string) (
            (float) $this->total - (float) $this->paid_amount
        );
    }

    public function getPaymentStatusAttribute(): string
    {
        if ((float) $this->paid_amount <= 0) {
            return 'unpaid';
        }

        if ((float) $this->paid_amount < (float) $this->total) {
            return 'partial';
        }

        return 'paid';
    }
}
