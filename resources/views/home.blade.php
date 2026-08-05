@extends('layouts.app')

@section('meta_title', $meta['title'])
@section('meta_description', $meta['description'])

@php
    $faqs = [
        [
            'q' => 'What is a prop firm coupon code?',
            'a' => 'A prop firm coupon code is a discount code that reduces the cost of a funded trading account evaluation or challenge fee at a proprietary trading firm. Codes are applied at checkout on the firm\'s own website.',
        ],
        [
            'q' => 'How do I use a prop firm discount code?',
            'a' => 'Copy the code from the firm\'s page on ' . config('app.name') . ', click through to the prop firm\'s website, choose a challenge or account size, and paste the code into the discount field before paying.',
        ],
        [
            'q' => 'Are the prop firm coupon codes on this site verified?',
            'a' => 'Codes marked "Verified" have been checked by our team, and every code also carries live success and failure votes from real traders so you can see how well it is currently working.',
        ],
        [
            'q' => 'What does "100% payout" mean for a prop firm?',
            'a' => 'A 100% payout means the funded trader keeps the full profit split on a specific payout cycle or account tier, instead of the firm keeping a percentage. It is one of the most sought-after perks in prop trading.',
        ],
        [
            'q' => 'How do I compare prop firms on this list?',
            'a' => 'Use the Popular Prop Firms section to see coupon counts at a glance, then open a firm\'s page to compare account sizes, profit splits, and currently active discount codes side by side.',
        ],
        [
            'q' => 'Do broker discount codes work the same way as prop firm codes?',
            'a' => 'Yes — broker promo codes follow the same process: copy the code, open the broker\'s signup or deposit page, and enter it wherever a promo or referral code field is offered.',
        ],
    ];
@endphp

@push('schema')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type'    => 'FAQPage',
    'mainEntity' => collect($faqs)->map(fn ($faq) => [
        '@type' => 'Question',
        'name'  => $faq['q'],
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text'  => $faq['a'],
        ],
    ])->values(),
], JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush

@section('content')

{{-- Hero --}}
<section class="sp-hero">
    <div class="container">
        <div class="sp-hero-eyebrow"><i class="bi bi-shield-check"></i> Verified Prop Firm & Broker Deals</div>
        <h1>Best <em>Prop Firm Coupon Codes</em> & Broker Discounts</h1>
        <p class="sp-hero-sub">
            Compare funded trading account discounts and trusted forex broker promo codes — checked, voted on by real traders, and updated regularly.
        </p>
    </div>
</section>

{{-- Trusted and 100% Payout Provided --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold h4 mb-1">Trusted and 100% Payout Provided</h2>
            <p class="text-muted small mb-0">Our top 5 handpicked prop firms — vetted for real, confirmed profit-split payouts.</p>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3">
            @forelse($topPropfirms as $store)
            <div class="col">
                <a href="{{ route('stores.show', $store->slug) }}" class="card border shadow-sm text-decoration-none h-100 hover-lift">
                    <div class="card-body text-center py-4 position-relative">
                        <span class="badge bg-success position-absolute top-0 start-50 translate-middle" style="font-size:.6rem">
                            <i class="bi bi-shield-check me-1"></i>100% Payout
                        </span>
                        <div class="store-icon mx-auto mb-3 mt-2 d-flex align-items-center justify-content-center bg-light border rounded-circle overflow-hidden"
                             style="width:56px;height:56px;">
                            @if($store->logo)
                                <img src="{{ asset($store->logo) }}" alt="{{ $store->name }}" style="object-fit:contain;width:56px;height:56px;">
                            @else
                                <span class="fw-bold text-primary fs-4">{{ $store->initials }}</span>
                            @endif
                        </div>
                        <div class="fw-semibold small">{{ $store->name }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ $store->coupons_count }} coupons</div>
                    </div>
                </a>
            </div>
            @empty
            <p class="text-muted">No prop firms listed yet.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- Best Prop Firm Coupon Codes --}}
