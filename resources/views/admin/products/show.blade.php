@extends('admin.layouts.app')
@section('title','Product Detail')
@section('page-title','Product Detail')

@push('styles')
<style>
    .detail-label{font-size:12px;color:#999;font-weight:600;text-transform:uppercase;letter-spacing:.5px}
    .detail-value{font-size:14px;color:#333;font-weight:500;margin-top:2px}
    .badge-pink{background:#FCE4EC;color:#C2185B;font-size:11px}
    .shade-swatch{width:32px;height:32px;border-radius:50%;border:2px solid #ddd}
    .img-thumb{width:80px;height:80px;object-fit:cover;border-radius:10px;border:2px solid #E91E8C}
    .section-card{background:#fff;border-radius:12px;padding:20px;margin-bottom:16px;border:1px solid #f0f0f0}
    .section-heading{font-size:13px;font-weight:700;color:#E91E8C;border-bottom:1px solid #f9c4dc;padding-bottom:6px;margin-bottom:14px}
</style>
@endpush

@section('content')

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
        <li class="breadcrumb-item active">{{ $product->name }}</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">{{ $product->name }}</h5>
        <span class="badge badge-pink me-2">{{ $product->sku }}</span>
        <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-danger' }}">
            {{ $product->is_active ? 'Active' : 'Inactive' }}
        </span>
        <span class="badge ms-1" style="background:#FCE4EC;color:#C2185B">
            {{ $product->getTypeLabel() }}
        </span>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
    </div>
</div>

<div class="row g-3">

    {{-- Images --}}
    <div class="col-md-4">
        <div class="section-card">
            <div class="section-heading">Images</div>
            @if($product->image)
            <img src="{{ asset('uploads/products/'.$product->image) }}"
                 class="w-100 rounded-3 mb-3" style="object-fit:cover;max-height:250px">
            @endif
            <div class="d-flex flex-wrap gap-2">
                @foreach(['image2','image3','image4','image5'] as $f)
                @if($product->$f)
                <img src="{{ asset('uploads/products/'.$product->$f) }}" class="img-thumb">
                @endif
                @endforeach
            </div>
            @if($product->gallery_images)
            <div class="mt-3">
                <div class="detail-label mb-2">Gallery</div>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($product->gallery_images as $g)
                    <img src="{{ asset('uploads/products/gallery/'.$g) }}" class="img-thumb">
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Basic & Pricing --}}
    <div class="col-md-8">
        <div class="section-card">
            <div class="section-heading">Basic Information</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="detail-label">Category</div>
                    <div class="detail-value">{{ $product->category->name ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="detail-label">Subcategory</div>
                    <div class="detail-value">{{ $product->subcategory->name ?? '-' }}</div>
                </div>
                <div class="col-md-4">
                    <div class="detail-label">Brand</div>
                    <div class="detail-value">{{ $product->brand ?? '-' }}</div>
                </div>
                <div class="col-md-4">
                    <div class="detail-label">Tags</div>
                    <div class="detail-value">
                        @foreach(explode(',', $product->tags ?? '') as $tag)
                        @if($tag)<span class="badge badge-pink me-1">{{ $tag }}</span>@endif
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="detail-label">Slug</div>
                    <div class="detail-value text-muted">{{ $product->slug }}</div>
                </div>
            </div>
        </div>

        <div class="section-card">
            <div class="section-heading">Pricing & Stock</div>
            <div class="row g-3">
                <div class="col-md-3 text-center">
                    <div class="detail-label">MRP</div>
                    <div class="detail-value text-decoration-line-through text-muted fs-5">₹{{ number_format($product->mrp_price,2) }}</div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="detail-label">Display Price</div>
                    <div class="detail-value text-success fs-4 fw-bold">₹{{ number_format($product->display_price,2) }}</div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="detail-label">Discount</div>
                    <div class="detail-value"><span class="badge bg-danger fs-6">{{ $product->discount }}%</span></div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="detail-label">Stock</div>
                    @php
                        $stockColor = $product->stock <= 0 ? 'danger' : ($product->stock <= $product->low_stock_alert ? 'warning' : 'success');
                    @endphp
                    <div class="detail-value">
                        <span class="badge bg-{{ $stockColor }} fs-6">{{ $product->stock }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Shade Variants --}}
    @if($product->shade_variants && count($product->shade_variants))
    <div class="col-md-12">
        <div class="section-card">
            <div class="section-heading">Shade Variants ({{ count($product->shade_variants) }})</div>
            <div class="d-flex flex-wrap gap-3">
                @foreach($product->shade_variants as $shade)
                <div class="text-center p-2 border rounded-3" style="min-width:90px">
                    <div class="shade-swatch mx-auto mb-2"
                         style="background:{{ $shade['hex'] ?? '#ccc' }}"></div>
                    <div style="font-size:12px;font-weight:600">{{ $shade['name'] ?? '-' }}</div>
                    <div style="font-size:11px;color:#999">Stock: {{ $shade['stock'] ?? 0 }}</div>
                    @if(!empty($shade['image']))
                    <img src="{{ asset('uploads/products/shades/'.$shade['image']) }}"
                         style="width:40px;height:40px;object-fit:cover;border-radius:6px;margin-top:4px">
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Size Variants --}}
    @if($product->size_variants && count($product->size_variants))
    <div class="col-md-12">
        <div class="section-card">
            <div class="section-heading">Size Variants</div>
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Size</th><th>Price</th><th>MRP</th><th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->size_variants as $sv)
                        <tr>
                            <td><strong>{{ $sv['label'] ?? '-' }}</strong></td>
                            <td class="text-success fw-bold">₹{{ $sv['price'] ?? 0 }}</td>
                            <td class="text-muted text-decoration-line-through">₹{{ $sv['mrp'] ?? 0 }}</td>
                            <td>{{ $sv['stock'] ?? 0 }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Flags --}}
    <div class="col-md-12">
        <div class="section-card">
            <div class="section-heading">Status Flags</div>
            <div class="d-flex flex-wrap gap-3">
                <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }} fs-6">
                    {{ $product->is_active ? '✅ Active' : '❌ Inactive' }}
                </span>
                <span class="badge {{ $product->product_on_sale ? 'bg-danger' : 'bg-secondary' }} fs-6">
                    {{ $product->product_on_sale ? '🔥 On Sale' : 'Not On Sale' }}
                </span>
                <span class="badge {{ $product->new_arrivals ? 'bg-info' : 'bg-secondary' }} fs-6">
                    {{ $product->new_arrivals ? '🆕 New Arrival' : 'Not New Arrival' }}
                </span>
                <span class="badge {{ $product->featured ? 'bg-warning text-dark' : 'bg-secondary' }} fs-6">
                    {{ $product->featured ? '⭐ Featured' : 'Not Featured' }}
                </span>
                <span class="badge {{ $product->cod_available ? 'bg-success' : 'bg-secondary' }} fs-6">
                    {{ $product->cod_available ? '💵 COD Available' : 'No COD' }}
                </span>
            </div>
        </div>
    </div>

</div>
@endsection