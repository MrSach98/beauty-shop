@extends('admin.layouts.app')
@section('title','Shipping')
@section('page-title','Shipping Management')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<style>
    .btn-pink{background:#E91E8C!important;color:#fff!important;border:none}
    .btn-pink:hover{background:#C2185B!important}
    .section-heading{font-size:13px;font-weight:700;color:#E91E8C;
                     border-bottom:1px solid #f9c4dc;padding-bottom:6px;margin-bottom:14px}
    .nav-tabs .nav-link{color:#555;font-weight:600;border:none;padding:10px 20px}
    .nav-tabs .nav-link.active{color:#E91E8C;border-bottom:3px solid #E91E8C;background:transparent}
    .states-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:6px}
</style>
@endpush

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Tabs --}}
<ul class="nav nav-tabs mb-4 bg-white px-3 shadow-sm">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#tab-zones">
            🗺️ Shipping Zones
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#tab-settings">
            ⚙️ Global Settings
        </a>
    </li>
</ul>

<div class="tab-content">

    {{-- ══ TAB 1: ZONES ══ --}}
    <div class="tab-pane fade show active" id="tab-zones">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-geo-alt me-2" style="color:#E91E8C"></i>
                    Shipping Zones
                </h6>
                <button class="btn btn-pink btn-sm"
                        data-bs-toggle="modal" data-bs-target="#addZoneModal">
                    <i class="bi bi-plus-lg me-1"></i>Add Zone
                </button>
            </div>
            <div class="card-body">
                <div class="alert alert-info py-2 mb-3 small">
                    <i class="bi bi-info-circle me-1"></i>
                    Zones define shipping charges for different states.
                    If no zone matches, default settings will be used.
                </div>
                <table id="zoneTable"
                       class="table table-bordered table-hover w-100 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Zone Name</th>
                            <th>States Covered</th>
                            <th>Charges</th>
                            <th width="100">Status</th>
                            <th width="110">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- ══ TAB 2: GLOBAL SETTINGS ══ --}}
    <div class="tab-pane fade" id="tab-settings">
        <form action="{{ route('admin.shipping.save-settings') }}" method="POST">
        @csrf
        <div class="row g-4">

            {{-- General --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="section-heading">General Settings</div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="global_shipping_enabled"
                                           class="form-check-input"
                                           {{ $settings['global_shipping_enabled'] ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold">
                                        Enable Shipping
                                    </label>
                                </div>
                                <small class="text-muted">
                                    Turn off to disable all shipping options
                                </small>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="global_cod_enabled"
                                           class="form-check-input"
                                           {{ $settings['global_cod_enabled'] ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold">
                                        Enable COD Globally
                                    </label>
                                </div>
                                <small class="text-muted">
                                    Allow Cash on Delivery for all products
                                </small>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">
                                    Default Shipping Charge (₹)
                                </label>
                                <input type="number" name="default_shipping_charge"
                                       class="form-control"
                                       value="{{ $settings['default_shipping_charge'] }}"
                                       step="0.01" min="0" required>
                                <small class="text-muted">
                                    Used when no shipping zone matches
                                </small>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">
                                    COD Extra Charge (₹)
                                </label>
                                <input type="number" name="cod_charge"
                                       class="form-control"
                                       value="{{ $settings['cod_charge'] }}"
                                       step="0.01" min="0" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">
                                    Free Shipping Above (₹)
                                </label>
                                <input type="number" name="global_free_shipping_above"
                                       class="form-control"
                                       value="{{ $settings['global_free_shipping_above'] }}"
                                       step="0.01" min="0"
                                       placeholder="Leave blank to disable">
                                <small class="text-muted">
                                    Orders above this amount get free shipping
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Delivery Partner --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="section-heading">Delivery Partner</div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">
                                    Delivery Partner Name
                                </label>
                                <select name="delivery_partner" class="form-select">
                                    <option value="">-- Select Partner --</option>
                                    @foreach(['Delhivery','Shiprocket','Blue Dart','DTDC','Ekart','India Post','FedEx','DHL','Custom'] as $dp)
                                    <option value="{{ $dp }}"
                                        {{ $settings['delivery_partner'] === $dp ? 'selected' : '' }}>
                                        {{ $dp }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">
                                    Tracking URL
                                </label>
                                <input type="url" name="tracking_url"
                                       class="form-control"
                                       value="{{ $settings['tracking_url'] }}"
                                       placeholder="https://track.example.com/?id=">
                                <small class="text-muted">
                                    Tracking number will be appended to this URL
                                </small>
                            </div>

                            {{-- Summary --}}
                            <div class="col-md-12 mt-2">
                                <div class="alert alert-warning py-2 small mb-0">
                                    <strong>Current Settings:</strong><br>
                                    Default Charge: ₹{{ $settings['default_shipping_charge'] }}<br>
                                    COD Charge: ₹{{ $settings['cod_charge'] }}<br>
                                    @if($settings['global_free_shipping_above'])
                                    Free Shipping Above: ₹{{ $settings['global_free_shipping_above'] }}<br>
                                    @endif
                                    COD: {{ $settings['global_cod_enabled'] ? '✅ Enabled' : '❌ Disabled' }}<br>
                                    Partner: {{ $settings['delivery_partner'] ?: 'Not Set' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <button type="submit" class="btn btn-pink px-4">
                    <i class="bi bi-check-lg me-2"></i>Save Settings
                </button>
            </div>
        </div>
        </form>
    </div>

</div>{{-- end tab-content --}}


{{-- ── ADD ZONE MODAL ── --}}
<div class="modal fade" id="addZoneModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content border-0 shadow">
      <div class="modal-header" style="background:#E91E8C">
        <h5 class="modal-title text-white fw-bold">
            <i class="bi bi-plus-circle me-2"></i>Add Shipping Zone
        </h5>
        <button type="button" class="btn-close btn-close-white"
                data-bs-dismiss="modal"></button>
      </div>
      <form id="addZoneForm">
        @csrf
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Zone Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="name" class="form-control"
                           placeholder="e.g. North India, Mumbai Local" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Base Shipping Charge (₹) <span class="text-danger">*</span>
                    </label>
                    <input type="number" name="base_charge" class="form-control"
                           placeholder="0.00" step="0.01" min="0" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Free Shipping Above (₹)
                    </label>
                    <input type="number" name="free_above" class="form-control"
                           placeholder="Leave blank to disable" step="0.01" min="0">
                </div>
                <div class="col-md-4">
                    <div class="form-check form-switch mt-3">
                        <input type="checkbox" name="cod_available"
                               class="form-check-input" checked
                               id="addCodAvail">
                        <label class="form-check-label fw-semibold">
                            COD Available in this Zone
                        </label>
                    </div>
                </div>
                <div class="col-md-4" id="addCodChargeWrap">
                    <label class="form-label fw-semibold">COD Extra Charge (₹)</label>
                    <input type="number" name="cod_charge" class="form-control"
                           value="0" step="0.01" min="0">
                </div>
                <div class="col-md-4">
                    <div class="form-check form-switch mt-3">
                        <input type="checkbox" name="status"
                               class="form-check-input" checked>
                        <label class="form-check-label fw-semibold">Active</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">
                        States Covered
                        <small class="text-muted fw-normal">
                            (Leave all unchecked = applies to all states)
                        </small>
                    </label>
                    <div class="states-grid mt-2">
                        @foreach($states as $state)
                        <div class="form-check">
                            <input type="checkbox" name="states[]"
                                   value="{{ $state }}" class="form-check-input">
                            <label class="form-check-label small">{{ $state }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-pink">
                <i class="bi bi-check-lg me-1"></i>Save Zone
            </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ── EDIT ZONE MODAL ── --}}
<div class="modal fade" id="editZoneModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content border-0 shadow">
      <div class="modal-header" style="background:#C2185B">
        <h5 class="modal-title text-white fw-bold">
            <i class="bi bi-pencil-square me-2"></i>Edit Shipping Zone
        </h5>
        <button type="button" class="btn-close btn-close-white"
                data-bs-dismiss="modal"></button>
      </div>
      <form id="editZoneForm">
        @csrf
        <input type="hidden" id="editZoneId">
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Zone Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="name" id="editZoneName"
                           class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Base Charge (₹) <span class="text-danger">*</span>
                    </label>
                    <input type="number" name="base_charge" id="editBaseCharge"
                           class="form-control" step="0.01" min="0" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Free Above (₹)</label>
                    <input type="number" name="free_above" id="editFreeAbove"
                           class="form-control" step="0.01" min="0"
                           placeholder="Leave blank to disable">
                </div>
                <div class="col-md-4">
                    <div class="form-check form-switch mt-3">
                        <input type="checkbox" name="cod_available"
                               class="form-check-input" id="editCodAvail">
                        <label class="form-check-label fw-semibold">
                            COD Available
                        </label>
                    </div>
                </div>
                <div class="col-md-4" id="editCodChargeWrap">
                    <label class="form-label fw-semibold">COD Charge (₹)</label>
                    <input type="number" name="cod_charge" id="editCodCharge"
                           class="form-control" step="0.01" min="0">
                </div>
                <div class="col-md-4">
                    <div class="form-check form-switch mt-3">
                        <input type="checkbox" name="status"
                               class="form-check-input" id="editZoneStatus">
                        <label class="form-check-label fw-semibold">Active</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">States Covered</label>
                    <div class="states-grid mt-2" id="editStatesGrid">
                        @foreach($states as $state)
                        <div class="form-check">
                            <input type="checkbox" name="states[]"
                                   value="{{ $state }}"
                                   class="form-check-input edit-state-check">
                            <label class="form-check-label small">{{ $state }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-pink">
                <i class="bi bi-check-lg me-1"></i>Update Zone
            </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="deleteZoneModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title fw-bold">
            <i class="bi bi-trash me-2"></i>Delete Zone
        </h5>
        <button type="button" class="btn-close btn-close-white"
                data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center py-4">
        <div style="font-size:44px">🗑️</div>
        <p class="mt-3 mb-1">Delete this shipping zone?</p>
        <p class="fw-bold text-dark" id="deleteZoneName"></p>
        <p class="text-danger small">This action cannot be undone!</p>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmZoneDelete">
            <i class="bi bi-trash me-1"></i>Delete
        </button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ── DataTable ─────────────────────────────────────
    var table = $('#zoneTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.shipping.index") }}',
        columns: [
            { data:'DT_RowIndex', name:'DT_RowIndex', orderable:false, searchable:false },
            { data:'name',        name:'name' },
            { data:'states_col',  name:'states',  orderable:false, searchable:false },
            { data:'charges_col', name:'base_charge', orderable:false, searchable:false },
            { data:'status_col',  name:'status',  orderable:false, searchable:false },
            { data:'action',      name:'action',  orderable:false, searchable:false },
        ],
        dom: '<"d-flex justify-content-between align-items-center mb-3"lB>frt<"d-flex justify-content-between mt-3"ip>',
        lengthMenu: [[10,25,50,-1],[10,25,50,'All']],
        pageLength: 10,
        buttons: [
            { extend:'csv',   text:'CSV',   className:'btn btn-sm btn-outline-secondary' },
            { extend:'excel', text:'Excel', className:'btn btn-sm btn-outline-success' },
        ],
    });

    // ── COD Charge toggle ──────────────────────────────
    $('#addCodAvail').on('change', function() {
        $(this).is(':checked')
            ? $('#addCodChargeWrap').show()
            : $('#addCodChargeWrap').hide();
    });
    $('#editCodAvail').on('change', function() {
        $(this).is(':checked')
            ? $('#editCodChargeWrap').show()
            : $('#editCodChargeWrap').hide();
    });

    // ── ADD ZONE ───────────────────────────────────────
    $('#addZoneForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("admin.shipping.zones.store") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                $('#addZoneModal').modal('hide');
                $('#addZoneForm')[0].reset();
                table.ajax.reload();
                Swal.fire({
                    icon:'success', title:'Zone Created!', text:res.message,
                    timer:2000, showConfirmButton:false
                });
            },
            error: function(xhr) {
                var msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                Swal.fire({ icon:'error', title:'Validation Error', text:msg });
            }
        });
    });

    // ── EDIT ZONE BUTTON ───────────────────────────────
    $(document).on('click', '.edit-zone-btn', function() {
        var btn    = $(this);
        var states = btn.data('states');
        if (typeof states === 'string') states = JSON.parse(states);

        $('#editZoneId').val(btn.data('id'));
        $('#editZoneName').val(btn.data('name'));
        $('#editBaseCharge').val(btn.data('base_charge'));
        $('#editFreeAbove').val(btn.data('free_above') || '');
        $('#editCodCharge').val(btn.data('cod_charge'));
        $('#editCodAvail').prop('checked', btn.data('cod_available') == 1);
        $('#editZoneStatus').prop('checked', btn.data('status') == 1);

        if (btn.data('cod_available') == 1) {
            $('#editCodChargeWrap').show();
        } else {
            $('#editCodChargeWrap').hide();
        }

        // Pre-check states
        $('.edit-state-check').prop('checked', false);
        (states || []).forEach(function(state) {
            $('.edit-state-check[value="'+state+'"]').prop('checked', true);
        });

        $('#editZoneModal').modal('show');
    });

    // ── EDIT ZONE SUBMIT ───────────────────────────────
    $('#editZoneForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#editZoneId').val();
        $.ajax({
            url: '/admin/shipping/zones/' + id,
            type: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                $('#editZoneModal').modal('hide');
                table.ajax.reload();
                Swal.fire({
                    icon:'success', title:'Updated!', text:res.message,
                    timer:2000, showConfirmButton:false
                });
            },
            error: function(xhr) {
                var msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                Swal.fire({ icon:'error', title:'Error', text:msg });
            }
        });
    });

    // ── DELETE ZONE ────────────────────────────────────
    var deleteId = null;
    $(document).on('click', '.delete-zone-btn', function() {
        deleteId = $(this).data('id');
        $('#deleteZoneName').text($(this).data('name'));
        $('#deleteZoneModal').modal('show');
    });
    $('#confirmZoneDelete').on('click', function() {
        $.ajax({
            url: '/admin/shipping/zones/' + deleteId,
            type: 'DELETE',
            success: function(res) {
                $('#deleteZoneModal').modal('hide');
                table.ajax.reload();
                Swal.fire({
                    icon:'success', title:'Deleted!', text:res.message,
                    timer:2000, showConfirmButton:false
                });
            }
        });
    });

    // ── STATUS TOGGLE ──────────────────────────────────
    $(document).on('change', '.zone-status-toggle', function() {
        var id = $(this).data('id'), el = $(this);
        $.post('{{ route("admin.shipping.zones.toggle") }}', { id:id }, function(res) {
            Swal.fire({
                icon:'success',
                title: res.status ? 'Activated!' : 'Deactivated!',
                timer:1200, showConfirmButton:false
            });
        }).fail(function() { el.prop('checked', !el.prop('checked')); });
    });

});
</script>
@endpush