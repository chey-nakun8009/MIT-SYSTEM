<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = [
        'campus_id',
        'key',
        'value',
        'type',
        'group'
    ];
}
