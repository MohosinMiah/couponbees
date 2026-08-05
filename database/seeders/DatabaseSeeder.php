<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\Coupon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $stores = [
            [
                'name'             => 'iFunds',
                'slug'             => 'ifunds',
                'website'          => 'https://ifunds.com',
                'description'      => 'iFunds is a leading investment platform offering smart financial tools and services.',
                'meta_title'       => 'iFunds Coupon Codes & Promo Codes 2025',
                'meta_description' => 'Get the latest iFunds coupon codes, promo codes and deals. Save money on your investments.',
                'is_popular'       => true,
                'page_views'       => 1240,
            ],
            [
                'name'             => 'Amazon',
                'slug'             => 'amazon',
                'website'          => 'https://amazon.com',
                'description'      => 'Amazon is the world\'s largest online retailer.',
                'meta_title'       => 'Amazon Coupon Codes & Promo Codes 2025',
                'meta_description' => 'Find the latest Amazon coupon codes and deals.',
                'is_popular'       => true,
                'page_views'       => 9800,
            ],
            [
                'name'             => 'Nike',
                'slug'             => 'nike',
                'website'          => 'https://nike.com',
                'description'      => 'Nike is a leading sportswear brand.',
                'meta_title'       => 'Nike Coupon Codes & Promo Codes 2025',
                'meta_description' => 'Save on Nike shoes and apparel with promo codes.',
                'is_popular'       => true,
                'page_views'       => 7500,
            ],
            [
                'name'             => 'Shopify',
                'slug'             => 'shopify',
                'website'          => 'https://shopify.com',
                'description'      => 'Shopify is an e-commerce platform for online stores.',
                'meta_title'       => 'Shopify Coupon Codes & Promo Codes 2025',
                'meta_description' => 'Get the best Shopify deals and promo codes.',
                'is_popular'       => true,
                'page_views'       => 5600,
            ],
            [
                'name'             => 'Udemy',
                'slug'             => 'udemy',
                'website'          => 'https://udemy.com',
                'description'      => 'Udemy is the world\'s largest online learning platform.',
                'meta_title'       => 'Udemy Coupon Codes & Promo Codes 2025',
                'meta_description' => 'Find Udemy promo codes and get courses for cheap.',
                'is_popular'       => true,
                'page_views'       => 4300,
            ],
        ];

        foreach ($stores as $storeData) {
            $store = Store::create($storeData);

            if ($store->slug === 'ifunds') {
                $coupons = [
                    [
                        'title'          => 'Get 20% Off Your First Investment',
                        'code'           => 'INVEST20',
                        'description'    => 'Use this exclusive code to get 20% off management fees on your first investment with iFunds.',
                        'type'           => 'code',
                        'discount_value' => '20',
                        'discount_type'  => 'percentage',
                        'expires_at'     => '2025-12-31',
                        'is_verified'    => true,
                        'is_exclusive'   => true,
                        'copy_count'     => 145,
                        'success_count'  => 98,
                        'failure_count'  => 12,
                    ],
                    [
                        'title'          => 'Free Premium Plan for 3 Months',
                        'code'           => 'FREE3MONTHS',
                        'description'    => 'Sign up today and enjoy 3 months of the premium plan absolutely free.',
                        'type'           => 'code',
                        'discount_value' => null,
                        'discount_type'  => 'other',
                        'expires_at'     => '2025-09-30',
                        'is_verified'    => true,
                        'is_exclusive'   => false,
                        'copy_count'     => 87,
                        'success_count'  => 61,
                        'failure_count'  => 8,
                    ],
                    [
                        'title'          => '$50 Bonus on First Deposit',
                        'code'           => 'BONUS50',
                        'description'    => 'Deposit $500 or more and receive a $50 bonus credited to your account.',
                        'type'           => 'code',
                        'discount_value' => '50',
                        'discount_type'  => 'fixed',
                        'expires_at'     => '2025-08-31',
                        'is_verified'    => true,
                        'is_exclusive'   => false,
                        'copy_count'     => 203,
                        'success_count'  => 150,
                        'failure_count'  => 25,
                    ],
                    [
                        'title'          => 'No Management Fees for 6 Months',
                        'code'           => 'NOFEES6',
                        'description'    => 'New investors get 6 months with zero management fees.',
                        'type'           => 'code',
                        'discount_value' => null,
                        'discount_type'  => 'free_shipping',
                        'expires_at'     => null,
                        'is_verified'    => true,
                        'is_exclusive'   => true,
                        'copy_count'     => 312,
                        'success_count'  => 240,
                        'failure_count'  => 18,
                    ],
                    [
                        'title'          => '15% Off Annual Subscription',
                        'code'           => 'ANNUAL15',
                        'description'    => 'Switch to annual billing and save 15% on your iFunds subscription.',
                        'type'           => 'code',
                        'discount_value' => '15',
                        'discount_type'  => 'percentage',
                        'expires_at'     => '2025-12-31',
                        'is_verified'    => false,
                        'is_exclusive'   => false,
                        'copy_count'     => 56,
                        'success_count'  => 30,
                        'failure_count'  => 15,
                    ],
                    [
                        'title'          => 'Refer a Friend and Both Get $25',
                        'code'           => null,
                        'description'    => 'Refer a friend to iFunds. When they make their first deposit, you both get $25 credited.',
                        'type'           => 'deal',
                        'discount_value' => '25',
                        'discount_type'  => 'fixed',
                        'expires_at'     => null,
                        'is_verified'    => true,
                        'is_exclusive'   => false,
                        'copy_count'     => 0,
                        'success_count'  => 0,
                        'failure_count'  => 0,
                    ],
                ];

                foreach ($coupons as $couponData) {
                    $couponData['store_id'] = $store->id;
                    Coupon::create($couponData);
                }
            } else {
                // Generic coupons for other stores
                for ($i = 1; $i <= 3; $i++) {
                    Coupon::create([
                        'store_id'       => $store->id,
                        'title'          => $i * 10 . '% Off Sitewide',
                        'code'           => strtoupper($store->slug) . $i * 10,
                        'description'    => 'Get ' . $i * 10 . '% off your entire order.',
                        'type'           => 'code',
                        'discount_value' => (string)($i * 10),
                        'discount_type'  => 'percentage',
                        'expires_at'     => '2025-12-31',
                        'is_verified'    => true,
                        'is_exclusive'   => $i === 1,
                        'copy_count'     => rand(20, 200),
                        'success_count'  => rand(10, 150),
                        'failure_count'  => rand(0, 20),
                    ]);
                }
            }
        }
    }
}
