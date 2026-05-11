<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    protected $fillable = [
        'name', 'slug', 'logo', 'description',
        'website_url', 'is_featured', 'status', 'sort_order'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'status'      => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($brand) {
            if (!$brand->slug) {
                $brand->slug = Str::slug($brand->name);
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'brand', 'name');
    }
}