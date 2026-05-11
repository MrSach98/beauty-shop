<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Subcategory::with('category')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category_name', fn($row) => $row->category->name ?? '-')
                ->addColumn('image', function ($row) {
                    if ($row->image && File::exists(public_path('uploads/subcategories/' . $row->image))) {
                        $url = asset('uploads/subcategories/' . $row->image);
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
                               data-id="' . $row->id . '" data-type="subcategory" ' . $checked . '>
                    </div>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-warning edit-sub-btn me-1"
                            data-id="' . $row->id . '"
                            data-category_id="' . $row->category_id . '"
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
                            data-type="subcategory">
                            <i class="bi bi-trash"></i>
                        </button>';
                })
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        $categories = Category::where('status', true)->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:100',
            'slug'        => 'nullable|string|unique:subcategories,slug',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = $this->uploadImage($request->file('image'), 'subcategories');
        }

        Subcategory::create([
            'category_id'      => $request->category_id,
            'name'             => $request->name,
            'slug'             => $request->slug
                                    ? Str::slug($request->slug)
                                    : Str::slug($request->name),
            'image'            => $imageName,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status'           => $request->has('status') ? true : false,
        ]);

        return response()->json(['success' => true, 'message' => 'Subcategory added Successfully!']);
    }

    public function update(Request $request, $id)
    {
        $sub = Subcategory::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:100',
            'slug'        => 'nullable|string|unique:subcategories,slug,' . $id,
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $imageName = $sub->image;
        if ($request->hasFile('image')) {
            $this->deleteImage('subcategories', $sub->image);
            $imageName = $this->uploadImage($request->file('image'), 'subcategories');
        }

        $sub->update([
            'category_id'      => $request->category_id,
            'name'             => $request->name,
            'slug'             => $request->slug
                                    ? Str::slug($request->slug)
                                    : Str::slug($request->name),
            'image'            => $imageName,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status'           => $request->has('status') ? true : false,
        ]);

        return response()->json(['success' => true, 'message' => 'Subcategory updated Successfully!']);
    }

    public function destroy($id)
    {
        $sub = Subcategory::findOrFail($id);
        $this->deleteImage('subcategories', $sub->image);
        foreach ($sub->childSubcategories as $child) {
            $this->deleteImage('child-subcategories', $child->image);
        }
        $sub->delete();
        return response()->json(['success' => true, 'message' => 'Subcategory Deleted Successfully!']);
    }

    public function toggleStatus(Request $request)
    {
        $sub = Subcategory::findOrFail($request->id);
        $sub->status = !$sub->status;
        $sub->save();
        return response()->json(['success' => true, 'status' => $sub->status]);
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
    $sub = Subcategory::findOrFail($id);
    if ($sub->image) {
        $this->deleteImage('subcategories', $sub->image);
        $sub->update(['image' => null]);
    }
    return response()->json(['success' => true, 'message' => 'Image Deleted Successfully']);
}
}