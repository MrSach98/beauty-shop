<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    // DataTable list
    public function index(Request $request)
{
    if ($request->ajax()) {
        $data = Category::latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                if ($row->image && File::exists(public_path('uploads/categories/' . $row->image))) {
                    $url = asset('uploads/categories/' . $row->image);
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
                           data-id="' . $row->id . '" data-type="category" ' . $checked . '>
                </div>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-sm btn-warning edit-btn me-1"
                        data-id="' . $row->id . '"
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
                        data-type="category">
                        <i class="bi bi-trash"></i>
                    </button>';
            })
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }

    // ✅ Yahan categories pass karo — ye line pehle missing thi
    $categories = Category::where('status', true)->get();
    return view('admin.categories.index', compact('categories'));
}

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'slug'  => 'nullable|string|unique:categories,slug',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = $this->uploadImage($request->file('image'), 'categories');
        }

        Category::create([
            'name'             => $request->name,
            'slug'             => $request->slug
                                    ? Str::slug($request->slug)
                                    : Str::slug($request->name),
            'image'            => $imageName,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status'           => $request->has('status') ? true : false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category successfully!'
        ]);
    }

    // Update
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:100',
            'slug'  => 'nullable|string|unique:categories,slug,' . $id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $imageName = $category->image;
        if ($request->hasFile('image')) {
            // Purani image delete karo
            $this->deleteImage('categories', $category->image);
            $imageName = $this->uploadImage($request->file('image'), 'categories');
        }

        $category->update([
            'name'             => $request->name,
            'slug'             => $request->slug
                                    ? Str::slug($request->slug)
                                    : Str::slug($request->name),
            'image'            => $imageName,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status'           => $request->has('status') ? true : false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category successfully.'
        ]);
    }

    // Delete
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Image folder se delete karo
        $this->deleteImage('categories', $category->image);

        // Subcategories ki images bhi delete karo
        foreach ($category->subcategories as $sub) {
            $this->deleteImage('subcategories', $sub->image);
            foreach ($sub->childSubcategories as $child) {
                $this->deleteImage('child-subcategories', $child->image);
            }
        }

        $category->delete(); // cascade se sub/child bhi delete honge

        return response()->json([
            'success' => true,
            'message' => 'Category and subcategories deleted'
        ]);
    }

    // Status Toggle
    public function toggleStatus(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->status = !$category->status;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Status update Successfully!',
            'status'  => $category->status
        ]);
    }

    // ── Private Helpers ─────────────────────────────────────
    private function uploadImage($file, $folder)
    {
        $dir = public_path('uploads/' . $folder);
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $imageName);
        return $imageName;
    }

    private function deleteImage($folder, $image)
    {
        if ($image) {
            $path = public_path('uploads/' . $folder . '/' . $image);
            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }
    // CategoryController mein rename karo
public function removeImage(Request $request, $id)  // ← rename
{
    $category = Category::findOrFail($id);
    if ($category->image) {
        $this->deleteImage('categories', $category->image); // private helper
        $category->update(['image' => null]);
    }
    return response()->json(['success' => true, 'message' => 'Image deleted Successfully!']);
}
}