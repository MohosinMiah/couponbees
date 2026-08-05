@extends('layouts.app')

@section('meta_title', $meta['title'])
@section('meta_description', $meta['description'])

@section('content')

<section class="sp-hero">
    <div class="container">
        <div class="sp-hero-eyebrow"><i class="bi bi-stars"></i> Partner With {{ config('app.name') }}</div>
        <h1>Reach shoppers who are ready to <em>save</em></h1>
        <p class="sp-hero-sub">
            {{ config('app.name') }} is where deal-seekers come to find a verified coupon code before they buy.
            Put your brand and your best offer in front of shoppers who are already looking for a reason to click "Buy Now."
        </p>
        <div class="sp-stats">
            <div><div class="sp-stat-num">{{ $stats['stores'] }}+</div><div class="sp-stat-lbl">Stores listed</div></div>
            <div><div class="sp-stat-num">{{ $stats['coupons'] }}+</div><div class="sp-stat-lbl">Coupons tracked</div></div>
            <div><div class="sp-stat-num">{{ number_format($stats['pageViews']) }}</div><div class="sp-stat-lbl">Store page views</div></div>
            <div><div class="sp-stat-num">{{ $stats['successRate'] }}%</div><div class="sp-stat-lbl">Coupon success rate</div></div>
        </div>
    </div>
</section>

