<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'campus_id',
        'brand_id',
        'sku',
        'category_id',
        'type',
        'base_unit_id',
        'is_active',
        'description',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function baseUnit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'base_unit_id');
    }

    public function productUnits(): HasMany
    {
        return $this->hasMany(ProductUnit::class);
    }

    public function unitOptions(): HasMany
    {
        return $this->hasMany(ProductUnitOption::class);
    }
    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class);
    }
    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order', 'asc');
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $primary = $this->images->where('is_primary', true)->first() ?? $this->images->first();
        if ($primary && $primary->image) {
            $path = 'uploads/products/' . $primary->image;

            if (Storage::disk('public')->exists($path)) {
                return Storage::disk('public')->url($path);
            }
        }
        return asset('admin/assets/images/no-img.png');
    }

    public function defaultUnitOption(): HasOne
    {
        return $this->hasOne(ProductUnitOption::class)->where('is_default', 1);
    }

    public function getPriceRangeAttribute(): string
    {
        if ($this->unitOptions->isEmpty()) {
            return '$0.00';
        }

        $min = $this->unitOptions->min('price');
        $max = $this->unitOptions->max('price');

        if ($min == $max) {
            return '$' . number_format($min, 2);
        }

        return '$' . number_format($min, 2) . ' - $' . number_format($max, 2);
    }

    public function getTotalStockAttribute(): float
    {
        return $this->inventory->quantity ?? 0.00;
    }

    public function productPhoto(): string
    {
        $path = 'uploads/products/' . $this->image;
        if (empty($this->image) || !Storage::disk('public')->exists($path)) {
            return asset('admin/assets/images/no-img.png');
        }
        return asset('storage/' . $path);
    }
}
