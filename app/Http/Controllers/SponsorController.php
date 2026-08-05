<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Sponsor;
use App\Models\Store;
use Illuminate\Routing\Controller;

class SponsorController extends Controller
{
    public function show()
    {
        $stats = [
            'stores'      => Store::count(),
            'coupons'     => Coupon::count(),
            'pageViews'   => Store::sum('page_views'),
            'successRate' => $this->averageSuccessRate(),
        ];

        $sponsors = Sponsor::where('is_active', true)->orderBy('position')->orderBy('name')->get();

        $meta = [
            'title'       => 'Become a Sponsor - ' . config('app.name'),
            'description' => 'Put your brand in front of shoppers actively looking for deals. Sponsor a spot on ' . config('app.name') . '.',
        ];

        return view('pages.become-a-sponsor', compact('stats', 'sponsors', 'meta'));
    }

    private function averageSuccessRate(): int
    {
        $success = Coupon::sum('success_count');
        $failure = Coupon::sum('failure_count');
        $total   = $success + $failure;

        return $total > 0 ? (int) round(($success / $total) * 100) : 0;
    }
}
