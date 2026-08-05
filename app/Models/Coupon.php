<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id', 'title', 'code', 'description', 'type',
        'discount_value', 'discount_type', 'position', 'expires_at',
        'is_verified', 'is_exclusive', 'copy_count', 'success_count', 'failure_count',
    ];

    protected $casts = [
        'expires_at'   => 'date',
        'is_verified'  => 'boolean',
        'is_exclusive' => 'boolean',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function histories()
    {
        return $this->hasMany(CouponHistory::class);
    }

    public function getSuccessRateAttribute()
    {
        $total = $this->success_count + $this->failure_count;
        if ($total === 0) return null;
        return round(($this->success_count / $total) * 100);
    }

    public function getIsExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getDiscountLabelAttribute()
    {
        if ($this->discount_type === 'percentage') return $this->discount_value . '% OFF';
        if ($this->discount_type === 'fixed') return '$' . $this->discount_value . ' OFF';
        if ($this->discount_type === 'free_shipping') return 'Free Shipping';
        return $this->discount_value ?? 'Deal';
    }
}
