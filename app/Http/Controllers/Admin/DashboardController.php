<?php

namespace App\Http\Controllers\Admin;

use App\Models\Store;
use App\Models\Coupon;
use App\Models\CouponHistory;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_stores'   => Store::count(),
            'total_coupons'  => Coupon::count(),
            'total_copies'   => Coupon::sum('copy_count'),
            'total_success'  => Coupon::sum('success_count'),
            'total_failure'  => Coupon::sum('failure_count'),
            'total_views'    => Store::sum('page_views'),
            'popular_stores' => Store::where('is_popular', true)->count(),
        ];

        $recentCoupons = Coupon::with('store')->latest()->limit(5)->get();
        $recentHistory = CouponHistory::with('store')->latest()->limit(10)->get();

        $topStores = Store::withCount('coupons')
            ->orderByDesc('page_views')
            ->limit(5)
            ->get();

        return view('admin.dashboard.index', compact('stats', 'recentCoupons', 'recentHistory', 'topStores'));
    }
}
