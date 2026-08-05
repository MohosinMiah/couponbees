@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h1><i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.stores.create') }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus me-1"></i>New Store
        </a>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus me-1"></i>New Coupon
        </a>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-shop"></i></div>
                <div>
                    <div class="fs-3 fw-bold">{{ $stats['total_stores'] }}</div>
                    <div class="small text-muted">Total Stores</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-success bg-opacity-10 text-success"><i class="bi bi-ticket-perforated"></i></div>
                <div>
                    <div class="fs-3 fw-bold">{{ $stats['total_coupons'] }}</div>
                    <div class="small text-muted">Total Coupons</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning"><i class="bi bi-clipboard-check"></i></div>
                <div>
                    <div class="fs-3 fw-bold">{{ number_format($stats['total_copies']) }}</div>
                    <div class="small text-muted">Total Copies</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-info bg-opacity-10 text-info"><i class="bi bi-eye"></i></div>
                <div>
                    <div class="fs-3 fw-bold">{{ number_format($stats['total_views']) }}</div>
                    <div class="small text-muted">Page Views</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-success bg-opacity-10 text-success"><i class="bi bi-hand-thumbs-up"></i></div>
                <div>
                    <div class="fs-3 fw-bold">{{ number_format($stats['total_success']) }}</div>
                    <div class="small text-muted">Worked</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-danger bg-opacity-10 text-danger"><i class="bi bi-hand-thumbs-down"></i></div>
                <div>
                    <div class="fs-3 fw-bold">{{ number_format($stats['total_failure']) }}</div>
                    <div class="small text-muted">Failed</div>
                </div>
            </div>
        </div>
    </div>
    @php
        $totalFeedback = $stats['total_success'] + $stats['total_failure'];
        $globalRate = $totalFeedback > 0 ? round(($stats['total_success'] / $totalFeedback) * 100) : 0;
    @endphp
    <div class="col-6 col-lg-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-graph-up"></i></div>
                <div>
                    <div class="fs-3 fw-bold">{{ $globalRate }}%</div>
                    <div class="small text-muted">Success Rate</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning"><i class="bi bi-fire"></i></div>
                <div>
                    <div class="fs-3 fw-bold">{{ $stats['popular_stores'] }}</div>
                    <div class="small text-muted">Popular Stores</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Recent Coupons --}}
    <div class="col-lg-7">
        <div class="card border shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="h6 fw-bold mb-0"><i class="bi bi-ticket-perforated me-1 text-primary"></i>Recent Coupons</h2>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Coupon</th>
                            <th>Store</th>
                            <th>Code</th>
                            <th class="pe-3">Copies</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentCoupons as $coupon)
                        <tr>
                            <td class="ps-3">
                                <a href="{{ route('admin.coupons.edit', $coupon) }}" class="text-decoration-none fw-semibold small">
                                    {{ Str::limit($coupon->title, 35) }}
                                </a>
                            </td>
                            <td><span class="small text-muted">{{ $coupon->store->name ?? '—' }}</span></td>
                            <td>
                                @if($coupon->code)
                                <code class="small bg-light px-2 py-1 rounded">{{ $coupon->code }}</code>
                                @else
                                <span class="badge bg-secondary">Deal</span>
                                @endif
                            </td>
                            <td class="pe-3 small">{{ number_format($coupon->copy_count) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Top Stores --}}
    <div class="col-lg-5">
        <div class="card border shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="h6 fw-bold mb-0"><i class="bi bi-trophy me-1 text-warning"></i>Top Stores by Views</h2>
                <a href="{{ route('admin.stores.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="list-group list-group-flush">
                @foreach($topStores as $i => $store)
                <div class="list-group-item d-flex align-items-center gap-3 py-2">
                    <span class="badge bg-{{ $i === 0 ? 'warning text-dark' : ($i === 1 ? 'secondary' : 'light text-dark') }} rounded-circle"
                          style="width:28px;height:28px;display:flex;align-items:center;justify-content:center;">
                        {{ $i + 1 }}
                    </span>
                    <div class="flex-grow-1 overflow-hidden">
                        <a href="{{ route('admin.stores.show', $store) }}" class="fw-semibold small text-decoration-none text-truncate d-block">
                            {{ $store->name }}
                        </a>
                        <div class="text-muted" style="font-size:.75rem">{{ $store->coupons_count }} coupons</div>
                    </div>
                    <span class="small text-muted text-nowrap">{{ number_format($store->page_views) }} views</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="card border shadow-sm mt-4">
            <div class="card-header bg-white">
                <h2 class="h6 fw-bold mb-0"><i class="bi bi-clock-history me-1 text-primary"></i>Recent Activity</h2>
            </div>
            <div class="list-group list-group-flush">
                @foreach($recentHistory as $history)
                <div class="list-group-item py-2 d-flex align-items-center gap-2">
                    @if($history->action === 'success')
                        <span class="badge bg-success">Worked</span>
                    @elseif($history->action === 'failure')
                        <span class="badge bg-danger">Failed</span>
                    @else
                        <span class="badge bg-secondary">Copied</span>
                    @endif
                    <span class="small text-truncate flex-grow-1">{{ Str::limit($history->coupon_title, 30) }}</span>
                    <span class="text-muted" style="font-size:.72rem;white-space:nowrap">{{ $history->created_at->diffForHumans() }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
