<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChildSubcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'subcategory_id', 'name', 'slug', 'image',
        'meta_title', 'meta_description', 'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($child) {
            if (!$child->slug) {
                $child->slug = Str::slug($child->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}