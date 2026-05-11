<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ChildSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class ChildSubcategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ChildSubcategory::with(['category', 'subcategory'])->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category_name', fn($row) => $row->category->name ?? '-')
                ->addColumn('subcategory_name', fn($row) => $row->subcategory->name ?? '-')
                ->addColumn('image', function ($row) {
                    if ($row->image && File::exists(public_path('uploads/child-subcategories/' . $row->image))) {
                        $url = asset('uploads/child-subcategories/' . $row->image);
                        return '<img src="' . $url . '" width="50" height="50"
                                style="border-radius:8px;object-fit:cover;" />';
                    }
                    return '<div style="width:50px;height:50px;background:#FCE4EC;
                            border-radius:8px;display:flex;align-items:center;
                            justify-content:center;font-size:20px;">💄</div>';
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<div class="form-check form-switch">
                        <input class="form-check-input status-toggle" type="checkbox"
                               data-id="' . $row->id . '" data-type="child" ' . $checked . '>
                    </div>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-warning edit-child-btn me-1"
                            data-id="' . $row->id . '"
                            data-category_id="' . $row->category_id . '"
                            data-subcategory_id="' . $row->subcategory_id . '"
                            data-name="' . $row->name . '"
                            data-slug="' . $row->slug . '"
                            data-meta_title="' . $row->meta_title . '"
                            data-meta_description="' . $row->meta_description . '"
                            data-image="' . $row->image . '"
                            data-status="' . $row->status . '">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-btn"
                            data-id="' . $row->id . '"
                            data-name="' . $row->name . '"
                            data-type="child">
                            <i class="bi bi-trash"></i>
                        </button>';
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        $categories = Category::where('status', true)->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function getSubcategories(Request $request)
    {
        $subs = Subcategory::where('category_id', $request->category_id)
                           ->where('status', true)
                           ->get(['id', 'name']);
        return response()->json($subs);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'name'           => 'required|string|max:100',
            'slug'           => 'nullable|string|unique:child_subcategories,slug',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = $this->uploadImage($request->file('image'), 'child-subcategories');
        }

        ChildSubcategory::create([
            'category_id'      => $request->category_id,
            'subcategory_id'   => $request->subcategory_id,
            'name'             => $request->name,
            'slug'             => $request->slug
                                    ? Str::slug($request->slug)
                                    : Str::slug($request->name),
            'image'            => $imageName,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status'           => $request->has('status') ? true : false,
        ]);

        return response()->json(['success' => true, 'message' => 'Child Subcategory added Successfully!']);
    }

    public function update(Request $request, $id)
    {
        $child = ChildSubcategory::findOrFail($id);

        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'name'           => 'required|string|max:100',
            'slug'           => 'nullable|string|unique:child_subcategories,slug,' . $id,
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $imageName = $child->image;
        if ($request->hasFile('image')) {
            $this->deleteImage('child-subcategories', $child->image);
            $imageName = $this->uploadImage($request->file('image'), 'child-subcategories');
        }

        $child->update([
            'category_id'      => $request->category_id,
            'subcategory_id'   => $request->subcategory_id,
            'name'             => $request->name,
            'slug'             => $request->slug
                                    ? Str::slug($request->slug)
                                    : Str::slug($request->name),
            'image'            => $imageName,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status'           => $request->has('status') ? true : false,
        ]);

        return response()->json(['success' => true, 'message' => 'Child Subcategory updated Successfully!']);
    }

    public function destroy($id)
    {
        $child = ChildSubcategory::findOrFail($id);
        $this->deleteImage('child-subcategories', $child->image);
        $child->delete();
        return response()->json(['success' => true, 'message' => 'Child Subcategory deleted Successfully!']);
    }

    public function toggleStatus(Request $request)
    {
        $child = ChildSubcategory::findOrFail($request->id);
        $child->status = !$child->status;
        $child->save();
        return response()->json(['success' => true, 'status' => $child->status]);
    }

    private function uploadImage($file, $folder)
    {
        $dir = public_path('uploads/' . $folder);
        if (!File::exists($dir)) File::makeDirectory($dir, 0755, true);
        $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $imageName);
        return $imageName;
    }

    private function deleteImage($folder, $image)
    {
        if ($image) {
            $path = public_path('uploads/' . $folder . '/' . $image);
            if (File::exists($path)) File::delete($path);
        }
    }
    public function removeImage(Request $request, $id)
{
    $child = ChildSubcategory::findOrFail($id);
    if ($child->image) {
        $this->deleteImage('child-subcategories', $child->image);
        $child->update(['image' => null]);
    }
    return response()->json(['success' => true, 'message' => 'Image deleted Successfully!']);
}
}