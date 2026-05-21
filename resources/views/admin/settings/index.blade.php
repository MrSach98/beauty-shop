@extends('admin.layouts.app')
@section('title','Settings')
@section('page-title','Settings')

@push('styles')
<style>
    .btn-pink{background:#E91E8C!important;color:#fff!important;border:none}
    .btn-pink:hover{background:#C2185B!important}
    .section-heading{font-size:13px;font-weight:700;color:#E91E8C;
                     border-bottom:1px solid #f9c4dc;padding-bottom:6px;margin-bottom:14px}
    .nav-tabs .nav-link{color:#555;font-weight:600;border:none;padding:10px 20px}
    .nav-tabs .nav-link.active{color:#E91E8C;border-bottom:3px solid #E91E8C;background:transparent}
    .setting-img-preview{max-width:150px;max-height:60px;object-fit:contain;
                         border-radius:8px;border:2px dashed #E91E8C;
                         display:none;margin-top:8px}
</style>
@endpush

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Setting Tabs --}}
<ul class="nav nav-tabs mb-0 bg-white px-3 shadow-sm">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#tab-general">
            ⚙️ General
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#tab-payment">
            💳 Payment
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#tab-social">
            🌐 Social Media
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#tab-seo">
            🔍 SEO
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#tab-email">
            📧 Email / SMTP
        </a>
    </li>
</ul>

<div class="tab-content bg-white shadow-sm">

    {{-- ══ GENERAL ══ --}}
    <div class="tab-pane fade show active p-4" id="tab-general">
        <form action="{{ route('admin.settings.update') }}"
              method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="group" value="general">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="section-heading">Site Information</div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">
                            Site Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="site_name" class="form-control"
                               value="{{ $general['site_name'] ?? '' }}" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Tagline</label>
                        <input type="text" name="site_tagline" class="form-control"
                               value="{{ $general['site_tagline'] ?? '' }}"
                               placeholder="Your shop's tagline">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Contact Email</label>
                        <input type="email" name="site_email" class="form-control"
                               value="{{ $general['site_email'] ?? '' }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Contact Phone</label>
                        <input type="text" name="site_phone" class="form-control"
                               value="{{ $general['site_phone'] ?? '' }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Address</label>
                        <textarea name="site_address" class="form-control"
                                  rows="3">{{ $general['site_address'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="section-heading">Logo & Favicon</div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">
                            Site Logo
                            <small class="text-muted fw-normal">(Max 2MB)</small>
                        </label>
                        @if(!empty($general['site_logo']))
                        <div class="mb-2">
                            <img src="{{ asset('uploads/settings/'.$general['site_logo']) }}"
                                 style="max-height:50px;object-fit:contain;">
                        </div>
                        @endif
                        <input type="file" name="site_logo" id="logoInput"
                               class="form-control" accept="image/*,.svg">
                        <img id="logoPreview" class="setting-img-preview" alt="Preview">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">
                            Favicon
                            <small class="text-muted fw-normal">(PNG/ICO — Max 512KB)</small>
                        </label>
                        @if(!empty($general['site_favicon']))
                        <div class="mb-2">
                            <img src="{{ asset('uploads/settings/'.$general['site_favicon']) }}"
                                 style="width:32px;height:32px;object-fit:contain;">
                        </div>
                        @endif
                        <input type="file" name="site_favicon" id="faviconInput"
                               class="form-control" accept=".png,.ico">
                        <img id="faviconPreview" class="setting-img-preview" alt="Preview">
                    </div>
                </div>

                <div class="section-heading mt-4">Currency</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Currency Symbol</label>
                        <input type="text" name="currency_symbol" class="form-control"
                               value="{{ $general['currency_symbol'] ?? '₹' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Currency Code</label>
                        <input type="text" name="currency_code" class="form-control"
                               value="{{ $general['currency_code'] ?? 'INR' }}">
                    </div>
                </div>

                <div class="section-heading mt-4">Maintenance Mode</div>
                <div class="form-check form-switch mb-3">
                    <input type="checkbox" name="maintenance_mode"
                           class="form-check-input"
                           {{ ($general['maintenance_mode'] ?? '0') === '1' ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold">
                        Enable Maintenance Mode
                    </label>
                </div>
                <label class="form-label fw-semibold">Maintenance Message</label>
                <textarea name="maintenance_msg" class="form-control"
                          rows="2">{{ $general['maintenance_msg'] ?? '' }}</textarea>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-pink px-4">
                <i class="bi bi-check-lg me-2"></i>Save General Settings
            </button>
        </div>
        </form>
    </div>

    {{-- ══ PAYMENT ══ --}}
    <div class="tab-pane fade p-4" id="tab-payment">
        <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <input type="hidden" name="group" value="payment">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="section-heading">Razorpay Gateway</div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="form-check form-switch mb-2">
                            <input type="checkbox" name="razorpay_enabled"
                                   class="form-check-input"
                                   {{ ($payment['razorpay_enabled'] ?? '0') === '1' ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">
                                Enable Razorpay
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Key ID</label>
                        <input type="text" name="razorpay_key_id" class="form-control"
                               value="{{ $payment['razorpay_key_id'] ?? '' }}"
                               placeholder="rzp_live_...">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Key Secret</label>
                        <div class="input-group">
                            <input type="password" name="razorpay_key_secret"
                                   id="razorpaySecret" class="form-control"
                                   value="{{ $payment['razorpay_key_secret'] ?? '' }}"
                                   placeholder="••••••••">
                            <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePass('razorpaySecret')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="section-heading">Other Payment Options</div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="cod_enabled"
                                   class="form-check-input"
                                   {{ ($payment['cod_enabled'] ?? '1') === '1' ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">
                                💵 Enable Cash on Delivery (COD)
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="wallet_enabled"
                                   class="form-check-input"
                                   {{ ($payment['wallet_enabled'] ?? '0') === '1' ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">
                                👛 Enable Wallet Payment
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="alert alert-info py-2 small">
                            <i class="bi bi-info-circle me-1"></i>
                            Get your Razorpay keys from
                            <a href="https://dashboard.razorpay.com" target="_blank">
                                dashboard.razorpay.com
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-pink px-4">
                <i class="bi bi-check-lg me-2"></i>Save Payment Settings
            </button>
        </div>
        </form>
    </div>

    {{-- ══ SOCIAL ══ --}}
    <div class="tab-pane fade p-4" id="tab-social">
        <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <input type="hidden" name="group" value="social">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    <i class="bi bi-facebook text-primary me-2"></i>Facebook URL
                </label>
                <input type="url" name="facebook_url" class="form-control"
                       value="{{ $social['facebook_url'] ?? '' }}"
                       placeholder="https://facebook.com/yourpage">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    <i class="bi bi-instagram text-danger me-2"></i>Instagram URL
                </label>
                <input type="url" name="instagram_url" class="form-control"
                       value="{{ $social['instagram_url'] ?? '' }}"
                       placeholder="https://instagram.com/yourprofile">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    <i class="bi bi-youtube text-danger me-2"></i>YouTube URL
                </label>
                <input type="url" name="youtube_url" class="form-control"
                       value="{{ $social['youtube_url'] ?? '' }}"
                       placeholder="https://youtube.com/yourchannel">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    <i class="bi bi-twitter-x me-2"></i>Twitter / X URL
                </label>
                <input type="url" name="twitter_url" class="form-control"
                       value="{{ $social['twitter_url'] ?? '' }}"
                       placeholder="https://twitter.com/yourhandle">
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-pink px-4">
                <i class="bi bi-check-lg me-2"></i>Save Social Settings
            </button>
        </div>
        </form>
    </div>

    {{-- ══ SEO ══ --}}
    <div class="tab-pane fade p-4" id="tab-seo">
        <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <input type="hidden" name="group" value="seo">
        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label fw-semibold">
                    Default Meta Title
                    <small class="text-muted fw-normal">(60 chars max)</small>
                </label>
                <input type="text" name="meta_title" class="form-control"
                       value="{{ $seo['meta_title'] ?? '' }}"
                       placeholder="Your Shop Name - Tagline" maxlength="60">
            </div>
            <div class="col-md-12">
                <label class="form-label fw-semibold">
                    Default Meta Description
                    <small class="text-muted fw-normal">(160 chars max)</small>
                </label>
                <textarea name="meta_description" class="form-control"
                          rows="3" maxlength="160">{{ $seo['meta_description'] ?? '' }}</textarea>
            </div>
            <div class="col-md-12">
                <label class="form-label fw-semibold">Meta Keywords</label>
                <input type="text" name="meta_keywords" class="form-control"
                       value="{{ $seo['meta_keywords'] ?? '' }}"
                       placeholder="keyword1, keyword2, keyword3">
            </div>
            <div class="col-md-12">
                <label class="form-label fw-semibold">
                    Google Analytics ID
                    <small class="text-muted fw-normal">(e.g. G-XXXXXXXXXX)</small>
                </label>
                <input type="text" name="google_analytics" class="form-control"
                       value="{{ $seo['google_analytics'] ?? '' }}"
                       placeholder="G-XXXXXXXXXX">
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-pink px-4">
                <i class="bi bi-check-lg me-2"></i>Save SEO Settings
            </button>
        </div>
        </form>
    </div>

    {{-- ══ EMAIL ══ --}}
    <div class="tab-pane fade p-4" id="tab-email">
        <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <input type="hidden" name="group" value="email">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="section-heading">SMTP Configuration</div>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">SMTP Host</label>
                        <input type="text" name="smtp_host" class="form-control"
                               value="{{ $email['smtp_host'] ?? '' }}"
                               placeholder="smtp.gmail.com">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Port</label>
                        <input type="number" name="smtp_port" class="form-control"
                               value="{{ $email['smtp_port'] ?? '587' }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Username</label>
                        <input type="text" name="smtp_username" class="form-control"
                               value="{{ $email['smtp_username'] ?? '' }}"
                               placeholder="your@email.com">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <input type="password" name="smtp_password"
                                   id="smtpPassword" class="form-control"
                                   value="{{ $email['smtp_password'] ?? '' }}"
                                   placeholder="••••••••">
                            <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePass('smtpPassword')">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Encryption</label>
                        <select name="smtp_encryption" class="form-select">
                            @foreach(['tls' => 'TLS', 'ssl' => 'SSL', '' => 'None'] as $val => $label)
                            <option value="{{ $val }}"
                                {{ ($email['smtp_encryption'] ?? 'tls') === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="section-heading">From Address</div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">From Name</label>
                        <input type="text" name="mail_from_name" class="form-control"
                               value="{{ $email['mail_from_name'] ?? '' }}"
                               placeholder="Beauty Shop">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">From Email</label>
                        <input type="email" name="mail_from_email" class="form-control"
                               value="{{ $email['mail_from_email'] ?? '' }}"
                               placeholder="noreply@beautyshop.com">
                    </div>
                </div>

                <div class="section-heading mt-4">Test Email</div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Send Test Email</label>
                        <div class="input-group">
                            <input type="email" id="testEmailInput"
                                   class="form-control"
                                   placeholder="test@example.com">
                            <button type="button" class="btn btn-outline-secondary"
                                    id="sendTestEmail">
                                <i class="bi bi-send me-1"></i>Send Test
                            </button>
                        </div>
                        <div id="testEmailResult" class="mt-2"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-pink px-4">
                <i class="bi bi-check-lg me-2"></i>Save Email Settings
            </button>
        </div>
        </form>
    </div>

</div>{{-- end tab-content --}}

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

// Toggle password visibility
function togglePass(id) {
    var input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}

// Image preview
function setupPreview(inputId, previewId) {
    document.getElementById(inputId)?.addEventListener('change', function() {
        var file = this.files[0];
        if (!file) return;
        if (file.size > 2*1024*1024) {
            Swal.fire({ icon:'error', title:'File too large!', text:'Max 2MB allowed.', confirmButtonColor:'#E91E8C' });
            this.value = ''; return;
        }
        var reader = new FileReader();
        reader.onload = function(e) {
            var p = document.getElementById(previewId);
            p.src = e.target.result;
            p.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });
}
setupPreview('logoInput',    'logoPreview');
setupPreview('faviconInput', 'faviconPreview');

// Test Email
$('#sendTestEmail').on('click', function() {
    var email = $('#testEmailInput').val();
    if (!email) {
        Swal.fire({ icon:'warning', title:'Enter email!', confirmButtonColor:'#E91E8C' });
        return;
    }
    $(this).prop('disabled', true).html('<i class="bi bi-hourglass me-1"></i>Sending...');
    $.post('{{ route("admin.settings.test-email") }}', { test_email: email }, function(res) {
        $('#testEmailResult').html(
            '<div class="alert alert-success py-2 small">'+
            '<i class="bi bi-check-circle me-1"></i>'+res.message+'</div>'
        );
    }).fail(function(xhr) {
        $('#testEmailResult').html(
            '<div class="alert alert-danger py-2 small">'+
            '<i class="bi bi-x-circle me-1"></i>'+(xhr.responseJSON?.message || 'Failed')+'</div>'
        );
    }).always(function() {
        $('#sendTestEmail').prop('disabled', false)
                          .html('<i class="bi bi-send me-1"></i>Send Test');
    });
});
</script>
@endpush