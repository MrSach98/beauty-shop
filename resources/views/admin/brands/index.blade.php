@extends('admin.layouts.app')
@section('title','Brands')
@section('page-title','Brand Management')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<style>
    .btn-pink{background:#E91E8C!important;color:#fff!important;border:none}
    .btn-pink:hover{background:#C2185B!important}
    .img-preview{width:90px;height:90px;object-fit:contain;border-radius:10px;
                 display:none;border:2px dashed #E91E8C;margin-top:8px;padding:4px}
    .current-logo{width:70px;height:70px;object-fit:contain;border-radius:8px;
                  border:2px solid #E91E8C;padding:4px}
    .current-logo-box{display:flex;align-items:center;gap:12px;padding:10px;
                      background:#fff8fb;border:1px solid #f9c4dc;border-radius:10px;margin-bottom:8px}
</style>
@endpush

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-bold">
            <i class="bi bi-award me-2" style="color:#E91E8C"></i>All Brands
        </h6>
        <button class="btn btn-pink btn-sm"
                data-bs-toggle="modal" data-bs-target="#addBrandModal">
            <i class="bi bi-plus-lg me-1"></i>Add Brand
        </button>
    </div>
    <div class="card-body">
        <table id="brandTable" class="table table-bordered table-hover w-100 align-middle">
            <thead class="table-light">
                <tr>
                    <th width="50">#</th>
                    <th width="80">Logo</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th width="120">Products</th>
                    <th width="120">Featured</th>
                    <th width="80">Sort</th>
                    <th width="100">Status</th>
                    <th width="110">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

{{-- ── ADD BRAND MODAL ── --}}
<div class="modal fade" id="addBrandModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow">
      <div class="modal-header" style="background:#E91E8C">
        <h5 class="modal-title text-white fw-bold">
            <i class="bi bi-plus-circle me-2"></i>Add Brand
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="addBrandForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Brand Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="name" id="brandName"
                           class="form-control" placeholder="e.g. Lakme" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Slug</label>
                    <input type="text" name="slug" id="brandSlug"
                           class="form-control" placeholder="auto generate hoga">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">
                        Logo <small class="text-muted fw-normal">(Max 2MB — JPG, PNG, WEBP, SVG)</small>
                    </label>
                    <input type="file" name="logo" id="addLogoInput"
                           class="form-control" accept="image/*,.svg">
                    <img id="addLogoPreview" class="img-preview" alt="Preview">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="3"
                              placeholder="write something about the brand..."></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Website URL</label>
                    <input type="url" name="website_url" class="form-control"
                           placeholder="https://brand.com">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control"
                           value="0" min="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold d-block mb-3">&nbsp;</label>
                    <div class="form-check form-switch">
                        <input type="checkbox" name="is_featured"
                               class="form-check-input">
                        <label class="form-check-label fw-semibold">⭐ Featured</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="status"
                               class="form-check-input" checked>
                        <label class="form-check-label fw-semibold">Active</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-pink">
                <i class="bi bi-check-lg me-1"></i>Save Brand
            </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ── EDIT BRAND MODAL ── --}}
<div class="modal fade" id="editBrandModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow">
      <div class="modal-header" style="background:#C2185B">
        <h5 class="modal-title text-white fw-bold">
            <i class="bi bi-pencil-square me-2"></i>Edit Brand
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="editBrandForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="editBrandId">
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Brand Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="name" id="editBrandName"
                           class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Slug</label>
                    <input type="text" name="slug" id="editBrandSlug"
                           class="form-control">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Current Logo</label>
                    <div id="editCurrentLogo"></div>
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">
                        New Logo Upload
                        <small class="text-muted fw-normal">
                           (Max 2MB — leave blank to keep the previous one)
                        </small>
                    </label>
                    <input type="file" name="logo" id="editLogoInput"
                           class="form-control" accept="image/*,.svg">
                    <img id="editLogoPreview" class="img-preview" alt="Preview">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" id="editBrandDesc"
                              class="form-control" rows="3"></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Website URL</label>
                    <input type="url" name="website_url" id="editBrandUrl"
                           class="form-control" placeholder="https://brand.com">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" id="editBrandSort"
                           class="form-control" min="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold d-block mb-3">&nbsp;</label>
                    <div class="form-check form-switch">
                        <input type="checkbox" name="is_featured"
                               class="form-check-input" id="editBrandFeatured">
                        <label class="form-check-label fw-semibold">⭐ Featured</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="status"
                               class="form-check-input" id="editBrandStatus">
                        <label class="form-check-label fw-semibold">Active</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-pink">
                <i class="bi bi-check-lg me-1"></i>Update Brand
            </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ── DELETE MODAL ── --}}
<div class="modal fade" id="deleteBrandModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title fw-bold">
            <i class="bi bi-trash me-2"></i>Delete Brand
        </h5>
        <button type="button" class="btn-close btn-close-white"
                data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center py-4">
        <div style="font-size:44px">🗑️</div>
        <p class="mt-3 mb-1">Do you want to delete it?</p>
        <p class="fw-bold" id="deleteBrandName"></p>
        <p class="text-danger small">This action cannot be undone!</p>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmBrandDelete">
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

    // ── DataTable ─────────────────────────────────────
    var table = $('#brandTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.brands.index") }}',
        columns: [
            { data:'DT_RowIndex',     name:'DT_RowIndex',     orderable:false, searchable:false },
            { data:'logo_col',        name:'logo',            orderable:false, searchable:false },
            { data:'name',            name:'name' },
            { data:'slug',            name:'slug' },
            { data:'products_count',  name:'products_count',  orderable:false, searchable:false },
            { data:'featured_col',    name:'is_featured',     searchable:false },
            { data:'sort_order',      name:'sort_order' },
            { data:'status_col',      name:'status',          orderable:false, searchable:false },
            { data:'action',          name:'action',          orderable:false, searchable:false },
        ],
        dom: '<"d-flex justify-content-between align-items-center mb-3"lB>frt<"d-flex justify-content-between mt-3"ip>',
        lengthMenu: [[10,25,50,-1],[10,25,50,'Sab']],
        pageLength: 10,
        buttons: [
            { extend:'csv',   text:'CSV',   className:'btn btn-sm btn-outline-secondary' },
            { extend:'excel', text:'Excel', className:'btn btn-sm btn-outline-success' },
            { extend:'print', text:'Print', className:'btn btn-sm btn-outline-info' },
        ],
    });

    // ── Auto Slug ──────────────────────────────────────
    $('#brandName').on('input', function() {
        $('#brandSlug').val(
            $(this).val().toLowerCase().trim()
                .replace(/ /g,'-').replace(/[^\w-]+/g,'')
        );
    });

    // ── Image Preview + 2MB ────────────────────────────
    function imgPreview(inputId, previewId) {
        $('#'+inputId).on('change', function() {
            var file = this.files[0];
            if (!file) return;
            if (file.size > 2*1024*1024) {
                Swal.fire({
                    icon:'error', title:'2MB se badi!',
                    text:'Max 2MB allowed hai.',
                    confirmButtonColor:'#E91E8C'
                });
                $(this).val(''); return;
            }
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#'+previewId).attr('src',e.target.result).show();
            };
            reader.readAsDataURL(file);
        });
    }
    imgPreview('addLogoInput', 'addLogoPreview');
    imgPreview('editLogoInput', 'editLogoPreview');

    // ── ADD BRAND ──────────────────────────────────────
    $('#addBrandForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("admin.brands.store") }}',
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(res) {
                $('#addBrandModal').modal('hide');
                $('#addBrandForm')[0].reset();
                $('#addLogoPreview').hide();
                table.ajax.reload();
                Swal.fire({
                    icon:'success', title:'Done!', text:res.message,
                    timer:2000, showConfirmButton:false
                });
            },
            error: function(xhr) {
                var msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                Swal.fire({ icon:'error', title:'Error', text:msg, confirmButtonColor:'#E91E8C' });
            }
        });
    });

    // ── EDIT BUTTON ────────────────────────────────────
    $(document).on('click', '.edit-brand-btn', function() {
        var btn = $(this);
        $('#editBrandId').val(btn.data('id'));
        $('#editBrandName').val(btn.data('name'));
        $('#editBrandSlug').val(btn.data('slug'));
        $('#editBrandDesc').val(btn.data('description'));
        $('#editBrandUrl').val(btn.data('website_url'));
        $('#editBrandSort').val(btn.data('sort_order'));
        $('#editBrandFeatured').prop('checked', btn.data('is_featured') == 1);
        $('#editBrandStatus').prop('checked', btn.data('status') == 1);
        $('#editLogoInput').val('');
        $('#editLogoPreview').hide();

        var logo = btn.data('logo');
        if (logo) {
            $('#editCurrentLogo').html(`
                <div class="current-logo-box">
                    <img src="/uploads/brands/${logo}" class="current-logo" alt="logo">
                    <div>
                        <div class="small fw-semibold text-dark mb-1">${logo}</div>
                        <button type="button" class="btn btn-danger btn-sm"
                                id="removeLogoBtn" data-id="${btn.data('id')}">
                            <i class="bi bi-trash me-1"></i>Logo Delete Karo
                        </button>
                    </div>
                </div>
            `);
        } else {
            $('#editCurrentLogo').html(
                '<p class="text-muted small"><i class="bi bi-image me-1"></i>Koi logo nahi hai</p>'
            );
        }
        $('#editBrandModal').modal('show');
    });

    // ── REMOVE LOGO ────────────────────────────────────
    $(document).on('click', '#removeLogoBtn', function() {
        var id = $(this).data('id');
        var box = $(this).closest('.current-logo-box').parent();

        Swal.fire({
            icon:'warning', title:'Delete logo?',
            text:'The logo will also be deleted from the folder!',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Haan, Delete!',
            cancelButtonText: 'Cancel'
        }).then(function(r) {
            if (r.isConfirmed) {
                $.ajax({
                    url: '/admin/brands/'+id+'/remove-logo',
                    type: 'DELETE',
                    success: function(res) {
                        box.html('<p class="text-muted small">The logo has been deleted</p>');
                        table.ajax.reload();
                        Swal.fire({
                            icon:'success', title:'Deleted!', text:res.message,
                            timer:1500, showConfirmButton:false
                        });
                    }
                });
            }
        });
    });

    // ── EDIT SUBMIT ────────────────────────────────────
    $('#editBrandForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#editBrandId').val();
        $.ajax({
            url: '/admin/brands/'+id,
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(res) {
                $('#editBrandModal').modal('hide');
                table.ajax.reload();
                Swal.fire({
                    icon:'success', title:'Updated!', text:res.message,
                    timer:2000, showConfirmButton:false
                });
            },
            error: function(xhr) {
                var msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                Swal.fire({ icon:'error', title:'Error', text:msg, confirmButtonColor:'#E91E8C' });
            }
        });
    });

    // ── DELETE ─────────────────────────────────────────
    var deleteId = null;
    $(document).on('click', '.delete-brand-btn', function() {
        deleteId = $(this).data('id');
        $('#deleteBrandName').text($(this).data('name'));
        $('#deleteBrandModal').modal('show');
    });
    $('#confirmBrandDelete').on('click', function() {
        $.ajax({
            url: '/admin/brands/'+deleteId,
            type: 'DELETE',
            success: function(res) {
                $('#deleteBrandModal').modal('hide');
                table.ajax.reload();
                Swal.fire({
                    icon:'success', title:'Deleted!', text:res.message,
                    timer:2000, showConfirmButton:false
                });
            }
        });
    });

    // ── STATUS TOGGLE ──────────────────────────────────
    $(document).on('change', '.brand-status-toggle', function() {
        var id = $(this).data('id'), el = $(this);
        $.post('{{ route("admin.brands.toggle") }}', { id:id }, function(res) {
            Swal.fire({
                icon:'success',
                title: res.status ? 'Active!' : 'Inactive!',
                timer:1200, showConfirmButton:false
            });
        }).fail(function() {
            el.prop('checked', !el.prop('checked'));
        });
    });

});
</script>
@endpush