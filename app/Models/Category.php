<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'campus_id',
        'name',
        'slug',
        'description',
        'img',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    public function showPhoto(): string
    {
        if (!$this->img) {
            return asset('admin/assets/images/no-img.png');
        }
        $path = 'uploads/categories/' . $this->img;
        if (!Storage::disk('public')->exists($path)) {
            return asset('admin/assets/images/no-img.png');
        }
        return Storage::disk('public')->url($path);
    }
}
