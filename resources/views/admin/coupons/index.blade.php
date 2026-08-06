@extends('admin.layouts.app')
@section('title', 'Coupons')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h1><i class="bi bi-ticket-perforated me-2 text-primary"></i>Coupons</h1>
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Coupon
    </a>
</div>

{{-- Filters --}}
<div class="card border shadow-sm mb-4">
    <div class="card-body py-3">
        <form action="{{ route('admin.coupons.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Search title or code..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="store_id" class="form-select form-select-sm">
                    <option value="">All Stores</option>
                    @foreach($stores as $store)
                    <option value="{{ $store->id }}" {{ request('store_id') == $store->id ? 'selected' : '' }}>
                        {{ $store->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="type" class="form-select form-select-sm">
                    <option value="">All Types</option>
                    <option value="code" {{ request('type') === 'code' ? 'selected' : '' }}>Code</option>
                    <option value="deal" {{ request('type') === 'deal' ? 'selected' : '' }}>Deal</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="verified" class="form-select form-select-sm">
                    <option value="">All</option>
                    <option value="1" {{ request('verified') === '1' ? 'selected' : '' }}>Verified</option>
                    <option value="0" {{ request('verified') === '0' ? 'selected' : '' }}>Unverified</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search me-1"></i>Filter</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card border shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">Coupon</th>
                    <th>Store</th>
                    <th>Code</th>
                    <th>Discount</th>
                    <th>Position</th>
                    <th>Copies</th>
                    <th>Success Rate</th>
                    <th>Expires</th>
                    <th>Badges</th>
                    <th class="pe-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                <tr>
                    <td class="ps-3">
                        <div class="fw-semibold small">{{ Str::limit($coupon->title, 38) }}</div>
                        <span class="badge bg-{{ $coupon->type === 'code' ? 'primary' : 'info' }} mt-1">
                            {{ ucfirst($coupon->type) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.stores.show', $coupon->store) }}" class="text-decoration-none small">
                            {{ $coupon->store->name ?? '—' }}
                        </a>
                    </td>
                    <td>
                        @if($coupon->code)
                        <code class="small bg-light px-2 py-1 rounded">{{ $coupon->code }}</code>
                        @else
                        <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td class="small">{{ $coupon->discount_label }}</td>
                    <td class="small">{{ $coupon->position }}</td>
                    <td class="small fw-semibold">{{ number_format($coupon->copy_count) }}</td>
                    <td>
                        @php $total = $coupon->success_count + $coupon->failure_count; @endphp
                        @if($total > 0)
                            @php $rate = round(($coupon->success_count / $total) * 100); @endphp
                            <div class="d-flex align-items-center gap-1">
                                <div class="progress" style="width:50px;height:6px">
                                    <div class="progress-bar bg-{{ $rate >= 70 ? 'success' : ($rate >= 40 ? 'warning' : 'danger') }}"
                                         style="width:{{ $rate }}%"></div>
                                </div>
                                <span class="small">{{ $rate }}%</span>
                            </div>
                        @else
                            <span class="text-muted small">No votes</span>
                        @endif
                    </td>
                    <td class="small">
                        @if($coupon->expires_at)
                            <span class="{{ $coupon->is_expired ? 'text-danger' : 'text-muted' }}">
                                {{ $coupon->expires_at->format('M d, Y') }}
                                @if($coupon->is_expired) <span class="badge bg-danger ms-1">Expired</span>@endif
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($coupon->is_verified)<span class="badge bg-success me-1">✓</span>@endif
                        @if($coupon->is_exclusive)<span class="badge bg-primary">★</span>@endif
                    </td>
                    <td class="pe-3 text-end">
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-xs btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.coupons.reset-stats', $coupon) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Reset all stats for this coupon?')">
                                @csrf
                                <button class="btn btn-xs btn-outline-warning" title="Reset Stats">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this coupon?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-5 text-muted">
                        <i class="bi bi-ticket-perforated fs-2 d-block mb-2 opacity-50"></i>
                        No coupons found. <a href="{{ route('admin.coupons.create') }}">Add your first coupon</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($coupons->hasPages())
    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
        <span class="small text-muted">Showing {{ $coupons->firstItem() }}–{{ $coupons->lastItem() }} of {{ $coupons->total() }}</span>
        {{ $coupons->links() }}
    </div>
    @endif
</div>

<style>.btn-xs { padding:.2rem .45rem;font-size:.75rem;border-radius:6px; }</style>
@endsection
