@extends('admin.layouts.app')
@section('title', 'Edit Sponsor')

@section('content')

<div class="page-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.sponsors.index') }}">Sponsors</a></li>
            <li class="breadcrumb-item active">Edit Sponsor</li>
        </ol>
    </nav>
    <h1><i class="bi bi-award me-2 text-primary"></i>Edit Sponsor</h1>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <form action="{{ route('admin.sponsors.update', $sponsor) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card border shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">Sponsor Details</div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-md-8">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $sponsor->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Position</label>
                            <input type="number" name="position" class="form-control @error('position') is-invalid @enderror"
                                   value="{{ old('position', $sponsor->position) }}" min="0">
                            @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Link <span class="text-danger">*</span></label>
                            <input type="url" name="link" class="form-control @error('link') is-invalid @enderror"
                                   value="{{ old('link', $sponsor->link) }}" required>
                            @error('link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">SVG Code <span class="text-danger">*</span></label>
                            <textarea name="svg" id="svgInput" class="form-control font-monospace small @error('svg') is-invalid @enderror"
                                      rows="8" required>{{ old('svg', $sponsor->svg) }}</textarea>
                            @error('svg')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Paste the full &lt;svg&gt;...&lt;/svg&gt; markup for the logo shown in the sponsor bar.</div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Preview</label>
                            <div id="svgPreview" class="d-flex align-items-center justify-content-center rounded-3 p-3"
                                 style="background:#1a1747;min-height:60px;"></div>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive"
                                       value="1" {{ old('is_active', $sponsor->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="isActive">
                                    <i class="bi bi-check-circle text-success me-1"></i>Active
                                </label>
                                <div class="text-muted small">Inactive sponsors are hidden from the sponsor bar and the Become a Sponsor page.</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i>Update Sponsor
                </button>
                <a href="{{ route('admin.sponsors.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 bg-light">
            <div class="card-body small text-muted">
                <h6 class="fw-semibold text-dark"><i class="bi bi-info-circle me-1"></i>Tips</h6>
                <ul class="ps-3 mb-0">
                    <li class="mb-1">The SVG should use <code>fill="white"</code> or <code>stroke="white"</code> so it's visible on the dark sponsor bar.</li>
                    <li class="mb-1"><strong>Position</strong> controls display order (lower shows first).</li>
                    <li>Uncheck <strong>Active</strong> to pause a sponsor without deleting it.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    var svgInput   = document.getElementById('svgInput');
    var svgPreview = document.getElementById('svgPreview');

    function updateSvgPreview() {
        svgPreview.innerHTML = svgInput.value.trim();
    }
    svgInput.addEventListener('input', updateSvgPreview);
    updateSvgPreview();
</script>
@endpush
