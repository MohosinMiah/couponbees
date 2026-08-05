<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::with('store');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('store_id')) {
            $query->where('store_id', $request->store_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('verified')) {
            $query->where('is_verified', $request->verified);
        }

        $coupons = $query->latest()->paginate(15)->withQueryString();
        $stores  = Store::orderBy('name')->get(['id', 'name']);

        return view('admin.coupons.index', compact('coupons', 'stores'));
    }

    public function create(Request $request)
    {
        $stores     = Store::orderBy('name')->get(['id', 'name']);
        $selectedStore = $request->store_id;
        return view('admin.coupons.create', compact('stores', 'selectedStore'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'store_id'       => 'required|exists:stores,id',
            'title'          => 'required|string|max:255',
            'code'           => 'nullable|string|max:100',
            'description'    => 'nullable|string',
            'type'           => 'required|in:code,deal',
            'discount_value' => 'nullable|string|max:50',
            'discount_type'  => 'required|in:percentage,fixed,free_shipping,other',
            'expires_at'     => 'nullable|date|after_or_equal:today',
            'is_verified'    => 'nullable|boolean',
            'is_exclusive'   => 'nullable|boolean',
        ]);

        $data['is_verified']  = $request->boolean('is_verified');
        $data['is_exclusive'] = $request->boolean('is_exclusive');

        // deals don't have codes
        if ($data['type'] === 'deal') {
            $data['code'] = null;
        }

        $coupon = Coupon::create($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon "' . $coupon->title . '" created successfully.');
    }

    public function edit(Coupon $coupon)
    {
        $stores = Store::orderBy('name')->get(['id', 'name']);
        return view('admin.coupons.edit', compact('coupon', 'stores'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $data = $request->validate([
            'store_id'       => 'required|exists:stores,id',
            'title'          => 'required|string|max:255',
            'code'           => 'nullable|string|max:100',
            'description'    => 'nullable|string',
            'type'           => 'required|in:code,deal',
            'discount_value' => 'nullable|string|max:50',
            'discount_type'  => 'required|in:percentage,fixed,free_shipping,other',
            'expires_at'     => 'nullable|date',
            'is_verified'    => 'nullable|boolean',
            'is_exclusive'   => 'nullable|boolean',
        ]);

        $data['is_verified']  = $request->boolean('is_verified');
        $data['is_exclusive'] = $request->boolean('is_exclusive');

        if ($data['type'] === 'deal') {
            $data['code'] = null;
        }

        $coupon->update($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon "' . $coupon->title . '" updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        $title = $coupon->title;
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon "' . $title . '" deleted.');
    }

    public function resetStats(Coupon $coupon)
    {
        $coupon->update(['copy_count' => 0, 'success_count' => 0, 'failure_count' => 0]);
        return back()->with('success', 'Stats reset for "' . $coupon->title . '".');
    }
}
