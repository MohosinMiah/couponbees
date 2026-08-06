<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    {{-- SEO Meta Tags --}}
    <title>@yield('meta_title', config('app.name') . ' - Coupon Codes & Promo Deals')</title>
    <meta name="description" content="@yield('meta_description', 'Find the best coupon codes, promo codes and deals. Save money with verified coupons.')">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('meta_title', config('app.name'))">
    <meta property="og:description" content="@yield('meta_description', 'Find the best coupon codes and deals.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    {{-- Schema.org JSON-LD --}}
    @stack('schema')

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Meta Pixel Code --}}
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window,document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '805740599134475');
    fbq('track', 'PageView');
    </script>
    {{-- End Meta Pixel Code --}}

    {{-- Google tag (gtag.js) --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-16752442655"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'AW-16752442655');
    </script>
    {{-- End Google tag --}}
</head>
<body>
<noscript>
    <img height="1" width="1" style="display:none"
         src="https://www.facebook.com/tr?id=805740599134475&ev=PageView&noscript=1" alt="">
</noscript>

{{-- Announcement Bar --}}
<div class="announcement-bar" role="region" aria-label="Promotional offers">
    <div class="announcement-bar-inner">

        <a href="https://www.ifundscoupon.com/" class="ann-entry"
           target="_blank" rel="noopener noreferrer" aria-label="Get started with iFunds instant funding">
            <span class="ann-dot" aria-hidden="true"></span>
            <span class="announcement-bar-text">
                <span class="ann-full">🚀 Instant Funding Access • No Rules • Fast &amp; Reliable Payouts</span>
                <span class="ann-short">🚀 iFunds • Instant Funding</span>
            </span>
            <span class="announcement-bar-cta">Get Started →</span>
            <span class="ann-arrow" aria-hidden="true">›</span>
        </a>

        <span class="ann-divider" aria-hidden="true"></span>

        <a href="https://www.couponterra.com/coupons/fxify.com" class="ann-entry"
           target="_blank" rel="noopener noreferrer" aria-label="Grab the FXIFY discount">
            <span class="ann-dot" aria-hidden="true"></span>
            <span class="announcement-bar-text">
                <span class="ann-full">⚡ FXIFY • Fastest Payouts in Prop Trading • Save Big Today</span>
                <span class="ann-short">⚡ FXIFY • Fastest Payouts</span>
            </span>
            <span class="announcement-bar-cta">Grab Deal →</span>
            <span class="ann-arrow" aria-hidden="true">›</span>
        </a>

    </div>
</div>

{{-- Sponsor Bar --}}
@php($sponsors = \App\Models\Sponsor::where('is_active', true)->orderBy('position')->orderBy('name')->get())
<div class="sponsor-bar" id="sponsorBar">

    <div class="sb-sparkles-left" aria-hidden="true">
        <svg width="52" height="50" viewBox="0 0 52 50" xmlns="http://www.w3.org/2000/svg" fill="none">
            <path d="M18 5 L19.6 12 L27 13.5 L19.6 15 L18 22 L16.4 15 L9 13.5 L16.4 12 Z" fill="#5eead4" opacity="0.78"></path>
            <path d="M7 29 L7.9 33 L12 33.8 L7.9 34.6 L7 38 L6.1 34.6 L2 33.8 L6.1 33 Z" fill="#38bdf8" opacity="0.5"></path>
            <circle cx="32" cy="10" r="2" fill="#7dd3fc" opacity="0.4"></circle>
            <path d="M40 30 L40.8 33 L44 33.8 L40.8 34.6 L40 37 L39.2 34.6 L36 33.8 L39.2 33 Z" fill="#67e8f9" opacity="0.3" transform="scale(0.6) translate(27, 16)"></path>
        </svg>
    </div>

    <div class="sb-label">
        <span class="sb-label-icon">🤝</span>
        <span class="sb-label-text">Sponsored by</span>
    </div>

    <div class="sb-track-wrap">
        <div class="sb-track" id="sbTrack">
            @foreach($sponsors as $sponsor)
                <a href="{{ $sponsor->link }}" class="sb-item" title="{{ $sponsor->name }}" target="_blank" rel="noopener noreferrer">
                    <span class="sb-svg-logo">{!! $sponsor->svg !!}</span>
                </a>
            @endforeach
            @foreach($sponsors as $sponsor)
                <a href="{{ $sponsor->link }}" class="sb-item sb-clone" aria-hidden="true" tabindex="-1" target="_blank" rel="noopener noreferrer">
                    <span class="sb-svg-logo">{!! $sponsor->svg !!}</span>
                </a>
            @endforeach
        </div>
    </div>

    <div class="sb-right">
        <div class="sb-sparkles-right" aria-hidden="true">
            <svg width="44" height="50" viewBox="0 0 44 50" xmlns="http://www.w3.org/2000/svg" fill="none">
                <path d="M18 8 L19.3 14 L26 15.5 L19.3 17 L18 23 L16.7 17 L10 15.5 L16.7 14 Z" fill="#c4b5fd" opacity="0.5"></path>
                <path d="M34 30 L34.9 34 L39 34.8 L34.9 35.6 L34 39 L33.1 35.6 L29 34.8 L33.1 34 Z" fill="#a78bfa" opacity="0.38"></path>
                <circle cx="8" cy="30" r="2" fill="#ddd6fe" opacity="0.28"></circle>
            </svg>
        </div>
        <div class="sb-cta-wrap">
            <a href="{{ route('become-a-sponsor') }}" class="sb-cta">
                <span class="sb-cta-star">✦</span>
                <span class="cta-text">Become a Sponsor</span>
            </a>
        </div>
    </div>

</div>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark site-navbar sticky-top shadow-sm">
    <div class="container">
        <div class="navbar-top-row d-flex align-items-center flex-nowrap">
            <a class="navbar-brand flex-shrink-0" href="{{ route('home') }}">
                <img src="{{ asset('uploads/logos/logo.svg') }}" alt="{{ config('app.name') }}" height="36">
            </a>

            {{-- Compact search box, always visible in the top bar on mobile --}}
            <div class="nav-search-wrap nav-search-wrap-compact d-lg-none flex-grow-1 mx-2">
                <i class="bi bi-search nav-search-icon"></i>
                <input type="text" class="nav-search" autocomplete="off"
                    placeholder="Search stores..."
                    aria-label="Search stores"
                    data-search-url="{{ route('stores.search') }}">
                <div class="search-dropdown"></div>
            </div>

            <button class="navbar-toggler flex-shrink-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav mx-lg-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="bi bi-house me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('stores.propfirms') }}">
                        <i class="bi bi-graph-up-arrow me-1"></i>Prop Firms
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('stores.brokers') }}">
                        <i class="bi bi-bank me-1"></i>Brokers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">
                        <i class="bi bi-envelope me-1"></i>Contact Us
                    </a>
                </li>
            </ul>

            {{-- Full search box inside the expanded menu (desktop always, mobile after tapping the hamburger) --}}
            <div class="nav-search-wrap my-2 my-lg-0">
                <i class="bi bi-search nav-search-icon"></i>
                <input type="text" class="nav-search" autocomplete="off"
                    placeholder="Search stores by name, slug or domain..."
                    aria-label="Search stores"
                    data-search-url="{{ route('stores.search') }}">
                <div class="search-dropdown"></div>
            </div>
        </div>
    </div>
