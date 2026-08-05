@extends('admin.layouts.app')
@section('title', $store->name)

@section('content')

<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-1">
                <li class="breadcrumb-item"><a href="{{ route('admin.stores.index') }}">Stores</a></li>
                <li class="breadcrumb-item active">{{ $store->name }}</li>
            </ol>
        </nav>
        <h1><i class="bi bi-shop me-2 text-primary"></i>{{ $store->name }}</h1>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.coupons.create', ['store_id' => $store->id]) }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i>Add Coupon
        </a>
        <a href="{{ route('admin.stores.edit', $store) }}" class="btn btn-outline-primary">
            <i class="bi bi-pencil me-1"></i>Edit Store
        </a>
        <a href="{{ route('stores.show', $store->slug) }}" target="_blank" class="btn btn-outline-secondary">
            <i class="bi bi-eye me-1"></i>View on Site
        </a>
    </div>
</div>

<div class="card border shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">Coupon</th>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Copies</th>
                    <th>Success</th>
                    <th>Expires</th>
                    <th>Status</th>
                    <th class="pe-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                <tr>
                    <td class="ps-3 fw-semibold small">{{ Str::limit($coupon->title, 40) }}</td>
                    <td>
                        @if($coupon->code)
                        <code class="small bg-light px-2 py-1 rounded">{{ $coupon->code }}</code>
                        @else
                        <span class="badge bg-secondary">Deal</span>
                        @endif
                    </td>
                    <td><span class="badge bg-{{ $coupon->type === 'code' ? 'primary' : 'info' }}">{{ ucfirst($coupon->type) }}</span></td>
                    <td class="small">{{ number_format($coupon->copy_count) }}</td>
                    <td class="small">
                        @php $total = $coupon->success_count + $coupon->failure_count; @endphp
                        @if($total > 0)
                        {{ round(($coupon->success_count / $total) * 100) }}%
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="small">
                        @if($coupon->expires_at)
                            @if($coupon->is_expired)
                                <span class="text-danger">{{ $coupon->expires_at->format('M d, Y') }}</span>
                            @else
                                {{ $coupon->expires_at->format('M d, Y') }}
                            @endif
                        @else
                            <span class="text-muted">No expiry</span>
                        @endif
                    </td>
                    <td>
                        @if($coupon->is_verified)<span class="badge bg-success me-1">Verified</span>@endif
                        @if($coupon->is_exclusive)<span class="badge bg-primary">Exclusive</span>@endif
                    </td>
                    <td class="pe-3 text-end">
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-xs btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this coupon?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-ticket-perforated fs-2 d-block mb-2 opacity-50"></i>
                        No coupons yet.
                        <a href="{{ route('admin.coupons.create', ['store_id' => $store->id]) }}">Add the first coupon</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($coupons->hasPages())
    <div class="card-footer bg-white">{{ $coupons->links() }}</div>
    @endif
</div>

<style>.btn-xs { padding:.2rem .45rem;font-size:.75rem;border-radius:6px; }</style>
@endsection
