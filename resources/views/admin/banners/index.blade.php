@extends('admin.layouts.app')
@section('title','Banners')
@section('page-title','Banner & Promotions')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<style>
    .btn-pink{background:#E91E8C!important;color:#fff!important;border:none}
    .btn-pink:hover{background:#C2185B!important}
    .filter-btn{border-radius:20px;font-size:12px;padding:5px 16px}
    .filter-btn.active{background:#E91E8C!important;color:#fff!important;border-color:#E91E8C!important}
</style>
@endpush

@section('content')

{{-- Success Alert --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Type Filter --}}
<div class="d-flex flex-wrap gap-2 mb-4">
    <button class="btn btn-outline-secondary filter-btn active" data-type="">
        All
    </button>
    @foreach($typeLabels as $key => $label)
    <button class="btn btn-outline-secondary filter-btn" data-type="{{ $key }}">
        {{ $label }}
    </button>
    @endforeach
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-bold">
            <i class="bi bi-image me-2" style="color:#E91E8C"></i>All Banners
        </h6>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-pink btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Add Banner
        </a>
    </div>
    <div class="card-body">
        <table id="bannerTable"
               class="table table-bordered table-hover w-100 align-middle">
            <thead class="table-light">
                <tr>
                    <th width="50">#</th>
                    <th width="120">Image</th>
                    <th>Title</th>
                    <th width="140">Type</th>
                    <th width="130">Position</th>
                    <th width="140">Validity</th>
                    <th width="80">Sort</th>
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
            <i class="bi bi-trash me-2"></i>Delete banner.
        </h5>
        <button type="button" class="btn-close btn-close-white"
                data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center py-4">
        <div style="font-size:44px">🗑️</div>
        <p class="mt-3 mb-1">Do you want to delete it?</p>
        <p class="fw-bold text-dark" id="deleteBannerTitle"></p>
        <p class="text-danger small">The image will also be deleted!</p>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmDelete">
            <i class="bi bi-trash me-1"></i>Delete it.
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

    var currentType = '';

    var table = $('#bannerTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.banners.index") }}',
            data: function(d) { d.type = currentType; }
        },
        columns: [
            { data:'DT_RowIndex',  name:'DT_RowIndex',  orderable:false, searchable:false },
            { data:'image_col',    name:'image',         orderable:false, searchable:false },
            { data:'title',        name:'title' },
            { data:'type_col',     name:'type',          searchable:false },
            { data:'position_col', name:'position',      searchable:false },
            { data:'validity_col', name:'start_date',    orderable:false, searchable:false },
            { data:'sort_order',   name:'sort_order' },
            { data:'status_col',   name:'status',        orderable:false, searchable:false },
            { data:'action',       name:'action',        orderable:false, searchable:false },
        ],
        dom: '<"d-flex justify-content-between align-items-center mb-3"lB>frt<"d-flex justify-content-between mt-3"ip>',
        lengthMenu: [[10,25,50,-1],[10,25,50,'Sab']],
        pageLength: 10,
        buttons: [
            { extend:'csv',   text:'CSV',   className:'btn btn-sm btn-outline-secondary' },
            { extend:'excel', text:'Excel', className:'btn btn-sm btn-outline-success' },
            { extend:'print', text:'Print', className:'btn btn-sm btn-outline-info' },
        ],
        order: [[6,'asc']],
    });

    // Filter buttons
    $('.filter-btn').on('click', function() {
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        currentType = $(this).data('type');
        table.ajax.reload();
    });

    // Status Toggle
    $(document).on('change', '.banner-status-toggle', function() {
        var id = $(this).data('id'), el = $(this);
        $.post('{{ route("admin.banners.toggle") }}', { id: id }, function(res) {
            Swal.fire({
                icon: 'success',
                title: res.status ? 'Active!' : 'Inactive!',
                timer: 1200, showConfirmButton: false
            });
        }).fail(function() {
            el.prop('checked', !el.prop('checked'));
        });
    });

    // Delete
    var deleteId = null;
    $(document).on('click', '.delete-banner-btn', function() {
        deleteId = $(this).data('id');
        $('#deleteBannerTitle').text($(this).data('title'));
        $('#deleteModal').modal('show');
    });

    $('#confirmDelete').on('click', function() {
        $.ajax({
            url: '/admin/banners/' + deleteId,
            type: 'DELETE',
            success: function(res) {
                $('#deleteModal').modal('hide');
                table.ajax.reload();
                Swal.fire({
                    icon: 'success', title: 'Deleted!', text: res.message,
                    timer: 2000, showConfirmButton: false
                });
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Error!', text: 'Delete nahi hua.' });
            }
        });
    });

});
</script>
@endpush