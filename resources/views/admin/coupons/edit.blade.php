@extends('admin.layouts.app')
@section('title', 'Edit Coupon')

@section('content')

<div class="page-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}">Coupons</a></li>
            <li class="breadcrumb-item active">Edit Coupon</li>
        </ol>
    </nav>
    <h1><i class="bi bi-pencil me-2 text-primary"></i>Edit Coupon</h1>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
            @csrf @method('PUT')

            <div class="card border shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">Coupon Details</div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-12">
                            <label class="form-label">Store <span class="text-danger">*</span></label>
                            <select name="store_id" class="form-select @error('store_id') is-invalid @enderror" required>
                                @foreach($stores as $store)
                                <option value="{{ $store->id }}" {{ old('store_id', $coupon->store_id) == $store->id ? 'selected' : '' }}>
                                    {{ $store->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('store_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Coupon Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $coupon->title) }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Type <span class="text-danger">*</span></label>
                            <select name="type" id="couponType" class="form-select" required>
                                <option value="code" {{ old('type', $coupon->type) === 'code' ? 'selected' : '' }}>Coupon Code</option>
                                <option value="deal" {{ old('type', $coupon->type) === 'deal' ? 'selected' : '' }}>Deal (No Code)</option>
                            </select>
                        </div>

                        <div class="col-md-6" id="codeField">
                            <label class="form-label">Coupon Code</label>
                            <input type="text" name="code" class="form-control"
                                   value="{{ old('code', $coupon->code) }}"
                                   style="text-transform:uppercase" oninput="this.value=this.value.toUpperCase()">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="2">{{ old('description', $coupon->description) }}</textarea>
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
                            <select name="discount_type" id="discountType" class="form-select" required>
                                <option value="percentage"   {{ old('discount_type', $coupon->discount_type) === 'percentage'   ? 'selected' : '' }}>Percentage (%)</option>
                                <option value="fixed"        {{ old('discount_type', $coupon->discount_type) === 'fixed'        ? 'selected' : '' }}>Fixed Amount ($)</option>
                                <option value="free_shipping"{{ old('discount_type', $coupon->discount_type) === 'free_shipping' ? 'selected' : '' }}>Free Shipping</option>
                                <option value="other"        {{ old('discount_type', $coupon->discount_type) === 'other'        ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="col-md-6" id="discountValueField">
                            <label class="form-label">Discount Value</label>
                            <div class="input-group">
                                <span class="input-group-text" id="discountSymbol">%</span>
                                <input type="text" name="discount_value" class="form-control"
                                       value="{{ old('discount_value', $coupon->discount_value) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Expiry Date</label>
                            <input type="date" name="expires_at" class="form-control"
                                   value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d')) }}">
                            <div class="form-text">Clear to remove expiry.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Position</label>
                            <input type="number" name="position" class="form-control @error('position') is-invalid @enderror"
                                   value="{{ old('position', $coupon->position) }}" min="0">
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
                                       value="1" {{ old('is_verified', $coupon->is_verified) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="isVerified">
                                    <i class="bi bi-shield-check text-success me-1"></i>Verified
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_exclusive" id="isExclusive"
                                       value="1" {{ old('is_exclusive', $coupon->is_exclusive) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="isExclusive">
                                    <i class="bi bi-star-fill text-primary me-1"></i>Exclusive
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i>Save Changes
                </button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <div class="col-lg-4">
        {{-- Coupon Stats --}}
        <div class="card border shadow-sm mb-3">
            <div class="card-header bg-white fw-semibold small">Coupon Stats</div>
            <div class="card-body small">
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Times Copied</span>
                    <strong>{{ number_format($coupon->copy_count) }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Worked</span>
                    <strong class="text-success">{{ number_format($coupon->success_count) }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Failed</span>
                    <strong class="text-danger">{{ number_format($coupon->failure_count) }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Success Rate</span>
                    @php $total = $coupon->success_count + $coupon->failure_count; @endphp
                    <strong>{{ $total > 0 ? round(($coupon->success_count/$total)*100) . '%' : '—' }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Created</span>
                    <strong>{{ $coupon->created_at->format('M d, Y') }}</strong>
                </div>
            </div>
            <div class="card-footer bg-white">
                <form action="{{ route('admin.coupons.reset-stats', $coupon) }}" method="POST"
                      onsubmit="return confirm('Reset all stats to zero?')">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-warning w-100">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Reset Stats
                    </button>
                </form>
            </div>
        </div>

        {{-- Danger zone --}}
        <div class="card border-danger">
            <div class="card-header bg-danger text-white small fw-semibold">Danger Zone</div>
            <div class="card-body">
                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST"
                      onsubmit="return confirm('Permanently delete this coupon?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm w-100">
                        <i class="bi bi-trash me-1"></i>Delete Coupon
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    var typeEl   = document.getElementById('couponType');
    var codeWrap = document.getElementById('codeField');
    function toggleCodeField() { codeWrap.style.display = typeEl.value === 'deal' ? 'none' : ''; }
    typeEl.addEventListener('change', toggleCodeField);
    toggleCodeField();

    var discountType   = document.getElementById('discountType');
    var discountSymbol = document.getElementById('discountSymbol');
    var discountWrap   = document.getElementById('discountValueField');
    function updateDiscountUI() {
        var val = discountType.value;
        if (val === 'free_shipping') { discountWrap.style.display = 'none'; }
        else {
            discountWrap.style.display = '';
            discountSymbol.textContent = val === 'percentage' ? '%' : val === 'fixed' ? '$' : '#';
        }
    }
    discountType.addEventListener('change', updateDiscountUI);
    updateDiscountUI();
</script>
@endpush
