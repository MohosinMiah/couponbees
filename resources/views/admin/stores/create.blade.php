@extends('admin.layouts.app')
@section('title', 'Add Store')

@section('content')

<div class="page-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.stores.index') }}">Stores</a></li>
            <li class="breadcrumb-item active">Add Store</li>
        </ol>
    </nav>
    <h1><i class="bi bi-shop me-2 text-primary"></i>Add New Store</h1>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <form action="{{ route('admin.stores.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Basic Info --}}
            <div class="card border shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">Basic Information</div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Store Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="storeName"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" placeholder="e.g. FTMO" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Slug <span class="text-muted small">(auto-generated)</span></label>
                            <div class="input-group">
                                <span class="input-group-text text-muted small">/store/</span>
                                <input type="text" name="slug" id="storeSlug"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       value="{{ old('slug') }}" placeholder="ftmo">
                            </div>
                            @error('slug')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Company Type <span class="text-danger">*</span></label>
                            <select name="company_type" class="form-select @error('company_type') is-invalid @enderror" required>
                                <option value="">— Select Type —</option>
                                <option value="propfirm" {{ old('company_type') === 'propfirm' ? 'selected' : '' }}>Prop Firm</option>
                                <option value="broker" {{ old('company_type') === 'broker' ? 'selected' : '' }}>Broker</option>
                            </select>
                            @error('company_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Position <span class="text-muted small">(lower shows first)</span></label>
                            <input type="number" name="position" class="form-control @error('position') is-invalid @enderror"
                                   value="{{ old('position', 0) }}" min="0">
                            @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Website URL</label>
                            <input type="url" name="website"
                                   class="form-control @error('website') is-invalid @enderror"
                                   value="{{ old('website') }}" placeholder="https://amazon.com">
                            @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"
                                      placeholder="Short description of the store...">{{ old('description') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Categories</label>
                            <select name="category_ids[]" class="form-select" multiple data-placeholder="Select categories...">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ collect(old('category_ids'))->contains($category->id) ? 'selected' : '' }}>
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

                        {{-- Preview --}}
                        <div class="col-auto">
                            <div class="logo-preview-box border rounded-3 bg-light d-flex align-items-center justify-content-center overflow-hidden"
                                 style="width:100px;height:100px;">
                                <img id="logoPreview" src="" alt="Preview"
                                     class="d-none img-fluid" style="object-fit:contain;max-height:100px;">
                                <span id="logoPlaceholder" class="text-muted" style="font-size:2rem;">
                                    <i class="bi bi-image"></i>
                                </span>
                            </div>
                        </div>

                        <div class="col">
                            <label class="form-label fw-semibold">Upload Logo</label>
                            <input type="file" name="logo" id="logoInput"
                                   class="form-control @error('logo') is-invalid @enderror"
                                   accept="image/jpeg,image/png,image/gif,image/webp,image/svg+xml">
                            @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Accepted: JPG, PNG, GIF, WebP, SVG. Max size: 2MB.</div>
                        </div>

                    </div>
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
                              rows="10">{{ old('details') }}</textarea>
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
                                   value="{{ old('meta_title') }}"
                                   placeholder="Amazon Coupon Codes &amp; Promo Codes 2025">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2"
                                      placeholder="Find the latest Amazon coupon codes and deals.">{{ old('meta_description') }}</textarea>
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
                               id="isPopular" value="1" {{ old('is_popular') ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isPopular">
                            <i class="bi bi-fire text-danger me-1"></i>Mark as Popular Store
                        </label>
                        <div class="text-muted small">Popular stores appear in the sidebar and Popular Prop Firms / Brokers sections.</div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_trusted"
                               id="isTrusted" value="1" {{ old('is_trusted') ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isTrusted">
                            <i class="bi bi-shield-check text-success me-1"></i>Mark as Trusted (100% Payout)
                        </label>
                        <div class="text-muted small">Trusted stores appear in the homepage "Trusted and 100% Payout Provided" section.</div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i>Create Store
                </button>
                <a href="{{ route('admin.stores.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>

        </form>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 bg-light">
            <div class="card-body small text-muted">
                <h6 class="fw-semibold text-dark"><i class="bi bi-info-circle me-1"></i>Tips</h6>
                <ul class="ps-3 mb-0">
                    <li class="mb-1">The <strong>slug</strong> is used in the URL: <code>/store/amazon</code></li>
                    <li class="mb-1">It is auto-generated from the name if left blank.</li>
                    <li class="mb-1">The <strong>website URL</strong> opens when users click Copy Code.</li>
                    <li class="mb-1">Logo is shown on the store page and listings.</li>
                    <li>Best logo size: <strong>200×200px</strong> square.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
// Auto-generate slug from name
document.getElementById('storeName').addEventListener('input', function () {
    var slug = this.value.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .trim().replace(/\s+/g, '-');
    document.getElementById('storeSlug').value = slug;
});

// Logo preview
document.getElementById('logoInput').addEventListener('change', function () {
    var file = this.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function (e) {
        var preview = document.getElementById('logoPreview');
        var placeholder = document.getElementById('logoPlaceholder');
        preview.src = e.target.result;
        preview.classList.remove('d-none');
        placeholder.classList.add('d-none');
    };
    reader.readAsDataURL(file);
});

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
</script>
@endpush
