@extends('admin.layouts.app')
@section('title','Edit Banner')
@section('page-title','Edit Banner')

@push('styles')
<style>
    .btn-pink{background:#E91E8C!important;color:#fff!important;border:none}
    .btn-pink:hover{background:#C2185B!important}
    .section-heading{font-size:13px;font-weight:700;color:#E91E8C;
                     border-bottom:1px solid #f9c4dc;padding-bottom:6px;margin-bottom:14px}
    .img-preview{width:100%;max-height:140px;object-fit:cover;border-radius:10px;
                 display:none;border:2px dashed #E91E8C;margin-top:8px}
    .current-img{width:100%;max-height:120px;object-fit:cover;border-radius:8px;
                 border:2px solid #E91E8C;margin-bottom:8px}
    .upload-hint{font-size:11px;color:#999;margin-top:4px}
</style>
@endpush

@section('content')

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.banners.index') }}">Banners</a>
        </li>
        <li class="breadcrumb-item active">Edit Banner</li>
    </ol>
</nav>

<form action="{{ route('admin.banners.update', $banner->id) }}"
      method="POST" enctype="multipart/form-data">
@csrf
@method('POST')

<div class="row g-4">

    {{-- Left Column --}}
    <div class="col-md-8">

        {{-- Basic Info --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="section-heading">Banner Information</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Banner Type <span class="text-danger">*</span>
                        </label>
                        <select name="type" class="form-select" required>
                            <option value="">-- Select Type --</option>
                            @foreach($typeLabels as $key => $label)
                                <option value="{{ $key }}"
                                    {{ $banner->type === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Position <span class="text-danger">*</span>
                        </label>
                        <select name="position" class="form-select" required>
                            <option value="">-- Select Position --</option>
                            @foreach($positionLabels as $key => $label)
                                <option value="{{ $key }}"
                                    {{ $banner->position === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('position')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text" name="title" class="form-control"
                               value="{{ old('title', $banner->title) }}"
                               placeholder="e.g. Summer Sale 2025">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Subtitle</label>
                        <input type="text" name="subtitle" class="form-control"
                               value="{{ old('subtitle', $banner->subtitle) }}"
                               placeholder="e.g. Up to 50% off">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Button Text</label>
                        <input type="text" name="button_text" class="form-control"
                               value="{{ old('button_text', $banner->button_text) }}"
                               placeholder="e.g. Shop Now">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Link URL</label>
                        <input type="url" name="link_url" class="form-control"
                               value="{{ old('link_url', $banner->link_url) }}"
                               placeholder="https://...">
                        @error('link_url')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Images --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="section-heading">Banner Images</div>
                <div class="row g-3">

                    {{-- Desktop Image --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Desktop Image</label>

                        @if($banner->image)
                        <div class="mb-2">
                            <img src="{{ asset('uploads/banners/'.$banner->image) }}"
                                 class="current-img" alt="Current Desktop">
                            <small class="text-muted d-block">Current image</small>
                        </div>
                        @endif

                        <input type="file" name="image" id="desktopImg"
                               class="form-control" accept="image/*">
                        <div class="upload-hint">
                            Nai image upload karo ya blank chhodo (purani rahegi)
                            — Max 2MB
                        </div>
                        @error('image')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <img id="desktopPreview" class="img-preview" alt="Preview">
                    </div>

                    {{-- Mobile Image --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Mobile Image</label>

                        @if($banner->image_mobile)
                        <div class="mb-2">
                            <img src="{{ asset('uploads/banners/'.$banner->image_mobile) }}"
                                 class="current-img" alt="Current Mobile">
                            <small class="text-muted d-block">Current mobile image</small>
                        </div>
                        @else
                        <div class="mb-2">
                            <small class="text-muted">Koi mobile image nahi hai</small>
                        </div>
                        @endif

                        <input type="file" name="image_mobile" id="mobileImg"
                               class="form-control" accept="image/*">
                        <div class="upload-hint">
                            Nai image upload karo ya blank chhodo — Max 2MB
                        </div>
                        @error('image_mobile')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <img id="mobilePreview" class="img-preview" alt="Preview">
                    </div>

                </div>
            </div>
        </div>

    </div>

    {{-- Right Column --}}
    <div class="col-md-4">

        {{-- Settings --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="section-heading">Settings</div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control"
                               value="{{ old('sort_order', $banner->sort_order) }}"
                               min="0">
                        <small class="text-muted">Chhota number = pehle dikhega</small>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Start Date</label>
                        <input type="date" name="start_date" class="form-control"
                               value="{{ old('start_date', $banner->start_date?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">End Date</label>
                        <input type="date" name="end_date" class="form-control"
                               value="{{ old('end_date', $banner->end_date?->format('Y-m-d')) }}">
                        @error('end_date')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        @if($banner->isExpired())
                        <div class="alert alert-danger py-1 mt-2 small">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Ye banner expire ho gaya hai!
                        </div>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="status"
                                   class="form-check-input" id="statusCheck"
                                   {{ $banner->status ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold"
                                   for="statusCheck">Active</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Banner Info --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="section-heading">Banner Info</div>
                <div class="small">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">ID:</span>
                        <span class="fw-semibold">#{{ $banner->id }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Created:</span>
                        <span class="fw-semibold">
                            {{ $banner->created_at->format('d M Y') }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Updated:</span>
                        <span class="fw-semibold">
                            {{ $banner->updated_at->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <button type="submit" class="btn btn-pink w-100 mb-2">
                    <i class="bi bi-check-lg me-2"></i>Update Banner
                </button>
                <a href="{{ route('admin.banners.index') }}"
                   class="btn btn-outline-secondary w-100">
                    <i class="bi bi-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>

    </div>
</div>

</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    function setupPreview(inputId, previewId) {
        var input   = document.getElementById(inputId);
        var preview = document.getElementById(previewId);
        if (!input) return;

        input.addEventListener('change', function() {
            var file = this.files[0];
            if (!file) return;

            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: '2MB se badi image!',
                    text: 'Maximum 2MB allowed hai.',
                    confirmButtonColor: '#E91E8C'
                });
                this.value = '';
                preview.style.display = 'none';
                return;
            }

            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }

    setupPreview('desktopImg', 'desktopPreview');
    setupPreview('mobileImg',  'mobilePreview');

});
</script>
@endpush