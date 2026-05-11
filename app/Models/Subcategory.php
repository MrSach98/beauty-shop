<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'image',
        'meta_title', 'meta_description', 'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($sub) {
            if (!$sub->slug) {
                $sub->slug = Str::slug($sub->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function childSubcategories()
    {
        return $this->hasMany(ChildSubcategory::class);
    }
}