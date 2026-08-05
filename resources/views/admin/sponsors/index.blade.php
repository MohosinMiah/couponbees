@extends('admin.layouts.app')
@section('title', 'Sponsors')

@section('content')

<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h1><i class="bi bi-award me-2 text-primary"></i>Sponsors</h1>
    <a href="{{ route('admin.sponsors.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Sponsor
    </a>
</div>

{{-- Filters --}}
<div class="card border shadow-sm mb-4">
    <div class="card-body py-3">
        <form action="{{ route('admin.sponsors.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm"
                       placeholder="Search sponsor name..." value="{{ request('search') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search me-1"></i>Filter</button>
                <a href="{{ route('admin.sponsors.index') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
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
                    <th style="width:140px">Preview</th>
                    <th>Name</th>
                    <th>SVG Code</th>
                    <th>Link</th>
                    <th>Status</th>
                    <th class="pe-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sponsors as $sponsor)
                <tr>
                    <td class="ps-3 small text-muted">{{ $sponsor->position }}</td>
                    <td>
                        <div class="d-flex align-items-center justify-content-center rounded-3 p-2" style="background:#1a1747;height:40px;">
                            {!! $sponsor->svg !!}
                        </div>
                    </td>
                    <td class="fw-semibold small">{{ $sponsor->name }}</td>
                    <td>
                        <code class="small bg-light px-2 py-1 rounded text-truncate d-inline-block" style="max-width:220px;">
                            {{ Str::limit($sponsor->svg, 60) }}
                        </code>
                    </td>
                    <td class="small">
                        <a href="{{ $sponsor->link }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
                            {{ Str::limit($sponsor->link, 32) }} <i class="bi bi-box-arrow-up-right ms-1"></i>
                        </a>
                    </td>
                    <td>
                        @if($sponsor->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td class="pe-3 text-end">
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="btn btn-xs btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.sponsors.destroy', $sponsor) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this sponsor?')">
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
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-award fs-2 d-block mb-2 opacity-50"></i>
                        No sponsors found. <a href="{{ route('admin.sponsors.create') }}">Add your first sponsor</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($sponsors->hasPages())
    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
        <span class="small text-muted">Showing {{ $sponsors->firstItem() }}–{{ $sponsors->lastItem() }} of {{ $sponsors->total() }}</span>
        {{ $sponsors->links() }}
    </div>
    @endif
</div>

<style>.btn-xs { padding:.2rem .45rem;font-size:.75rem;border-radius:6px; }</style>
@endsection
