<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = [
        'name', 'svg', 'link', 'position', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
