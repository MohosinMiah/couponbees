@extends('admin.layouts.app')
@section('title', 'Add Coupon')

@section('content')

<div class="page-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">Coupons</a></li>
            <li class="breadcrumb-item active">Add Coupon</li>
        </ol>
    </nav>
    <h1><i class="bi bi-ticket-perforated me-2 text-primary"></i>Add New Coupon</h1>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf

            <div class="card border shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">Coupon Details</div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-12">
                            <label class="form-label">Store <span class="text-danger">*</span></label>
                            <select name="store_id" class="form-select @error('store_id') is-invalid @enderror" required>
                                <option value="">— Select a Store —</option>
                                @foreach($stores as $store)
                                <option value="{{ $store->id }}"
                                    {{ (old('store_id', $selectedStore) == $store->id) ? 'selected' : '' }}>
                                    {{ $store->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('store_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Coupon Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" placeholder="e.g. Get 20% Off Your First Order" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Type <span class="text-danger">*</span></label>
                            <select name="type" id="couponType" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="code" {{ old('type', 'code') === 'code' ? 'selected' : '' }}>Coupon Code</option>
                                <option value="deal" {{ old('type') === 'deal' ? 'selected' : '' }}>Deal (No Code)</option>
                            </select>
                            @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6" id="codeField">
                            <label class="form-label">Coupon Code</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                                   value="{{ old('code') }}" placeholder="e.g. SAVE20" style="text-transform:uppercase"
                                   oninput="this.value=this.value.toUpperCase()">
                            @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="2"
                                      placeholder="Describe the offer in detail...">{{ old('description') }}</textarea>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card border shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">Discount Details</div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Discount Type <span class="text-danger">*</span></label>
                            <select name="discount_type" id="discountType" class="form-select @error('discount_type') is-invalid @enderror" required>
                                <option value="percentage" {{ old('discount_type', 'percentage') === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                <option value="fixed"      {{ old('discount_type') === 'fixed'      ? 'selected' : '' }}>Fixed Amount ($)</option>
                                <option value="free_shipping" {{ old('discount_type') === 'free_shipping' ? 'selected' : '' }}>Free Shipping</option>
                                <option value="other"      {{ old('discount_type') === 'other'      ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('discount_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6" id="discountValueField">
                            <label class="form-label">Discount Value</label>
                            <div class="input-group">
                                <span class="input-group-text" id="discountSymbol">%</span>
                                <input type="text" name="discount_value" class="form-control @error('discount_value') is-invalid @enderror"
                                       value="{{ old('discount_value') }}" placeholder="e.g. 20">
                            </div>
                            @error('discount_value')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Expiry Date</label>
                            <input type="date" name="expires_at" class="form-control @error('expires_at') is-invalid @enderror"
                                   value="{{ old('expires_at') }}" min="{{ date('Y-m-d') }}">
                            @error('expires_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Leave empty for no expiry.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Position</label>
                            <input type="number" name="position" class="form-control @error('position') is-invalid @enderror"
                                   value="{{ old('position', 100) }}" min="0">
                            @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Lower number shows first. Exclusive coupons always show first regardless of position.</div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card border shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">Badges & Visibility</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_verified" id="isVerified"
                                       value="1" {{ old('is_verified', '1') ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="isVerified">
                                    <i class="bi bi-shield-check text-success me-1"></i>Verified
                                </label>
                                <div class="text-muted small">Mark this coupon as verified and working.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_exclusive" id="isExclusive"
                                       value="1" {{ old('is_exclusive') ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="isExclusive">
                                    <i class="bi bi-star-fill text-primary me-1"></i>Exclusive
                                </label>
                                <div class="text-muted small">Mark as an exclusive deal only found here.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i>Create Coupon
                </button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 bg-light">
            <div class="card-body small text-muted">
                <h6 class="fw-semibold text-dark"><i class="bi bi-info-circle me-1"></i>Tips</h6>
                <ul class="ps-3 mb-0">
                    <li class="mb-2">Choose <strong>Deal</strong> type if there's no code to enter at checkout.</li>
                    <li class="mb-2">The <strong>coupon code</strong> is automatically UPPERCASED.</li>
                    <li class="mb-2">Leave <strong>Expiry Date</strong> blank if the coupon doesn't expire.</li>
                    <li class="mb-2"><strong>Verified</strong> coupons show a green shield badge.</li>
                    <li><strong>Exclusive</strong> coupons show a blue star and are highlighted.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Show/hide code field based on type
    var typeEl   = document.getElementById('couponType');
    var codeWrap = document.getElementById('codeField');

    function toggleCodeField() {
        codeWrap.style.display = typeEl.value === 'deal' ? 'none' : '';
    }
    typeEl.addEventListener('change', toggleCodeField);
    toggleCodeField();

    // Update discount symbol
    var discountType   = document.getElementById('discountType');
    var discountSymbol = document.getElementById('discountSymbol');
    var discountWrap   = document.getElementById('discountValueField');

    function updateDiscountUI() {
        var val = discountType.value;
        if (val === 'free_shipping') {
            discountWrap.style.display = 'none';
        } else {
            discountWrap.style.display = '';
            discountSymbol.textContent = val === 'percentage' ? '%' : val === 'fixed' ? '$' : '#';
        }
    }
    discountType.addEventListener('change', updateDiscountUI);
    updateDiscountUI();
</script>
@endpush
