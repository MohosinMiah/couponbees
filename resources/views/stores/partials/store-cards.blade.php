@foreach($stores as $store)
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
@endforeach
