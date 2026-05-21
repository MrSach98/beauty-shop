@extends('admin.layouts.app')
@section('title','Discount Codes')
@section('page-title','Discount & Coupon Management')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<style>
    .btn-pink{background:#E91E8C!important;color:#fff!important;border:none}
    .btn-pink:hover{background:#C2185B!important}
    .filter-bar{background:#fff8fb;border:1px solid #f9c4dc;border-radius:12px;padding:16px;margin-bottom:20px}
</style>
@endpush

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Filter --}}
<div class="filter-bar">
    <div class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label fw-semibold small mb-1">Discount Type</label>
            <select id="filterType" class="form-select form-select-sm">
                <option value="">All Types</option>
                <option value="percentage">% Percentage</option>
                <option value="fixed">₹ Fixed Amount</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold small mb-1">Status</label>
            <select id="filterStatus" class="form-select form-select-sm">
                <option value="">All</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button id="applyFilter" class="btn btn-pink btn-sm w-100">
                <i class="bi bi-funnel me-1"></i>Filter
            </button>
            <button id="clearFilter" class="btn btn-outline-secondary btn-sm w-100">
                <i class="bi bi-x-circle me-1"></i>Clear
            </button>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-bold">
            <i class="bi bi-tag me-2" style="color:#E91E8C"></i>All Coupon Codes
        </h6>
        <a href="{{ route('admin.discounts.create') }}" class="btn btn-pink btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Add Coupon
        </a>
    </div>
    <div class="card-body">
        <table id="discountTable"
               class="table table-bordered table-hover w-100 align-middle">
            <thead class="table-light">
                <tr>
                    <th width="50">#</th>
                    <th>Code</th>
                    <th width="130">Type</th>
                    <th width="100">Value</th>
                    <th width="120">Min Order</th>
                    <th width="100">Usage</th>
                    <th width="160">Validity</th>
                    <th width="100">Status</th>
                    <th width="100">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title fw-bold">
            <i class="bi bi-trash me-2"></i>Delete Coupon
        </h5>
        <button type="button" class="btn-close btn-close-white"
                data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center py-4">
        <div style="font-size:44px">🗑️</div>
        <p class="mt-3 mb-1">Are you sure you want to delete?</p>
        <p class="fw-bold text-dark" id="deleteCodeName"></p>
        <p class="text-danger small">This action cannot be undone!</p>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmDelete">
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
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    var table = $('#discountTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.discounts.index") }}',
            data: function(d) {
                d.type   = $('#filterType').val();
                d.status = $('#filterStatus').val();
            }
        },
        columns: [
            { data:'DT_RowIndex', name:'DT_RowIndex', orderable:false, searchable:false },
            { data:'code',        name:'code' },
            { data:'type_col',    name:'type',       searchable:false },
            { data:'value_col',   name:'value',      searchable:false },
            { data:'min_order_value', name:'min_order_value',
              render: function(d) { return d > 0 ? '₹'+parseFloat(d).toFixed(2) : '<span class="text-muted">No Min</span>'; }
            },
            { data:'usage_col',   name:'used_count', searchable:false },
            { data:'validity_col',name:'start_date', orderable:false, searchable:false },
            { data:'status_col',  name:'status',     orderable:false, searchable:false },
            { data:'action',      name:'action',     orderable:false, searchable:false },
        ],
        dom: '<"d-flex justify-content-between align-items-center mb-3"lB>frt<"d-flex justify-content-between mt-3"ip>',
        lengthMenu: [[10,25,50,-1],[10,25,50,'All']],
        pageLength: 10,
        buttons: [
            { extend:'csv',   text:'CSV',   className:'btn btn-sm btn-outline-secondary' },
            { extend:'excel', text:'Excel', className:'btn btn-sm btn-outline-success' },
            { extend:'print', text:'Print', className:'btn btn-sm btn-outline-info' },
        ],
        order: [[0,'desc']],
    });

    $('#applyFilter').on('click', function() { table.ajax.reload(); });
    $('#clearFilter').on('click', function() {
        $('#filterType,#filterStatus').val('');
        table.ajax.reload();
    });

    // Status Toggle
    $(document).on('change', '.discount-status-toggle', function() {
        var id = $(this).data('id'), el = $(this);
        $.post('{{ route("admin.discounts.toggle") }}', { id: id }, function(res) {
            Swal.fire({
                icon: 'success',
                title: res.status ? 'Activated!' : 'Deactivated!',
                timer: 1200, showConfirmButton: false
            });
        }).fail(function() { el.prop('checked', !el.prop('checked')); });
    });

    // Delete
    var deleteId = null;
    $(document).on('click', '.delete-discount-btn', function() {
        deleteId = $(this).data('id');
        $('#deleteCodeName').text($(this).data('code'));
        $('#deleteModal').modal('show');
    });
    $('#confirmDelete').on('click', function() {
        $.ajax({
            url: '/admin/discounts/' + deleteId,
            type: 'DELETE',
            success: function(res) {
                $('#deleteModal').modal('hide');
                table.ajax.reload();
                Swal.fire({
                    icon: 'success', title: 'Deleted!', text: res.message,
                    timer: 2000, showConfirmButton: false
                });
            }
        });
    });

});
</script>
@endpush