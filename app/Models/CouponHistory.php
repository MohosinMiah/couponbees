<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_id', 'store_id', 'coupon_code', 'coupon_title',
        'action', 'ip_address', 'user_agent',
    ];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
