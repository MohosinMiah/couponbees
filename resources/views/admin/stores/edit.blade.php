@extends('admin.layouts.app')
@section('title', 'Edit Store')

@section('content')

<div class="page-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.stores.index') }}">Stores</a></li>
            <li class="breadcrumb-item active">Edit: {{ $store->name }}</li>
        </ol>
    </nav>
    <h1><i class="bi bi-pencil me-2 text-primary"></i>Edit Store: {{ $store->name }}</h1>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <form action="{{ route('admin.stores.update', $store) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            {{-- Basic Info --}}
            <div class="card border shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">Basic Information</div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Store Name <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $store->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Slug</label>
                            <div class="input-group">
                                <span class="input-group-text text-muted small">/store/</span>
                                <input type="text" name="slug"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       value="{{ old('slug', $store->slug) }}">
                            </div>
                            @error('slug')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Company Type <span class="text-danger">*</span></label>
                            <select name="company_type" class="form-select @error('company_type') is-invalid @enderror" required>
                                <option value="">— Select Type —</option>
                                <option value="propfirm" {{ old('company_type', $store->company_type) === 'propfirm' ? 'selected' : '' }}>Prop Firm</option>
                                <option value="broker" {{ old('company_type', $store->company_type) === 'broker' ? 'selected' : '' }}>Broker</option>
                            </select>
                            @error('company_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Position <span class="text-muted small">(lower shows first)</span></label>
                            <input type="number" name="position" class="form-control @error('position') is-invalid @enderror"
                                   value="{{ old('position', $store->position) }}" min="0">
                            @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Website URL</label>
                            <input type="url" name="website"
                                   class="form-control @error('website') is-invalid @enderror"
                                   value="{{ old('website', $store->website) }}">
                            @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $store->description) }}</textarea>
                        </div>

                        <div class="col-12">
                            @php $selectedCategoryIds = collect(old('category_ids', $store->categories->pluck('id'))); @endphp
                            <label class="form-label">Categories</label>
                            <select name="category_ids[]" class="form-select" multiple data-placeholder="Select categories...">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $selectedCategoryIds->contains($category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            <div class="form-text">A store can belong to multiple categories.</div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Logo Upload --}}
            <div class="card border shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">Store Logo</div>
                <div class="card-body">
                    <div class="row g-3 align-items-center">

                        {{-- Current / Preview --}}
                        <div class="col-auto">
                            <div class="logo-preview-box border rounded-3 bg-light d-flex align-items-center justify-content-center overflow-hidden"
                                 style="width:100px;height:100px;">
                                @if($store->logo)
                                    <img id="logoPreview" src="{{ asset($store->logo) }}"
                                         alt="{{ $store->name }} logo"
                                         class="img-fluid" style="object-fit:contain;max-height:100px;">
                                    <span id="logoPlaceholder" class="text-muted d-none" style="font-size:2rem;">
                                        <i class="bi bi-image"></i>
                                    </span>
                                @else
                                    <img id="logoPreview" src="" alt="Preview"
                                         class="d-none img-fluid" style="object-fit:contain;max-height:100px;">
                                    <span id="logoPlaceholder" class="text-muted" style="font-size:2rem;">
                                        <i class="bi bi-image"></i>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col">
                            <label class="form-label fw-semibold">
                                {{ $store->logo ? 'Replace Logo' : 'Upload Logo' }}
                            </label>
                            <input type="file" name="logo" id="logoInput"
                                   class="form-control @error('logo') is-invalid @enderror"
                                   accept="image/jpeg,image/png,image/gif,image/webp,image/svg+xml">
                            @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Accepted: JPG, PNG, GIF, WebP, SVG. Max: 2MB.</div>

                            @if($store->logo)
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox"
                                       name="remove_logo" id="removeLogo" value="1">
                                <label class="form-check-label text-danger small" for="removeLogo">
                                    <i class="bi bi-trash me-1"></i>Remove current logo
                                </label>
                            </div>
                            @endif
                        </div>

                    </div>

                    {{-- Current logo filename --}}
                    @if($store->logo)
                    <div class="mt-3 pt-3 border-top d-flex align-items-center gap-2">
                        <span class="small text-muted">Current:</span>
                        <code class="small">{{ basename($store->logo) }}</code>
                        <a href="{{ asset($store->logo) }}" target="_blank" class="btn btn-xs btn-outline-secondary ms-1">
                            <i class="bi bi-eye me-1"></i>View
                        </a>
                    </div>
                    @endif

                </div>
            </div>


            {{-- Store Details / Content --}}
            <div class="card border shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Store Details <span class="text-muted small fw-normal">(shown below Activity Log on frontend)</span></span>
                </div>
                <div class="card-body">
                    <label class="form-label">Content</label>
                    <textarea name="details" id="detailsEditor" class="d-none @error('details') is-invalid @enderror"
                              rows="10">{{ old('details', $store->details) }}</textarea>
                    <div id="detailsQuillEditor"></div>
                    @error('details')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    <div class="form-text">Supports rich text formatting via the editor toolbar.</div>
                </div>
            </div>

            {{-- SEO --}}
            <div class="card border shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">SEO Settings</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control"
                                   value="{{ old('meta_title', $store->meta_title) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $store->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Settings --}}
            <div class="card border shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">Settings</div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_popular"
                               id="isPopular" value="1"
                               {{ old('is_popular', $store->is_popular) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isPopular">
                            <i class="bi bi-fire text-danger me-1"></i>Mark as Popular Store
                        </label>
                        <div class="text-muted small">Popular stores appear in the sidebar and Popular Prop Firms / Brokers sections.</div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_trusted"
                               id="isTrusted" value="1"
                               {{ old('is_trusted', $store->is_trusted) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isTrusted">
                            <i class="bi bi-shield-check text-success me-1"></i>Mark as Trusted (100% Payout)
                        </label>
                        <div class="text-muted small">Trusted stores appear in the homepage "Trusted and 100% Payout Provided" section.</div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i>Save Changes
                </button>
                <a href="{{ route('admin.stores.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <a href="{{ route('stores.show', $store->slug) }}" target="_blank" class="btn btn-outline-info ms-auto">
                    <i class="bi bi-eye me-1"></i>View on Site
                </a>
            </div>

        </form>
    </div>

    <div class="col-lg-4">

        {{-- Store Stats --}}
        <div class="card border shadow-sm mb-3">
            <div class="card-header bg-white fw-semibold small">Store Stats</div>
            <div class="card-body small">
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Page Views</span>
                    <strong>{{ number_format($store->page_views) }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Total Coupons</span>
                    <strong>{{ $store->coupons()->count() }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted">Created</span>
                    <strong>{{ $store->created_at->format('M d, Y') }}</strong>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted">Last Updated</span>
                    <strong>{{ $store->updated_at->diffForHumans() }}</strong>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.coupons.create', ['store_id' => $store->id]) }}"
           class="btn btn-success w-100 mb-3">
            <i class="bi bi-plus-lg me-1"></i>Add Coupon to this Store
        </a>

        {{-- Danger Zone --}}
        <div class="card border-danger">
            <div class="card-header bg-danger text-white small fw-semibold">Danger Zone</div>
            <div class="card-body">
                <p class="small text-muted mb-2">Deleting removes the store, all its coupons, and the logo file.</p>
                <form action="{{ route('admin.stores.destroy', $store) }}" method="POST"
                      onsubmit="return confirm('Permanently delete {{ addslashes($store->name) }} and ALL its coupons?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm w-100">
                        <i class="bi bi-trash me-1"></i>Delete Store
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<style>.btn-xs { padding:.2rem .45rem;font-size:.75rem;border-radius:6px; }</style>

@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>

// Quill rich text editor for Store Details.
// The textarea stays in the form (hidden) as the field Laravel actually
// receives; Quill's contenteditable div is just the visual editor.
var detailsTextarea = document.getElementById('detailsEditor');
var detailsQuill = new Quill('#detailsQuillEditor', {
    theme: 'snow',
    placeholder: 'Write detailed store info, FAQs, how-to-use guides...',
    modules: {
        toolbar: [
            [{ header: [2, 3, false] }],
            ['bold', 'italic', 'underline'],
            [{ list: 'ordered' }, { list: 'bullet' }],
            ['link'],
            ['clean']
        ]
    }
});

if (detailsTextarea.value) {
    detailsQuill.clipboard.dangerouslyPasteHTML(detailsTextarea.value);
}

detailsQuill.on('text-change', function () {
    detailsTextarea.value = detailsQuill.root.innerHTML;
});

detailsTextarea.closest('form').addEventListener('submit', function () {
    detailsTextarea.value = detailsQuill.root.innerHTML;
});

// Live logo preview on new file select
document.getElementById('logoInput').addEventListener('change', function () {
    var file = this.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function (e) {
        var preview     = document.getElementById('logoPreview');
        var placeholder = document.getElementById('logoPlaceholder');
        preview.src = e.target.result;
        preview.classList.remove('d-none');
        if (placeholder) placeholder.classList.add('d-none');
    };
    reader.readAsDataURL(file);
});

// Remove logo checkbox — grey out preview
var removeChk = document.getElementById('removeLogo');
if (removeChk) {
    removeChk.addEventListener('change', function () {
        var preview = document.getElementById('logoPreview');
        preview.style.opacity = this.checked ? '0.25' : '1';
    });
}
</script>
@endpush
