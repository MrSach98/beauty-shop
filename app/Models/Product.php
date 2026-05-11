<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'subcategory_id', 'child_subcategory_id',
        'product_type',
        'sku', 'name', 'slug', 'brand', 'tags',
        'mrp_price', 'display_price', 'discount', 'stock', 'low_stock_alert',
        'image', 'image2', 'image3', 'image4', 'image5', 'gallery_images',
        'description', 'how_to_use', 'features',
        'shipping_type', 'shipping_charge', 'cod_available',
        'meta_title', 'meta_description', 'meta_keywords',
        'extra_fields',
        'product_on_sale', 'new_arrivals', 'featured', 'is_active',
    ];

    protected $casts = [
        'extra_fields'   => 'array',
        'features'       => 'array',
        'gallery_images' => 'array',
        'cod_available'  => 'boolean',
        'product_on_sale'=> 'boolean',
        'new_arrivals'   => 'boolean',
        'featured'       => 'boolean',
        'is_active'      => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($p) {
            if (!$p->slug) $p->slug = Str::slug($p->name);
            if (!$p->sku)  $p->sku  = 'SKU-'.strtoupper(Str::random(8));
        });
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function subcategory() {
        return $this->belongsTo(Subcategory::class);
    }
    public function childSubcategory() {
        return $this->belongsTo(ChildSubcategory::class);
    }
    public function productType() {
        return $this->belongsTo(ProductType::class, 'product_type', 'slug');
    }

    // Extra field helper — null safe
    public function getExtraField($key, $default = null)
    {
        return $this->extra_fields[$key] ?? $default;
    }
}