<section class="sp-pricing-section" id="pricing">
    <div class="container" style="max-width:1240px">

        <div class="text-center">
            <div class="sp-pricing-label">✦ Sponsorship Packages</div>
            <h2 class="sp-pricing-title">Choose your sponsorship plan</h2>
            <p class="sp-pricing-sub">Transparent pricing. Real placements. Cancel monthly plans anytime.</p>
        </div>

        <div class="billing-toggle-wrap">
            <div class="billing-pill">
                <button class="billing-opt active" id="btnMonthly" onclick="setBilling('monthly')" type="button">Monthly</button>
                <button class="billing-opt" id="btnYearly" onclick="setBilling('yearly')" type="button">Yearly</button>
            </div>
            <span class="billing-discount-tag" id="discountTag" style="display:none">
                <i class="bi bi-tag-fill me-1"></i>15% off
            </span>
        </div>

        <div class="pkg-grid">

            <div class="pkg-card pkg-free">
                <div class="pkg-free-tag">Free Enlistment</div>
                <div class="pkg-name">Free</div>
                <div class="pkg-desc">List your store at no cost. Claim your profile and manage your own coupons.</div>

                <div class="pkg-price-row">
                    <span class="pkg-price-amount">$0</span>
                    <span class="pkg-price-period">/forever</span>
                </div>
                <div class="pkg-billing-note">No credit card required</div>

                <hr class="pkg-divider">

                <ul class="pkg-features">
                    <li><span class="pf-on">✓</span> <span><strong>Claim your store's profile</strong> &amp; manage your coupons</span></li>
                    <li><span class="pf-on">✓</span> <span>Eligible for a verified badge</span></li>
                    <li><span class="pf-off">—</span> <span>Logo in sponsor bar</span></li>
                    <li><span class="pf-off">—</span> <span>Featured category placement</span></li>
                    <li><span class="pf-off">—</span> <span>Homepage feature slot</span></li>
                    <li><span class="pf-off">—</span> <span>Exclusive homepage placement</span></li>
                    <li><span class="pf-off">—</span> <span>Dedicated spotlight write-up</span></li>
                </ul>

                <a href="#contact" class="pkg-cta pkg-cta-default">List Your Store →</a>
            </div>

            <div class="pkg-card">
                <div class="pkg-name">Starter</div>
                <div class="pkg-desc">Get your brand in front of every visitor from day one, site-wide.</div>

                <div class="pkg-price-row">
                    <span class="pkg-price-amount" id="amount1">$99</span>
                    <span class="pkg-price-period">/mo</span>
                </div>
                <div class="pkg-billing-note" id="note1">Billed monthly · cancel anytime</div>
                <div class="pkg-annual-box" id="annual1">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    $1,010 billed annually &nbsp;·&nbsp; <strong>Save $178 / year</strong>
                </div>

                <hr class="pkg-divider">

                <ul class="pkg-features">
                    <li><span class="pf-on">✓</span> <span><strong>Logo in rotating sponsor bar</strong></span></li>
                    <li><span class="pf-on">✓</span> <span>Verified badge on store page</span></li>
                    <li><span class="pf-on">✓</span> <span>Featured placement in 1 category</span></li>
                    <li><span class="pf-off">—</span> <span>Homepage feature slot</span></li>
                    <li><span class="pf-off">—</span> <span>Exclusive homepage placement</span></li>
                    <li><span class="pf-off">—</span> <span>Dedicated spotlight write-up</span></li>
                </ul>

                <a href="#contact" class="pkg-cta pkg-cta-default">Contact Us →</a>
            </div>

            <div class="pkg-card pkg-featured">
                <div class="pkg-pop-badge">Most Popular</div>
                <div class="pkg-name">Featured</div>
                <div class="pkg-desc">Be present at every decision point — browsing, searching, comparing deals.</div>

                <div class="pkg-price-row">
                    <span class="pkg-price-amount" id="amount2">$199</span>
                    <span class="pkg-price-period">/mo</span>
                </div>
                <div class="pkg-billing-note" id="note2">Billed monthly · cancel anytime</div>
                <div class="pkg-annual-box" id="annual2">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    $2,030 billed annually &nbsp;·&nbsp; <strong>Save $358 / year</strong>
                </div>

                <hr class="pkg-divider">

                <ul class="pkg-features">
                    <li><span class="pf-on">✓</span> <span><strong>Logo in rotating sponsor bar</strong></span></li>
                    <li><span class="pf-on">✓</span> <span>Verified badge on store page</span></li>
                    <li><span class="pf-on">✓</span> <span>Featured placement across categories</span></li>
                    <li><span class="pf-on">✓</span> <span>Homepage feature slot</span></li>
                    <li><span class="pf-off">—</span> <span>Exclusive homepage placement</span></li>
                    <li><span class="pf-off">—</span> <span>Dedicated spotlight write-up</span></li>
                </ul>

                <a href="#contact" class="pkg-cta pkg-cta-primary">Contact Us →</a>
            </div>

            <div class="pkg-card">
                <div class="pkg-name">Exclusive</div>
                <div class="pkg-desc">Maximum coverage across every high-traffic page. Own the spotlight.</div>

                <div class="pkg-price-row">
                    <span class="pkg-price-amount" id="amount3">$349</span>
                    <span class="pkg-price-period">/mo</span>
                </div>
                <div class="pkg-billing-note" id="note3">Billed monthly · cancel anytime</div>
                <div class="pkg-annual-box" id="annual3">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    $3,560 billed annually &nbsp;·&nbsp; <strong>Save $628 / year</strong>
                </div>

                <hr class="pkg-divider">

                <ul class="pkg-features">
                    <li><span class="pf-on">✓</span> <span><strong>Logo in rotating sponsor bar</strong></span></li>
                    <li><span class="pf-on">✓</span> <span>Verified badge on store page</span></li>
                    <li><span class="pf-on">✓</span> <span>Featured placement across categories</span></li>
                    <li><span class="pf-on">✓</span> <span>Homepage feature slot <strong>(exclusive)</strong></span></li>
                    <li><span class="pf-on">✓</span> <span>Dedicated spotlight write-up on your store page</span></li>
                </ul>

                <a href="#contact" class="pkg-cta pkg-cta-dark">Contact Us →</a>
            </div>

        </div>

        <div class="sp-reassurance">
            <span><i class="bi bi-shield-check"></i> No lock-in on monthly plans</span>
            <span><i class="bi bi-lightning-charge"></i> Setup within 48 hours</span>
            <span><i class="bi bi-graph-up-arrow"></i> Monthly performance report</span>
            <span><i class="bi bi-envelope"></i> Dedicated account contact</span>
        </div>

    </div>
</section>

