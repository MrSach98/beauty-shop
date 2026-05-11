<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{
    // ── Index ────────────────────────────────────────────
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Banner::query();
            if ($request->type) {
                $query->where('type', $request->type);
            }

            return DataTables::of($query->latest())
                ->addIndexColumn()
                ->addColumn('image_col', function ($row) {
                    if (File::exists(public_path('uploads/banners/'.$row->image))) {
                        return '<img src="'.asset('uploads/banners/'.$row->image).'"
                                    style="width:110px;height:55px;object-fit:cover;
                                           border-radius:8px;border:1px solid #eee;">';
                    }
                    return '<div style="width:110px;height:55px;background:#f0f0f0;
                                border-radius:8px;display:flex;align-items:center;
                                justify-content:center;font-size:20px;">🖼️</div>';
                })
                ->addColumn('type_col', function ($row) {
                    $labels = Banner::typeLabels();
                    $colors = [
                        'hero_slider'     => 'primary',
                        'offer_banner'    => 'success',
                        'popup_banner'    => 'warning',
                        'category_banner' => 'info',
                    ];
                    $label = $labels[$row->type]  ?? $row->type;
                    $color = $colors[$row->type] ?? 'secondary';
                    return '<span class="badge bg-'.$color.'">'.$label.'</span>';
                })
                ->addColumn('position_col', function ($row) {
                    $labels = Banner::positionLabels();
                    return '<span class="badge bg-secondary">'
                           .($labels[$row->position] ?? $row->position).'</span>';
                })
                ->addColumn('validity_col', function ($row) {
                    $html = '';
                    if ($row->start_date) {
                        $html .= '<small class="text-muted d-block">From: '.
                                 $row->start_date->format('d M Y').'</small>';
                    }
                    if ($row->end_date) {
                        $cls  = $row->isExpired() ? 'text-danger' : 'text-success';
                        $html .= '<small class="'.$cls.' d-block">To: '.
                                 $row->end_date->format('d M Y').'</small>';
                        if ($row->isExpired()) {
                            $html .= '<span class="badge bg-danger">Expired</span>';
                        }
                    }
                    if (!$row->start_date && !$row->end_date) {
                        $html = '<span class="text-muted small">No limit</span>';
                    }
                    return $html;
                })
                ->addColumn('status_col', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<div class="form-check form-switch">
                        <input class="form-check-input banner-status-toggle"
                               type="checkbox" data-id="'.$row->id.'" '.$checked.'>
                    </div>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="'.route('admin.banners.edit', $row->id).'"
                           class="btn btn-sm btn-warning me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-sm btn-danger delete-banner-btn"
                            data-id="'.$row->id.'"
                            data-title="'.e($row->title ?? 'Banner').'">
                            <i class="bi bi-trash"></i>
                        </button>';
                })
                ->rawColumns(['image_col','type_col','position_col','validity_col','status_col','action'])
                ->make(true);
        }

        $typeLabels = Banner::typeLabels();
        return view('admin.banners.index', compact('typeLabels'));
    }

    // ── Create ───────────────────────────────────────────
    public function create()
    {
        $typeLabels     = Banner::typeLabels();
        $positionLabels = Banner::positionLabels();
        return view('admin.banners.create', compact('typeLabels', 'positionLabels'));
    }

    // ── Store ────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'image'        => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_mobile' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'type'         => 'required|in:hero_slider,offer_banner,popup_banner,category_banner',
            'position'     => 'required|in:homepage,category_page,checkout_page,all_pages',
            'link_url'     => 'nullable|url',
            'sort_order'   => 'nullable|integer|min:0',
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
        ], [
            'image.required'          => 'Banner image zaroori hai',
            'image.max'               => 'Image max 2MB honi chahiye',
            'type.required'           => 'Banner type select karo',
            'position.required'       => 'Position select karo',
            'link_url.url'            => 'Valid URL daalo (https://...)',
            'end_date.after_or_equal' => 'End date, start date ke baad honi chahiye',
        ]);

        $imageName = $this->uploadImage($request->file('image'), 'banners');
        $mobileImg = null;
        if ($request->hasFile('image_mobile')) {
            $mobileImg = $this->uploadImage($request->file('image_mobile'), 'banners');
        }

        Banner::create([
            'title'        => $request->title,
            'subtitle'     => $request->subtitle,
            'image'        => $imageName,
            'image_mobile' => $mobileImg,
            'button_text'  => $request->button_text,
            'link_url'     => $request->link_url,
            'type'         => $request->type,
            'position'     => $request->position,
            'sort_order'   => $request->sort_order ?? 0,
            'start_date'   => $request->start_date ?: null,
            'end_date'     => $request->end_date   ?: null,
            'status'       => $request->has('status') ? true : false,
        ]);

        return redirect()->route('admin.banners.index')
                         ->with('success', 'Banner successfully add ho gaya! 🎉');
    }

    // ── Edit ─────────────────────────────────────────────
    public function edit($id)
    {
        $banner         = Banner::findOrFail($id);
        $typeLabels     = Banner::typeLabels();
        $positionLabels = Banner::positionLabels();
        return view('admin.banners.edit', compact('banner', 'typeLabels', 'positionLabels'));
    }

    // ── Update ───────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_mobile' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'type'         => 'required|in:hero_slider,offer_banner,popup_banner,category_banner',
            'position'     => 'required|in:homepage,category_page,checkout_page,all_pages',
            'link_url'     => 'nullable|url',
            'sort_order'   => 'nullable|integer|min:0',
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
        ]);

        $imageName = $banner->image;
        if ($request->hasFile('image')) {
            $this->deleteFile('banners', $banner->image);
            $imageName = $this->uploadImage($request->file('image'), 'banners');
        }

        $mobileImg = $banner->image_mobile;
        if ($request->hasFile('image_mobile')) {
            $this->deleteFile('banners', $banner->image_mobile);
            $mobileImg = $this->uploadImage($request->file('image_mobile'), 'banners');
        }

        $banner->update([
            'title'        => $request->title,
            'subtitle'     => $request->subtitle,
            'image'        => $imageName,
            'image_mobile' => $mobileImg,
            'button_text'  => $request->button_text,
            'link_url'     => $request->link_url,
            'type'         => $request->type,
            'position'     => $request->position,
            'sort_order'   => $request->sort_order ?? 0,
            'start_date'   => $request->start_date ?: null,
            'end_date'     => $request->end_date   ?: null,
            'status'       => $request->has('status') ? true : false,
        ]);

        return redirect()->route('admin.banners.index')
                         ->with('success', 'Banner update ho gaya!');
    }

    // ── Destroy ──────────────────────────────────────────
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $this->deleteFile('banners', $banner->image);
        $this->deleteFile('banners', $banner->image_mobile);
        $banner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Banner delete ho gaya!'
        ]);
    }

    // ── Toggle Status ────────────────────────────────────
    public function toggleStatus(Request $request)
    {
        $banner = Banner::findOrFail($request->id);
        $banner->status = !$banner->status;
        $banner->save();

        return response()->json([
            'success' => true,
            'status'  => $banner->status
        ]);
    }

    // ── Helpers ──────────────────────────────────────────
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