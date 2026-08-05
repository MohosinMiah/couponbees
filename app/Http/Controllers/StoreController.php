<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Setting;
use App\Models\Store;
use App\Models\CouponHistory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function home()
    {
        $bestCoupons = Coupon::with('store')
            ->where('type', 'code')
            ->whereHas('store', fn ($q) => $q->where('company_type', 'propfirm'))
            ->orderByDesc('is_exclusive')
            ->orderByDesc('is_verified')
            ->orderByDesc('copy_count')
            ->limit(Setting::get('homepage_best_coupons_count', 9))
            ->get();

        $topPropfirms = Store::where('company_type', 'propfirm')
            ->where('is_trusted', true)
            ->withCount('coupons')
            ->orderByDesc('page_views')
            ->orderBy('name')
            ->limit(Setting::get('homepage_trusted_count', 8))
            ->get();

        $popularPropfirms = Store::where('company_type', 'propfirm')
            ->withCount('coupons')
            ->orderByDesc('is_popular')
            ->orderByDesc('page_views')
            ->orderBy('name')
            ->limit(Setting::get('homepage_popular_propfirms_count', 12))
            ->get();

        $popularBrokers = Store::where('company_type', 'broker')
            ->withCount('coupons')
            ->orderByDesc('is_popular')
            ->orderByDesc('page_views')
            ->orderBy('name')
            ->limit(Setting::get('homepage_popular_brokers_count', 12))
            ->get();

        $overallStats = [
            'stores'          => Store::count(),
            'coupons'         => Coupon::count(),
            'verifiedCoupons' => Coupon::where('is_verified', true)->count(),
            'pageViews'       => Store::sum('page_views'),
            'totalCopies'     => Coupon::sum('copy_count'),
            'successRate'     => $this->overallSuccessRate(),
        ];

        $meta = [
            'title'       => 'Prop Firm Coupon Codes & Broker Discounts ' . date('Y') . ' - ' . config('app.name'),
            'description' => 'Verified prop firm coupon codes and trusted broker discounts. Compare funded trading account discounts and forex broker deals, all in one place.',
        ];

        return view('home', compact('bestCoupons', 'topPropfirms', 'popularPropfirms', 'popularBrokers', 'overallStats', 'meta'));
    }

    private function overallSuccessRate(): int
    {
        $success = Coupon::sum('success_count');
        $failure = Coupon::sum('failure_count');
        $total   = $success + $failure;

        return $total > 0 ? (int) round(($success / $total) * 100) : 0;
    }

    public function show(Store $store)
    {
        // Increment page views
        $store->increment('page_views');

        $coupons = $store->coupons()
            ->orderBy('position')
            ->orderByDesc('is_exclusive')
            ->orderByDesc('is_verified')
            ->orderByDesc('created_at')
            ->get();

        $popularStores = Store::where('is_popular', true)
            ->where('id', '!=', $store->id)
            ->withCount('coupons')
            ->orderByDesc('page_views')
            ->limit(5)
            ->get();

        $histories = CouponHistory::where('store_id', $store->id)
            ->with('coupon')
            ->latest()
            ->limit(30)
            ->get();

        $totalCopies   = $store->coupons->sum('copy_count');
        $totalSuccess  = $store->coupons->sum('success_count');
        $totalFailure  = $store->coupons->sum('failure_count');
        $totalFeedback = $totalSuccess + $totalFailure;
        $successRate   = $totalFeedback > 0 ? round(($totalSuccess / $totalFeedback) * 100) : 0;

        $meta = [
            'title'       => $store->meta_title ?: $store->name . ' Coupons & Promo Codes ' . date('Y'),
            'description' => $store->meta_description ?: 'Find the latest ' . $store->name . ' coupon codes and deals. Save money with verified promo codes.',
        ];

        return view('stores.show', compact(
            'store', 'coupons', 'popularStores', 'histories',
            'totalCopies', 'totalSuccess', 'totalFailure', 'successRate', 'meta'
        ));
    }

    public function propfirms()
    {
        return $this->typeListing('propfirm');
    }

    public function brokers()
    {
        return $this->typeListing('broker');
    }

    private function typeListing(string $type)
    {
        $label = $type === 'propfirm' ? 'Prop Firms' : 'Brokers';

        $stores = Store::where('company_type', $type)
            ->withCount('coupons')
            ->orderBy('position')
            ->orderBy('name')
            ->paginate(20);

        $couponQuery = Coupon::whereHas('store', fn ($q) => $q->where('company_type', $type));

        $stats = [
            'stores'          => Store::where('company_type', $type)->count(),
            'coupons'         => (clone $couponQuery)->count(),
            'verifiedCoupons' => (clone $couponQuery)->where('is_verified', true)->count(),
            'pageViews'       => Store::where('company_type', $type)->sum('page_views'),
            'successRate'     => $this->typeSuccessRate($type),
        ];

        $meta = [
            'title'       => $label . ' - Coupon Codes & Promo Deals',
            'description' => 'Browse all ' . strtolower($label) . ' and find the best coupon codes and deals.',
        ];

        return view('stores.listing', compact('stores', 'type', 'label', 'stats', 'meta'));
    }

    private function typeSuccessRate(string $type): int
    {
        $success = Coupon::whereHas('store', fn ($q) => $q->where('company_type', $type))->sum('success_count');
        $failure = Coupon::whereHas('store', fn ($q) => $q->where('company_type', $type))->sum('failure_count');
        $total   = $success + $failure;

        return $total > 0 ? (int) round(($success / $total) * 100) : 0;
    }

    public function loadMore(Request $request)
    {
        $request->validate([
            'type' => 'required|in:propfirm,broker',
            'page' => 'nullable|integer|min:1',
        ]);

        $stores = Store::where('company_type', $request->type)
            ->withCount('coupons')
            ->orderBy('position')
            ->orderBy('name')
            ->paginate(20, ['*'], 'page', $request->input('page', 1));

        return response()->json([
            'html'     => view('stores.partials.store-cards', compact('stores'))->render(),
            'hasMore'  => $stores->hasMorePages(),
            'nextPage' => $stores->currentPage() + 1,
        ]);
    }

    public function search(Request $request)
    {
        $term = trim((string) $request->query('q', ''));

        if ($term === '') {
            return response()->json([]);
        }

        // Allow matching a pasted domain like "https://www.amazon.com/" against a
        // plain "amazon.com" website value (and vice versa).
        $domain = rtrim(preg_replace('#^https?://(www\.)?#i', '', $term), '/');

        $stores = Store::where(function ($query) use ($term, $domain) {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('slug', 'like', "%{$term}%")
                    ->orWhere('website', 'like', "%{$domain}%");
            })
            ->orderByDesc('is_popular')
            ->orderBy('name')
            ->limit(8)
            ->get(['name', 'slug', 'logo', 'description']);

        return response()->json($stores->map(function ($store) {
            return [
                'name'        => $store->name,
                'slug'        => $store->slug,
                'description' => Str::limit(strip_tags($store->description ?? ''), 80),
                'logo'        => $store->logo ? asset($store->logo) : null,
                'url'         => route('stores.show', $store->slug),
            ];
        }));
    }
}
