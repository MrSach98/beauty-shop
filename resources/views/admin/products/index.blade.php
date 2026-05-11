@extends('admin.layouts.app')
@section('title','Products')
@section('page-title','Product Management')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<style>
    .btn-pink{background:#E91E8C!important;color:#fff!important;border:none}
    .btn-pink:hover{background:#C2185B!important}
    .filter-bar{background:#fff8fb;border:1px solid #f9c4dc;border-radius:12px;padding:16px;margin-bottom:20px}
    table.dataTable thead th{background:#f8f9fa;font-weight:700;font-size:13px}
    .dt-buttons .btn{font-size:12px;padding:4px 10px;margin-right:4px;border-radius:6px}
</style>
@endpush

@section('content')

{{-- Filter Bar --}}
<div class="filter-bar">
    <div class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label fw-semibold small mb-1">Product Type</label>
            <select id="filterType" class="form-select form-select-sm">
                <option value="">-- All Types --</option>
                @foreach($productTypes as $pt)
                    <option value="{{ $pt->slug }}">{{ $pt->icon }} {{ $pt->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold small mb-1">Category</label>
            <select id="filterCat" class="form-select form-select-sm">
                <option value="">-- All Categories --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label fw-semibold small mb-1">Brand</label>
            <input type="text" id="filterBrand" class="form-control form-control-sm" placeholder="Brand name">
        </div>
        <div class="col-md-2">
            <label class="form-label fw-semibold small mb-1">Status</label>
            <select id="filterStatus" class="form-select form-select-sm">
                <option value="">-- All --</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
        <div class="col-md-2 d-flex flex-column gap-1">
            <button id="applyFilter" class="btn btn-pink btn-sm">
                <i class="bi bi-funnel me-1"></i>Filter
            </button>
            <button id="clearFilter" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-x-circle me-1"></i>Clear
            </button>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <div class="d-flex align-items-center gap-3">
            <h6 class="mb-0 fw-bold">
                <i class="bi bi-box-seam me-2" style="color:#E91E8C"></i>All Products
            </h6>
            <button id="bulkDeleteBtn" class="btn btn-danger btn-sm d-none">
                <i class="bi bi-trash me-1"></i>Bulk Delete
                (<span id="selectedCount">0</span>)
            </button>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-pink btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Add Product
        </a>
    </div>
    <div class="card-body">
        <table id="productTable" class="table table-bordered table-hover w-100 align-middle">
            <thead class="table-light">
                <tr>
                    <th width="40"><input type="checkbox" id="selectAll"></th>
                    <th width="50">#</th>
                    <th width="70">Image</th>
                    <th>Name / SKU</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th width="90">Status</th>
                    <th width="110">Action</th>
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
        <h5 class="modal-title fw-bold"><i class="bi bi-trash me-2"></i>Delete</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center py-4">
        <div style="font-size:44px">🗑️</div>
        <p class="mt-3 mb-1">Delete karna chahte ho?</p>
        <p class="fw-bold" id="deleteProductName"></p>
        <p class="text-danger small">Ye action undo nahi hogi!</p>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmDeleteBtn">Delete Karo</button>
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

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    var table = $('#productTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.products.index") }}',
            data: function(d) {
                d.product_type = $('#filterType').val();
                d.category_id  = $('#filterCat').val();
                d.brand        = $('#filterBrand').val();
                d.status       = $('#filterStatus').val();
            }
        },
        columns: [
            { data: null, orderable: false, searchable: false, width: '40px',
              render: function(d,t,r) {
                  return '<input type="checkbox" class="row-check" value="'+r.id+'">';
              }
            },
            { data: 'DT_RowIndex',   name: 'DT_RowIndex',   orderable: false, searchable: false },
            { data: 'image_col',     name: 'image',          orderable: false, searchable: false },
            { data: 'name_col',      name: 'name' },
            { data: 'type_col',      name: 'product_type',   searchable: false },
            { data: 'category_name', name: 'category_name',  searchable: false },
            { data: 'price_col',     name: 'display_price',  searchable: false },
            { data: 'stock_col',     name: 'stock',          searchable: false },
            { data: 'status_col',    name: 'is_active',      orderable: false, searchable: false },
            { data: 'action',        name: 'action',         orderable: false, searchable: false },
        ],
        dom: '<"d-flex justify-content-between align-items-center mb-3"lB>frt<"d-flex justify-content-between mt-3"ip>',
        lengthMenu: [[10,25,50,100,-1],[10,25,50,100,'Sab']],
        pageLength: 10,
        buttons: [
            { extend:'csv',   text:'<i class="bi bi-filetype-csv"></i> CSV',   className:'btn btn-sm btn-outline-secondary' },
            { extend:'excel', text:'<i class="bi bi-file-earmark-excel"></i> Excel', className:'btn btn-sm btn-outline-success' },
            { extend:'print', text:'<i class="bi bi-printer"></i> Print',      className:'btn btn-sm btn-outline-info' },
        ],
        order: [[1,'desc']],
    });

    // Filters
    $('#applyFilter').on('click', function() { table.ajax.reload(); });
    $('#clearFilter').on('click', function() {
        $('#filterType,#filterCat,#filterStatus').val('');
        $('#filterBrand').val('');
        table.ajax.reload();
    });

    // Select All
    $('#selectAll').on('change', function() {
        $('.row-check').prop('checked', $(this).is(':checked'));
        updateBulkBtn();
    });
    $(document).on('change', '.row-check', updateBulkBtn);

    function updateBulkBtn() {
        var count = $('.row-check:checked').length;
        $('#selectedCount').text(count);
        count > 0 ? $('#bulkDeleteBtn').removeClass('d-none') : $('#bulkDeleteBtn').addClass('d-none');
    }

    // Bulk Delete
    $('#bulkDeleteBtn').on('click', function() {
        var ids = $('.row-check:checked').map(function(){ return $(this).val(); }).get();
        Swal.fire({
            icon: 'warning', title: 'Bulk Delete!',
            text: ids.length+' products delete honge. Sure ho?',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Haan, Delete!',
            cancelButtonText: 'Cancel'
        }).then(function(r) {
            if (r.isConfirmed) {
                $.post('{{ route("admin.products.bulk-delete") }}', { ids: ids }, function(res) {
                    table.ajax.reload();
                    $('#bulkDeleteBtn').addClass('d-none');
                    Swal.fire({ icon:'success', title:'Deleted!', text:res.message, timer:2000, showConfirmButton:false });
                });
            }
        });
    });

    // Single Delete
    var deleteId = null;
    $(document).on('click', '.product-delete-btn', function() {
        deleteId = $(this).data('id');
        $('#deleteProductName').text($(this).data('name'));
        $('#deleteModal').modal('show');
    });
    $('#confirmDeleteBtn').on('click', function() {
        $.ajax({
            url: '/admin/products/'+deleteId,
            type: 'DELETE',
            success: function(res) {
                $('#deleteModal').modal('hide');
                table.ajax.reload();
                Swal.fire({ icon:'success', title:'Deleted!', text:res.message, timer:2000, showConfirmButton:false });
            }
        });
    });

    // Status Toggle
    $(document).on('change', '.product-status-toggle', function() {
        var id = $(this).data('id'), el = $(this);
        $.post('{{ route("admin.products.toggle") }}', { id:id }, function(res) {
            Swal.fire({ icon:'success', title: res.status ? 'Active!' : 'Inactive!', timer:1200, showConfirmButton:false });
        }).fail(function() { el.prop('checked', !el.prop('checked')); });
    });

});
</script>
@endpush