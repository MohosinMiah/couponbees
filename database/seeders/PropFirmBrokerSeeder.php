<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropFirmBrokerSeeder extends Seeder
{
    /**
     * This site is scoped to prop firms and brokers only. Remove the
     * leftover generic e-commerce demo stores so "All Stores" only
     * contains the two relevant company types, then seed a full
     * propfirm + broker catalogue (20 of each) with demo coupons.
     *
     * NOTE: websites, coupon codes, and discount amounts below are
     * demo/placeholder data for a set of real, well-known industry
     * names — verify and replace with real affiliate links and actual
     * live offers before this goes to production.
     */
    public function run(): void
    {
        Store::whereIn('slug', ['amazon', 'nike', 'shopify', 'udemy'])->delete();

        Store::where('slug', 'ifunds')->update(['company_type' => 'propfirm']);

        $propfirms = [
            'FTMO'                    => 'https://ftmo.com',
            'Apex Trader Funding'     => 'https://apextraderfunding.com',
            'Topstep'                 => 'https://topstep.com',
            'Earn2Trade'              => 'https://earn2trade.com',
            'Bulenox'                 => 'https://bulenox.com',
            'FundedNext'              => 'https://fundednext.com',
            'The5ers'                 => 'https://the5ers.com',
            'SurgeTrader'             => 'https://surgetrader.com',
            'E8 Markets'              => 'https://e8markets.com',
            'Blue Guardian'           => 'https://blueguardian.com',
            'Goat Funded Trader'      => 'https://goatfundedtrader.com',
            'City Traders Imperium'   => 'https://citytradersimperium.com',
            'Trade The Pool'          => 'https://tradethepool.com',
            'Think Capital'           => 'https://thinkcapital.com',
            'FXIFY'                   => 'https://fxify.com',
            'Instant Funding'         => 'https://instantfunding.com',
            'DNA Funded'              => 'https://dnafunded.com',
            'Funder Pro'              => 'https://funderpro.com',
            'Alpha Capital'           => 'https://alphacapitalgroup.uk',
        ];

        $brokers = [
            'IC Markets'          => 'https://icmarkets.com',
            'Pepperstone'         => 'https://pepperstone.com',
            'XM'                  => 'https://xm.com',
            'FP Markets'          => 'https://fpmarkets.com',
            'Exness'              => 'https://exness.com',
            'OANDA'               => 'https://oanda.com',
            'FXTM'                => 'https://fxtm.com',
            'AvaTrade'            => 'https://avatrade.com',
            'IG'                  => 'https://ig.com',
            'Interactive Brokers' => 'https://interactivebrokers.com',
            'eToro'               => 'https://etoro.com',
            'Plus500'             => 'https://plus500.com',
            'Vantage Markets'     => 'https://vantagemarkets.com',
            'HFM'                 => 'https://hfm.com',
            'Tickmill'            => 'https://tickmill.com',
            'FBS'                 => 'https://fbs.com',
            'RoboForex'           => 'https://roboforex.com',
            'Axi'                 => 'https://axi.com',
            'BlackBull Markets'   => 'https://blackbullmarkets.com',
            'OspreyFX'            => 'https://ospreyfx.com',
        ];

        $this->seedCompanies($propfirms, 'propfirm');
        $this->seedCompanies($brokers, 'broker');
    }

    private function seedCompanies(array $companies, string $type): void
    {
        $discounts = [10, 15, 20, 25, 30];
        $i = 0;

        foreach ($companies as $name => $website) {
            $slug = Str::slug($name);

            if (Store::where('slug', $slug)->exists()) {
                continue;
            }

            $discount = $discounts[$i % count($discounts)];
            $isPopular = $i % 2 === 0;
            $isExclusive = $i % 3 === 0;
            $codePrefix = strtoupper(Str::slug(explode(' ', $name)[0]));

            $store = Store::create([
                'name'         => $name,
                'slug'         => $slug,
                'company_type' => $type,
                'website'      => $website,
                'description'  => $type === 'propfirm'
                    ? "{$name} is a proprietary trading firm offering funded trading accounts and profit-split payouts to qualifying traders."
                    : "{$name} is a forex and CFD broker offering trading accounts, tight spreads, and a range of tradable instruments.",
                'is_popular'   => $isPopular,
                'page_views'   => rand(150, 4200),
            ]);

            $codeSuccess = rand(40, 320);
            $codeFailure = rand(2, 40);

            Coupon::create([
                'store_id'       => $store->id,
                'title'          => $type === 'propfirm'
                    ? "{$discount}% Off Your Challenge Fee"
                    : "{$discount}% Off Trading Fees",
                'code'           => $codePrefix . $discount,
                'description'    => $type === 'propfirm'
                    ? "Use this code to save {$discount}% on any evaluation challenge at {$name}."
                    : "Use this code to reduce trading fees by {$discount}% when you open an account with {$name}.",
                'type'           => 'code',
                'discount_value' => (string) $discount,
                'discount_type'  => 'percentage',
                'is_verified'    => $i % 5 !== 4,
                'is_exclusive'   => $isExclusive,
                'copy_count'     => $codeSuccess + $codeFailure + rand(0, 50),
                'success_count'  => $codeSuccess,
                'failure_count'  => $codeFailure,
            ]);

            $dealSuccess = rand(15, 150);
            $dealFailure = rand(1, 20);

            Coupon::create([
                'store_id'       => $store->id,
                'title'          => $type === 'propfirm'
                    ? 'Free Retry on a Failed Challenge'
                    : 'Zero Commission on Standard Accounts',
                'code'           => null,
                'description'    => $type === 'propfirm'
                    ? "New traders at {$name} get one free retry if their first challenge attempt fails."
                    : "Open a standard account with {$name} and trade commission-free on select instruments.",
                'type'           => 'deal',
                'discount_value' => null,
                'discount_type'  => 'other',
                'is_verified'    => true,
                'is_exclusive'   => false,
                'copy_count'     => $dealSuccess + $dealFailure,
                'success_count'  => $dealSuccess,
                'failure_count'  => $dealFailure,
            ]);

            $i++;
        }
    }
}
