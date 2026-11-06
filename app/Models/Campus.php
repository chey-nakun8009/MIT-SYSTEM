<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Campus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'logo_path',
        'status',
        'currency',
        'timezone',
        'locale',
    ];
    public function showCampusLogo(): string
    {
        if (!$this->logo_path) {
            return asset('photos/login_logo.png');
        }
        $path = str_starts_with($this->logo_path, 'uploads/campuses/')
            ? $this->logo_path : 'uploads/campuses/' . $this->logo_path;
        if (!Storage::disk('public')->exists($path)) {
            return asset('photos/login_logo.png');
        }
        return Storage::disk('public')->url($path);
    }
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class);
    }
    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }
    public function productSettings(): HasOne
    {
        return $this->hasOne(ProductSetting::class);
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function supplierPayments(): HasMany
    {
        return $this->hasMany(SupplierPayment::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    protected static function booted()
    {
        static::deleting(function ($campus) {
            if ($campus->logo_path) {
                $path = str_starts_with($campus->logo_path, 'uploads/campuses/')
                    ? $campus->logo_path
                    : 'uploads/campuses/' . $campus->logo_path;

                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        });
    }
}
