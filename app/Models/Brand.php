<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    protected $fillable = [
        'campus_id',
        'name',
        'slug',
        'description',
        'img',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function showBrandLogo(): string
    {
        $path = 'uploads/brands/' . $this->img;

        if (
            !$this->img ||
            !Storage::disk('public')->exists($path)
        ) {
            return asset('admin/assets/images/no-img.png');
        }

        return Storage::disk('public')->url($path);
    }
}
