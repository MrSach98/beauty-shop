@extends('admin.layouts.app')
@section('title','Edit Product')
@section('page-title','Edit Product')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
<style>
    .btn-pink{background:#E91E8C!important;color:#fff!important;border:none}
    .btn-pink:hover{background:#C2185B!important}
    .nav-tabs .nav-link{color:#555;font-weight:600;border:none;padding:10px 16px}
    .nav-tabs .nav-link.active{color:#E91E8C;border-bottom:3px solid #E91E8C;background:transparent}
    .section-heading{font-size:13px;font-weight:700;color:#E91E8C;border-bottom:1px solid #f9c4dc;padding-bottom:6px;margin-bottom:14px}
    .img-preview-thumb{width:80px;height:80px;object-fit:cover;border-radius:8px;display:none;border:2px dashed #E91E8C;margin-top:6px}
    .current-img{width:80px;height:80px;object-fit:cover;border-radius:8px;border:2px solid #E91E8C}
    .tag-wrap{border:1px solid #dee2e6;border-radius:8px;padding:6px 10px;min-height:42px;display:flex;flex-wrap:wrap;gap:6px;align-items:center;cursor:text}
    .tag-item{background:#FCE4EC;color:#C2185B;border-radius:20px;padding:3px 10px;font-size:12px;display:flex;align-items:center;gap:4px}
    .tag-item .remove-tag{cursor:pointer;font-weight:bold}
    .tag-field{border:none;outline:none;flex:1;min-width:100px;font-size:13px}
    .attr-row{background:#f8f9fa;border-radius:8px;padding:10px;margin-bottom:8px}
    .color-row{background:#fff8fb;border:1px solid #f9c4dc;border-radius:8px;padding:10px;margin-bottom:8px}
</style>
@endpush

@section('content')

@php $ef = $product->extra_fields ?? []; @endphp

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
        <li class="breadcrumb-item active">Edit: {{ $product->name }}</li>
    </ol>
</nav>

<form id="productForm"
      action="{{ route('admin.products.update', $product->id) }}"
      method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
<input type="hidden" name="product_type" value="{{ $product->product_type }}">

{{-- Type Heading --}}
<div class="card border-0 shadow-sm mb-0">
    <div class="card-body py-3">
        <div class="d-flex align-items-center gap-3">
            <div style="font-size:32px">{{ $selectedType->icon ?? '📦' }}</div>
            <div>
                <h5 class="mb-0 fw-bold">{{ $product->name }}</h5>
                <small class="text-muted">
                    {{ $selectedType->name ?? $product->product_type }}
                    &nbsp;|&nbsp; SKU: <strong>{{ $product->sku }}</strong>
                    &nbsp;|&nbsp; Added: {{ $product->created_at->format('d M Y') }}
                </small>
            </div>
            <div class="ms-auto d-flex gap-2">
                <a href="{{ route('admin.products.show', $product->id) }}"
                   class="btn btn-outline-info btn-sm">
                    <i class="bi bi-eye me-1"></i>View
                </a>
                <a href="{{ route('admin.products.index') }}"
                   class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Back
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Tabs --}}
<ul class="nav nav-tabs mb-0 bg-white px-2 shadow-sm flex-nowrap overflow-auto">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#tab-basic">
            📋 Basic Info
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#tab-pricing">
            💰 Pricing & Stock
        </a>
    </li>

    {{-- Dynamic Tabs --}}
    @if($selectedType)
        @php
            $tabMeta = [
                'beauty'     => ['icon'=>'💄','label'=>'Beauty Details'],
                'clothing'   => ['icon'=>'👗','label'=>'Clothing Details'],
                'book'       => ['icon'=>'📚','label'=>'Book Details'],
                'electronic' => ['icon'=>'💻','label'=>'Electronics Details'],
                'mobile'     => ['icon'=>'📱','label'=>'Mobile Details'],
                'jewelry'    => ['icon'=>'💍','label'=>'Jewelry Details'],
                'grocery'    => ['icon'=>'🛒','label'=>'Grocery Details'],
                'furniture'  => ['icon'=>'🪑','label'=>'Furniture Details'],
                'sports'     => ['icon'=>'⚽','label'=>'Sports Details'],
                'baby'       => ['icon'=>'🍼','label'=>'Baby Details'],
                'pet'        => ['icon'=>'🐾','label'=>'Pet Details'],
                'medical'    => ['icon'=>'💊','label'=>'Medical Details'],
            ];
        @endphp
        @foreach($selectedType->tabs ?? [] as $tab)
            @php $meta = $tabMeta[$tab] ?? ['icon'=>'📦','label'=>ucfirst($tab).' Details']; @endphp
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab-{{ $tab }}">
                    {{ $meta['icon'] }} {{ $meta['label'] }}
                </a>
            </li>
        @endforeach
    @endif

    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#tab-media">🖼️ Media</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#tab-desc">📝 Description</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#tab-shipping">🚚 Shipping & SEO</a>
    </li>
</ul>

<div class="tab-content">

{{-- ══ TAB 1: BASIC INFO ══ --}}
<div class="tab-pane fade show active p-4 bg-white shadow-sm" id="tab-basic">
    <div class="section-heading">Basic Information</div>
    <div class="row g-3">
        <div class="col-md-8">
            <label class="form-label fw-semibold">
                Product Name <span class="text-danger">*</span>
            </label>
            <input type="text" name="name" id="productName"
                   class="form-control" value="{{ $product->name }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">SKU</label>
            <input type="text" name="sku" class="form-control"
                   value="{{ $product->sku }}" readonly
                   style="background:#f8f9fa;color:#666">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Slug</label>
            <input type="text" name="slug" id="productSlug"
                   class="form-control" value="{{ $product->slug }}">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Brand</label>
            <input type="text" name="brand" class="form-control"
                   value="{{ $product->brand }}">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">
                Category <span class="text-danger">*</span>
            </label>
            <select name="category_id" id="catSelect" class="form-select" required>
                <option value="">-- Select --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Subcategory</label>
            <select name="subcategory_id" id="subSelect" class="form-select">
                <option value="">-- Select --</option>
                @foreach($subcategories as $sub)
                    <option value="{{ $sub->id }}"
                        {{ $product->subcategory_id == $sub->id ? 'selected' : '' }}>
                        {{ $sub->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Child Subcategory</label>
            <select name="child_subcategory_id" id="childSelect" class="form-select">
                <option value="">-- Select --</option>
                @foreach($childSubs as $child)
                    <option value="{{ $child->id }}"
                        {{ $product->child_subcategory_id == $child->id ? 'selected' : '' }}>
                        {{ $child->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            <label class="form-label fw-semibold">Tags</label>
            <div class="tag-wrap" id="tagWrap">
                <input type="text" class="tag-field" id="tagInput"
                       placeholder="Tag type karo aur Enter dabaao">
            </div>
            <input type="hidden" name="tags" id="tagsHidden"
                   value="{{ $product->tags }}">
        </div>
        <div class="col-md-12">
            <div class="section-heading mt-2">Product Flags</div>
            <div class="d-flex flex-wrap gap-4">
                <div class="form-check form-switch">
                    <input type="checkbox" name="is_active" class="form-check-input"
                           {{ $product->is_active ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold">Active</label>
                </div>
                <div class="form-check form-switch">
                    <input type="checkbox" name="product_on_sale" class="form-check-input"
                           {{ $product->product_on_sale ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold">🔥 On Sale</label>
                </div>
                <div class="form-check form-switch">
                    <input type="checkbox" name="new_arrivals" class="form-check-input"
                           {{ $product->new_arrivals ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold">🆕 New Arrival</label>
                </div>
                <div class="form-check form-switch">
                    <input type="checkbox" name="featured" class="form-check-input"
                           {{ $product->featured ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold">⭐ Featured</label>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══ TAB 2: PRICING ══ --}}
<div class="tab-pane fade p-4 bg-white shadow-sm" id="tab-pricing">
    <div class="section-heading">Pricing & Stock</div>
    <div class="row g-3">
        <div class="col-md-3">
            <label class="form-label fw-semibold">
                MRP Price (₹) <span class="text-danger">*</span>
            </label>
            <input type="number" name="mrp_price" id="mrpPrice"
                   class="form-control" value="{{ $product->mrp_price }}"
                   step="0.01" min="0" required>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">
                Display Price (₹) <span class="text-danger">*</span>
            </label>
            <input type="number" name="display_price" id="displayPrice"
                   class="form-control" value="{{ $product->display_price }}"
                   step="0.01" min="0" required>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Discount %</label>
            <input type="text" id="discountShow" class="form-control" readonly
                   value="{{ $product->discount }}%"
                   style="background:#f8f9fa;color:#E91E8C;font-weight:700">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Savings</label>
            <input type="text" id="savingsShow" class="form-control" readonly
                   value="₹{{ number_format($product->mrp_price - $product->display_price, 2) }}"
                   style="background:#f8f9fa;color:#16a34a;font-weight:700">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">
                Stock Qty <span class="text-danger">*</span>
            </label>
            <input type="number" name="stock" class="form-control"
                   value="{{ $product->stock }}" min="0" required>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Low Stock Alert Qty</label>
            <input type="number" name="low_stock_alert" class="form-control"
                   value="{{ $product->low_stock_alert }}">
        </div>
    </div>
</div>

{{-- ══ DYNAMIC TABS ══ --}}
@if($selectedType)
    @foreach($selectedType->tabs ?? [] as $tab)

        {{-- ── BEAUTY ── --}}
        @if($tab === 'beauty')
        <div class="tab-pane fade p-4 bg-white shadow-sm" id="tab-beauty">
            <div class="section-heading">💄 Beauty & Cosmetics Details</div>
            @php $skinTypes = $ef['skin_type'] ?? []; @endphp
            @php $concerns  = $ef['concern']   ?? []; @endphp
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Skin Type (multiple)</label>
                    <div class="d-flex flex-wrap gap-3 mt-1">
                        @foreach(['Oily','Dry','Combination','Sensitive','Normal','All'] as $st)
                        <div class="form-check">
                            <input type="checkbox" name="skin_type[]"
                                   value="{{ $st }}" class="form-check-input"
                                   {{ in_array($st, $skinTypes) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $st }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Men','Women','Unisex','Kids'] as $g)
                            <option {{ ($ef['gender'] ?? '') === $g ? 'selected' : '' }}>
                                {{ $g }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Net Weight</label>
                    <input type="text" name="net_weight" class="form-control"
                           value="{{ $ef['net_weight'] ?? '' }}"
                           placeholder="e.g. 50ml, 100g">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Concern (multiple)</label>
                    <div class="d-flex flex-wrap gap-3 mt-1">
                        @foreach(['Acne','Anti-Aging','Brightening','Hydration','Dark Spots','Sun Protection','Anti-Hair Fall','Dandruff'] as $c)
                        <div class="form-check">
                            <input type="checkbox" name="concern[]"
                                   value="{{ $c }}" class="form-check-input"
                                   {{ in_array($c, $concerns) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $c }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Shelf Life</label>
                    <input type="text" name="shelf_life" class="form-control"
                           value="{{ $ef['shelf_life'] ?? '' }}"
                           placeholder="e.g. 24 months">
                </div>
                <div class="col-md-12">
                    <div class="section-heading mt-2">Ingredients</div>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Key Ingredients</label>
                    <input type="text" name="key_ingredients" class="form-control"
                           value="{{ $ef['key_ingredients'] ?? '' }}"
                        placeholder="Vitamin C, Niacinamide (separate with commas)">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Full Ingredients List</label>
                    <textarea name="full_ingredients" class="form-control"
                              rows="3">{{ $ef['full_ingredients'] ?? '' }}</textarea>
                </div>
                <div class="col-md-12">
                    <div class="d-flex flex-wrap gap-4">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_organic"
                                   class="form-check-input"
                                   {{ !empty($ef['is_organic']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">🌿 Organic</label>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_vegan"
                                   class="form-check-input"
                                   {{ !empty($ef['is_vegan']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">🌱 Vegan</label>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_cruelty_free"
                                   class="form-check-input"
                                   {{ !empty($ef['is_cruelty_free']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">🐇 Cruelty Free</label>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_paraben_free"
                                   class="form-check-input"
                                   {{ !empty($ef['is_paraben_free']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">✅ Paraben Free</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- ── CLOTHING ── --}}
        @if($tab === 'clothing')
        <div class="tab-pane fade p-4 bg-white shadow-sm" id="tab-clothing">
            <div class="section-heading">👗 Clothing & Fashion Details</div>
            @php $selectedSizes  = $ef['sizes']  ?? []; @endphp
            @php $selectedColors = $ef['colors'] ?? []; @endphp
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Available Sizes</label>
                    <div class="d-flex flex-wrap gap-3 mt-1">
                        @foreach(['XS','S','M','L','XL','XXL','3XL','Free Size','28','30','32','34','36','38','40','42'] as $sz)
                        <div class="form-check">
                            <input type="checkbox" name="sizes[]"
                                   value="{{ $sz }}" class="form-check-input"
                                   {{ in_array($sz, $selectedSizes) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $sz }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Material / Fabric</label>
                    <input type="text" name="material" class="form-control"
                           value="{{ $ef['material'] ?? '' }}"
                           placeholder="e.g. Cotton, Polyester">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Men','Women','Unisex','Kids','Boys','Girls'] as $g)
                            <option {{ ($ef['gender'] ?? '') === $g ? 'selected' : '' }}>
                                {{ $g }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Occasion</label>
                    <input type="text" name="occasion" class="form-control"
                           value="{{ $ef['occasion'] ?? '' }}"
                           placeholder="e.g. Casual, Formal">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Colors</label>
                    <div id="colorsContainer">
                        @if(count($selectedColors))
                            @foreach($selectedColors as $color)
                            <div class="color-row d-flex gap-2 align-items-center">
                                <input type="text" name="colors[]"
                                       class="form-control"
                                       value="{{ $color }}">
                                <button type="button"
                                        class="btn btn-danger btn-sm remove-color">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                            @endforeach
                        @else
                            <div class="color-row d-flex gap-2 align-items-center">
                                <input type="text" name="colors[]"
                                       class="form-control"
                                       placeholder="Color name (e.g. Red)">
                                <button type="button"
                                        class="btn btn-danger btn-sm remove-color">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                    <button type="button"
                            class="btn btn-outline-secondary btn-sm mt-2"
                            id="addColor">
                        <i class="bi bi-plus me-1"></i>Add Color
                    </button>
                </div>
            </div>
        </div>
        @endif

        {{-- ── BOOK ── --}}
        @if($tab === 'book')
        <div class="tab-pane fade p-4 bg-white shadow-sm" id="tab-book">
            <div class="section-heading">📚 Book & Publication Details</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Author Name</label>
                    <input type="text" name="author" class="form-control"
                           value="{{ $ef['author'] ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Publisher</label>
                    <input type="text" name="publisher" class="form-control"
                           value="{{ $ef['publisher'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">ISBN</label>
                    <input type="text" name="isbn" class="form-control"
                           value="{{ $ef['isbn'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Language</label>
                    <select name="language" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Hindi','English','Gujarati','Marathi','Tamil','Telugu','Bengali','Kannada','Punjabi','Other'] as $lang)
                            <option {{ ($ef['language'] ?? '') === $lang ? 'selected' : '' }}>
                                {{ $lang }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Edition</label>
                    <input type="text" name="edition" class="form-control"
                           value="{{ $ef['edition'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Published Date</label>
                    <input type="date" name="published_date" class="form-control"
                           value="{{ $ef['published_date'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Number of Pages</label>
                    <input type="number" name="pages" class="form-control"
                           value="{{ $ef['pages'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Book Type</label>
                    <select name="book_type" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Paperback','Hardcover','Ebook','Audiobook'] as $bt)
                            <option {{ ($ef['book_type'] ?? '') === $bt ? 'selected' : '' }}>
                                {{ $bt }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @endif

        {{-- ── ELECTRONICS ── --}}
        @if($tab === 'electronic')
        <div class="tab-pane fade p-4 bg-white shadow-sm" id="tab-electronic">
            <div class="section-heading">💻 Electronics Details</div>
            @php $specs = $ef['specs'] ?? []; @endphp
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Model Number</label>
                    <input type="text" name="model_number" class="form-control"
                           value="{{ $ef['model_number'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Warranty (Months)</label>
                    <input type="number" name="warranty_months" class="form-control"
                           value="{{ $ef['warranty_months'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Warranty Type</label>
                    <select name="warranty_type" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Brand Warranty','Seller Warranty','No Warranty'] as $w)
                            <option {{ ($ef['warranty_type'] ?? '') === $w ? 'selected' : '' }}>
                                {{ $w }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Specifications</label>
                    <div id="specsContainer">
                        @if(count($specs))
                            @foreach($specs as $key => $val)
                            <div class="attr-row d-flex gap-2 mb-2">
                                <input type="text" name="spec_keys[]"
                                       class="form-control" value="{{ $key }}">
                                <input type="text" name="spec_values[]"
                                       class="form-control" value="{{ $val }}">
                                <button type="button"
                                        class="btn btn-danger btn-sm remove-spec">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                            @endforeach
                        @else
                            <div class="attr-row d-flex gap-2 mb-2">
                                <input type="text" name="spec_keys[]"
                                       class="form-control" placeholder="e.g. Connectivity">
                                <input type="text" name="spec_values[]"
                                       class="form-control" placeholder="e.g. Bluetooth 5.0">
                                <button type="button"
                                        class="btn btn-danger btn-sm remove-spec">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-outline-secondary btn-sm"
                            id="addSpec">
                        <i class="bi bi-plus me-1"></i>Add Spec
                    </button>
                </div>
            </div>
        </div>
        @endif

        {{-- ── MOBILE ── --}}
        @if($tab === 'mobile')
        <div class="tab-pane fade p-4 bg-white shadow-sm" id="tab-mobile">
            <div class="section-heading">📱 Mobile Details</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Model Number</label>
                    <input type="text" name="model_number" class="form-control"
                           value="{{ $ef['model_number'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Warranty (Months)</label>
                    <input type="number" name="warranty_months" class="form-control"
                           value="{{ $ef['warranty_months'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Warranty Type</label>
                    <select name="warranty_type" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Brand Warranty','Seller Warranty','No Warranty'] as $w)
                            <option {{ ($ef['warranty_type'] ?? '') === $w ? 'selected' : '' }}>
                                {{ $w }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">RAM</label>
                    <input type="text" name="ram" class="form-control"
                           value="{{ $ef['ram'] ?? '' }}" placeholder="e.g. 8GB">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Storage</label>
                    <input type="text" name="storage" class="form-control"
                           value="{{ $ef['storage'] ?? '' }}" placeholder="e.g. 128GB">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Battery</label>
                    <input type="text" name="battery" class="form-control"
                           value="{{ $ef['battery'] ?? '' }}" placeholder="e.g. 5000mAh">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Display</label>
                    <input type="text" name="display" class="form-control"
                           value="{{ $ef['display'] ?? '' }}"
                           placeholder="e.g. 6.5 inch AMOLED">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Camera</label>
                    <input type="text" name="camera" class="form-control"
                           value="{{ $ef['camera'] ?? '' }}" placeholder="e.g. 108MP">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Processor</label>
                    <input type="text" name="processor" class="form-control"
                           value="{{ $ef['processor'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">OS</label>
                    <input type="text" name="os" class="form-control"
                           value="{{ $ef['os'] ?? '' }}" placeholder="e.g. Android 14">
                </div>
            </div>
        </div>
        @endif

        {{-- ── JEWELRY ── --}}
        @if($tab === 'jewelry')
        <div class="tab-pane fade p-4 bg-white shadow-sm" id="tab-jewelry">
            <div class="section-heading">💍 Jewelry Details</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Material</label>
                    <select name="jewelry_material" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Gold','Silver','Platinum','Rose Gold','White Gold','Artificial','Brass','Copper'] as $m)
                            <option {{ ($ef['material'] ?? '') === $m ? 'selected' : '' }}>
                                {{ $m }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Purity</label>
                    <input type="text" name="purity" class="form-control"
                           value="{{ $ef['purity'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Weight (grams)</label>
                    <input type="number" name="weight_grams" class="form-control"
                           value="{{ $ef['weight_grams'] ?? '' }}" step="0.001">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Gemstone</label>
                    <input type="text" name="gemstone" class="form-control"
                           value="{{ $ef['gemstone'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Jewelry Type</label>
                    <select name="jewelry_type" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Ring','Necklace','Bracelet','Earring','Pendant','Anklet','Chain','Bangle','Set'] as $jt)
                            <option {{ ($ef['jewelry_type'] ?? '') === $jt ? 'selected' : '' }}>
                                {{ $jt }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Men','Women','Unisex','Kids'] as $g)
                            <option {{ ($ef['gender'] ?? '') === $g ? 'selected' : '' }}>
                                {{ $g }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Occasion</label>
                    <input type="text" name="occasion" class="form-control"
                           value="{{ $ef['occasion'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Hallmark Number</label>
                    <input type="text" name="hallmark_number" class="form-control"
                           value="{{ $ef['hallmark_number'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Making Charges (₹)</label>
                    <input type="number" name="making_charges" class="form-control"
                           value="{{ $ef['making_charges'] ?? '' }}" step="0.01">
                </div>
                <div class="col-md-12">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="is_hallmarked"
                               class="form-check-input"
                               {{ !empty($ef['is_hallmarked']) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold">✅ Hallmarked</label>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- ── GROCERY ── --}}
        @if($tab === 'grocery')
        <div class="tab-pane fade p-4 bg-white shadow-sm" id="tab-grocery">
            <div class="section-heading">🛒 Grocery & Food Details</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Net Weight / Volume</label>
                    <input type="text" name="net_weight" class="form-control"
                           value="{{ $ef['net_weight'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Shelf Life</label>
                    <input type="text" name="shelf_life" class="form-control"
                           value="{{ $ef['shelf_life'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Food Type</label>
                    <select name="food_type" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Veg','Non-Veg','Vegan'] as $ft)
                            <option {{ ($ef['food_type'] ?? '') === $ft ? 'selected' : '' }}>
                                {{ $ft }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Manufacturer</label>
                    <input type="text" name="manufacturer" class="form-control"
                           value="{{ $ef['manufacturer'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Country of Origin</label>
                    <input type="text" name="country_origin" class="form-control"
                           value="{{ $ef['country_origin'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Storage Instructions</label>
                    <input type="text" name="storage_instructions" class="form-control"
                           value="{{ $ef['storage_instructions'] ?? '' }}">
                </div>
                <div class="col-md-12">
                    <div class="d-flex flex-wrap gap-4">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_organic"
                                   class="form-check-input"
                                   {{ !empty($ef['is_organic']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">🌿 Organic</label>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_vegan"
                                   class="form-check-input"
                                   {{ !empty($ef['is_vegan']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">🌱 Vegan</label>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="gluten_free"
                                   class="form-check-input"
                                   {{ !empty($ef['gluten_free']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">🌾 Gluten Free</label>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="sugar_free"
                                   class="form-check-input"
                                   {{ !empty($ef['sugar_free']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">🍬 Sugar Free</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- ── FURNITURE ── --}}
        @if($tab === 'furniture')
        <div class="tab-pane fade p-4 bg-white shadow-sm" id="tab-furniture">
            <div class="section-heading">🪑 Furniture & Home Details</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Material</label>
                    <input type="text" name="material" class="form-control"
                           value="{{ $ef['material'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Color / Finish</label>
                    <input type="text" name="color" class="form-control"
                           value="{{ $ef['color'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Assembly Required</label>
                    <select name="assembly" class="form-select">
                        <option value="">-- Select --</option>
                        <option {{ ($ef['assembly'] ?? '') === 'Yes' ? 'selected' : '' }}>Yes</option>
                        <option {{ ($ef['assembly'] ?? '') === 'No'  ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Width (cm)</label>
                    <input type="number" name="width_cm" class="form-control"
                           value="{{ $ef['width_cm'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Height (cm)</label>
                    <input type="number" name="height_cm" class="form-control"
                           value="{{ $ef['height_cm'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Depth (cm)</label>
                    <input type="number" name="depth_cm" class="form-control"
                           value="{{ $ef['depth_cm'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Weight (kg)</label>
                    <input type="number" name="weight_kg" class="form-control"
                           value="{{ $ef['weight_kg'] ?? '' }}" step="0.1">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Room Type</label>
                    <select name="room_type" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Living Room','Bedroom','Kitchen','Office','Outdoor','Kids Room'] as $rt)
                            <option {{ ($ef['room_type'] ?? '') === $rt ? 'selected' : '' }}>
                                {{ $rt }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Warranty (Months)</label>
                    <input type="number" name="warranty_months" class="form-control"
                           value="{{ $ef['warranty'] ?? '' }}">
                </div>
            </div>
        </div>
        @endif

        {{-- ── SPORTS ── --}}
        @if($tab === 'sports')
        <div class="tab-pane fade p-4 bg-white shadow-sm" id="tab-sports">
            <div class="section-heading">⚽ Sports & Fitness Details</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Sport Type</label>
                    <select name="sport_type" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Cricket','Football','Basketball','Tennis','Badminton','Gym / Fitness','Yoga','Swimming','Running','Cycling','Other'] as $st)
                            <option {{ ($ef['sport_type'] ?? '') === $st ? 'selected' : '' }}>
                                {{ $st }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Target User</label>
                    <select name="target_user" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Beginner','Intermediate','Professional','Kids'] as $tu)
                            <option {{ ($ef['target_user'] ?? '') === $tu ? 'selected' : '' }}>
                                {{ $tu }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Men','Women','Unisex','Kids'] as $g)
                            <option {{ ($ef['gender'] ?? '') === $g ? 'selected' : '' }}>
                                {{ $g }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Material</label>
                    <input type="text" name="material" class="form-control"
                           value="{{ $ef['material'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Net Weight</label>
                    <input type="text" name="net_weight" class="form-control"
                           value="{{ $ef['net_weight'] ?? '' }}">
                </div>
                <div class="col-md-12">
                    <div class="form-check form-switch mb-2">
                        <input type="checkbox" name="is_supplement"
                               class="form-check-input" id="isSuppl"
                               {{ !empty($ef['is_supplement']) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold">
                            This is a Supplement
                        </label>
                    </div>
                    <div id="supplFields"
                         style="display:{{ !empty($ef['is_supplement']) ? 'block' : 'none' }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Flavor</label>
                                <input type="text" name="flavor" class="form-control"
                                       value="{{ $ef['flavor'] ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Serving Size</label>
                                <input type="text" name="serving_size" class="form-control"
                                       value="{{ $ef['serving_size'] ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Servings Per Pack</label>
                                <input type="number" name="servings_per_pack"
                                       class="form-control"
                                       value="{{ $ef['servings_per_pack'] ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- ── BABY ── --}}
        @if($tab === 'baby')
        <div class="tab-pane fade p-4 bg-white shadow-sm" id="tab-baby">
            <div class="section-heading">🍼 Baby Product Details</div>
            @php $certs = $ef['certifications'] ?? []; @endphp
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Age Group</label>
                    <select name="age_group" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['0-3 Months','3-6 Months','6-12 Months','1-2 Years','2-5 Years','5+ Years'] as $ag)
                            <option {{ ($ef['age_group'] ?? '') === $ag ? 'selected' : '' }}>
                                {{ $ag }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Baby Category</label>
                    <select name="baby_category" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Feeding','Diapering','Clothing','Bath & Skincare','Toys','Health & Safety','Nursery','Travel'] as $bc)
                            <option {{ ($ef['baby_category'] ?? '') === $bc ? 'selected' : '' }}>
                                {{ $bc }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Material</label>
                    <input type="text" name="material" class="form-control"
                           value="{{ $ef['material'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Net Weight</label>
                    <input type="text" name="net_weight" class="form-control"
                           value="{{ $ef['net_weight'] ?? '' }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Safety Certifications</label>
                    <div class="d-flex flex-wrap gap-3 mt-1">
                        @foreach(['BIS Certified','IS 9873','EN 71','ASTM F963','Non-Toxic','Dermatologist Tested'] as $cert)
                        <div class="form-check">
                            <input type="checkbox" name="certifications[]"
                                   value="{{ $cert }}" class="form-check-input"
                                   {{ in_array($cert, $certs) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $cert }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d-flex flex-wrap gap-4">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_organic"
                                   class="form-check-input"
                                   {{ !empty($ef['is_organic']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">🌿 Organic</label>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="bpa_free"
                                   class="form-check-input"
                                   {{ !empty($ef['bpa_free']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">✅ BPA Free</label>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="hypoallergenic"
                                   class="form-check-input"
                                   {{ !empty($ef['hypoallergenic']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">💚 Hypoallergenic</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- ── PET ── --}}
        @if($tab === 'pet')
        <div class="tab-pane fade p-4 bg-white shadow-sm" id="tab-pet">
            <div class="section-heading">🐾 Pet Product Details</div>
            @php $petTypes = $ef['pet_type'] ?? []; @endphp
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Pet Type (multiple)</label>
                    <div class="d-flex flex-wrap gap-3 mt-1">
                        @foreach(['Dog','Cat','Fish','Bird','Rabbit','Hamster','All Pets'] as $pet)
                        <div class="form-check">
                            <input type="checkbox" name="pet_type[]"
                                   value="{{ $pet }}" class="form-check-input"
                                   {{ in_array($pet, $petTypes) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $pet }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Pet Age Group</label>
                    <select name="pet_age" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Puppy / Kitten (0-1 year)','Adult (1-7 years)','Senior (7+ years)','All Ages'] as $pa)
                            <option {{ ($ef['pet_age'] ?? '') === $pa ? 'selected' : '' }}>
                                {{ $pa }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Pet Size</label>
                    <select name="pet_size" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Small (upto 10kg)','Medium (10-25kg)','Large (25kg+)','All Sizes'] as $ps)
                            <option {{ ($ef['pet_size'] ?? '') === $ps ? 'selected' : '' }}>
                                {{ $ps }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Product Category</label>
                    <select name="pet_category" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Food & Treats','Grooming','Toys','Accessories','Health & Wellness','Beds & Furniture','Training'] as $pc)
                            <option {{ ($ef['pet_category'] ?? '') === $pc ? 'selected' : '' }}>
                                {{ $pc }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Flavor</label>
                    <input type="text" name="flavor" class="form-control"
                           value="{{ $ef['flavor'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Net Weight</label>
                    <input type="text" name="net_weight" class="form-control"
                           value="{{ $ef['net_weight'] ?? '' }}">
                </div>
                <div class="col-md-12">
                    <div class="d-flex flex-wrap gap-4">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="vet_approved"
                                   class="form-check-input"
                                   {{ !empty($ef['vet_approved']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">🩺 Vet Approved</label>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="grain_free"
                                   class="form-check-input"
                                   {{ !empty($ef['grain_free']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">✅ Grain Free</label>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_organic"
                                   class="form-check-input"
                                   {{ !empty($ef['is_organic']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">🌿 Natural</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- ── MEDICAL ── --}}
        @if($tab === 'medical')
        <div class="tab-pane fade p-4 bg-white shadow-sm" id="tab-medical">
            <div class="section-heading">💊 Medical & Pharmacy Details</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Generic Name</label>
                    <input type="text" name="generic_name" class="form-control"
                           value="{{ $ef['generic_name'] ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Manufacturer</label>
                    <input type="text" name="manufacturer" class="form-control"
                           value="{{ $ef['manufacturer'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Form</label>
                    <select name="medicine_form" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['Tablet','Capsule','Syrup','Injection','Cream / Ointment','Drops','Powder','Inhaler','Patch','Gel'] as $mf)
                            <option {{ ($ef['medicine_form'] ?? '') === $mf ? 'selected' : '' }}>
                                {{ $mf }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Strength</label>
                    <input type="text" name="strength" class="form-control"
                           value="{{ $ef['strength'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Pack Size</label>
                    <input type="text" name="pack_size" class="form-control"
                           value="{{ $ef['pack_size'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Drug Schedule</label>
                    <select name="schedule" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach(['OTC (No Prescription)','Schedule H','Schedule H1','Schedule X'] as $sc)
                            <option {{ ($ef['schedule'] ?? '') === $sc ? 'selected' : '' }}>
                                {{ $sc }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Storage</label>
                    <input type="text" name="storage" class="form-control"
                           value="{{ $ef['storage'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Manufacture Date</label>
                    <input type="date" name="manufacture_date" class="form-control"
                           value="{{ $ef['manufacture_date'] ?? '' }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Composition</label>
                    <textarea name="composition" class="form-control"
                              rows="2">{{ $ef['composition'] ?? '' }}</textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Side Effects</label>
                    <textarea name="side_effects" class="form-control"
                              rows="2">{{ $ef['side_effects'] ?? '' }}</textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Dosage Instructions</label>
                    <textarea name="dosage_instructions" class="form-control"
                              rows="2">{{ $ef['dosage_instructions'] ?? '' }}</textarea>
                </div>
                <div class="col-md-12">
                    <div class="d-flex flex-wrap gap-4">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="prescription_required"
                                   class="form-check-input"
                                   {{ !empty($ef['prescription_required']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">
                                📋 Prescription Required
                            </label>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="refrigeration_required"
                                   class="form-check-input"
                                   {{ !empty($ef['refrigeration_required']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">
                                ❄️ Refrigeration Required
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    @endforeach
@endif

{{-- ══ TAB: MEDIA ══ --}}
<div class="tab-pane fade p-4 bg-white shadow-sm" id="tab-media">
    <div class="section-heading">🖼️ Product Images</div>
    <div class="row g-4">

        {{-- Main + Image 2-5 --}}
        @foreach(['image','image2','image3','image4','image5'] as $imgField)
        <div class="col-md-4">
            <label class="form-label fw-semibold">
                {{ $imgField === 'image' ? 'Main Image' : 'Image '.str_replace('image','',$imgField) }}
                <small class="text-muted fw-normal">(Max 2MB)</small>
            </label>

            {{-- Current Image --}}
            @if($product->$imgField)
            <div class="mb-2 d-flex align-items-center gap-2">
                <img src="{{ asset('uploads/products/'.$product->$imgField) }}"
                     class="current-img">
                <small class="text-muted">Current Image</small>
            </div>
            @endif

            <input type="file"
                   name="{{ $imgField }}"
                   id="{{ $imgField }}Input"
                   class="form-control" accept="image/*">
            <img id="{{ $imgField }}Preview" class="img-preview-thumb">
        </div>
        @endforeach

        {{-- Gallery --}}
        <div class="col-md-12">
            <label class="form-label fw-semibold">
                Gallery Images
                <small class="text-muted fw-normal">
                    (Max 2MB each — upload karne se purani replace ho jayegi)
                </small>
            </label>

            {{-- Current Gallery --}}
            @if($product->gallery_images && count($product->gallery_images))
            <div class="d-flex flex-wrap gap-2 mb-2">
                @foreach($product->gallery_images as $gImg)
                <img src="{{ asset('uploads/products/gallery/'.$gImg) }}"
                     style="width:70px;height:70px;object-fit:cover;
                            border-radius:8px;border:2px solid #E91E8C">
                @endforeach
            </div>
            @endif

            <input type="file" name="gallery_images[]" id="galleryImgs"
                   class="form-control" accept="image/*" multiple>
            <div id="galleryPreview" class="d-flex flex-wrap gap-2 mt-2"></div>
        </div>
    </div>
</div>

{{-- ══ TAB: DESCRIPTION ══ --}}
<div class="tab-pane fade p-4 bg-white shadow-sm" id="tab-desc">
    <div class="section-heading">📝 Product Content</div>
    <div class="row g-3">
        <div class="col-md-12">
            <label class="form-label fw-semibold">Product Description</label>
            <textarea name="description" id="descEditor"
                      class="form-control" rows="5">{{ $product->description }}</textarea>
        </div>
        <div class="col-md-12">
            <label class="form-label fw-semibold">How to Use</label>
            <textarea name="how_to_use" class="form-control"
                      rows="3">{{ $product->how_to_use }}</textarea>
        </div>
        <div class="col-md-12">
            <label class="form-label fw-semibold">
                Features / Highlights
                <small class="text-muted fw-normal">(har line ek feature)</small>
            </label>
            <textarea name="features" class="form-control" rows="4">{{ $product->features ? implode("\n", $product->features) : '' }}</textarea>
        </div>
    </div>
</div>

{{-- ══ TAB: SHIPPING & SEO ══ --}}
<div class="tab-pane fade p-4 bg-white shadow-sm" id="tab-shipping">
    <div class="row g-4">
        <div class="col-md-6">
            <div class="section-heading">🚚 Shipping Settings</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Shipping Type</label>
                    <select name="shipping_type" id="shippingType" class="form-select">
                        <option value="paid"
                            {{ $product->shipping_type === 'paid' ? 'selected' : '' }}>
                            Paid Shipping
                        </option>
                        <option value="free"
                            {{ $product->shipping_type === 'free' ? 'selected' : '' }}>
                            Free Shipping
                        </option>
                    </select>
                </div>
                <div class="col-md-6" id="shippingChargeWrap"
                     style="{{ $product->shipping_type === 'free' ? 'display:none' : '' }}">
                    <label class="form-label fw-semibold">Shipping Charge (₹)</label>
                    <input type="number" name="shipping_charge" class="form-control"
                           value="{{ $product->shipping_charge }}"
                           step="0.01" min="0">
                </div>
                <div class="col-md-12">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="cod_available"
                               class="form-check-input"
                               {{ $product->cod_available ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold">💵 COD Available</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="section-heading">🔍 SEO Settings</div>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control"
                           value="{{ $product->meta_title }}"
                           placeholder="SEO title (60 chars max)">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="2"
                              placeholder="SEO description (160 chars max)">{{ $product->meta_description }}</textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Meta Keywords</label>
                    <input type="text" name="meta_keywords" class="form-control"
                           value="{{ $product->meta_keywords }}"
                           placeholder="keyword1, keyword2">
                </div>
            </div>
        </div>
    </div>
</div>

</div>{{-- end tab-content --}}

{{-- Submit --}}
<div class="card border-0 shadow-sm mt-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.products.index') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.show', $product->id) }}"
               class="btn btn-outline-info">
                <i class="bi bi-eye me-1"></i>View Product
            </a>
            <button type="submit" class="btn btn-pink px-4">
                <i class="bi bi-check-lg me-2"></i>Update Product
            </button>
        </div>
    </div>
</div>

</form>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ── Summernote ─────────────────────────────────────
    $('#descEditor').summernote({
        height: 200,
        toolbar: [
            ['style',['bold','italic','underline','clear']],
            ['para',['ul','ol','paragraph']],
            ['insert',['link']],
            ['view',['codeview']]
        ]
    });

    // ── Auto Slug ──────────────────────────────────────
    $('#productName').on('input', function() {
        $('#productSlug').val(
            $(this).val().toLowerCase().trim()
                .replace(/ /g,'-').replace(/[^\w-]+/g,'')
        );
    });

    // ── Discount Calculate ─────────────────────────────
    function calcDiscount() {
        var mrp  = parseFloat($('#mrpPrice').val())     || 0;
        var disp = parseFloat($('#displayPrice').val()) || 0;
        if (mrp > 0 && disp > 0 && disp < mrp) {
            $('#discountShow').val((((mrp-disp)/mrp)*100).toFixed(1)+'%');
            $('#savingsShow').val('₹'+(mrp-disp).toFixed(2));
        }
    }
    $('#mrpPrice,#displayPrice').on('input', calcDiscount);

    // ── Category → Sub → Child ─────────────────────────
    $('#catSelect').on('change', function() {
        var catId = $(this).val();
        $('#subSelect').html('<option value="">Loading...</option>');
        $('#childSelect').html('<option value="">-- Pehle Sub --</option>');
        if (!catId) {
            $('#subSelect').html('<option value="">-- Select --</option>');
            return;
        }
        $.get('{{ route("admin.products.get-subs") }}',
            { category_id: catId },
            function(data) {
                var opts = '<option value="">-- Select --</option>';
                $.each(data, function(i,s) {
                    opts += '<option value="'+s.id+'">'+s.name+'</option>';
                });
                $('#subSelect').html(opts);
            }
        );
    });

    $('#subSelect').on('change', function() {
        var subId = $(this).val();
        $('#childSelect').html('<option value="">Loading...</option>');
        if (!subId) {
            $('#childSelect').html('<option value="">-- Select --</option>');
            return;
        }
        $.get('{{ route("admin.products.get-child-subs") }}',
            { subcategory_id: subId },
            function(data) {
                var opts = '<option value="">-- Select --</option>';
                $.each(data, function(i,c) {
                    opts += '<option value="'+c.id+'">'+c.name+'</option>';
                });
                $('#childSelect').html(opts);
            }
        );
    });

    // ── Tag Input (pre-fill) ───────────────────────────
    var tags = $('#tagsHidden').val()
               ? $('#tagsHidden').val().split(',').filter(Boolean)
               : [];

    function renderTags() {
        $('.tag-item').remove();
        tags.forEach(function(tag, i) {
            $('#tagWrap').prepend(
                '<span class="tag-item">'+tag+
                '<span class="remove-tag" data-i="'+i+'">×</span></span>'
            );
        });
        $('#tagsHidden').val(tags.join(','));
    }
    renderTags();

    $('#tagInput').on('keydown', function(e) {
        if (e.key==='Enter' || e.key===',') {
            e.preventDefault();
            var val = $(this).val().trim().replace(',','');
            if (val && !tags.includes(val)) {
                tags.push(val); renderTags();
            }
            $(this).val('');
        }
    });
    $(document).on('click', '.remove-tag', function() {
        tags.splice($(this).data('i'), 1); renderTags();
    });

    // ── Image Preview + 2MB Check ──────────────────────
    ['image','image2','image3','image4','image5'].forEach(function(f) {
        $('#'+f+'Input').on('change', function() {
            var file = this.files[0];
            if (!file) return;
            if (file.size > 2*1024*1024) {
                Swal.fire({
                    icon: 'error',
                    title: '2MB se badi image!',
                    text: 'Maximum 2MB allowed hai.',
                    confirmButtonColor: '#E91E8C'
                });
                $(this).val(''); return;
            }
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#'+f+'Preview').attr('src',e.target.result).show();
            };
            reader.readAsDataURL(file);
        });
    });

    // Gallery preview
    $('#galleryImgs').on('change', function() {
        $('#galleryPreview').empty();
        Array.from(this.files).forEach(function(file) {
            if (file.size > 2*1024*1024) return;
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#galleryPreview').append(
                    '<img src="'+e.target.result+'"'+
                    ' style="width:70px;height:70px;object-fit:cover;'+
                    'border-radius:8px;border:2px dashed #E91E8C">'
                );
            };
            reader.readAsDataURL(file);
        });
    });

    // ── Shipping ──────────────────────────────────────
    $('#shippingType').on('change', function() {
        $(this).val() === 'free'
            ? $('#shippingChargeWrap').hide()
            : $('#shippingChargeWrap').show();
    });

    // ── Electronics Specs ──────────────────────────────
    $('#addSpec').on('click', function() {
        $('#specsContainer').append(
            '<div class="attr-row d-flex gap-2 mb-2">' +
            '<input type="text" name="spec_keys[]" class="form-control" placeholder="Spec Name">' +
            '<input type="text" name="spec_values[]" class="form-control" placeholder="Value">' +
            '<button type="button" class="btn btn-danger btn-sm remove-spec">' +
            '<i class="bi bi-x"></i></button></div>'
        );
    });
    $(document).on('click', '.remove-spec', function() {
        $(this).closest('.attr-row').remove();
    });

    // ── Clothing Colors ────────────────────────────────
    $('#addColor').on('click', function() {
        $('#colorsContainer').append(
            '<div class="color-row d-flex gap-2 align-items-center mt-2">' +
            '<input type="text" name="colors[]" class="form-control"' +
            ' placeholder="Color name">' +
            '<button type="button" class="btn btn-danger btn-sm remove-color">' +
            '<i class="bi bi-x"></i></button></div>'
        );
    });
    $(document).on('click', '.remove-color', function() {
        $(this).closest('.color-row').remove();
    });

    // ── Sports Supplement Toggle ───────────────────────
    $('#isSuppl').on('change', function() {
        $(this).is(':checked')
            ? $('#supplFields').show()
            : $('#supplFields').hide();
    });

});
</script>
@endpush