@extends('admin.layouts.app')
@section('title', 'Categories')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h1><i class="bi bi-tags me-2 text-primary"></i>Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Category
    </a>
</div>

{{-- Filters --}}
<div class="card border shadow-sm mb-4">
    <div class="card-body py-3">
        <form action="{{ route('admin.categories.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Search category name..." value="{{ request('search') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search me-1"></i>Filter</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card border shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3" style="width:70px">Position</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Stores</th>
                    <th>Status</th>
                    <th class="pe-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td class="ps-3 small text-muted">{{ $category->position }}</td>
                    <td class="fw-semibold small">{{ $category->name }}</td>
                    <td><code class="small bg-light px-2 py-1 rounded">{{ $category->slug }}</code></td>
                    <td class="small">{{ number_format($category->stores_count) }}</td>
                    <td>
                        @if($category->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td class="pe-3 text-end">
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-xs btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this category?')">
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
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-tags fs-2 d-block mb-2 opacity-50"></i>
                        No categories found. <a href="{{ route('admin.categories.create') }}">Add your first category</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
        <span class="small text-muted">Showing {{ $categories->firstItem() }}–{{ $categories->lastItem() }} of {{ $categories->total() }}</span>
        {{ $categories->links() }}
    </div>
    @endif
</div>

<style>.btn-xs { padding:.2rem .45rem;font-size:.75rem;border-radius:6px; }</style>
@endsection