<section class="sp-benefits">
    <div class="container" style="max-width:820px">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="font-size:1.35rem;color:#0f172a">Why sponsor {{ config('app.name') }}?</h2>
        </div>
        <div class="row g-0">
            <div class="col-md-6">
                <div class="benefit-item">
                    <div class="benefit-icon">🎯</div>
                    <div>
                        <div class="benefit-title">High-intent shoppers</div>
                        <div class="benefit-text">Our visitors are actively looking for a coupon before they buy — not browsing casually. Your offer reaches people ready to convert.</div>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">📈</div>
                    <div>
                        <div class="benefit-title">Growing traffic, no waste</div>
                        <div class="benefit-text">{{ $stats['stores'] }}+ stores and {{ $stats['coupons'] }}+ coupons tracked and growing. Every visitor is comparing deals like yours.</div>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">🔗</div>
                    <div>
                        <div class="benefit-title">SEO backlink included</div>
                        <div class="benefit-text">Your store page on {{ config('app.name') }} ranks in search results. Sponsorship adds extra editorial links back to your site.</div>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">🏷️</div>
                    <div>
                        <div class="benefit-title">Prime sponsor bar placement</div>
                        <div class="benefit-text">Your logo rotates in the sponsor bar at the very top of every page — seen by every single visitor before they scroll.</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="benefit-item">
                    <div class="benefit-icon">✍️</div>
                    <div>
                        <div class="benefit-title">Editorial transparency</div>
                        <div class="benefit-text">Sponsorship is clearly labelled — our visitors trust our coupon listings because we're upfront about partnerships.</div>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">💬</div>
                    <div>
                        <div class="benefit-title">Real user feedback</div>
                        <div class="benefit-text">Every coupon gets a "Worked" / "Didn't Work" vote from real shoppers, so your offers build authentic trust from day one.</div>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">📊</div>
                    <div>
                        <div class="benefit-title">Transparent monthly reports</div>
                        <div class="benefit-text">Every sponsor gets a monthly report — page views, copy clicks, and success rate for your listing. No black boxes, just clear numbers.</div>
                    </div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">🚀</div>
                    <div>
                        <div class="benefit-title">Fast setup</div>
                        <div class="benefit-text">Get your logo live in the sponsor bar within 48 hours of signing up. No long onboarding, no waiting.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="sp-current">
    <div class="container" style="max-width:820px; text-align:center">
        <p class="text-muted small fw-semibold mb-4" style="letter-spacing:.06em;text-transform:uppercase;font-size:.68rem">
            Current sponsors
        </p>
        <div class="row g-3 justify-content-center">
            @foreach($sponsors as $sponsor)
            <div class="col-6 col-sm-4 col-md-3">
                <a href="{{ $sponsor->link }}" class="sp-current-card text-decoration-none" target="_blank" rel="noopener noreferrer">
                    <span class="sp-current-name">{{ $sponsor->name }}</span>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="sp-contact" id="contact">
    <div class="container">
        <h2>Ready to partner with us?</h2>
        <p>Send us a message and we'll get back to you within 1 business day.</p>
        <a href="mailto:{{ \App\Http\Controllers\ContactController::EMAIL }}?subject=Sponsorship%20Inquiry" class="sp-contact-btn">
            <i class="bi bi-envelope"></i> Get in Touch
        </a>
    </div>
</section>

@endsection

@push('scripts')
<script>
    var billingPrices = {
        1: { monthly: 99,  yearly: 1010 },
        2: { monthly: 199, yearly: 2030 },
        3: { monthly: 349, yearly: 3560 }
    };

    function setBilling(mode) {
        document.getElementById('btnMonthly').classList.toggle('active', mode === 'monthly');
        document.getElementById('btnYearly').classList.toggle('active', mode === 'yearly');
        document.getElementById('discountTag').style.display = mode === 'yearly' ? 'inline-flex' : 'none';

        [1, 2, 3].forEach(function (i) {
            var amountEl = document.getElementById('amount' + i);
            var noteEl   = document.getElementById('note' + i);
            var annualEl = document.getElementById('annual' + i);
            var periodEl = amountEl.nextElementSibling;

            if (mode === 'yearly') {
                amountEl.textContent = '$' + Math.round(billingPrices[i].yearly / 12);
                periodEl.textContent = '/mo';
                noteEl.textContent = 'Billed yearly · cancel anytime';
                annualEl.classList.add('show');
            } else {
                amountEl.textContent = '$' + billingPrices[i].monthly;
                periodEl.textContent = '/mo';
                noteEl.textContent = 'Billed monthly · cancel anytime';
                annualEl.classList.remove('show');
            }
        });
    }
</script>
@endpush
