<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductType extends Model
{
    protected $fillable = [
        'name', 'slug', 'icon', 'tabs', 'status', 'sort_order'
    ];

    protected $casts = [
        'tabs'   => 'array',
        'status' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($type) {
            if (!$type->slug) {
                $type->slug = Str::slug($type->name);
            }
        });
    }
}