@extends('admin.layouts.app')
@section('title','Add Coupon')
@section('page-title','Add New Coupon Code')

@push('styles')
<style>
    .btn-pink{background:#E91E8C!important;color:#fff!important;border:none}
    .btn-pink:hover{background:#C2185B!important}
    .section-heading{font-size:13px;font-weight:700;color:#E91E8C;
                     border-bottom:1px solid #f9c4dc;padding-bottom:6px;margin-bottom:14px}
    .preview-badge{font-size:22px;font-weight:700;letter-spacing:3px;
                   color:#E91E8C;background:#FCE4EC;border-radius:8px;
                   padding:10px 20px;display:inline-block;margin-top:6px}
</style>
@endpush

@section('content')

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.discounts.index') }}">Coupons</a></li>
        <li class="breadcrumb-item active">Add Coupon</li>
    </ol>
</nav>

<form action="{{ route('admin.discounts.store') }}" method="POST">
@csrf

<div class="row g-4">

    {{-- Left --}}
    <div class="col-md-8">

        {{-- Coupon Code --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="section-heading">Coupon Code</div>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">
                            Code <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="text" name="code" id="couponCode"
                                   class="form-control text-uppercase fw-bold"
                                   value="{{ old('code') }}"
                                   placeholder="e.g. WELCOME10" required
                                   style="letter-spacing:2px">
                            <button type="button" class="btn btn-outline-secondary"
                                    id="generateCode" title="Auto Generate">
                                <i class="bi bi-arrow-clockwise me-1"></i>Generate
                            </button>
                        </div>
                        @error('code')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold d-block">Preview</label>
                        <div class="preview-badge" id="codePreview">
                            {{ old('code') ?: 'CODE' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Discount Value --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="section-heading">Discount Value</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Type <span class="text-danger">*</span>
                        </label>
                        <select name="type" id="discountType" class="form-select" required>
                            <option value="percentage"
                                {{ old('type') === 'percentage' ? 'selected' : '' }}>
                                % Percentage
                            </option>
                            <option value="fixed"
                                {{ old('type') === 'fixed' ? 'selected' : '' }}>
                                ₹ Fixed Amount
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Value <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" id="valuePrefix">%</span>
                            <input type="number" name="value" class="form-control"
                                   value="{{ old('value') }}"
                                   placeholder="0" step="0.01" min="0.01" required>
                        </div>
                        @error('value')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Max Discount (₹)
                            <small class="text-muted fw-normal">(For % type only)</small>
                        </label>
                        <input type="number" name="max_discount" class="form-control"
                               value="{{ old('max_discount') }}"
                               placeholder="Leave blank for no cap"
                               step="0.01" min="0">
                        @error('max_discount')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Minimum Order Value (₹)
                        </label>
                        <input type="number" name="min_order_value" class="form-control"
                               value="{{ old('min_order_value', 0) }}"
                               placeholder="0" step="0.01" min="0">
                        <small class="text-muted">
                            Minimum cart total to apply this coupon
                        </small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Usage Limits --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="section-heading">Usage Limits</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Total Usage Limit
                        </label>
                        <input type="number" name="usage_limit" class="form-control"
                               value="{{ old('usage_limit') }}"
                               placeholder="Leave blank for unlimited" min="1">
                        <small class="text-muted">
                            How many times this coupon can be used in total
                        </small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Usage Per User
                        </label>
                        <input type="number" name="usage_per_user" class="form-control"
                               value="{{ old('usage_per_user', 1) }}"
                               placeholder="1" min="1">
                        <small class="text-muted">
                            How many times one user can use this coupon
                        </small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Applicable On --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="section-heading">Applicable On</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Apply On</label>
                        <select name="applicable_on" id="applicableOn"
                                class="form-select">
                            <option value="all"
                                {{ old('applicable_on','all') === 'all' ? 'selected' : '' }}>
                                All Products
                            </option>
                            <option value="category"
                                {{ old('applicable_on') === 'category' ? 'selected' : '' }}>
                                Specific Categories
                            </option>
                            <option value="product"
                                {{ old('applicable_on') === 'product' ? 'selected' : '' }}>
                                Specific Products
                            </option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">User Restriction</label>
                        <select name="user_restriction" class="form-select">
                            <option value="all"
                                {{ old('user_restriction','all') === 'all' ? 'selected' : '' }}>
                                All Users
                            </option>
                            <option value="new_users"
                                {{ old('user_restriction') === 'new_users' ? 'selected' : '' }}>
                                New Users Only
                            </option>
                        </select>
                    </div>

                    {{-- Category Select --}}
                    <div class="col-md-12" id="categorySelect" style="display:none">
                        <label class="form-label fw-semibold">Select Categories</label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach($categories as $cat)
                            <div class="form-check">
                                <input type="checkbox" name="applicable_ids[]"
                                       value="{{ $cat->id }}" class="form-check-input"
                                       {{ in_array($cat->id, old('applicable_ids', [])) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $cat->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Product Select --}}
                    <div class="col-md-12" id="productSelect" style="display:none">
                        <label class="form-label fw-semibold">Select Products</label>
                        <select name="applicable_ids[]" class="form-select" multiple
                                style="height:150px">
                            @foreach($products as $product)
                            <option value="{{ $product->id }}"
                                {{ in_array($product->id, old('applicable_ids', [])) ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold Ctrl/Cmd to select multiple</small>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Right --}}
    <div class="col-md-4">

        {{-- Validity --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="section-heading">Validity Period</div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Start Date</label>
                        <input type="date" name="start_date" class="form-control"
                               value="{{ old('start_date') }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">End Date</label>
                        <input type="date" name="end_date" class="form-control"
                               value="{{ old('end_date') }}">
                        @error('end_date')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <div class="alert alert-info py-2 small mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Leave blank for no expiry
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="section-heading">Status</div>
                <div class="form-check form-switch">
                    <input type="checkbox" name="status" class="form-check-input"
                           id="statusCheck"
                           {{ old('status', true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="statusCheck">
                        Active
                    </label>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <button type="submit" class="btn btn-pink w-100 mb-2">
                    <i class="bi bi-check-lg me-2"></i>Save Coupon
                </button>
                <a href="{{ route('admin.discounts.index') }}"
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
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Code Preview
    $('#couponCode').on('input', function() {
        var val = $(this).val().toUpperCase();
        $(this).val(val);
        $('#codePreview').text(val || 'CODE');
    });

    // Generate Code
    $('#generateCode').on('click', function() {
        $.get('{{ route("admin.discounts.generate-code") }}', function(res) {
            $('#couponCode').val(res.code);
            $('#codePreview').text(res.code);
        });
    });

    // Discount Type → prefix change
    $('#discountType').on('change', function() {
        $('#valuePrefix').text($(this).val() === 'percentage' ? '%' : '₹');
    });

    // Applicable On → show/hide fields
    $('#applicableOn').on('change', function() {
        $('#categorySelect,#productSelect').hide();
        if ($(this).val() === 'category') $('#categorySelect').show();
        if ($(this).val() === 'product')  $('#productSelect').show();
    });

    // Init on load
    var initVal = '{{ old("applicable_on", "all") }}';
    if (initVal === 'category') $('#categorySelect').show();
    if (initVal === 'product')  $('#productSelect').show();

});
</script>
@endpush