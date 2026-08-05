<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'company_type', 'position', 'logo', 'website', 'description', 'details',
        'meta_title', 'meta_description', 'is_popular', 'is_trusted', 'page_views',
    ];

    protected $casts = [
        'is_popular' => 'boolean',
        'is_trusted' => 'boolean',
    ];

    public function getInitialsAttribute(): string
    {
        return strtoupper(substr($this->name, 0, 2));
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function histories()
    {
        return $this->hasMany(CouponHistory::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function activeCoupons()
    {
        return $this->hasMany(Coupon::class)->where(function ($q) {
            $q->whereNull('expires_at')->orWhere('expires_at', '>=', now()->toDateString());
        });
    }

    public function getSuccessRateAttribute()
    {
        $total = $this->coupons->sum('success_count') + $this->coupons->sum('failure_count');
        if ($total === 0) return 0;
        return round(($this->coupons->sum('success_count') / $total) * 100);
    }
}