</nav>

{{-- Main Content --}}
<main>
    @yield('content')
</main>

{{-- Footer --}}
<footer class="site-footer text-light py-5 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5 class="fw-bold mb-3"><img src="{{ asset('uploads/logos/logo.svg') }}" alt="{{ config('app.name') }}" height="28"></h5>
                <p class="text-muted small">Find the best coupon codes, promo codes and deals. Save money every day with verified coupons from top stores.</p>
            </div>
            <div class="col-lg-2">
                <h6 class="fw-semibold mb-3">Quick Links</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('home') }}" class="text-muted text-decoration-none">Home</a></li>
                    <li><a href="{{ route('stores.propfirms') }}" class="text-muted text-decoration-none">Prop Firms</a></li>
                    <li><a href="{{ route('stores.brokers') }}" class="text-muted text-decoration-none">Brokers</a></li>
                    <li><a href="{{ route('contact') }}" class="text-muted text-decoration-none">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h6 class="fw-semibold mb-3">Popular Stores</h6>
                @php($footerPopularStores = \App\Models\Store::where('is_popular', true)->orderByDesc('page_views')->limit(4)->get())
                <ul class="list-unstyled small">
                    @foreach($footerPopularStores as $popularStore)
                    <li><a href="{{ route('stores.show', $popularStore->slug) }}" class="text-muted text-decoration-none">{{ $popularStore->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-3">
                <h6 class="fw-semibold mb-3">About</h6>
                <p class="text-muted small">CouponBees helps you save money with the best verified coupons and promo codes from hundreds of top stores.</p>
            </div>
        </div>
        <hr class="border-secondary my-4">
        <div class="row">
            <div class="col-md-6">
                <p class="text-muted small mb-0">&copy; {{ date('Y') }} CouponBees.  All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="text-muted small mb-0">Saving money made simple.</p>
            </div>
        </div>
    </div>
</footer>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/store-search.js') }}"></script>@stack('scripts')
</body>
</html>
