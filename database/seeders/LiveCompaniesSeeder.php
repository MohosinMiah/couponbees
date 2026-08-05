<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class LiveCompaniesSeeder extends Seeder
{
    /**
     * Companies, sourced from the production `companies` table export
     * (coupvzga_couponterra). `ebc.com` and `ultimamarkets.com` are real
     * forex brokers (deposit-bonus offers); every other host here is a
     * proprietary trading firm.
     */
    private array $companies = [
        11   => ['FTMO', 'ftmo.com', 'propfirm'],
        12   => ['The Trading Pit', 'thetradingpit.com', 'propfirm'],
        56   => ['Bespoke Funding Program', 'bespokefundingprogram.com', 'propfirm'],
        58   => ['FX2 Funding', 'fx2funding.com', 'propfirm'],
        59   => ['FundedNext', 'fundednext.com', 'propfirm'],
        60   => ['Audacity Capital', 'audacitycapital.co.uk', 'propfirm'],
        61   => ['City Traders Imperium', 'citytradersimperium.com', 'propfirm'],
        62   => ['Fidelcrest', 'fidelcrest.com', 'propfirm'],
        63   => ['Skilled Funded Traders', 'skilledfundedtraders.com', 'propfirm'],
        64   => ['E8 Funding', 'e8funding.com', 'propfirm'],
        65   => ['Blue Guardian', 'blueguardian.com', 'propfirm'],
        66   => ['Alpha Capital Group', 'alphacapitalgroup.uk', 'propfirm'],
        67   => ['FXIFY', 'fxify.com', 'propfirm'],
        68   => ['Next Step Funded', 'nextstepfunded.com', 'propfirm'],
        69   => ['Blue Hedge Capital', 'bluehedgecap.com', 'propfirm'],
        70   => ['Rebels Funding', 'rebelsfunding.com', 'propfirm'],
        71   => ['FTUK', 'ftuk.com', 'propfirm'],
        73   => ['Top Tier Trader', 'toptiertrader.com', 'propfirm'],
        74   => ['Instant Funding', 'instantfunding.com', 'propfirm'],
        75   => ['MyFundedFX', 'myfundedfx.com', 'propfirm'],
        76   => ['Funded Engineer', 'fundedengineer.com', 'propfirm'],
        77   => ['Lux Trading Firm', 'luxtradingfirm.com', 'propfirm'],
        78   => ['Smart Prop Trader', 'smartproptrader.com', 'propfirm'],
        79   => ['SurgeTrader', 'surgetrader.com', 'propfirm'],
        80   => ['True Forex Funds', 'trueforexfunds.com', 'propfirm'],
        81   => ['Traders With Edge', 'traderswithedge.com', 'propfirm'],
        82   => ['Limitless Funding', 'limitlessfunding.io', 'propfirm'],
        83   => ['Infinity Forex Funds', 'infinityforexfunds.com', 'propfirm'],
        84   => ['Nova Funding', 'nova-funding.com', 'propfirm'],
        85   => ['TopOneTrader', 'toponetrader.com', 'propfirm'],
        86   => ['The Talented Trader', 'thetalentedtrader.com', 'propfirm'],
        87   => ['Next Level Funding', 'nextlevelfunding.co.uk', 'propfirm'],
        88   => ['Keeper Funded', 'keeperfunded.com', 'propfirm'],
        89   => ['Funded Choice', 'fundedchoice.com', 'propfirm'],
        90   => ['BFX Funding', 'bfxfunding.com', 'propfirm'],
        91   => ['RPF FX', 'rpffx.com', 'propfirm'],
        92   => ['Social Trading Club Funding', 'socialtradingclubfunding.com', 'propfirm'],
        93   => ['Fast Forex Funding', 'fastforexfunding.com', 'propfirm'],
        94   => ['ProTrade Funded', 'protradefunded.com', 'propfirm'],
        284  => ['Forex Prop Firm', 'forexpropfirm.com', 'propfirm'],
        661  => ['AscendX Capital', 'ascendxcapital.com', 'propfirm'],
        1674 => ['Tradicave', 'tradicave.com', 'propfirm'],
        1682 => ['Blueberry Funded', 'blueberryfunded.com', 'propfirm'],
        2254 => ['Seacrest Markets', 'seacrestmarkets.io', 'propfirm'],
        2257 => ['TX3 Funding', 'tx3funding.com', 'propfirm'],
        2258 => ['EBC', 'ebc.com', 'broker'],
        2259 => ['Ultima Markets', 'ultimamarkets.com', 'broker'],
    ];

    /**
     * Raw coupon rows from the production `coupons` table export, grouped
     * by company_id. Each row: [title, type('code'|'deal'), code, affiliate
     * url, discount, position]. Transcribed as-is from the live dump; the
     * one 'test' junk row (company 67) is omitted, and two mojibake
     * artifacts (" â " -> " - ", stray "ð") are cleaned inline. Duplicate
     * codes within a company are collapsed programmatically below (kept:
     * lowest position).
     */
    private array $rawCoupons = [
        11 => [
            ['Get Discount With FTMO', 'code', 'GAINPIPS', 'https://trader.fundedgain.com/challenges?affiliateId=PFA', '10', 100],
            ['UP TO 40% OFF DEALS', 'code', 'FTMO', 'https://trader.fundedgain.com/challenges?affiliateId=PFA', '40', 100],
            ['FTMO Black Friday 30% Off', 'code', 'BLACKFRIDAY', 'https://trader.fundedgain.com/challenges?affiliateId=PFA', '30', 100],
        ],
        12 => [
            ['Up to 10% Discount with The Trading Pit', 'code', 'GAINPIPS', 'https://www.thetradingpit.com?ref=rua', '10', 100],
            ['Get 10%', 'code', 'ABC', 'https://www.thetradingpit.com?ref=rua', '10', 100],
            ['Up to 20% Discount Code', 'code', 'SUMMERCHALLENGE2023', 'https://www.thetradingpit.com?ref=rua', '20', 100],
            ['The Trading Pit 20% Discount', 'code', 'WOJCHFMMJ5LPS0VWTAYG', 'https://www.thetradingpit.com?ref=rua', '20', 100],
            ['10% Discount Code with The Trading Pit', 'code', 'AKHAND10', 'https://www.thetradingpit.com?ref=rua', '10', 100],
            ['Get 10% off Any Trading Challenges', 'code', 'WARMUP30', 'https://www.thetradingpit.com?ref=rua', '10', 100],
            ['10% Off', 'code', 'BLACKFRIDAY2023', 'https://www.thetradingpit.com?ref=rua', '10', 100],
            ['25% Off', 'code', 'BLACKFRIDAY25', 'https://affiliate.thetradingpit.com/visit/?bta=7974&brand=thetradingpit', '25', 100],
            ['30% Off, Only November 30', 'code', 'BANANAS30', 'https://affiliate.thetradingpit.com/visit/?bta=7974&brand=thetradingpit', '30', 100],
            ['10% Off The Trading Pit Coupon Code', 'code', 'PFA', 'https://affiliate.thetradingpit.com/visit/?bta=7974&brand=thetradingpit', '10', 1],
        ],
        56 => [
            ['25% Off Bespoke Funding Program', 'code', 'APRIL', 'https://www.bespokefundingprogram.com/?ref=3948', '25', 100],
            ['Save 42% Off', 'code', 'FLASH42', 'https://www.bespokefundingprogram.com/?ref=3948', '42', 100],
            ['50% Off with 90% Profit Split', 'code', 'XMAS', 'https://www.bespokefundingprogram.com/?ref=3948', '50', 100],
        ],
        58 => [
            ['45% Off', 'code', 'CT45', 'https://fx2funding.com/', '45', 100],
            ['30% Off', 'code', 'TRADEPRO', 'https://fx2funding.com/', '30', 100],
        ],
        59 => [
            ['10% Off', 'code', 'STELLAR10', 'https://fundednext.com/?fpr=coupon84', '10', 100],
            ['30% Off + 85% Lifetime Payout + 15% Profit Share', 'code', 'INFINITY30', 'https://fundednext.com/?fpr=coupon84', '30', 100],
            ['10% Off, Fast Payout', 'code', 'DEALS', 'https://fundednext.com/?fpr=coupon84', '10', 100],
            ['25% Off Right Now', 'code', '15MAY', 'https://fundednext.com/?fpr=coupon84', '25', 1],
            ['Buy One Get One: Best FundedNext Coupon Code', 'code', 'PFA', 'https://www.fundedgain.com', '50', 7],
            ['120% Reward Refund on Passing the Challenge', 'code', 'PFA', 'https://www.fundedgain.com', '120', 1],
            ['20% More Refund Reward After Passing the Challenge', 'code', 'PFA', 'https://www.fundedgain.com', '20', 100],
            ['Exclusive 30% Off on All Futures Challenges', 'code', 'PFA', 'https://www.fundedgain.com', '30', 5],
            ['5% Discount Code for FundedNext Futures', 'code', 'PFA', 'https://www.fundedgain.com', '5', 6],
            ['First Purchase 15% Off with 200% Reward', 'code', 'GAIN', 'https://www.fundedgain.com', '200', 2],
            ['10% Off + 150% Reward for Existing Users', 'code', 'GAIN', 'https://www.fundedgain.com', '150', 3],
        ],
        60 => [
            ['Save with Audacity Capital', 'code', 'CELEBRATE', 'https://www.audacitycapital.co.uk/#aff=fundedtrading', '50', 100],
            ['Save Money with Audacity Capital', 'code', 'DREAM10', 'https://www.audacitycapital.co.uk/#aff=fundedtrading', '10', 100],
            ['Save with Audacity Capital', 'code', 'CTERRA', 'https://www.audacitycapital.co.uk/#aff=fundedtrading', '20', 100],
        ],
        61 => [
            ['Save with City Traders Imperium', 'code', '8f7d04', 'https://app.citytradersimperium.com/register?referral_code=8f7d04&utm_source=client&utm_medium=referral', '50', 100],
            ['Save Money with City Traders Imperium', 'code', 'ICTERRA', 'https://app.citytradersimperium.com/register?referral_code=8f7d04&utm_source=client&utm_medium=referral', '50', 100],
            ['15% Off Your Next Funded Account', 'code', 'LITCANDLES', 'https://app.citytradersimperium.com/register?referral_code=8f7d04&utm_source=client&utm_medium=referral', '15', 100],
        ],
        62 => [
            ['2 for 1: Save 50% Off, the Best Fidelcrest Coupon Code', 'code', 'INSTANT-2FOR1', 'https://trade.fidelcrest.com/log-in', '50', 100],
            ['15% Off All Account Purchases', 'code', 'ARCH15', 'https://trade.fidelcrest.com/log-in', '15', 100],
        ],
        63 => [
            ['12.5% Off Challenges', 'code', 'PALADIN', 'https://skilledfundedtraders.com', '12.5', 100],
            ['25% Off $25K-$100K, 10% Drawdown Accounts', 'code', 'WOMENSDAY25', 'https://skilledfundedtraders.com', '25', 100],
        ],
        64 => [
            ['10% Off, the Best E8 Funding Discount Code', 'code', 'FOREXPROPREVIEWS', 'https://e8markets.com/', '10', 100],
        ],
        65 => [
            ['10% Off, the Best Blue Guardian Discount Code', 'code', 'PROPFIRMS10', 'https://blueguardian.com/?afmc=PFA', '10', 100],
            ['40% Off 10K & 25K Accounts', 'code', 'SALE40', 'https://blueguardian.com/?afmc=PFA', '40', 100],
            ['40% Off Blue Guardian', 'code', 'JUNE', 'https://blueguardian.com/?afmc=PFA', '40', 100],
            ['30% Off All Challenges', 'code', 'BG30', 'https://blueguardian.com/?afmc=PFA', '30', 1],
            ['Save 30% on All Trading Challenges', 'code', 'BF30', 'https://blueguardian.com/?afmc=PFA', '30', 2],
            ['50% Off All Challenges', 'code', 'PFA', 'https://blueguardian.com/?afmc=PFA', '50', 1],
        ],
        66 => [
            ['Save with Alpha Capital Group', 'code', 'DFD9F', 'https://app.alphacapitalgroup.uk/signup/DFD9F', '50', 100],
            ['Save Money', 'code', 'TWENTY', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '50', 100],
            ['Save 50%', 'code', 'IRD50', 'https://app.alphacapitalgroup.uk/signup/DFD9F', '50', 100],
            ['Save 50% Off', 'code', 'CTERRA', 'https://app.alphacapitalgroup.uk/signup/DFD9F', '50', 1],
            ['Alpha Capital Group Discount Price', 'code', 'BBAEC', 'https://app.alphacapitalgroup.uk/signup/DFD9F', '45', 100],
            ['20% Discount', 'code', 'META50', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '20', 100],
            ['20% Discount for All Challenges', 'code', 'GAIN20', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '20', 100],
            ['Alpha Capital Group up to 50% Discount', 'code', 'C50', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '50', 1],
            ['More Discount with Alpha Capital Group', 'code', 'CTALPHA50', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '20', 100],
            ['Exclusive Savings with Alpha Capital Group', 'code', '50CTALPHA50', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '20', 100],
            ['Unlock Bigger Discounts at Alpha Capital Group', 'code', 'CTCAPITAL50', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '20', 100],
            ['Get More for Less with Alpha Capital Group', 'code', 'CTCAPITAL', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '20', 100],
            ['Enhanced Discounts Available at Alpha Capital Group', 'code', '50CT50', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '20', 100],
            ["Save More with Alpha Capital Group's Special Offers", 'code', 'CTCAPITALPRO50', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '20', 100],
            ['Alpha Capital Group: Where Bigger Discounts Begin', 'code', '50GD50', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '20', 100],
            ['Discover More Discounts at Alpha Capital Group', 'code', '50PRO50GD', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '20', 100],
            ['Boost Your Savings with Alpha Capital Group', 'code', 'CAPITALGD', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '20', 100],
            ['50% Off', 'code', 'PROPFIRM50', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '50', 100],
            ['50% Off', 'code', 'N50', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '50', 3],
            ['50% Off', 'code', 'AK50', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '50', 4],
            ['30% Off All Purchases', 'code', 'MENTALITY', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '30', 100],
            ['Enjoy 20% Off Across 1-Step, 2-Step & 3-Step Accounts', 'code', 'JAN20', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '20', 1],
            ['30% Off All Challenges', 'code', 'ONDEMAND', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '30', 1],
            ['Save 20% on All Evaluation Accounts', 'code', 'ALPHA20', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '20', 9],
            ['25% Off On-Demand Payout Option Only', 'code', 'ONDEMAND', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '25', 8],
            ['15% Off', 'code', 'ALPHA15', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '15', 3],
            ['$10K Accounts for Just $40', 'code', '10KFOR40', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '40', 4],
            ['25% Off On-Demand Pro Plan', 'code', 'ONDEMAND', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '25', 5],
            ['25% Off Alpha One Plan', 'code', '25ONE', 'https://app.alphacapitalgroup.uk/signup/COUPONTERRA', '25', 6],
        ],
        67 => [
            ['10% Discount Coupon Code', 'code', 'CTERRA', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '10', 100],
            ['Get Discount with FXIFY, 10% Off All Challenges', 'code', 'FXIFYONE', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '10', 100],
            ['Save 15% Off', 'code', '15FORYOU', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '15', 100],
            ['25% Off on 10K-50K Challenges', 'code', 'SUM25', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '25', 100],
            ['20% Off on 100K-400K Challenges', 'code', 'SUM20', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '20', 100],
            ['10% Off All Challenges', 'code', '4THJULY', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '10', 100],
            ['10% Discount on All FXIFY Challenges', 'code', 'WINORWIN', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '10', 100],
            ['Save 15% with FXIFY', 'code', 'AUGUST15', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '15', 100],
            ['Flash Offer with FXIFY', 'code', '15PLUS', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '15', 100],
            ['20% Off 10K-50K Challenges', 'code', 'SEPT20', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '20', 100],
            ['15% Off 100K-400K Challenges', 'code', 'SEPT15', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '15', 100],
            ['10% Off $10K-$50K Challenges + Free Bi-Weekly Payouts', 'code', 'CELEBRATE20M', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '10', 100],
            ['10% Off $100K-$400K Challenges + Free Bi-Weekly Payouts', 'code', 'CELEBRATE', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '10', 100],
            ['10% Off', 'code', 'ITRADI', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '10', 100],
            ['10% Off for All Challenges', 'code', 'CWFY', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '10', 100],
            ['10% Off with FXIFY, Best FXIFY Coupon Code', 'code', 'META01', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '10', 1],
            ['25% Off on $25K Challenges', 'code', 'X25X', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '25', 100],
            ['25% Off on All 3-Phase Programs', 'code', 'SPOOKY25', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '25', 100],
            ['15% Off on All 1-Phase & 2-Phase Programs', 'code', 'SPOOKY15', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '15', 100],
            ['15% Off Again', 'code', '15AGAIN', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '15', 100],
            ['15% Off 100K-400K Challenges', 'code', 'MOVE15', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '15', 100],
            ['20% Off 5K-50K Challenges', 'code', 'MOVE20', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '20', 100],
            ['FXIFY 28% Off Black Friday', 'code', 'BESTDEAL', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '28', 100],
            ['19% Off Total Purchase', 'code', 'FROSTY19', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '19', 100],
            ['30% Off, Only 15K Challenge', 'code', 'XMAS9', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '30', 100],
            ['Enjoy 25% Off on 5K-25K Evaluations', 'code', 'HAPPY2025', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '25', 100],
            ['25% Off', 'code', 'NEW2025', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '25', 100],
            ['20% Off', 'code', 'LUNCH20', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '20', 100],
            ['1-Phase & 3-Phase Evaluations, 28% Off Lunar New Year', 'code', 'LUNAR28', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '28', 100],
            ['29% Off', 'code', 'LOVETREAT', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '29', 100],
            ['Worth 19% Off', 'code', 'TRUST', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '19', 100],
            ['30% Off 3-Phase', 'code', '3THIRTY', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '30', 1],
            ['15% Off 1-Phase', 'code', 'ONE15', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '15', 1],
            ['15% Off Instant Funding', 'code', 'INSTANT15', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '15', 100],
            ['29% Discount on All FXIFY Evaluations', 'code', 'LUCKYDAY', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '29', 1],
            ['20% Off 1, 2 & 3-Phase Programs', 'code', 'EXP20', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '20', 1],
            ['25% Off All Accounts', 'code', 'GF25', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '25', 1],
            ['30% Off Instant Funding', 'code', 'FXIFY2', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '30', 1],
            ['20% Off 1, 2 & 3-Step Evaluations', 'code', 'EVAL2', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '20', 1],
            ['35% Off Instant Funding, Best FXIFY Discount Code', 'code', 'DADDY35', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '35', 6],
            ['Claim 25% Off Coupon Code', 'code', 'SUMMER25', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '25', 7],
            ['20% Off FXIFY Coupon Code', 'code', 'JULY4', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '20', 5],
            ['25% Off FXIFY Coupon Code', 'code', 'MIDSUMMER', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '25', 3],
            ['20% Off + 2 Free Addons, FXIFY Coupon Code', 'code', 'CHARTS', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '20', 2],
            ['15% Off FXIFY Coupon Code', 'code', 'PFA', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '15', 1],
            ['FXIFY 40% Off All Challenges', 'code', 'GOAL26', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '40', 100],
            ['26% Off All Programs', 'code', 'GOAL26', 'https://trader.fxify.com/purchasechallenge?affiliateId=4499', '26', 2],
        ],
        68 => [
            ['30% Off All Standard and HFT Challenges', 'code', 'NSF30OFF', 'https://nextstepfunded.com/ref/3513/', '30', 100],
            ['10% Off', 'code', 'DXB10', 'https://nextstepfunded.com/ref/3513/', '10', 100],
            ['40% Off with Next Step Funded', 'code', 'FLASH40', 'https://nextstepfunded.com/ref/3513/', '40', 100],
        ],
        70 => [
            ['25% Off All Trading Programs', 'code', 'SUMMER25', 'https://www.rebelsfunding.com/', '25', 100],
            ['12% Off', 'code', '07COMR', 'https://www.rebelsfunding.com/', '12', 100],
        ],
        71 => [
            ['Save Money with FTUK', 'code', 'MATCH30', 'https://ftuk.com/?ref=608', null, 100],
            ['FTUK 50% Off Everything', 'code', 'SPRING30', 'https://ftuk.com/?ref=608', '50', 1],
            ['Save 35% Off', 'code', 'SPRING35', 'https://ftuk.com/?ref=608', '35', 100],
            ['Get 35% Off & a 5% Payout Boost', 'code', 'SPRING30', 'https://ftuk.com/?ref=608', '35', 1],
            ['35% Off All Accounts + Free Level 7 Activation', 'code', 'SPRING30', 'https://ftuk.com/?ref=608', '35', 1],
        ],
        73 => [
            ['20% Discount with Top Tier Trader', 'code', 'k8zytp', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '20', 100],
            ['20% Discount with Top Tier Trader', 'code', 'jhe7uu', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '20', 100],
            ['25% Discount with Top Tier Trader', 'code', '8p82am', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '25', 1],
            ['10% Discount with Top Tier Trader', 'code', 'SAVE10', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '10', 100],
            ['25% Discount with TX3 Funding, All Challenges', 'code', 'FALL25', 'https://dashboard.fx.tx3funding.com/new-challenge?referral=AFR_283679AD54', '25', 1],
            ['Save 20%', 'code', 'NEWCUSTOMER', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '20', 100],
            ['Save Money', 'code', 'n31ppk', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '20', 100],
            ['Save with Top Tier Trader', 'code', 'TTMOM', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '20', 100],
            ['20% Off for All Challenges with Top Tier Trader', 'code', 'T1W6JG', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '20', 100],
            ['20% Off for All Challenges', 'code', 'WEBACK', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '20', 100],
            ['Dare to Be Great, Limited Time Discount Inside', 'code', 'DARETOBEGREAT', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '15', 100],
            ['25% Off', 'code', 'HBD25', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '25', 100],
            ['25% Off', 'code', 'TTBLACKFRIDAY', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '25', 100],
            ['20% Off', 'code', 'TT20', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '20', 100],
            ['10% Off, 85% Lifetime Payout', 'code', 'BEBOLD', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '10', 100],
            ['20% Off + 150% Refund + 90% Profit Split', 'code', 'DECEMBER20', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '20', 100],
            ['35% Off, Only 5K Challenge', 'code', 'JUNE5', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '35', 1],
            ['90% Lifetime Profit Split + 125% Refund', 'code', 'TOPTIERONLY', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '90', 100],
            ['25% Discount, Unwrap the Final', 'code', 'ONEPHASEHOLIDAY', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '25', 100],
            ['25% Off + 85% Payouts', 'code', 'TTHOLIDAY', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '25', 100],
            ['30% Off, Only 10K Challenge - Coupon Code', 'code', 'JUNE10', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '30', 1],
            ['Save 20% on 2-Phase Challenges and Keep 10% Profits', 'code', 'NEWYEAR20', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '20', 1],
            ['Save 15% + Get 90% Lifetime Profit Split', 'code', 'TRADEBIG15', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '15', 1],
            ['30% Off for Donald Trump', 'code', 'TRUMP30', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '30', 100],
            ['20% Off + BOGO, Buy One Get One Free', 'code', 'TTBOGO', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '50', 1],
            ['25% Off, Only 25K Challenge - Coupon Code', 'code', 'JUNE25', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '25', 1],
            ['20% Off, Only 50K Challenge - Coupon Code', 'code', 'JUNE50', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '20', 1],
            ['10% Off, Only 200K Challenge - Coupon Code', 'code', 'JUNE200', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '10', 1],
            ['10% Off, Only 300K Challenge - Coupon Code', 'code', 'JUNE300', 'https://app.toptiertrader.com/buy-challenge/?referral=8f5934f8', '10', 1],
            ['30% Off Top Tier Trader Flex and Pro Challenge', 'code', 'OCTCHOICEPRO', 'https://dashboard.fx.tx3funding.com/new-challenge?referral=AFR_283679AD54', '30', 1],
        ],
        74 => [
            ['Save Money', 'code', 'ottlz', 'https://instantfunding.io/', null, 100],
            ['30% Off Your Trading Fees', 'code', 'FIRST30', 'https://instantfunding.io/', '30', 100],
            ['10% Off Instant Funding', 'code', 'AFFDELTAFOXTROT', 'https://instantfunding.io?partner=1780', '10', 1],
            ['15% Off', 'code', 'PREPARE', 'https://instantfunding.io?partner=1780', '15', 100],
            ['30% Off', 'code', 'OURBEST', 'https://instantfunding.io?partner=1780', '30', 100],
            ['10% Off and Four Free Addons', 'code', 'BFBOOST', 'https://instantfunding.io?partner=1780', '10', 100],
            ['20% Off, Multi-Use Code', 'code', 'BF2090', 'https://instantfunding.io?partner=1780', '20', 100],
            ['50% Off Your First Instant Funding Account', 'code', 'GIFTPKC50', 'https://instantfunding.io?partner=1780', '50', 100],
            ['50% Off a Free Account of the Same Size', 'code', 'BOGO', 'https://instantfunding.io?partner=1780', '50', 100],
            ['20.25% Off Any Purchase, Kickstart the New Year', 'code', 'HAPPY2025', 'https://instantfunding.io?partner=1780', '23', 7],
            ['15% Off with Instant Funding', 'code', 'START15', 'https://instantfunding.io?partner=1780', '15', 6],
            ['Save 16.8% on Accounts, Enjoy a 90% Profit Split', 'code', 'LUNAR', 'https://instantfunding.io?partner=1780', '17', 5],
            ['Save 13.14% on Challenges, 90% Profit Split, No Min Days', 'code', 'SNAKE', 'https://instantfunding.io?partner=1780', '14', 3],
            ['15% Off Instant Funding', 'code', 'CTIF', 'https://instantfunding.io?partner=1780', '15', 4],
            ['18% Off All Products + 90% Profit Split', 'code', 'TERRA18', 'https://instantfunding.io?partner=1780', '18', 2],
            ['40% Off Instant Funding', 'code', 'FEB40', 'https://instantfunding.io?partner=1780', '40', 100],
            ['Unbelievable 25% Off Any Instant Funding Account', 'code', 'TRYIF25', 'https://instantfunding.io?partner=1780', '25', 100],
            ['12.5% Off Our Crypto Products', 'code', 'GOCRYPTO', 'https://instantfunding.io?partner=1780', '13', 1],
            ['20% Off', 'code', '50KSTRONG', 'https://instantfunding.io?partner=1780', '20', 100],
            ['15% Off Plus a Free 90% Profit Split Add-On', 'code', 'TY50K', 'https://instantfunding.io?partner=1780', '15', 100],
            ['50% Off All Clarity Products, Unlimited Usage', 'code', 'CLARITY50', 'https://instantfunding.io?partner=1780', '50', 1],
            ['50% Off Account Sizes up to $5K, New Customers Only', 'code', 'NEW50', 'https://instantfunding.io?partner=1780', '50', 1],
            ['40% Off All Micro Accounts, Including Two-Phase Micro', 'code', 'LEGEND40', 'https://instantfunding.io?partner=1780', '40', 1],
            ['35% Off Accounts up to $20K', 'code', 'STAR35', 'https://instantfunding.io?partner=1780', '35', 1],
            ['30% Off Accounts $20K to $100K', 'code', 'STAR30', 'https://instantfunding.io?partner=1780', '30', 1],
            ['20% Off Accounts Above $100K', 'code', 'STAR20', 'https://instantfunding.io?partner=1780', '20', 1],
            ['70% Off the IF Micro $5,000 Account, New Customers Only', 'code', 'IFM70', 'https://instantfunding.io?partner=1780', '70', 1],
        ],
        75 => [
            ['35% Off All Accounts Across the Website', 'code', 'MFFX9625', 'https://myfundedfx.tech/purchasechallenge/?sl=10243', '35', 100],
            ['30% Off', 'code', 'MFFX9624', 'https://myfundedfx.tech/purchasechallenge/?sl=10243', '30', 100],
            ['15% Off All Evaluation Accounts', 'code', 'MFFX8026', 'https://myfundedfx.tech/purchasechallenge/?sl=10243', '15', 100],
            ['12% Off', 'code', 'SEPT12', 'https://myfundedfx.tech/purchasechallenge/?sl=10243', null, 100],
            ['Save up to 20% Off', 'code', 'SAVECT', 'https://myfundedfx.tech/purchasechallenge/?sl=10243', '20', 1],
            ["Don't Miss Out! 20% on MyFundedFX Plans", 'code', 'SEPTEMBER20', 'https://myfundedfx.tech/purchasechallenge/?sl=10243', '20', 100],
            ['10% Off All MyFundedFX Accounts + Free One Day Pass', 'code', 'BESTDEALS30', 'https://myfundedfx.tech/purchasechallenge/?sl=10243', '10', 100],
            ['20% Off on All Plans', 'code', 'DECEMBER2024', 'https://myfundedfx.tech/purchasechallenge/?sl=10243', '20', 1],
            ['30% Off', 'code', 'MFFX30', 'https://myfundedfx.tech/purchasechallenge/?sl=10243', '30', 100],
        ],
        76 => [
            ['27.5% Off 100K-300K Accounts', 'code', 'FEB2', 'https://fundedengineer.com', '27.5', 100],
        ],
        77 => [
            ['Save Money with Lux Trading Firm', 'code', 'LUX', 'https://luxtradingfirm.com/?ref=843', '50', 100],
            ['10% Off', 'code', 'CTERRA', 'https://luxtradingfirm.com/?ref=843', '10', 100],
            ['5% Off', 'code', 'FUNDEDTRADING5', 'https://luxtradingfirm.com/?ref=843', '5', 100],
            ['20% Off', 'code', 'BEST', 'https://luxtradingfirm.com/?ref=843', '20', 100],
        ],
        78 => [
            ['27% Off Your Entire Order', 'code', 'FREEADDON', 'https://smartproptrader.com', '27', 100],
            ['10% Off', 'code', 'SPTVVS', 'https://smartproptrader.com', '10', 100],
        ],
        79 => [
            ['Save 50%', 'code', 'couponsterra', 'https://www.surgetrader.com/?afmc=31d&utm_campaign=31d&utm_source=leaddyno&utm_medium=affiliate', '50', 100],
            ['Save 20% Off', 'code', 'SAVE', 'https://www.surgetrader.com/?afmc=31d&utm_campaign=31d&utm_source=leaddyno&utm_medium=affiliate', '20', 100],
        ],
        80 => [
            ['True Forex Funds 50% Off', 'code', 'TRUE', 'https://trueforexfunds.com/#81437', '50', 100],
            ['5% Off', 'code', 'KIMMEL5', 'https://trueforexfunds.com/#81437', '5', 100],
        ],
        81 => [
            ['15% Off, the Best Traders With Edge Coupon Code', 'code', 'KINGABETRADES15', 'https://traderswithedge.com', '15', 100],
            ['15% Off at Store', 'code', 'JASPER15', 'https://traderswithedge.com', '15', 100],
        ],
        82 => [
            ['Save 50% Off', 'code', 'NOVEMBER', 'https://limitlessfunding.io', '50', 100],
            ['10% Off', 'code', 'INVEST', 'https://limitlessfunding.io', '10', 100],
        ],
        83 => [
            ['Save Money with Infinity Forex Funds', 'code', 'CTERRA', 'https://trading.infinityforexfunds.com/#a_aid=66356022b68ab', '15', 100],
            ['Save 50% Off', 'code', '50HFTLIMITED', 'https://trading.infinityforexfunds.com/#a_aid=66356022b68ab', '50', 100],
            ['Save 25% Off', 'code', '25ALGO', 'https://trading.infinityforexfunds.com/#a_aid=66356022b68ab', '25', 100],
            ['50% Off, the Best Infinity Forex Funds Coupon Code', 'code', 'HFT50LIMITED', 'https://trading.infinityforexfunds.com/#a_aid=66356022b68ab', '50', 100],
            ['20% Off', 'code', 'UNIQUE20', 'https://trading.infinityforexfunds.com/#a_aid=66356022b68ab', '20', 100],
        ],
        84 => [
            ['50% Off HFT Passing Service, the Best Nova Funding Code', 'code', 'HFT5', 'https://nova-funding.com', '50', 100],
            ['25% Off Purchase', 'code', 'CRYPTO25', 'https://nova-funding.com', '25', 100],
        ],
        85 => [
            ['Save 50% Off', 'code', 'LOCKER50', 'https://toponetrader.com/?linkId=lp_148658&sourceId=cterra&tenantId=toponetrader', '50', 100],
            ['35% Off All Trading Challenges', 'code', 'BONUSECAPITAL', 'https://toponetrader.com/?linkId=lp_148658&sourceId=cterra&tenantId=toponetrader', '35', 100],
            ['$10 Off Select Items', 'code', 'FATHERSDAY', 'https://toponetrader.com/?linkId=lp_148658&sourceId=cterra&tenantId=toponetrader', null, 100],
            ['New Year, New Deals: 52.5% Off Instant Funding Accounts', 'code', 'NEWYEAR', 'https://toponetrader.com/?linkId=lp_148658&sourceId=cterra&tenantId=toponetrader', '53', 1],
        ],
        87 => [
            ['15% Off Your Challenge Account', 'code', 'FIT', 'https://nextlevelfunding.co.uk', '15', 100],
            ['10% Off for First 30 Traders', 'code', 'NLF10', 'https://nextlevelfunding.co.uk', '10', 100],
        ],
        90 => [
            ['50% Off on Your First Payment', 'code', 'BFX50', 'https://bfxfunding.com/', '50', 100],
            ['30% Off Your BFX Challenge', 'code', 'BFX30', 'https://bfxfunding.com/', '30', 100],
        ],
        93 => [
            ['30% Off Any Challenge', 'code', 'BLUEFOREX', 'https://fastforexfunding.com', '30', 100],
            ['50% Off Your Challenge', 'code', 'RAMADAN', 'https://fastforexfunding.com', '50', 100],
        ],
        94 => [
            ['50% Off ProTrade Funded', 'code', 'SUMMER', 'https://protradefunded.com/ref/335/', '50', 100],
        ],
        284 => [
            ['50% Off Challenge, the Best Forex Prop Firm Coupon Code', 'code', 'AUGUST30', 'https://forexpropfirm.com/fpf/1348/', '50', 100],
            ['40% Off Challenge', 'code', 'FOREXPROPREVIEWS', 'https://forexpropfirm.com/fpf/1348/', '40', 100],
            ['Save 50% Off', 'code', 'MOTHER', 'https://forexpropfirm.com/fpf/1348/', '50', 100],
            ['Save 50% Off', 'code', '50', 'https://forexpropfirm.com/fpf/1348/', '50', 100],
            ['50% Off Everything', 'code', 'BOGO', 'https://forexpropfirm.com/fpf/1348/', '50', 100],
            ['50% Off', 'code', 'MANYMEN', 'https://forexpropfirm.com/fpf/1348/', '50', 100],
            ['50% Off + 150% Refund + 95% Profit Split', 'code', 'RTH', 'https://forexpropfirm.com/fpf/1348/', '50', 1],
            ['50% Off + 150% Refund + 95% Profit Split', 'code', 'CRYPTO', 'https://forexpropfirm.com/fpf/1348/', '50', 100],
        ],
        661 => [
            ['Save 30% Off', 'code', 'PROP30', 'https://app.ascendxcapital.com/signup/C15/', '30', 100],
            ['Save 50%', 'code', 'CTRADER50', 'https://app.ascendxcapital.com/signup/C15/', '50', 100],
        ],
        1674 => [
            ['30% Off Tradicave', 'code', 'DRAGON30', 'https://tradicave.com/?aff=443', '30', 100],
            ['50% Off 50K, 100K & 200K Challenges', 'code', 'GEMSTONE20', 'https://tradicave.com/?aff=443', '50', 100],
        ],
        1682 => [
            ['Save up to 30% on Your First Order', 'deal', null, 'https://blueberryfunded.com/?utm_source=affiliate&ref=67', '20', 100],
            ['Save 15% with Blueberry Funded', 'code', 'CTERRA', 'https://blueberryfunded.com/?utm_source=affiliate&ref=67', '15', 100],
            ['Blueberry Funded 15% Off', 'code', 'DIGGER', 'https://blueberryfunded.com/?utm_source=affiliate&ref=67', '10', 100],
            ['Blueberry Funded 20% Off All Challenges', 'code', 'WELCOME20', 'https://affiliates.blueberryfunded.com/Tracking/click/?affid=583&campaign=1834&product_id=1&t_type=HomePage&t_lang=EN', '20', 100],
            ['10% Off with Blueberry Funded', 'code', 'MINDEDTRADER', 'https://blueberryfunded.com/?utm_source=affiliate&ref=67', '10', 100],
            ['15% Off for All Challenges', 'code', 'SAVECT', 'https://affiliates.blueberryfunded.com/Tracking/click/?affid=583&campaign=1834&product_id=1&t_type=HomePage&t_lang=EN', '15', 4],
            ['10% Off', 'code', 'CART10', 'https://affiliates.blueberryfunded.com/Tracking/click/?affid=583&campaign=1834&product_id=1&t_type=HomePage&t_lang=EN', '10', 100],
            ['20% Off for All Blueberry Funded Challenges', 'code', 'BFCT20', 'https://affiliates.blueberryfunded.com/Tracking/click/?affid=583&campaign=1834&product_id=1&t_type=HomePage&t_lang=EN', '20', 3],
            ['20% Discount with Blueberry Funded', 'code', 'BERRY20', 'https://affiliates.blueberryfunded.com/Tracking/click/?affid=583&campaign=1834&product_id=1&t_type=HomePage&t_lang=EN', '20', 100],
            ['25% Off', 'code', 'CWBF', 'https://affiliates.blueberryfunded.com/Tracking/click/?affid=583&campaign=1834&product_id=1&t_type=HomePage&t_lang=EN', '25', 2],
            ['25% Off with Blueberry Funded, All Challenges', 'code', 'CT25', 'https://affiliates.blueberryfunded.com/Tracking/click/?affid=583&campaign=1834&product_id=1&t_type=HomePage&t_lang=EN', '25', 1],
            ['20% Off', 'code', 'CART20', 'https://affiliates.blueberryfunded.com/Tracking/click/?affid=583&campaign=1834&product_id=1&t_type=HomePage&t_lang=EN', '20', 100],
            ['25% Off Black Friday Deal', 'code', 'BLACKFRIDAY25', 'https://blueberryfunded.com/?utm_source=affiliate&ref=583', '25', 100],
            ['30% Off Black Friday Offer', 'code', 'BLACKFRIDAY30', 'https://affiliates.blueberryfunded.com/Tracking/click/?affid=583&campaign=1834&product_id=1&t_type=HomePage&t_lang=EN', '30', 100],
            ['30% Off + 10K Challenge Free', 'code', '10KCYBER', 'https://affiliates.blueberryfunded.com/Tracking/click/?affid=583&campaign=1834&product_id=1&t_type=HomePage&t_lang=EN', '30', 100],
            ['20% Off All Challenges for New Traders', 'code', 'BERRY20', 'https://affiliates.blueberryfunded.com/Tracking/click/?affid=583&campaign=1834&product_id=1&t_type=HomePage&t_lang=EN', '20', 100],
            ['25% Off', 'code', 'PFM25', 'https://affiliates.blueberryfunded.com/Tracking/click/?affid=583&campaign=1834&product_id=1&t_type=HomePage&t_lang=EN', null, 100],
            ['30% Off for a Limited Time', 'code', 'PRIMEXMAS', 'https://affiliates.blueberryfunded.com/Tracking/click/?affid=583&campaign=1834&product_id=1&t_type=HomePage&t_lang=EN', '30', 100],
            ['30% Off All Stock Challenges', 'code', 'PRIMEXMAS', 'https://affiliates.blueberryfunded.com/Tracking/click/?affid=583&campaign=1834&product_id=1&t_type=HomePage&t_lang=EN', '30', 100],
            ['Blueberry Funded 45% Off Instant, Use Code', 'code', 'LIMITED45', 'https://affiliates.blueberryfunded.com/Tracking/click/?affid=583&campaign=1834&product_id=1&t_type=HomePage&t_lang=EN', '45', 1],
            ['Blueberry Funded 30% Discounts', 'code', 'DIWALI30', 'https://affiliates.blueberryfunded.com/Tracking/click/?affid=583&campaign=1834&product_id=1&t_type=HomePage&t_lang=EN', '30', 3],
        ],
        2254 => [
            ['Save up to 20% Off', 'code', 'SAVECT', 'https://fundedtech.seacrestmarkets.io/purchasechallenge/?sl=10243', '20', 1],
            ['20% Off on All Plans', 'code', 'DECEMBER2024', 'https://fundedtech.seacrestmarkets.io/purchasechallenge/?sl=10243', '20', 2],
            ["Don't Miss Out! 20% on Seacrest Markets Plans", 'code', 'SEPTEMBER20', 'https://fundedtech.seacrestmarkets.io/purchasechallenge/?sl=10243', '20', 3],
            ['30% Off', 'code', 'MFFX30', 'https://fundedtech.seacrestmarkets.io/purchasechallenge/?sl=10243', '30', 4],
            ['12% Off', 'code', 'SEPT12', 'https://fundedtech.seacrestmarkets.io/purchasechallenge/?sl=10243', null, 7],
            ['10% Off All Accounts + Free One Day Pass', 'code', 'BESTDEALS30', 'https://fundedtech.seacrestmarkets.io/purchasechallenge/?sl=10243', '10', 6],
            ['35% Off All Accounts Across the Website', 'code', 'MFFX9625', 'https://fundedtech.seacrestmarkets.io/purchasechallenge/?sl=10243', '35', 5],
        ],
        2257 => [
            ['Best TX3 Funding Coupon for 35% Off All Challenges', 'code', 'PFASK', 'https://panel.tx3funding.com/register?referral_id=79a9f51d16e440949567', '35', 1],
            ['Best TX3 Funding Discount Code', 'code', 'AFFL_PFAFX', 'https://dashboard.fx.tx3funding.com/new-challenge?referral=AFR_283679AD54', '30', 2],
            ['35% Off Flex and Pro Challenges', 'code', 'AFFL_M50DY', 'https://dashboard.fx.tx3funding.com/new-challenge?referral=AFR_283679AD54', '35', 1],
        ],
        2258 => [
            ['EBC Up to 70% Deposit Bonus', 'deal', null, 'https://client.ebccrm.com/signup/B9883712-a01', '70', 1],
            ['EBC Discounts and Coupons', 'deal', null, 'https://client.ebccrm.com/signup/B9883712-a01', null, 2],
            ['EBC Voucher Code', 'deal', null, 'https://client.ebccrm.com/signup/B9883712-a01', null, 3],
            ['EBC Coupons and Promo Deals', 'deal', null, 'https://client.ebccrm.com/signup/B9883712-a01', null, 4],
        ],
        2259 => [
            ['Ultima Markets Up to 75% Deposit Bonus', 'deal', 'ZgYgu4a5', 'https://ultgo.com/la-com/ZgYgu4a5', '75', 1],
            ['Ultima Markets Voucher Code', 'deal', 'ZgYgu4a5', 'https://ultgo.com/la-com/ZgYgu4a5', '100', 2],
            ['Top Ultima Markets Discounts and Coupons', 'deal', 'ZgYgu4a5', 'https://ultgo.com/la-com/ZgYgu4a5', null, 3],
            ['Ultima Markets Coupons and Promo Deals', 'deal', 'ZgYgu4a5', 'https://ultgo.com/la-com/ZgYgu4a5', null, 4],
        ],
    ];

    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('coupon_histories')->truncate();
        DB::table('category_store')->truncate();
        Coupon::truncate();
        Store::truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($this->companies as $companyId => [$name, $host, $type]) {
            $rows = $this->dedupeByCode($this->rawCoupons[$companyId] ?? []);

            $store = Store::create([
                'name'         => $name,
                'slug'         => Str::slug($name),
                'company_type' => $type,
                'website'      => $this->pickAffiliateLink($rows) ?? 'https://' . $host,
                'description'  => $this->buildStoreDescription($name, $type, $rows),
                'details'      => $this->buildAeoDetails($name, $rows),
                'is_popular'   => count($rows) >= 5,
                'is_trusted'   => count($rows) >= 3,
                'page_views'   => 0,
            ]);

            foreach ($rows as $row) {
                [$title, $srcType, $code, , $discount, $position, $description] = $row + [6 => null];

                Coupon::create([
                    'store_id'       => $store->id,
                    'title'          => $title,
                    'code'           => $code,
                    'description'    => $description,
                    'type'           => $srcType === 'deal' ? 'deal' : 'code',
                    'discount_value' => $discount,
                    'discount_type'  => $discount !== null ? 'percentage' : 'other',
                    'position'       => $position ?? 100,
                    'is_verified'    => true,
                    'is_exclusive'   => false,
                    'copy_count'     => 0,
                    'success_count'  => 0,
                    'failure_count'  => 0,
                ]);
            }
        }
    }

    /**
     * One affiliate link per store, used for every coupon/deal button on
     * that store's page. The live dump had a per-coupon tracking URL, so
     * pick whichever URL is most common across that company's coupons
     * (ties broken by lowest/most prominent position).
     */
    private function pickAffiliateLink(array $rows): ?string
    {
        if (empty($rows)) {
            return null;
        }

        $counts = [];
        $bestPosition = [];

        foreach ($rows as $row) {
            $link = $row[3] ?? null;
            if (!$link) {
                continue;
            }
            $counts[$link] = ($counts[$link] ?? 0) + 1;
            $bestPosition[$link] = min($bestPosition[$link] ?? 100, $row[5] ?? 100);
        }

        if (empty($counts)) {
            return null;
        }

        uksort($counts, fn ($a, $b) => $counts[$b] <=> $counts[$a] ?: $bestPosition[$a] <=> $bestPosition[$b]);

        return array_key_first($counts);
    }

    /**
     * The live dump has many repeated codes per company (same promo synced
     * from multiple campaigns). Keep one row per unique code, preferring
     * the lowest (most prominent) position.
     */
    private function dedupeByCode(array $rows): array
    {
        $byCode = [];

        foreach ($rows as $row) {
            $key = $row[2] ?? $row[0]; // code, or title when there's no code (deal rows)
            $position = $row[5] ?? 100;

            if (!isset($byCode[$key]) || $position < ($byCode[$key][5] ?? 100)) {
                $byCode[$key] = $row;
            }
        }

        $result = array_values($byCode);
        usort($result, fn ($a, $b) => ($a[5] ?? 100) <=> ($b[5] ?? 100));

        return $result;
    }

    private function buildStoreDescription(string $name, string $type, array $rows): string
    {
        $top = collect($rows)->sortBy(fn ($r) => $r[5] ?? 100)->first();

        if (!$top) {
            return "This page contains the best {$name} coupon codes and deals, updated regularly. "
                . "New {$name} coupon codes are <strong>added and verified by our team as soon as they're released.</strong>";
        }

        $code = $top[2] ?? null;

        if ($code) {
            return "This page contains the best {$name} coupon code: <strong>{$code}</strong>. "
                . "<strong>Every {$name} discount code on this page has been manually verified by our team before being published.</strong>";
        }

        return "This page contains the best {$name} deals, including: <strong>{$top[0]}</strong>. "
            . "<strong>Every {$name} deal on this page has been manually verified by our team before being published.</strong>";
    }

    /**
     * Short AEO/GEO content block rendered in the store.details section,
     * right after the Activity Log on the store page. A direct Q&A pair
     * plus the top 3 offers only — written to be quoted verbatim by answer
     * engines / AI search for "{name} coupon code", "{name} discount code",
     * and "{name} promo code" queries, not as a full listing (the coupon
     * cards above already list everything).
     */
    private function buildAeoDetails(string $name, array $rows): ?string
    {
        if (empty($rows)) {
            return null;
        }

        $top3 = array_slice($rows, 0, 3);

        [$firstTitle, , $firstCode, , $firstDiscount] = $top3[0] + [4 => null];
        $bestLabel = $firstCode ?: $firstTitle;
        $bestAnswer = $firstDiscount !== null
            ? "The best {$name} coupon code is <strong>{$bestLabel}</strong> for {$firstDiscount}% off."
            : "The best {$name} coupon code is <strong>{$bestLabel}</strong>.";

        $listItems = collect($top3)->map(function ($row) {
            [$title, , $code, , $discount] = $row + [4 => null];
            $label = $code ?: 'Deal';
            $discountText = $discount !== null ? "{$discount}% off" : 'special offer';

            return "<li><strong>{$label}</strong> &mdash; {$title} ({$discountText})</li>";
        })->implode("\n                ");

        return <<<HTML
            <h2>{$name} Coupon Code, Discount Code &amp; Promo Code</h2>
            <p><strong>What is the best {$name} coupon code?</strong> {$bestAnswer}</p>
            <ul>
                {$listItems}
            </ul>
            <p>These are the top verified {$name} discount codes and {$name} promo codes today.</p>
            HTML;
    }
}
