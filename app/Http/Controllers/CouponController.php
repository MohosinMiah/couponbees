<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CouponHistory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CouponController extends Controller
{
    /**
     * Record copy action and return code
     */
    public function copy(Request $request, Coupon $coupon)
    {
        $coupon->increment('copy_count');

        CouponHistory::create([
            'coupon_id'    => $coupon->id,
            'store_id'     => $coupon->store_id,
            'coupon_code'  => $coupon->code,
            'coupon_title' => $coupon->title,
            'action'       => 'copy',
            'ip_address'   => $request->ip(),
            'user_agent'   => substr($request->userAgent() ?? '', 0, 255),
        ]);

        return response()->json([
            'success'      => true,
            'code'         => $coupon->code,
            'couponTitle'  => $coupon->title,
            'message'      => 'Code copied!',
        ]);
    }

    /**
     * Record feedback (success or failure)
     */
    public function feedback(Request $request, Coupon $coupon)
    {
        $request->validate(['worked' => 'required|boolean']);

        $worked = $request->boolean('worked');

        if ($worked) {
            $coupon->increment('success_count');
            $action = 'success';
        } else {
            $coupon->increment('failure_count');
            $action = 'failure';
        }

        CouponHistory::create([
            'coupon_id'    => $coupon->id,
            'store_id'     => $coupon->store_id,
            'coupon_code'  => $coupon->code,
            'coupon_title' => $coupon->title,
            'action'       => $action,
            'ip_address'   => $request->ip(),
            'user_agent'   => substr($request->userAgent() ?? '', 0, 255),
        ]);

        // Reload fresh counts from DB
        $coupon->refresh();

        $total = $coupon->success_count + $coupon->failure_count;
        $rate  = $total > 0 ? round(($coupon->success_count / $total) * 100) : 0;

        return response()->json([
            'success'      => true,
            'worked'       => $worked,
            'couponTitle'  => $coupon->title,
            'successCount' => $coupon->success_count,
            'failureCount' => $coupon->failure_count,
            'successRate'  => $rate,
            'message'      => $worked
                ? 'Great! Thanks for the feedback.'
                : "Sorry it didn't work. Thanks for letting us know.",
        ]);
    }
}
