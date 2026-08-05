@extends('layouts.app')

@section('meta_title', $meta['title'])
@section('meta_description', $meta['description'])

@section('content')

<div class="bg-primary text-white py-5">
    <div class="container text-center">
        <h1 class="fw-bold mb-2">{{ $label }} Coupon Codes</h1>
        <p class="lead mb-0 opacity-75">Browse all {{ strtolower($label) }} and find the best verified coupons</p>
    </div>
</div>

{{-- Stats Bar --}}
<div class="bg-light border-bottom py-2">
    <div class="container">
        <div class="row row-cols-2 row-cols-md-5 g-2 text-center">
            <div class="col">
                <div class="small">
                    <span class="fw-semibold text-primary">{{ number_format($stats['stores']) }}</span>
                    <span class="text-muted ms-1">{{ $label }}</span>
                </div>
            </div>
            <div class="col">
                <div class="small">
                    <span class="fw-semibold text-primary">{{ number_format($stats['coupons']) }}</span>
                    <span class="text-muted ms-1">Coupon Codes</span>
                </div>
            </div>
            <div class="col">
                <div class="small">
                    <span class="fw-semibold text-success">{{ number_format($stats['verifiedCoupons']) }}</span>
                    <span class="text-muted ms-1">Verified</span>
                </div>
            </div>
            <div class="col">
                <div class="small">
                    <span class="fw-semibold text-primary">{{ number_format($stats['pageViews']) }}</span>
                    <span class="text-muted ms-1">Total Views</span>
                </div>
            </div>
            <div class="col">
                <div class="small">
                    @php
                        $rateClass = $stats['successRate'] >= 70 ? 'success' : ($stats['successRate'] >= 40 ? 'warning' : 'secondary');
                    @endphp
                    <span class="fw-semibold text-{{ $rateClass }}">{{ $stats['successRate'] }}%</span>
                    <span class="text-muted ms-1">Success Rate</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h2 class="h5 fw-bold mb-0">
            <i class="bi bi-{{ $type === 'propfirm' ? 'graph-up-arrow' : 'bank' }} me-1"></i>{{ $label }}
        </h2>
        <span class="text-muted small">{{ $stores->total() }} total</span>
    </div>

    <div class="row g-3" id="storeGrid"
         data-type="{{ $type }}"
         data-next-page="2"
         data-has-more="{{ $stores->hasMorePages() ? '1' : '0' }}"
         data-load-more-url="{{ route('stores.load-more') }}">
        @include('stores.partials.store-cards', ['stores' => $stores])
    </div>

    <div class="text-center py-4">
        <div class="spinner-border text-primary d-none" id="storeGridSpinner" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="text-muted small d-none" id="storeGridEnd">You've reached the end of the list.</div>
        <div id="storeGridSentinel"></div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/store-infinite-scroll.js') }}"></script>
@endpush
