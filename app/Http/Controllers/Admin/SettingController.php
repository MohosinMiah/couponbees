<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SettingController extends Controller
{
    private const DEFAULTS = [
        'homepage_trusted_count'           => 8,
        'homepage_popular_propfirms_count' => 12,
        'homepage_popular_brokers_count'   => 12,
        'homepage_best_coupons_count'      => 9,
    ];

    public function homepage()
    {
        $settings = collect(self::DEFAULTS)->mapWithKeys(
            fn ($default, $key) => [$key => Setting::get($key, $default)]
        );

        return view('admin.settings.homepage', compact('settings'));
    }

    public function updateHomepage(Request $request)
    {
        $request->validate([
            'homepage_trusted_count'           => 'required|integer|min:1|max:50',
            'homepage_popular_propfirms_count' => 'required|integer|min:1|max:50',
            'homepage_popular_brokers_count'   => 'required|integer|min:1|max:50',
            'homepage_best_coupons_count'      => 'required|integer|min:1|max:50',
        ]);

        foreach (array_keys(self::DEFAULTS) as $key) {
            Setting::set($key, $request->input($key));
        }

        return redirect()->route('admin.settings.homepage')
            ->with('success', 'Homepage settings updated successfully.');
    }
}