<section class="py-5" style="background:#f8fafc;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <h2 class="fw-bold h4 mb-0"><i class="bi bi-lightning-charge-fill text-primary me-1"></i>Best Prop Firm Coupon Codes</h2>
            <a href="{{ route('stores.propfirms') }}" class="btn btn-sm btn-outline-primary">View All Prop Firms</a>
        </div>
        <div class="row g-4">
            @forelse($bestCoupons as $coupon)
            <div class="col-md-6 col-lg-4">
                <div class="card border shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="d-flex align-items-center justify-content-center bg-light border rounded-circle overflow-hidden"
                                 style="width:36px;height:36px;min-width:36px;">
                                @if($coupon->store->logo)
                                    <img src="{{ asset($coupon->store->logo) }}" alt="{{ $coupon->store->name }}" style="object-fit:contain;width:36px;height:36px;">
                                @else
                                    <span class="fw-bold text-primary small">{{ $coupon->store->initials }}</span>
                                @endif
                            </div>
                            <div class="fw-semibold small">{{ $coupon->store->name }}</div>
                            @if($coupon->is_exclusive)<span class="badge bg-primary ms-auto"><i class="bi bi-star-fill"></i></span>@endif
                            @if($coupon->is_verified)<span class="badge bg-success"><i class="bi bi-shield-check"></i></span>@endif
                        </div>

                        <h3 class="h6 fw-semibold">{{ $coupon->title }}</h3>
                        <div class="text-primary fw-bold small mb-3">{{ $coupon->discount_label }}</div>

                        <div class="coupon-code-group d-flex align-items-stretch mb-3">
                            <code class="coupon-code-text d-flex align-items-center flex-grow-1 justify-content-center">{{ $coupon->code }}</code>
                        </div>

                        <a href="{{ route('stores.show', $coupon->store->slug) }}" class="btn btn-primary mt-auto">
                            Get Code <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info mb-0">No prop firm coupon codes available yet. Check back soon!</div>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Popular Prop Firms --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <h2 class="fw-bold h4 mb-0"><i class="bi bi-graph-up-arrow text-primary me-1"></i>Popular Prop Firms</h2>
            <a href="{{ route('stores.propfirms') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="row g-3">
            @forelse($popularPropfirms as $store)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('stores.show', $store->slug) }}" class="card border shadow-sm text-decoration-none h-100 hover-lift">
                    <div class="card-body text-center py-4">
                        <div class="store-icon mx-auto mb-3 d-flex align-items-center justify-content-center bg-light border rounded-circle overflow-hidden"
                             style="width:56px;height:56px;">
                            @if($store->logo)
                                <img src="{{ asset($store->logo) }}" alt="{{ $store->name }}" style="object-fit:contain;width:56px;height:56px;">
                            @else
                                <span class="fw-bold text-primary fs-4">{{ $store->initials }}</span>
                            @endif
                        </div>
                        <div class="fw-semibold small">{{ $store->name }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ $store->coupons_count }} coupons</div>
                    </div>
                </a>
            </div>
            @empty
            <p class="text-muted">No prop firms listed yet.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- Popular Brokers --}}
<section class="py-5" style="background:#f8fafc;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <h2 class="fw-bold h4 mb-0"><i class="bi bi-bank text-primary me-1"></i>Popular and Trusted Brokers</h2>
            <a href="{{ route('stores.brokers') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="row g-3">
            @forelse($popularBrokers as $store)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('stores.show', $store->slug) }}" class="card border shadow-sm text-decoration-none h-100 hover-lift">
                    <div class="card-body text-center py-4">
                        <div class="store-icon mx-auto mb-3 d-flex align-items-center justify-content-center bg-light border rounded-circle overflow-hidden"
                             style="width:56px;height:56px;">
                            @if($store->logo)
                                <img src="{{ asset($store->logo) }}" alt="{{ $store->name }}" style="object-fit:contain;width:56px;height:56px;">
                            @else
                                <span class="fw-bold text-primary fs-4">{{ $store->initials }}</span>
                            @endif
                        </div>
                        <div class="fw-semibold small">{{ $store->name }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ $store->coupons_count }} coupons</div>
                    </div>
                </a>
            </div>
            @empty
            <p class="text-muted">No brokers listed yet.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- AEO / GEO / SEO FAQ --}}
<section class="py-5 bg-white">
    <div class="container" style="max-width:880px">
        <div class="text-center mb-4">
            <h2 class="fw-bold h4 mb-1">Prop Firm Coupon Codes & Propfirm List — FAQ</h2>
            <p class="text-muted small mb-0">Everything you need to know about using a prop firm discount code and comparing funded trading programs.</p>
        </div>
        <div class="accordion" id="faqAccordion">
            @foreach($faqs as $i => $faq)
            <div class="accordion-item">
                <h3 class="accordion-header" id="faqHeading{{ $i }}">
                    <button class="accordion-button {{ $i === 0 ? '' : 'collapsed' }}" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $i }}"
                            aria-expanded="{{ $i === 0 ? 'true' : 'false' }}" aria-controls="faqCollapse{{ $i }}">
                        {{ $faq['q'] }}
                    </button>
                </h3>
                <div id="faqCollapse{{ $i }}" class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}"
                     aria-labelledby="faqHeading{{ $i }}" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted small">
                        {{ $faq['a'] }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Overall Statistics --}}
<section class="py-5 text-white" style="background: linear-gradient(135deg, #0d1030 0%, #161055 55%, #3b1fa0 100%);">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold h4 mb-1">{{ config('app.name') }} By The Numbers</h2>
            <p class="opacity-75 small mb-0">Real, live data — not marketing fluff.</p>
        </div>
        <div class="row g-4 text-center">
            <div class="col-6 col-md-4 col-lg-2">
                <div class="fs-3 fw-bold">{{ $overallStats['stores'] }}+</div>
                <div class="small opacity-75">Stores Listed</div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="fs-3 fw-bold">{{ $overallStats['coupons'] }}+</div>
                <div class="small opacity-75">Coupon Codes</div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="fs-3 fw-bold">{{ $overallStats['verifiedCoupons'] }}+</div>
                <div class="small opacity-75">Verified Codes</div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="fs-3 fw-bold">{{ number_format($overallStats['pageViews']) }}</div>
                <div class="small opacity-75">Total Views</div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="fs-3 fw-bold">{{ number_format($overallStats['totalCopies']) }}</div>
                <div class="small opacity-75">Codes Copied</div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="fs-3 fw-bold">{{ $overallStats['successRate'] }}%</div>
                <div class="small opacity-75">Success Rate</div>
            </div>
        </div>
    </div>
</section>

@endsection
