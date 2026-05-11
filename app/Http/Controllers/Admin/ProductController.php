<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ChildSubcategory;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    // ── Index ────────────────────────────────────────────
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Product::with(['category', 'subcategory'])
                            ->select('products.*');

            if ($request->product_type) {
                $query->where('product_type', $request->product_type);
            }
            if ($request->category_id) {
                $query->where('category_id', $request->category_id);
            }
            if ($request->brand) {
                $query->where('brand', 'like', '%'.$request->brand.'%');
            }
            if ($request->status !== null && $request->status !== '') {
                $query->where('is_active', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('image_col', function ($row) {
                    if ($row->image && File::exists(public_path('uploads/products/'.$row->image))) {
                        return '<img src="'.asset('uploads/products/'.$row->image).'"
                                    width="50" height="50"
                                    style="border-radius:8px;object-fit:cover;">';
                    }
                    return '<div style="width:50px;height:50px;background:#FCE4EC;
                                border-radius:8px;display:flex;align-items:center;
                                justify-content:center;font-size:18px;">📦</div>';
                })
                ->addColumn('name_col', function ($row) {
                    return '<div class="fw-semibold">'.e($row->name).'</div>
                            <small class="text-muted">'.e($row->sku).'</small>';
                })
                ->addColumn('type_col', function ($row) {
                    $pt   = ProductType::where('slug', $row->product_type)->first();
                    $icon = $pt ? $pt->icon : '📦';
                    $name = $pt ? $pt->name : $row->product_type;
                    return '<span class="badge"
                                style="background:#FCE4EC;color:#C2185B;font-size:11px">
                                '.$icon.' '.$name.'
                            </span>';
                })
                ->addColumn('category_name', fn($r) => $r->category->name ?? '-')
                ->addColumn('price_col', function ($row) {
                    return '<div>
                        <span class="fw-bold text-success">
                            ₹'.number_format($row->display_price, 2).'
                        </span><br>
                        <small class="text-muted text-decoration-line-through">
                            ₹'.number_format($row->mrp_price, 2).'
                        </small>
                        <span class="badge bg-danger ms-1">'.$row->discount.'%</span>
                    </div>';
                })
                ->addColumn('stock_col', function ($row) {
                    $color = $row->stock <= 0
                        ? 'danger'
                        : ($row->stock <= $row->low_stock_alert ? 'warning' : 'success');
                    $label = $row->stock <= 0
                        ? 'Out of Stock'
                        : ($row->stock <= $row->low_stock_alert ? 'Low Stock' : 'In Stock');
                    return '<span class="badge bg-'.$color.'">'.$label.'</span>
                            <div class="small text-muted">Qty: '.$row->stock.'</div>';
                })
                ->addColumn('status_col', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    return '<div class="form-check form-switch">
                        <input class="form-check-input product-status-toggle"
                               type="checkbox" data-id="'.$row->id.'" '.$checked.'>
                    </div>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="'.route('admin.products.show', $row->id).'"
                           class="btn btn-sm btn-info me-1">
                           <i class="bi bi-eye"></i>
                        </a>
                        <a href="'.route('admin.products.edit', $row->id).'"
                           class="btn btn-sm btn-warning me-1">
                           <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-sm btn-danger product-delete-btn"
                            data-id="'.$row->id.'"
                            data-name="'.addslashes($row->name).'">
                            <i class="bi bi-trash"></i>
                        </button>';
                })
                ->rawColumns([
                    'image_col','name_col','type_col',
                    'price_col','stock_col','status_col','action'
                ])
                ->make(true);
        }

        $categories   = Category::where('status', true)->get();
        $productTypes = ProductType::where('status', true)
                                   ->orderBy('sort_order')->get();
        return view('admin.products.index', compact('categories', 'productTypes'));
    }

    // ── Create ───────────────────────────────────────────
    public function create(Request $request)
    {
        $categories   = Category::where('status', true)->get();
        $productTypes = ProductType::where('status', true)
                                   ->orderBy('sort_order')->get();

        $selectedType = null;
        if ($request->type) {
            $selectedType = ProductType::where('slug', $request->type)
                                       ->where('status', true)->first();
        }
        if (!$selectedType) {
            $selectedType = $productTypes->first();
        }

        return view('admin.products.create',
            compact('categories', 'productTypes', 'selectedType'));
    }

    // ── Store ────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'product_type'  => 'required|string',
            'mrp_price'     => 'required|numeric|min:0',
            'display_price' => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image2'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image3'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image4'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image5'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $this->prepareData($request);

        foreach (['image','image2','image3','image4','image5'] as $f) {
            if ($request->hasFile($f)) {
                $data[$f] = $this->uploadImage($request->file($f), 'products');
            }
        }
        if ($request->hasFile('gallery_images')) {
            $gallery = [];
            foreach ($request->file('gallery_images') as $file) {
                $gallery[] = $this->uploadImage($file, 'products/gallery');
            }
            $data['gallery_images'] = $gallery;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product successfully add ');
    }

    // ── Show ─────────────────────────────────────────────
    public function show($id)
    {
        $product = Product::with(['category', 'subcategory', 'childSubcategory'])
                          ->findOrFail($id);
        $selectedType = ProductType::where('slug', $product->product_type)->first();
        return view('admin.products.show', compact('product', 'selectedType'));
    }

    // ── Edit ─────────────────────────────────────────────
    public function edit($id)
    {
        $product      = Product::findOrFail($id);
        $categories   = Category::where('status', true)->get();
        $productTypes = ProductType::where('status', true)
                                   ->orderBy('sort_order')->get();

        $selectedType = ProductType::where('slug', $product->product_type)->first();
        if (!$selectedType) $selectedType = $productTypes->first();

        $subcategories = Subcategory::where('category_id', $product->category_id)
                                    ->where('status', true)->get();
        $childSubs     = ChildSubcategory::where('subcategory_id', $product->subcategory_id)
                                         ->where('status', true)->get();

        return view('admin.products.edit', compact(
            'product', 'categories', 'productTypes',
            'selectedType', 'subcategories', 'childSubs'
        ));
    }

    // ── Update ───────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'product_type'  => 'required|string',
            'mrp_price'     => 'required|numeric|min:0',
            'display_price' => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image2'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image3'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image4'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image5'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $this->prepareData($request);

        foreach (['image','image2','image3','image4','image5'] as $f) {
            if ($request->hasFile($f)) {
                $this->deleteFile('products', $product->$f);
                $data[$f] = $this->uploadImage($request->file($f), 'products');
            }
        }
        if ($request->hasFile('gallery_images')) {
            if ($product->gallery_images) {
                foreach ($product->gallery_images as $old) {
                    $this->deleteFile('products/gallery', $old);
                }
            }
            $gallery = [];
            foreach ($request->file('gallery_images') as $file) {
                $gallery[] = $this->uploadImage($file, 'products/gallery');
            }
            $data['gallery_images'] = $gallery;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product successfully update ho gaya!');
    }

    // ── Destroy ──────────────────────────────────────────
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        foreach (['image','image2','image3','image4','image5'] as $f) {
            $this->deleteFile('products', $product->$f);
        }
        if ($product->gallery_images) {
            foreach ($product->gallery_images as $g) {
                $this->deleteFile('products/gallery', $g);
            }
        }

        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'Product delete ho gaya!'
        ]);
    }

    // ── Bulk Delete ──────────────────────────────────────
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids ?? [];
        foreach ($ids as $id) {
            $this->destroy($id);
        }
        return response()->json([
            'success' => true,
            'message' => count($ids).' products delete ho gaye!'
        ]);
    }

    // ── Toggle Status ────────────────────────────────────
    public function toggleStatus(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->is_active = !$product->is_active;
        $product->save();
        return response()->json([
            'success' => true,
            'status'  => $product->is_active
        ]);
    }

    // ── AJAX: Subcategories ──────────────────────────────
    public function getSubcategories(Request $request)
    {
        return response()->json(
            Subcategory::where('category_id', $request->category_id)
                       ->where('status', true)
                       ->get(['id','name'])
        );
    }

    // ── AJAX: Child Subcategories ────────────────────────
    public function getChildSubs(Request $request)
    {
        return response()->json(
            ChildSubcategory::where('subcategory_id', $request->subcategory_id)
                            ->where('status', true)
                            ->get(['id','name'])
        );
    }

    // ── AJAX: Generate SKU ───────────────────────────────
    public function generateSku()
    {
        do {
            $sku = 'SKU-'.strtoupper(Str::random(8));
        } while (Product::where('sku', $sku)->exists());

        return response()->json(['sku' => $sku]);
    }

    // ════════════════════════════════════════════════════
    // PRIVATE HELPERS
    // ════════════════════════════════════════════════════

    private function prepareData(Request $request)
    {
        // Auto discount calculate
        $mrp  = $request->mrp_price    ?? 0;
        $disp = $request->display_price ?? 0;
        $disc = ($mrp > 0 && $disp > 0 && $disp < $mrp)
                ? round((($mrp - $disp) / $mrp) * 100, 2)
                : 0;

        // Extra fields — type ke hisaab se
        $extraFields = $this->buildExtraFields($request);

        return [
            'category_id'          => $request->category_id,
            'subcategory_id'       => $request->subcategory_id,
            'child_subcategory_id' => $request->child_subcategory_id,
            'product_type'         => $request->product_type,
            'sku'                  => $request->sku
                                        ?: 'SKU-'.strtoupper(Str::random(8)),
            'name'                 => $request->name,
            'slug'                 => $request->slug
                                        ? Str::slug($request->slug)
                                        : Str::slug($request->name),
            'brand'                => $request->brand,
            'tags'                 => $request->tags,
            'mrp_price'            => $mrp,
            'display_price'        => $disp,
            'discount'             => $disc,
            'stock'                => $request->stock,
            'low_stock_alert'      => $request->low_stock_alert ?? 5,
            'description'          => $request->description,
            'how_to_use'           => $request->how_to_use,
            'features'             => $request->features
                                        ? array_filter(
                                            explode("\n", $request->features)
                                          )
                                        : null,
            'shipping_type'        => $request->shipping_type  ?? 'paid',
            'shipping_charge'      => $request->shipping_charge ?? 0,
            'cod_available'        => $request->boolean('cod_available'),
            'meta_title'           => $request->meta_title,
            'meta_description'     => $request->meta_description,
            'meta_keywords'        => $request->meta_keywords,
            'extra_fields'         => $extraFields,
            'product_on_sale'      => $request->boolean('product_on_sale'),
            'new_arrivals'         => $request->boolean('new_arrivals'),
            'featured'             => $request->boolean('featured'),
            'is_active'            => $request->boolean('is_active'),
        ];
    }

    // ── Extra Fields Builder — type ke hisaab se ────────
    private function buildExtraFields(Request $request)
    {
        $type = $request->product_type;

        switch ($type) {

            case 'beauty':
                return [
                    'skin_type'       => $request->skin_type
                                         ? (array)$request->skin_type
                                         : [],
                    'concern'         => $request->concern
                                         ? (array)$request->concern
                                         : [],
                    'key_ingredients' => $request->key_ingredients,
                    'full_ingredients'=> $request->full_ingredients,
                    'is_organic'      => $request->boolean('is_organic'),
                    'is_vegan'        => $request->boolean('is_vegan'),
                    'is_cruelty_free' => $request->boolean('is_cruelty_free'),
                    'is_paraben_free' => $request->boolean('is_paraben_free'),
                    'net_weight'      => $request->net_weight,
                    'shelf_life'      => $request->shelf_life,
                    'gender'          => $request->gender,
                ];

            case 'clothing':
                return [
                    'sizes'    => $request->sizes
                                  ? (array)$request->sizes
                                  : [],
                    'colors'   => $request->colors
                                  ? (array)$request->colors
                                  : [],
                    'material' => $request->material,
                    'gender'   => $request->gender,
                    'occasion' => $request->occasion,
                ];

            case 'book':
                return [
                    'author'         => $request->author,
                    'publisher'      => $request->publisher,
                    'isbn'           => $request->isbn,
                    'language'       => $request->language,
                    'edition'        => $request->edition,
                    'pages'          => $request->pages,
                    'book_type'      => $request->book_type,
                    'published_date' => $request->published_date,
                ];

            case 'electronic':
                return [
                    'model_number'    => $request->model_number,
                    'warranty_months' => $request->warranty_months,
                    'warranty_type'   => $request->warranty_type,
                    'specs'           => $this->buildSpecs($request),
                ];

            case 'mobile':
                return [
                    'model_number'    => $request->model_number,
                    'warranty_months' => $request->warranty_months,
                    'warranty_type'   => $request->warranty_type,
                    'ram'             => $request->ram,
                    'storage'         => $request->storage,
                    'battery'         => $request->battery,
                    'display'         => $request->display,
                    'camera'          => $request->camera,
                    'processor'       => $request->processor,
                    'os'              => $request->os,
                    'specs'           => $this->buildSpecs($request),
                ];

            case 'jewelry':
                return [
                    'material'        => $request->jewelry_material,
                    'purity'          => $request->purity,
                    'weight_grams'    => $request->weight_grams,
                    'gemstone'        => $request->gemstone,
                    'jewelry_type'    => $request->jewelry_type,
                    'gender'          => $request->gender,
                    'occasion'        => $request->occasion,
                    'hallmark_number' => $request->hallmark_number,
                    'making_charges'  => $request->making_charges,
                    'is_hallmarked'   => $request->boolean('is_hallmarked'),
                ];

            case 'grocery':
                return [
                    'net_weight'           => $request->net_weight,
                    'shelf_life'           => $request->shelf_life,
                    'food_type'            => $request->food_type,
                    'country_origin'       => $request->country_origin,
                    'storage_instructions' => $request->storage_instructions,
                    'manufacturer'         => $request->manufacturer,
                    'is_organic'           => $request->boolean('is_organic'),
                    'is_vegan'             => $request->boolean('is_vegan'),
                    'gluten_free'          => $request->boolean('gluten_free'),
                    'sugar_free'           => $request->boolean('sugar_free'),
                ];

            case 'furniture':
                return [
                    'material'   => $request->material,
                    'color'      => $request->color,
                    'assembly'   => $request->assembly,
                    'width_cm'   => $request->width_cm,
                    'height_cm'  => $request->height_cm,
                    'depth_cm'   => $request->depth_cm,
                    'weight_kg'  => $request->weight_kg,
                    'room_type'  => $request->room_type,
                    'warranty'   => $request->warranty_months,
                ];

            case 'sports':
                return [
                    'sport_type'      => $request->sport_type,
                    'target_user'     => $request->target_user,
                    'gender'          => $request->gender,
                    'material'        => $request->material,
                    'net_weight'      => $request->net_weight,
                    'is_supplement'   => $request->boolean('is_supplement'),
                    'flavor'          => $request->flavor,
                    'serving_size'    => $request->serving_size,
                    'servings_per_pack'=> $request->servings_per_pack,
                ];

            case 'baby':
                return [
                    'age_group'      => $request->age_group,
                    'baby_category'  => $request->baby_category,
                    'material'       => $request->material,
                    'net_weight'     => $request->net_weight,
                    'certifications' => $request->certifications
                                        ? (array)$request->certifications
                                        : [],
                    'is_organic'     => $request->boolean('is_organic'),
                    'bpa_free'       => $request->boolean('bpa_free'),
                    'hypoallergenic' => $request->boolean('hypoallergenic'),
                ];

            case 'pet':
                return [
                    'pet_type'     => $request->pet_type
                                      ? (array)$request->pet_type
                                      : [],
                    'pet_age'      => $request->pet_age,
                    'pet_size'     => $request->pet_size,
                    'pet_category' => $request->pet_category,
                    'flavor'       => $request->flavor,
                    'net_weight'   => $request->net_weight,
                    'vet_approved' => $request->boolean('vet_approved'),
                    'grain_free'   => $request->boolean('grain_free'),
                    'is_organic'   => $request->boolean('is_organic'),
                ];

            case 'medical':
                return [
                    'generic_name'           => $request->generic_name,
                    'manufacturer'           => $request->manufacturer,
                    'medicine_form'          => $request->medicine_form,
                    'strength'               => $request->strength,
                    'pack_size'              => $request->pack_size,
                    'schedule'               => $request->schedule,
                    'storage'                => $request->storage,
                    'manufacture_date'       => $request->manufacture_date,
                    'composition'            => $request->composition,
                    'side_effects'           => $request->side_effects,
                    'dosage_instructions'    => $request->dosage_instructions,
                    'prescription_required'  => $request->boolean('prescription_required'),
                    'refrigeration_required' => $request->boolean('refrigeration_required'),
                ];

            default:
                return $request->extra_fields ?? null;
        }
    }

    // ── Specs builder (Electronics/Mobile) ──────────────
    private function buildSpecs(Request $request)
    {
        $specs = [];
        $keys   = $request->spec_keys   ?? [];
        $values = $request->spec_values ?? [];
        foreach ($keys as $i => $key) {
            if ($key) {
                $specs[$key] = $values[$i] ?? '';
            }
        }
        return $specs;
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