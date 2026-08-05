@extends('admin.layouts.app')
@section('title', 'Homepage Settings')

@section('content')

<div class="page-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Homepage Settings</li>
        </ol>
    </nav>
    <h1><i class="bi bi-house-gear me-2 text-primary"></i>Homepage Settings</h1>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <form action="{{ route('admin.settings.homepage.update') }}" method="POST">
            @csrf

            <div class="card border shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">Module Item Counts</div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">"Trusted and 100% Payout Provided" <span class="text-danger">*</span></label>
                            <input type="number" name="homepage_trusted_count" min="1" max="50"
                                   class="form-control @error('homepage_trusted_count') is-invalid @enderror"
                                   value="{{ old('homepage_trusted_count', $settings['homepage_trusted_count']) }}" required>
                            @error('homepage_trusted_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">How many prop firms to show. Mark stores as <strong>Trusted</strong> on the store edit page to control which ones appear.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">"Best Prop Firm Coupon Codes" <span class="text-danger">*</span></label>
                            <input type="number" name="homepage_best_coupons_count" min="1" max="50"
                                   class="form-control @error('homepage_best_coupons_count') is-invalid @enderror"
                                   value="{{ old('homepage_best_coupons_count', $settings['homepage_best_coupons_count']) }}" required>
                            @error('homepage_best_coupons_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">How many coupon cards to show, ranked by exclusive/verified/most copied.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">"Popular Prop Firms" <span class="text-danger">*</span></label>
                            <input type="number" name="homepage_popular_propfirms_count" min="1" max="50"
                                   class="form-control @error('homepage_popular_propfirms_count') is-invalid @enderror"
                                   value="{{ old('homepage_popular_propfirms_count', $settings['homepage_popular_propfirms_count']) }}" required>
                            @error('homepage_popular_propfirms_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">How many prop firm stores to list, ranked by Popular flag then page views.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">"Popular and Trusted Brokers" <span class="text-danger">*</span></label>
                            <input type="number" name="homepage_popular_brokers_count" min="1" max="50"
                                   class="form-control @error('homepage_popular_brokers_count') is-invalid @enderror"
                                   value="{{ old('homepage_popular_brokers_count', $settings['homepage_popular_brokers_count']) }}" required>
                            @error('homepage_popular_brokers_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">How many broker stores to list, ranked by Popular flag then page views.</div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i>Save Settings
                </button>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary">
                    <i class="bi bi-eye me-1"></i>Preview Homepage
                </a>
            </div>
        </form>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 bg-light">
            <div class="card-body small text-muted">
                <h6 class="fw-semibold text-dark"><i class="bi bi-info-circle me-1"></i>How this works</h6>
                <ul class="ps-3 mb-0">
                    <li class="mb-2">These counts control how many items each homepage module shows.</li>
                    <li class="mb-2">The <strong>Trusted</strong> section only shows stores you've explicitly marked as Trusted — go to <a href="{{ route('admin.stores.index') }}">Stores</a> and edit a store to toggle it.</li>
                    <li class="mb-2"><strong>Popular Prop Firms</strong> / <strong>Popular Brokers</strong> pull from the <strong>Popular</strong> flag and page views automatically — no manual list needed.</li>
                    <li>Changes apply immediately, no cache to clear.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
