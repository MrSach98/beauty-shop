<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'image',
        'meta_title', 'meta_description', 'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Auto slug generate
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            if (!$category->slug) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function childSubcategories()
    {
        return $this->hasMany(ChildSubcategory::class);
    }
}