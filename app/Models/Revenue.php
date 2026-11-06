<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;

    protected $fillable = [
        'campus_id',
        'revenue_category_id',
        'amount',
        'reference_no',
        'note',
        'user_id',
    ];
    public function category()
    {
        return $this->belongsTo(RevenueCategory::class, 'revenue_category_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function campus()
    {
        return $this->belongsTo(Campus::class, 'campus_id');
    }
}