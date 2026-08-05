@extends('layouts.app')

@section('meta_title', $meta['title'])
@section('meta_description', $meta['description'])

@section('content')

    {{-- JSON-LD Schema --}}
    <script type="application/ld+json">
{!! json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'WebPage',
    'name'        => $meta['title'],
    'description' => $meta['description'],
    'url'         => url()->current(),
], JSON_UNESCAPED_SLASHES) !!}
</script>

    @php
        $typeRoute = $store->company_type === 'broker' ? 'stores.brokers' : 'stores.propfirms';
        $typeLabel = $store->company_type === 'broker' ? 'Brokers' : 'Prop Firms';
    @endphp

    {{-- Store Header --}}
    <section class="store-header py-4 bg-white border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route($typeRoute) }}">{{ $typeLabel }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $store->name }}</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="store-logo-box d-flex align-items-center justify-content-center bg-light border rounded-3 overflow-hidden"
                    style="width:80px;height:80px;">
                    @if ($store->logo)
                        <img src="{{ asset($store->logo) }}" alt="{{ $store->name }} logo" class="img-fluid"
                            style="object-fit:contain;max-height:80px;max-width:80px;">
                    @else
                        <span class="fs-1 fw-bold text-primary">{{ $store->initials }}</span>
                    @endif
                </div>
                <div>
                    <h1 class="h3 fw-bold mb-1">{{ $store->name }} Coupon Codes</h1>
                    <p class="text-muted mb-1 small">{!! $store->description !!}</p>
                    <div class="d-flex flex-wrap gap-3 small">
                        <span class="text-muted"><i class="bi bi-tag me-1"></i>{{ $coupons->count() }} Coupons</span>
                        <span class="text-muted"><i class="bi bi-eye me-1"></i>{{ number_format($store->page_views) }}
                            Views</span>
                        @if ($successRate > 0)
                            <span class="text-success"><i class="bi bi-check-circle me-1"></i>{{ $successRate }}% Success
                                Rate</span>
                        @endif
                        @if ($store->website)
                            <a href="{{ $store->website }}" target="storeAffiliateTab" rel="nofollow"
                                class="text-primary text-decoration-none">
                                <i class="bi bi-box-arrow-up-right me-1"></i>Visit Store
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Bar --}}
    <div class="bg-light border-bottom py-2">
        <div class="container">
            <div class="row g-2 text-center">
                <div class="col-6 col-md-3">
                    <div class="small">
                        <span class="fw-semibold text-primary" id="stat-copies">{{ number_format($totalCopies) }}</span>
                        <span class="text-muted ms-1">Copies</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="small">
                        <span class="fw-semibold text-success" id="stat-worked">{{ number_format($totalSuccess) }}</span>
                        <span class="text-muted ms-1">Worked</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="small">
                        <span class="fw-semibold text-danger" id="stat-failed">{{ number_format($totalFailure) }}</span>
                        <span class="text-muted ms-1">Failed</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="small">
                        @php
                            $rateClass =
                                $successRate >= 70 ? 'success' : ($successRate >= 40 ? 'warning' : 'secondary');
                        @endphp
                        <span class="fw-semibold text-{{ $rateClass }}" id="stat-rate">{{ $successRate }}%</span>
                        <span class="text-muted ms-1">Success Rate</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <div class="row g-4">

            {{-- Main Content --}}
            <div class="col-lg-8">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 fw-bold mb-0">{{ $coupons->count() }} {{ Str::plural('Coupon', $coupons->count()) }}
                        Available</h2>
                    <span class="badge bg-success"><i class="bi bi-clock me-1"></i>Updated
                        {{ $store->updated_at->diffForHumans() }}</span>
                </div>

                {{-- Coupons List --}}
                @forelse($coupons as $coupon)

                    @php
                        $isExpired = $coupon->is_expired;
                        $hasHeader = $coupon->is_exclusive || $coupon->is_verified || $isExpired || $coupon->expires_at;
                        $successRate2 = $coupon->success_rate;
                        $srClass = $successRate2 >= 70 ? 'success' : ($successRate2 >= 40 ? 'warning' : 'danger');
                    @endphp

                    <article
                        class="coupon-card card mb-3 border shadow-sm {{ $coupon->is_exclusive ? 'border-primary' : '' }}"
                        data-coupon-id="{{ $coupon->id }}" itemscope itemtype="https://schema.org/Offer">

                        <meta itemprop="name" content="{{ $coupon->title }}">
                        <meta itemprop="description" content="{{ $coupon->description }}">

                        @if ($hasHeader)
                            <div class="card-header py-1 px-3 d-flex gap-2 flex-wrap bg-white border-bottom">
                                @if ($coupon->is_exclusive)
                                    <span class="badge bg-primary"><i class="bi bi-star-fill me-1"></i>Exclusive</span>
                                @endif
                                @if ($coupon->is_verified)
                                    <span class="badge bg-success"><i class="bi bi-shield-check me-1"></i>Verified</span>
                                @endif
                                @if ($isExpired)
                                    <span class="badge bg-secondary">Expired</span>
                                @elseif($coupon->expires_at)
                                    <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Expires
                                        {{ $coupon->expires_at->format('M d, Y') }}</span>
                                @endif
                            </div>
                        @endif

                        <div class="card-body">
                            <div class="row align-items-center g-3">

                                <div class="col-auto">
                                    <div class="discount-badge text-center bg-primary bg-opacity-10 border border-primary rounded-3 px-3 py-2"
                                        style="min-width:80px">
                                        <div class="fw-bold text-primary" style="font-size:1.05rem">
                                            {{ $coupon->discount_label }}</div>
                                        <div class="text-muted" style="font-size:0.7rem">
                                            {{ $coupon->type === 'deal' ? 'DEAL' : 'CODE' }}</div>
                                    </div>
                                </div>

                                <div class="col">
                                    <h3 class="h6 fw-semibold mb-1">{{ $coupon->title }}</h3>
                                    @if ($coupon->description)
                                        <p class="text-muted small mb-1">{{ $coupon->description }}</p>
                                    @endif
                                    @if ($successRate2 !== null)
                                        <div class="d-flex align-items-center gap-2 mt-1">
                                            <div class="progress" style="width:80px;height:6px;">
                                                <div class="progress-bar bg-{{ $srClass }}"
                                                    style="width:{{ $successRate2 }}%"></div>
                                            </div>
                                            <span class="text-muted" style="font-size:0.75rem">
                                                {{ $successRate2 }}% success
                                                ({{ $coupon->success_count + $coupon->failure_count }} votes)
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-auto text-center">
                                    @if ($coupon->type === 'deal')
                                        <a href="{{ $store->website ?? '#' }}" target="storeAffiliateTab" rel="nofollow"
                                            class="btn btn-outline-success px-4">
                                            <i class="bi bi-box-arrow-up-right me-1"></i>Get Deal
                                        </a>
                                    @else
                                        <div class="coupon-code-group d-inline-flex align-items-stretch">
                                            <code class="coupon-code-text d-flex align-items-center">{{ $coupon->code }}</code>
                                            <button class="btn btn-success copy-btn"
                                                data-coupon-id="{{ $coupon->id }}" data-code="{{ $coupon->code }}"
                                                data-copy-url="{{ route('coupons.copy', $coupon->id) }}"
                                                data-affiliate-url="{{ $store->website ?? '' }}"
                                                {{ $isExpired ? 'disabled' : '' }}>
                                                <i class="bi bi-clipboard me-1"></i><span class="btn-label">Copy</span>
                                            </button>
                                        </div>
                                        <div class="mt-1 small text-muted" id="copy-count-{{ $coupon->id }}">
                                            @if ($coupon->copy_count > 0)
                                                {{ number_format($coupon->copy_count) }} used
                                            @endif
                                        </div>
                                    @endif
                                </div>

                            </div>

                            {{-- Feedback Section --}}
                            <div class="feedback-section mt-3 pt-3 border-top d-none" id="feedback-{{ $coupon->id }}">
                                <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                                    <span class="text-muted small">Your code:</span>
                                    <code class="bg-light border rounded px-3 py-2 fs-6 fw-bold text-primary"
                                        id="code-display-{{ $coupon->id }}">{{ $coupon->code }}</code>
                                    <span class="badge bg-success d-none" id="copied-badge-{{ $coupon->id }}">
                                        <i class="bi bi-check-lg me-1"></i>Copied!
                                    </span>
                                </div>
                                <p class="small fw-semibold mb-2">Did this code work at checkout?</p>
                                <div class="d-flex gap-2 flex-wrap align-items-center">
                                    <button class="btn btn-sm btn-outline-success feedback-btn"
                                        data-coupon-id="{{ $coupon->id }}" data-worked="1"
                                        data-feedback-url="{{ route('coupons.feedback', $coupon->id) }}">
                                        <i class="bi bi-hand-thumbs-up-fill me-1"></i>Yes, it worked!
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger feedback-btn"
                                        data-coupon-id="{{ $coupon->id }}" data-worked="0"
                                        data-feedback-url="{{ route('coupons.feedback', $coupon->id) }}">
                                        <i class="bi bi-hand-thumbs-down-fill me-1"></i>No, didn't work
                                    </button>
                                    <span class="d-none small fw-semibold" id="feedback-msg-{{ $coupon->id }}"></span>
                                </div>
                                <div class="d-flex gap-3 mt-2 small text-muted" id="live-stats-{{ $coupon->id }}">
                                    <span><i class="bi bi-check-circle-fill text-success me-1"></i><span
                                            class="sc">{{ $coupon->success_count }}</span> worked</span>
                                    <span><i class="bi bi-x-circle-fill text-danger me-1"></i><span
                                            class="fc">{{ $coupon->failure_count }}</span> failed</span>
                                </div>
                            </div>

                        </div>
                    </article>

                @empty
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>No coupons available yet. Check back soon!
                    </div>
                @endforelse

                {{-- HISTORY SECTION --}}
                <section class="mt-5" id="history-section">
                    <div class="d-flex align-items-center mb-3">
                        <h2 class="h5 fw-bold mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Usage History
                        </h2>
                        <span class="badge bg-secondary ms-2" id="history-count">{{ $histories->count() }} Events</span>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-3">
                            <div class="card text-center border-0 bg-primary bg-opacity-10 rounded-3">
                                <div class="card-body py-3">
                                    <div class="fs-4 fw-bold text-primary" id="hist-views">
                                        {{ number_format($store->page_views) }}</div>
                                    <div class="small text-muted">Page Views</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card text-center border-0 bg-secondary bg-opacity-10 rounded-3">
                                <div class="card-body py-3">
                                    <div class="fs-4 fw-bold text-secondary" id="hist-copies">
                                        {{ number_format($totalCopies) }}</div>
                                    <div class="small text-muted">Total Copies</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card text-center border-0 bg-success bg-opacity-10 rounded-3">
                                <div class="card-body py-3">
                                    <div class="fs-4 fw-bold text-success" id="hist-worked">
                                        {{ number_format($totalSuccess) }}</div>
                                    <div class="small text-muted">Worked</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="card text-center border-0 bg-danger bg-opacity-10 rounded-3">
                                <div class="card-body py-3">
                                    <div class="fs-4 fw-bold text-danger" id="hist-failed">
                                        {{ number_format($totalFailure) }}</div>
                                    <div class="small text-muted">Failed</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 bg-light mb-4">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-success fw-semibold" id="rate-bar-label">{{ $successRate }}% Success
                                    Rate</span>
                                <span class="text-muted" id="rate-bar-votes">{{ $totalSuccess + $totalFailure }} total
                                    votes</span>
                            </div>
                            <div class="progress" style="height:10px">
                                <div class="progress-bar bg-success" id="rate-bar-success"
                                    style="width:{{ $successRate }}%"></div>
                                <div class="progress-bar bg-danger" id="rate-bar-fail"
                                    style="width:{{ 100 - $successRate }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card border shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h3 class="h6 fw-semibold mb-0"><i class="bi bi-list-ul me-1"></i>{{ $store->name }} Coupons Activity Log</h3>
                            <span class="small text-muted">Most recent first</span>
                        </div>
                        <div class="table-responsive history-scroll">
                            <table class="table table-hover table-sm mb-0">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th class="ps-3" style="width:40%">Coupon</th>
                                        <th style="width:25%">Code</th>
                                        <th style="width:20%">Action</th>
                                        <th class="pe-3" style="width:15%">Time</th>
                                    </tr>
                                </thead>
                                <tbody id="historyTableBody">
                                    @forelse($histories as $history)
                                        <tr>
                                            <td class="ps-3 small">{{ Str::limit($history->coupon_title, 38) }}</td>
                                            <td>
                                                @if ($history->coupon_code)
                                                    <code
                                                        class="small bg-light px-2 py-1 rounded">{{ $history->coupon_code }}</code>
                                                @else
                                                    <span class="text-muted small">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($history->action === 'copy')
                                                    <span class="badge bg-secondary"><i
                                                            class="bi bi-clipboard me-1"></i>Copied</span>
                                                @elseif($history->action === 'success')
                                                    <span class="badge bg-success"><i
                                                            class="bi bi-check-lg me-1"></i>Worked</span>
                                                @else
                                                    <span class="badge bg-danger"><i
                                                            class="bi bi-x-lg me-1"></i>Failed</span>
                                                @endif
                                            </td>
                                            <td class="pe-3 small text-muted text-nowrap">
                                                {{ $history->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @empty
                                        <tr id="no-history-row">
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                <i class="bi bi-clock-history fs-3 d-block mb-2 opacity-50"></i>
                                                No activity yet. Be the first to use a coupon!
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>


                {{-- ========== STORE DETAILS CONTENT SECTION ========== --}}
                @if ($store->details)
                    <section class="mt-5" aria-label="{{ $store->name }} Details">
                        <div class="d-flex align-items-center mb-3">
                            <h2 class="h5 fw-bold mb-0">
                                <i class="bi bi-info-circle me-2 text-primary"></i>About {{ $store->name }}
                            </h2>
                        </div>
                        <div class="card border shadow-sm">
                            <div class="card-body store-details-content py-4 px-4">
                                {!! $store->details !!}
                            </div>
                        </div>
                    </section>
                @endif

            </div>{{-- /col-lg-8 --}}

            {{-- Sidebar --}}
            <aside class="col-lg-4">
                <div class="card border shadow-sm mb-4 position-sticky" style="top:75px">
                    <div class="card-header bg-white">
                        <h2 class="h6 fw-bold mb-0"><i class="bi bi-fire text-danger me-1"></i>Popular Stores</h2>
                    </div>
                    <div class="list-group list-group-flush">
                        @forelse($popularStores as $popular)
                            <a href="{{ route('stores.show', $popular->slug) }}"
                                class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3">
                                <div class="store-icon-sm d-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle text-primary fw-bold"
                                    style="width:40px;height:40px;min-width:40px;">
                                    {{ $popular->initials }}
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="fw-semibold small text-truncate">{{ $popular->name }}</div>
                                    <div class="text-muted" style="font-size:0.75rem">{{ $popular->coupons_count }}
                                        coupons</div>
                                </div>
                                <i class="bi bi-chevron-right text-muted small"></i>
                            </a>
                        @empty
                            <div class="list-group-item text-muted small py-3">No popular stores yet.</div>
                        @endforelse
                    </div>
                    <div class="card-footer bg-white text-center">
                        <a href="{{ route($typeRoute) }}" class="btn btn-sm btn-outline-primary w-100">
                            View All {{ $typeLabel }} <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </aside>

        </div>
    </div>

    {{-- Inline data for JS --}}
    <script>
        var COUPON_DATA = {
            csrf: '{{ csrf_token() }}',
            totalCopies: {{ $totalCopies }},
            totalSuccess: {{ $totalSuccess }},
            totalFailure: {{ $totalFailure }},
            historyCount: {{ $histories->count() }}
        };
    </script>

    <script src="{{ asset('js/store-show.js') }}"></script>

@endsection
