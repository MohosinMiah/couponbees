@extends('admin.layouts.app')
@section('title', 'Edit Category')

@section('content')

<div class="page-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
            <li class="breadcrumb-item active">Edit Category</li>
        </ol>
    </nav>
    <h1><i class="bi bi-tags me-2 text-primary"></i>Edit Category</h1>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card border shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">Category Details</div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-md-8">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="categoryName"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $category->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Position</label>
                            <input type="number" name="position" class="form-control @error('position') is-invalid @enderror"
                                   value="{{ old('position', $category->position) }}" min="0">
                            @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Slug</label>
                            <div class="input-group">
                                <span class="input-group-text text-muted small">/category/</span>
                                <input type="text" name="slug" id="categorySlug"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       value="{{ old('slug', $category->slug) }}">
                            </div>
                            @error('slug')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive"
                                       value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="isActive">
                                    <i class="bi bi-check-circle text-success me-1"></i>Active
                                </label>
                                <div class="text-muted small">Inactive categories are hidden from selection on the frontend.</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i>Update Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 bg-light">
            <div class="card-body small text-muted">
                <h6 class="fw-semibold text-dark"><i class="bi bi-info-circle me-1"></i>Tips</h6>
                <ul class="ps-3 mb-0">
                    <li class="mb-1"><strong>Position</strong> controls the display order (lower shows first).</li>
                    <li>Stores can be assigned to multiple categories from the Store edit page.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('categoryName').addEventListener('input', function () {
    var slug = this.value.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .trim().replace(/\s+/g, '-');
    document.getElementById('categorySlug').value = slug;
});
</script>
@endpush
