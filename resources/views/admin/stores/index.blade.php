@extends('admin.layouts.app')
@section('title', 'Stores')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h1><i class="bi bi-shop me-2 text-primary"></i>Stores</h1>
    <a href="{{ route('admin.stores.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Store
    </a>
</div>

{{-- Filters --}}
<div class="card border shadow-sm mb-4">
    <div class="card-body py-3">
        <form action="{{ route('admin.stores.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Search by store name..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="popular" class="form-select form-select-sm">
                    <option value="">All Stores</option>
                    <option value="1" {{ request('popular') === '1' ? 'selected' : '' }}>Popular Only</option>
                    <option value="0" {{ request('popular') === '0' ? 'selected' : '' }}>Non-Popular</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="company_type" class="form-select form-select-sm">
                    <option value="">All Types</option>
                    <option value="propfirm" {{ request('company_type') === 'propfirm' ? 'selected' : '' }}>Prop Firm</option>
                    <option value="broker" {{ request('company_type') === 'broker' ? 'selected' : '' }}>Broker</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
                <a href="{{ route('admin.stores.index') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card border shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3" style="width:5%">#</th>
                    <th>Store Name</th>
                    <th>Slug</th>
                    <th>Type</th>
                    <th style="width:70px">Position</th>
                    <th>Coupons</th>
                    <th>Views</th>
                    <th>Popular</th>
                    <th>Website</th>
                    <th class="pe-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stores as $store)
                <tr>
                    <td class="ps-3 text-muted small">{{ $store->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center justify-content-center bg-light border rounded overflow-hidden"
                                 style="width:36px;height:36px;min-width:36px;">
                                @if($store->logo)
                                    <img src="{{ asset($store->logo) }}" alt="{{ $store->name }}"
                                         style="object-fit:contain;width:36px;height:36px;">
                                @else
                                    <span class="fw-bold text-primary" style="font-size:.85rem;">{{ $store->initials }}</span>
                                @endif
                            </div>
                            <div>
                                <div class="fw-semibold small">{{ $store->name }}</div>
                                @if($store->description)
                                <div class="text-muted" style="font-size:.72rem">{{ Str::limit($store->description, 45) }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td><code class="small">{{ $store->slug }}</code></td>
                    <td>
                        @if($store->company_type === 'propfirm')
                            <span class="badge bg-info text-dark">Prop Firm</span>
                        @elseif($store->company_type === 'broker')
                            <span class="badge bg-secondary">Broker</span>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td class="small text-muted">{{ $store->position }}</td>
                    <td>
                        <a href="{{ route('admin.coupons.index', ['store_id' => $store->id]) }}" class="badge bg-primary text-decoration-none">
                            {{ $store->coupons_count }} coupons
                        </a>
                    </td>
                    <td class="small">{{ number_format($store->page_views) }}</td>
                    <td>
                        @if($store->is_popular)
                        <span class="badge bg-warning text-dark"><i class="bi bi-fire me-1"></i>Popular</span>
                        @else
                        <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td>
                        @if($store->website)
                        <a href="{{ $store->website }}" target="_blank" rel="noopener" class="small text-primary text-decoration-none">
                            <i class="bi bi-box-arrow-up-right me-1"></i>Visit
                        </a>
                        @else
                        <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td class="pe-3 text-end">
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="{{ route('stores.show', $store->slug) }}" target="_blank"
                               class="btn btn-xs btn-outline-secondary" title="View on site">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.stores.edit', $store) }}" class="btn btn-xs btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.stores.destroy', $store) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete store {{ addslashes($store->name) }} and ALL its coupons?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-5 text-muted">
                        <i class="bi bi-shop fs-2 d-block mb-2 opacity-50"></i>
                        No stores found.
                        <a href="{{ route('admin.stores.create') }}">Add your first store</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($stores->hasPages())
    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
        <span class="small text-muted">Showing {{ $stores->firstItem() }}–{{ $stores->lastItem() }} of {{ $stores->total() }}</span>
        {{ $stores->links() }}
    </div>
    @endif
</div>

<style>
.btn-xs { padding: .2rem .45rem; font-size: .75rem; border-radius: 6px; }
</style>
@endsection
