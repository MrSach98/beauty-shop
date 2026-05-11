<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Brand::orderBy('sort_order')->orderBy('name')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('logo_col', function ($row) {
                    if ($row->logo && File::exists(public_path('uploads/brands/'.$row->logo))) {
                        return '<img src="'.asset('uploads/brands/'.$row->logo).'"
                                    width="60" height="60"
                                    style="border-radius:8px;object-fit:contain;border:1px solid #eee;padding:4px;">';
                    }
                    return '<div style="width:60px;height:60px;background:#FCE4EC;border-radius:8px;
                                display:flex;align-items:center;justify-content:center;font-size:22px;">🏷️</div>';
                })
                ->addColumn('featured_col', function ($row) {
                    return $row->is_featured
                        ? '<span class="badge bg-warning text-dark">⭐ Featured</span>'
                        : '<span class="badge bg-secondary">Normal</span>';
                })
                ->addColumn('products_count', function ($row) {
                    $count = \App\Models\Product::where('brand', $row->name)->count();
                    return '<span class="badge bg-info">'.$count.' Products</span>';
                })
                ->addColumn('status_col', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<div class="form-check form-switch">
                        <input class="form-check-input brand-status-toggle"
                               type="checkbox" data-id="'.$row->id.'" '.$checked.'>
                    </div>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-warning edit-brand-btn me-1"
                            data-id="'.$row->id.'"
                            data-name="'.$row->name.'"
                            data-slug="'.$row->slug.'"
                            data-description="'.e($row->description).'"
                            data-website_url="'.$row->website_url.'"
                            data-is_featured="'.($row->is_featured ? 1 : 0).'"
                            data-status="'.($row->status ? 1 : 0).'"
                            data-sort_order="'.$row->sort_order.'"
                            data-logo="'.$row->logo.'">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-brand-btn"
                            data-id="'.$row->id.'"
                            data-name="'.$row->name.'">
                            <i class="bi bi-trash"></i>
                        </button>';
                })
                ->rawColumns(['logo_col','featured_col','products_count','status_col','action'])
                ->make(true);
        }

        return view('admin.brands.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'slug'        => 'nullable|string|unique:brands,slug',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'description' => 'nullable|string',
            'website_url' => 'nullable|url',
            'sort_order'  => 'nullable|integer',
        ], [
            'name.required' => 'Brand naam daalna zaroori hai',
            'logo.image'    => 'Logo ek image file honi chahiye',
            'logo.max'      => 'Logo max 2MB ka hona chahiye',
            'website_url.url' => 'Valid URL daalo (https://...)',
        ]);

        $logoName = null;
        if ($request->hasFile('logo')) {
            $logoName = $this->uploadImage($request->file('logo'), 'brands');
        }

        Brand::create([
            'name'        => $request->name,
            'slug'        => $request->slug
                             ? Str::slug($request->slug)
                             : Str::slug($request->name),
            'logo'        => $logoName,
            'description' => $request->description,
            'website_url' => $request->website_url,
            'is_featured' => $request->boolean('is_featured'),
            'status'      => $request->boolean('status'),
            'sort_order'  => $request->sort_order ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => $request->name.' brand add ho gaya!'
        ]);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:100',
            'slug'        => 'nullable|string|unique:brands,slug,'.$id,
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'description' => 'nullable|string',
            'website_url' => 'nullable|url',
            'sort_order'  => 'nullable|integer',
        ]);

        $logoName = $brand->logo;
        if ($request->hasFile('logo')) {
            $this->deleteFile('brands', $brand->logo);
            $logoName = $this->uploadImage($request->file('logo'), 'brands');
        }

        $brand->update([
            'name'        => $request->name,
            'slug'        => $request->slug
                             ? Str::slug($request->slug)
                             : Str::slug($request->name),
            'logo'        => $logoName,
            'description' => $request->description,
            'website_url' => $request->website_url,
            'is_featured' => $request->boolean('is_featured'),
            'status'      => $request->boolean('status'),
            'sort_order'  => $request->sort_order ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => $brand->name.' update ho gaya!'
        ]);
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $this->deleteFile('brands', $brand->logo);
        $name = $brand->name;
        $brand->delete();

        return response()->json([
            'success' => true,
            'message' => $name.' delete ho gaya!'
        ]);
    }

    public function removeLogo(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $this->deleteFile('brands', $brand->logo);
        $brand->update(['logo' => null]);

        return response()->json([
            'success' => true,
            'message' => 'Logo delete ho gaya!'
        ]);
    }

    public function toggleStatus(Request $request)
    {
        $brand = Brand::findOrFail($request->id);
        $brand->status = !$brand->status;
        $brand->save();

        return response()->json([
            'success' => true,
            'status'  => $brand->status
        ]);
    }

    private function uploadImage($file, $folder)
    {
        $dir = public_path('uploads/'.$folder);
        if (!File::exists($dir)) File::makeDirectory($dir, 0755, true);
        $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move($dir, $name);
        return $name;
    }

    private function deleteFile($folder, $file)
    {
        if ($file) {
            $path = public_path('uploads/'.$folder.'/'.$file);
            if (File::exists($path)) File::delete($path);
        }
    }
}