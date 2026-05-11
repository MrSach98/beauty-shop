@extends('admin.layouts.app')

@section('title', 'Category Management')
@section('page-title', 'Category Management')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<style>
    .nav-tabs .nav-link { color: #555; font-weight: 600; border: none; padding: 10px 20px; }
    .nav-tabs .nav-link.active { color: #E91E8C; border-bottom: 3px solid #E91E8C; background: transparent; }
    .tab-count { background: #E91E8C; color: #fff; border-radius: 20px; padding: 1px 8px; font-size: 11px; margin-left: 6px; }
    .btn-pink { background: #E91E8C !important; color: #fff !important; border: none; }
    .btn-pink:hover { background: #C2185B !important; }
    .img-preview { width: 80px; height: 80px; border-radius: 10px; object-fit: cover; display: none; border: 2px dashed #E91E8C; margin-top: 8px; }
    .dataTables_length { margin-bottom: 0; }
    .dt-buttons { margin-left: 10px; }
    .dt-buttons .btn { font-size: 12px; padding: 4px 10px; margin-right: 4px; border-radius: 6px; }
    table.dataTable thead th { background: #f8f9fa; font-weight: 700; font-size: 13px; color: #333; }
    .current-img-box { display: flex; align-items: center; gap: 12px; padding: 10px; background: #fff8fb; border: 1px solid #f9c4dc; border-radius: 10px; margin-bottom: 8px; }
    .current-img-box img { border-radius: 8px; object-fit: cover; border: 2px solid #E91E8C; }
</style>
@endpush

@section('content')

{{-- Tabs --}}
<ul class="nav nav-tabs mb-4 border-bottom bg-white px-3 rounded-top shadow-sm" id="catTabs">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#tab-category">
            <i class="bi bi-grid me-1"></i>Categories
            <span class="tab-count" id="cat-count">0</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#tab-subcategory">
            <i class="bi bi-diagram-2 me-1"></i>Subcategories
            <span class="tab-count" id="sub-count">0</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#tab-child">
            <i class="bi bi-diagram-3 me-1"></i>Child Subcategories
            <span class="tab-count" id="child-count">0</span>
        </a>
    </li>
</ul>

<div class="tab-content">

    {{-- ════════════════════════════════
         TAB 1 — CATEGORIES
    ════════════════════════════════ --}}
    <div class="tab-pane fade show active" id="tab-category">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-grid me-2 text-pink" style="color:#E91E8C;"></i>All Categories</h6>
                <button class="btn btn-pink btn-sm" data-bs-toggle="modal" data-bs-target="#addCatModal">
                    <i class="bi bi-plus-lg me-1"></i>Add Category
                </button>
            </div>
            <div class="card-body">
                <table id="categoryTable" class="table table-bordered table-hover w-100 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th width="80">Image</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th width="100">Status</th>
                            <th width="130">Created</th>
                            <th width="110">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════
         TAB 2 — SUBCATEGORIES
    ════════════════════════════════ --}}
    <div class="tab-pane fade" id="tab-subcategory">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-diagram-2 me-2" style="color:#E91E8C;"></i>All Subcategories</h6>
                <button class="btn btn-pink btn-sm" data-bs-toggle="modal" data-bs-target="#addSubModal">
                    <i class="bi bi-plus-lg me-1"></i>Add Subcategory
                </button>
            </div>
            <div class="card-body">
                <table id="subcategoryTable" class="table table-bordered table-hover w-100 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th width="80">Image</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th width="100">Status</th>
                            <th width="110">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════
         TAB 3 — CHILD SUBCATEGORIES
    ════════════════════════════════ --}}
    <div class="tab-pane fade" id="tab-child">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-diagram-3 me-2" style="color:#E91E8C;"></i>All Child Subcategories</h6>
                <button class="btn btn-pink btn-sm" data-bs-toggle="modal" data-bs-target="#addChildModal">
                    <i class="bi bi-plus-lg me-1"></i>Add Child Subcategory
                </button>
            </div>
            <div class="card-body">
                <table id="childTable" class="table table-bordered table-hover w-100 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th width="80">Image</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th width="100">Status</th>
                            <th width="110">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</div>{{-- end tab-content --}}


{{-- ════════════════════════════════════════════════════════
     MODALS
════════════════════════════════════════════════════════ --}}

{{-- ── ADD CATEGORY ─────────────────────────────────────── --}}
<div class="modal fade" id="addCatModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow">
      <div class="modal-header" style="background:#E91E8C;">
        <h5 class="modal-title text-white fw-bold">
            <i class="bi bi-plus-circle me-2"></i>Add Category
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="addCatForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
              <input type="text" name="name" id="catName" class="form-control"
                     placeholder="e.g. Skincare" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Slug
                <small class="text-muted fw-normal">(auto generate hoga)</small>
              </label>
              <input type="text" name="slug" id="catSlug" class="form-control"
                     placeholder="e.g. skincare">
            </div>
            <div class="col-md-12">
              <label class="form-label fw-semibold">Image
                <small class="text-muted fw-normal">(Max 2MB — JPG, PNG, WEBP)</small>
              </label>
              <input type="file" name="image" id="catImage"
                     class="form-control" accept="image/*">
              <img id="catImgPreview" class="img-preview" alt="Preview">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Meta Title</label>
              <input type="text" name="meta_title" class="form-control"
                     placeholder="SEO ke liye title">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Meta Description</label>
              <input type="text" name="meta_description" class="form-control"
                     placeholder="SEO ke liye description">
            </div>
            <div class="col-md-12">
              <div class="form-check form-switch">
                <input type="checkbox" name="status" class="form-check-input"
                       id="catStatus" checked>
                <label class="form-check-label fw-semibold" for="catStatus">Active</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-pink">
            <i class="bi bi-check-lg me-1"></i>Save Category
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ── EDIT CATEGORY ────────────────────────────────────── --}}
<div class="modal fade" id="editCatModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow">
      <div class="modal-header" style="background:#C2185B;">
        <h5 class="modal-title text-white fw-bold">
            <i class="bi bi-pencil-square me-2"></i>Edit Category
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="editCatForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="editCatId">
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
              <input type="text" name="name" id="editCatName" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Slug</label>
              <input type="text" name="slug" id="editCatSlug" class="form-control">
            </div>
            <div class="col-md-12">
              <label class="form-label fw-semibold">Current Image</label>
              <div id="editCatCurrentImg"></div>
            </div>
            <div class="col-md-12">
              <label class="form-label fw-semibold">new Image Uploaded
                <small class="text-muted fw-normal">(Max 2MB)</small>
              </label>
              <input type="file" name="image" id="editCatImage"
                     class="form-control" accept="image/*">
              <img id="editCatImgPreview" class="img-preview" alt="Preview">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Meta Title</label>
              <input type="text" name="meta_title" id="editCatMetaTitle" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Meta Description</label>
              <input type="text" name="meta_description" id="editCatMetaDesc" class="form-control">
            </div>
            <div class="col-md-12">
              <div class="form-check form-switch">
                <input type="checkbox" name="status" class="form-check-input" id="editCatStatus">
                <label class="form-check-label fw-semibold" for="editCatStatus" id="editCatStatusLabel">Active</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-pink">
            <i class="bi bi-check-lg me-1"></i>Update Category
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ── ADD SUBCATEGORY ──────────────────────────────────── --}}
<div class="modal fade" id="addSubModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow">
      <div class="modal-header" style="background:#E91E8C;">
        <h5 class="modal-title text-white fw-bold">
            <i class="bi bi-plus-circle me-2"></i>Add Subcategory
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="addSubForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-12">
              <label class="form-label fw-semibold">Parent Category <span class="text-danger">*</span></label>
              <select name="category_id" class="form-select" required>
                <option value="">-- Category Select Karo --</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Subcategory Name <span class="text-danger">*</span></label>
              <input type="text" name="name" id="subName" class="form-control"
                     placeholder="e.g. Face Wash" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Slug</label>
              <input type="text" name="slug" id="subSlug" class="form-control"
                     placeholder="auto generate hoga">
            </div>
            <div class="col-md-12">
              <label class="form-label fw-semibold">Image
                <small class="text-muted fw-normal">(Max 2MB)</small>
              </label>
              <input type="file" name="image" id="subImage"
                     class="form-control" accept="image/*">
              <img id="subImgPreview" class="img-preview" alt="Preview">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Meta Title</label>
              <input type="text" name="meta_title" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Meta Description</label>
              <input type="text" name="meta_description" class="form-control">
            </div>
            <div class="col-md-12">
              <div class="form-check form-switch">
                <input type="checkbox" name="status" class="form-check-input" checked>
                <label class="form-check-label fw-semibold">Active</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-pink">
            <i class="bi bi-check-lg me-1"></i>Save Subcategory
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ── EDIT SUBCATEGORY ─────────────────────────────────── --}}
<div class="modal fade" id="editSubModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow">
      <div class="modal-header" style="background:#C2185B;">
        <h5 class="modal-title text-white fw-bold">
            <i class="bi bi-pencil-square me-2"></i>Edit Subcategory
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="editSubForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="editSubId">
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-12">
              <label class="form-label fw-semibold">Parent Category <span class="text-danger">*</span></label>
              <select name="category_id" id="editSubCatId" class="form-select" required>
                <option value="">-- Category Select Karo --</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
              <input type="text" name="name" id="editSubName" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Slug</label>
              <input type="text" name="slug" id="editSubSlug" class="form-control">
            </div>
            <div class="col-md-12">
              <label class="form-label fw-semibold">Current Image</label>
              <div id="editSubCurrentImg"></div>
            </div>
            <div class="col-md-12">
              <label class="form-label fw-semibold">New Image Upload
                <small class="text-muted fw-normal">(Max 2MB)</small>
              </label>
              <input type="file" name="image" id="editSubImage"
                     class="form-control" accept="image/*">
              <img id="editSubImgPreview" class="img-preview" alt="Preview">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Meta Title</label>
              <input type="text" name="meta_title" id="editSubMetaTitle" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Meta Description</label>
              <input type="text" name="meta_description" id="editSubMetaDesc" class="form-control">
            </div>
            <div class="col-md-12">
              <div class="form-check form-switch">
                <input type="checkbox" name="status" class="form-check-input" id="editSubStatus">
                <label class="form-check-label fw-semibold" for="editSubStatus" id="editSubStatusLabel">Active</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-pink">
            <i class="bi bi-check-lg me-1"></i>Update Subcategory
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ── ADD CHILD SUBCATEGORY ────────────────────────────── --}}
<div class="modal fade" id="addChildModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow">
      <div class="modal-header" style="background:#E91E8C;">
        <h5 class="modal-title text-white fw-bold">
            <i class="bi bi-plus-circle me-2"></i>Add Child Subcategory
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="addChildForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
              <select name="category_id" id="childCatSelect" class="form-select" required>
                <option value="">-- Category Select Karo --</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Subcategory <span class="text-danger">*</span></label>
              <select name="subcategory_id" id="childSubSelect" class="form-select" required>
                <option value="">-- Pehle Category choose karo --</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Child Name <span class="text-danger">*</span></label>
              <input type="text" name="name" id="childName" class="form-control"
                     placeholder="e.g. Vitamin C Serum" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Slug</label>
              <input type="text" name="slug" id="childSlug" class="form-control"
                     placeholder="auto generate hoga">
            </div>
            <div class="col-md-12">
              <label class="form-label fw-semibold">Image
                <small class="text-muted fw-normal">(Max 2MB)</small>
              </label>
              <input type="file" name="image" id="childImage"
                     class="form-control" accept="image/*">
              <img id="childImgPreview" class="img-preview" alt="Preview">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Meta Title</label>
              <input type="text" name="meta_title" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Meta Description</label>
              <input type="text" name="meta_description" class="form-control">
            </div>
            <div class="col-md-12">
              <div class="form-check form-switch">
                <input type="checkbox" name="status" class="form-check-input" checked>
                <label class="form-check-label fw-semibold">Active</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-pink">
            <i class="bi bi-check-lg me-1"></i>Save Child Subcategory
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ── EDIT CHILD SUBCATEGORY ───────────────────────────── --}}
<div class="modal fade" id="editChildModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow">
      <div class="modal-header" style="background:#C2185B;">
        <h5 class="modal-title text-white fw-bold">
            <i class="bi bi-pencil-square me-2"></i>Edit Child Subcategory
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="editChildForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="editChildId">
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
              <select name="category_id" id="editChildCatId" class="form-select" required>
                <option value="">-- Category --</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Subcategory <span class="text-danger">*</span></label>
              <select name="subcategory_id" id="editChildSubId" class="form-select" required>
                <option value="">-- Subcategory --</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
              <input type="text" name="name" id="editChildName" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Slug</label>
              <input type="text" name="slug" id="editChildSlug" class="form-control">
            </div>
            <div class="col-md-12">
              <label class="form-label fw-semibold">Current Image</label>
              <div id="editChildCurrentImg"></div>
            </div>
            <div class="col-md-12">
              <label class="form-label fw-semibold">New Image Upload
                <small class="text-muted fw-normal">(Max 2MB)</small>
              </label>
              <input type="file" name="image" id="editChildImage"
                     class="form-control" accept="image/*">
              <img id="editChildImgPreview" class="img-preview" alt="Preview">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Meta Title</label>
              <input type="text" name="meta_title" id="editChildMetaTitle" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Meta Description</label>
              <input type="text" name="meta_description" id="editChildMetaDesc" class="form-control">
            </div>
            <div class="col-md-12">
              <div class="form-check form-switch">
                <input type="checkbox" name="status" class="form-check-input" id="editChildStatus">
                <label class="form-check-label fw-semibold" for="editChildStatus" id="editChildStatusLabel">Active</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-pink">
            <i class="bi bi-check-lg me-1"></i>Update Child Subcategory
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ── DELETE CONFIRM ───────────────────────────────────── --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title fw-bold">
            <i class="bi bi-exclamation-triangle me-2"></i>Delete Confirm
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center py-4">
        <div style="font-size:44px;">🗑️</div>
        <p class="mt-3 mb-1">Are you sure Deleted?</p>
        <p class="fw-bold text-dark" id="deleteItemName"></p>
        <p class="text-danger small">Your action is undo !</p>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmDeleteBtn">
            <i class="bi bi-trash me-1"></i>Deleted
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
$(document).ready(function () {

    // ── CSRF ─────────────────────────────────────────────────
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ════════════════════════════════════════════════════════
    // DATATABLE CONFIG — common options
    // ════════════════════════════════════════════════════════
    var dtButtons = [
        { extend: 'csv',   text: '<i class="bi bi-filetype-csv"></i> CSV',   className: 'btn btn-sm btn-outline-secondary' },
        { extend: 'excel', text: '<i class="bi bi-file-earmark-excel"></i> Excel', className: 'btn btn-sm btn-outline-success' },
        { extend: 'print', text: '<i class="bi bi-printer"></i> Print',      className: 'btn btn-sm btn-outline-info' },
    ];

    var dtDom     = '<"d-flex justify-content-between align-items-center mb-3"lB>frt<"d-flex justify-content-between align-items-center mt-3"ip>';
    var dtLength  = [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Sab']];

    // ── Category Table ────────────────────────────────────
    var catTable = $('#categoryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.categories.index") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, width: '50px' },
            { data: 'image',       name: 'image',        orderable: false, searchable: false, width: '80px' },
            { data: 'name',        name: 'name' },
            { data: 'slug',        name: 'slug' },
            { data: 'status',      name: 'status',       orderable: false, searchable: false, width: '100px' },
            { data: 'created_at',  name: 'created_at',   width: '130px' },
            { data: 'action',      name: 'action',       orderable: false, searchable: false, width: '110px' },
        ],
        dom: dtDom,
        lengthMenu: dtLength,
        pageLength: 10,
        buttons: dtButtons,
        drawCallback: function(s) { $('#cat-count').text(s.json.recordsTotal ?? 0); }
    });

    // ── Subcategory Table ─────────────────────────────────
    var subTable = $('#subcategoryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.subcategories.index") }}',
        columns: [
            { data: 'DT_RowIndex',   name: 'DT_RowIndex',   orderable: false, searchable: false, width: '50px' },
            { data: 'image',         name: 'image',          orderable: false, searchable: false, width: '80px' },
            { data: 'category_name', name: 'category_name',  searchable: false },
            { data: 'name',          name: 'name' },
            { data: 'slug',          name: 'slug' },
            { data: 'status',        name: 'status',         orderable: false, searchable: false, width: '100px' },
            { data: 'action',        name: 'action',         orderable: false, searchable: false, width: '110px' },
        ],
        dom: dtDom,
        lengthMenu: dtLength,
        pageLength: 10,
        buttons: dtButtons,
        drawCallback: function(s) { $('#sub-count').text(s.json.recordsTotal ?? 0); }
    });

    // ── Child Table ───────────────────────────────────────
    var childTable = $('#childTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.child.index") }}',
        columns: [
            { data: 'DT_RowIndex',      name: 'DT_RowIndex',      orderable: false, searchable: false, width: '50px' },
            { data: 'image',            name: 'image',             orderable: false, searchable: false, width: '80px' },
            { data: 'category_name',    name: 'category_name',     searchable: false },
            { data: 'subcategory_name', name: 'subcategory_name',  searchable: false },
            { data: 'name',             name: 'name' },
            { data: 'slug',             name: 'slug' },
            { data: 'status',           name: 'status',            orderable: false, searchable: false, width: '100px' },
            { data: 'action',           name: 'action',            orderable: false, searchable: false, width: '110px' },
        ],
        dom: dtDom,
        lengthMenu: dtLength,
        pageLength: 10,
        buttons: dtButtons,
        drawCallback: function(s) { $('#child-count').text(s.json.recordsTotal ?? 0); }
    });

    // ════════════════════════════════════════════════════════
    // IMAGE SIZE CHECK + PREVIEW — sabhi file inputs ke liye
    // ════════════════════════════════════════════════════════
    var previewMap = {
        'catImage':        'catImgPreview',
        'subImage':        'subImgPreview',
        'childImage':      'childImgPreview',
        'editCatImage':    'editCatImgPreview',
        'editSubImage':    'editSubImgPreview',
        'editChildImage':  'editChildImgPreview',
    };

    $(document).on('change', 'input[type="file"][accept="image/*"]', function () {
        var file = this.files[0];
        if (!file) return;

        // 2MB check
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'File is very big!',
                text: 'Maximum 2MB image uploaded.',
                confirmButtonColor: '#E91E8C'
            });
            $(this).val('');
            return;
        }

        // Preview
        var inputId    = $(this).attr('id');
        var previewId  = previewMap[inputId];
        if (previewId) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#' + previewId).attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        }
    });

    // ════════════════════════════════════════════════════════
    // AUTO SLUG
    // ════════════════════════════════════════════════════════
    function makeSlug(str) {
        return str.toLowerCase().trim()
                  .replace(/ /g, '-')
                  .replace(/[^\w-]+/g, '');
    }
    $('#catName').on('input',   function() { $('#catSlug').val(makeSlug($(this).val())); });
    $('#subName').on('input',   function() { $('#subSlug').val(makeSlug($(this).val())); });
    $('#childName').on('input', function() { $('#childSlug').val(makeSlug($(this).val())); });

    // ════════════════════════════════════════════════════════
    // CURRENT IMAGE DISPLAY HELPER
    // ════════════════════════════════════════════════════════
    function showCurrentImg(containerId, folder, id, type, image) {
        if (image && image !== 'null' && image !== '') {
            $('#' + containerId).html(`
                <div class="current-img-box">
                    <img src="/uploads/${folder}/${image}" width="65" height="65" alt="current">
                    <div>
                        <div class="small fw-semibold text-dark mb-1">${image}</div>
                        <button type="button"
                                class="btn btn-danger btn-sm remove-img-btn"
                                data-id="${id}"
                                data-type="${type}"
                                data-folder="${folder}"
                                data-image="${image}">
                            <i class="bi bi-trash me-1"></i>Image Deleted
                        </button>
                    </div>
                </div>
            `);
        } else {
            $('#' + containerId).html(
                '<p class="text-muted small mb-0"><i class="bi bi-image me-1"></i>Not Any Image</p>'
            );
        }
    }

    // ════════════════════════════════════════════════════════
    // ADD CATEGORY
    // ════════════════════════════════════════════════════════
    $('#addCatForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("admin.categories.store") }}',
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(res) {
                $('#addCatModal').modal('hide');
                $('#addCatForm')[0].reset();
                $('#catImgPreview').hide();
                catTable.ajax.reload();
                Swal.fire({ icon:'success', title:'Done!', text: res.message, timer:2000, showConfirmButton:false });
            },
            error: function(xhr) {
                var msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                Swal.fire({ icon:'error', title:'Validation Error', text: msg, confirmButtonColor:'#E91E8C' });
            }
        });
    });

    // ════════════════════════════════════════════════════════
    // EDIT CATEGORY
    // ════════════════════════════════════════════════════════
    $(document).on('click', '.edit-btn', function() {
        var btn = $(this);
        var status = btn.data('status');
        $('#editCatId').val(btn.data('id'));
        $('#editCatName').val(btn.data('name'));
        $('#editCatSlug').val(btn.data('slug'));
        $('#editCatMetaTitle').val(btn.data('meta_title'));
        $('#editCatMetaDesc').val(btn.data('meta_description'));
        $('#editCatStatus').prop('checked', status == 1);
    // ✅ Label update
    $('#editCatStatusLabel').text(status == 1 ? 'Active' : 'Inactive');
        $('#editCatImgPreview').hide();
        $('#editCatImage').val('');
        showCurrentImg('editCatCurrentImg', 'categories', btn.data('id'), 'category', btn.data('image'));
        $('#editCatModal').modal('show');
    });

    $('#editCatForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#editCatId').val();
        $.ajax({
            url: '/admin/categories/' + id,
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(res) {
                $('#editCatModal').modal('hide');
                catTable.ajax.reload();
                Swal.fire({ icon:'success', title:'Updated!', text: res.message, timer:2000, showConfirmButton:false });
            },
            error: function(xhr) {
                var msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                Swal.fire({ icon:'error', title:'Error', text: msg, confirmButtonColor:'#E91E8C' });
            }
        });
    });

    // ════════════════════════════════════════════════════════
    // ADD SUBCATEGORY
    // ════════════════════════════════════════════════════════
    $('#addSubForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("admin.subcategories.store") }}',
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(res) {
                $('#addSubModal').modal('hide');
                $('#addSubForm')[0].reset();
                $('#subImgPreview').hide();
                subTable.ajax.reload();
                Swal.fire({ icon:'success', title:'Done!', text: res.message, timer:2000, showConfirmButton:false });
            },
            error: function(xhr) {
                var msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                Swal.fire({ icon:'error', title:'Error', text: msg, confirmButtonColor:'#E91E8C' });
            }
        });
    });

    // ════════════════════════════════════════════════════════
    // EDIT SUBCATEGORY
    // ════════════════════════════════════════════════════════
    $(document).on('click', '.edit-sub-btn', function() {
        var btn = $(this);
        var status = btn.data('status');
        $('#editSubId').val(btn.data('id'));
        $('#editSubCatId').val(btn.data('category_id'));
        $('#editSubName').val(btn.data('name'));
        $('#editSubSlug').val(btn.data('slug'));
        $('#editSubMetaTitle').val(btn.data('meta_title'));
        $('#editSubMetaDesc').val(btn.data('meta_description'));
        $('#editSubStatus').prop('checked', status == 1);
        $('#editSubStatusLabel').text(status == 1 ? 'Active' : 'Inactive');
        $('#editSubImage').val('');
        $('#editSubImgPreview').hide();
        showCurrentImg('editSubCurrentImg', 'subcategories', btn.data('id'), 'subcategory', btn.data('image'));
        $('#editSubModal').modal('show');
    });

    $('#editSubForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#editSubId').val();
        $.ajax({
            url: '/admin/subcategories/' + id,
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(res) {
                $('#editSubModal').modal('hide');
                subTable.ajax.reload();
                Swal.fire({ icon:'success', title:'Updated!', text: res.message, timer:2000, showConfirmButton:false });
            },
            error: function(xhr) {
                var msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                Swal.fire({ icon:'error', title:'Error', text: msg, confirmButtonColor:'#E91E8C' });
            }
        });
    });

    // ════════════════════════════════════════════════════════
    // CHILD — Category change karo → Subcategories load karo
    // ════════════════════════════════════════════════════════
    function loadSubs(catId, targetSelect, selectedId) {
        $(targetSelect).html('<option value="">Loading...</option>');
        $.get('{{ route("admin.get.subcategories") }}', { category_id: catId }, function(data) {
            var opts = '<option value="">-- Select Subcategory  --</option>';
            $.each(data, function(i, sub) {
                var sel = (selectedId && selectedId == sub.id) ? 'selected' : '';
                opts += '<option value="' + sub.id + '" ' + sel + '>' + sub.name + '</option>';
            });
            $(targetSelect).html(opts);
        });
    }

    $('#childCatSelect').on('change', function() {
        if ($(this).val()) {
            loadSubs($(this).val(), '#childSubSelect', null);
        } else {
            $('#childSubSelect').html('<option value="">-- First Category choose  --</option>');
        }
    });

    $('#editChildCatId').on('change', function() {
        if ($(this).val()) loadSubs($(this).val(), '#editChildSubId', null);
    });

    // ════════════════════════════════════════════════════════
    // ADD CHILD
    // ════════════════════════════════════════════════════════
    $('#addChildForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("admin.child.store") }}',
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(res) {
                $('#addChildModal').modal('hide');
                $('#addChildForm')[0].reset();
                $('#childImgPreview').hide();
                childTable.ajax.reload();
                Swal.fire({ icon:'success', title:'Done!', text: res.message, timer:2000, showConfirmButton:false });
            },
            error: function(xhr) {
                var msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                Swal.fire({ icon:'error', title:'Error', text: msg, confirmButtonColor:'#E91E8C' });
            }
        });
    });

    // ════════════════════════════════════════════════════════
    // EDIT CHILD
    // ════════════════════════════════════════════════════════
    $(document).on('click', '.edit-child-btn', function() {
        var btn   = $(this);
        var catId = btn.data('category_id');
        var subId = btn.data('subcategory_id');
        var status = btn.data('status');

        $('#editChildId').val(btn.data('id'));
        $('#editChildCatId').val(catId);
        $('#editChildName').val(btn.data('name'));
        $('#editChildSlug').val(btn.data('slug'));
        $('#editChildMetaTitle').val(btn.data('meta_title'));
        $('#editChildMetaDesc').val(btn.data('meta_description'));
        $('#editChildStatus').prop('checked', status == 1);
        $('#editChildStatusLabel').text(status == 1 ? 'Active' : 'Inactive');
        $('#editChildImage').val('');
        $('#editChildImgPreview').hide();
        showCurrentImg('editChildCurrentImg', 'child-subcategories', btn.data('id'), 'child', btn.data('image'));
        loadSubs(catId, '#editChildSubId', subId);
        $('#editChildModal').modal('show');
    });

    $('#editChildForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#editChildId').val();
        $.ajax({
            url: '/admin/child-subcategories/' + id,
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(res) {
                $('#editChildModal').modal('hide');
                childTable.ajax.reload();
                Swal.fire({ icon:'success', title:'Updated!', text: res.message, timer:2000, showConfirmButton:false });
            },
            error: function(xhr) {
                var msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                Swal.fire({ icon:'error', title:'Error', text: msg, confirmButtonColor:'#E91E8C' });
            }
        });
    });

    // ════════════════════════════════════════════════════════
    // DELETE — Category / Subcategory / Child
    // ════════════════════════════════════════════════════════
    var deleteId   = null;
    var deleteType = null;

    $(document).on('click', '.delete-btn', function() {
        deleteId   = $(this).data('id');
        deleteType = $(this).data('type');
        $('#deleteItemName').text($(this).data('name'));
        $('#deleteModal').modal('show');
    });

    $('#confirmDeleteBtn').on('click', function() {
        var urls = {
            'category':    '/admin/categories/',
            'subcategory': '/admin/subcategories/',
            'child':       '/admin/child-subcategories/'
        };
        $.ajax({
            url: urls[deleteType] + deleteId,
            type: 'DELETE',
            success: function(res) {
                $('#deleteModal').modal('hide');
                if (deleteType === 'category')    catTable.ajax.reload();
                if (deleteType === 'subcategory') subTable.ajax.reload();
                if (deleteType === 'child')       childTable.ajax.reload();
                Swal.fire({ icon:'success', title:'Deleted!', text: res.message, timer:2000, showConfirmButton:false });
            },
            error: function() {
                Swal.fire({ icon:'error', title:'Error!', text:'Delete didn’t work, please try again.' });
            }
        });
    });

    // ════════════════════════════════════════════════════════
    // REMOVE CURRENT IMAGE (edit modal ke andar)
    // ════════════════════════════════════════════════════════
    var removeUrls = {
        'category':    '/admin/categories/remove-image/',
        'subcategory': '/admin/subcategories/remove-image/',
        'child':       '/admin/child-subcategories/remove-image/'
    };

    $(document).on('click', '.remove-img-btn', function() {
        var id     = $(this).data('id');
        var type   = $(this).data('type');
        var folder = $(this).data('folder');
        var image  = $(this).data('image');
        var box    = $(this).closest('.current-img-box').parent();

        Swal.fire({
            icon: 'warning',
            title: 'Image deleted?',
            text: 'This image will also be permanently deleted from the folder!',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Haan, Delete!',
            cancelButtonText: 'Cancel'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: removeUrls[type] + id,
                    type: 'DELETE',
                    success: function(res) {
                        box.html('<p class="text-muted small mb-0"><i class="bi bi-image me-1"></i>Image deleted Successfully</p>');
                        Swal.fire({ icon:'success', title:'Deleted!', text: res.message, timer:1500, showConfirmButton:false });
                    },
                    error: function() {
                        Swal.fire({ icon:'error', title:'Error!', text:'Image Not Deleted.' });
                    }
                });
            }
        });
    });

    // ════════════════════════════════════════════════════════
    // STATUS TOGGLE
    // ════════════════════════════════════════════════════════
    var toggleUrls = {
        'category':    '{{ route("admin.categories.toggle") }}',
        'subcategory': '{{ route("admin.subcategories.toggle") }}',
        'child':       '{{ route("admin.child.toggle") }}'
    };

    $(document).on('change', '.status-toggle', function() {
        var id   = $(this).data('id');
        var type = $(this).data('type');
        var el   = $(this);
        $.post(toggleUrls[type], { id: id }, function(res) {
            Swal.fire({
                icon: 'success',
                title: res.status ? 'Active!' : 'Inactive!',
                timer: 1200,
                showConfirmButton: false
            });
        }).fail(function() {
            el.prop('checked', !el.prop('checked'));
            Swal.fire({ icon:'error', title:'Status update Not Successfully!' });
        });
    });

});
</script>
@endpush