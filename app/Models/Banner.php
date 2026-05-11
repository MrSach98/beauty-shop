<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'image', 'image_mobile',
        'button_text', 'link_url', 'type', 'position',
        'sort_order', 'start_date', 'end_date', 'status'
    ];

    protected $casts = [
        'status'     => 'boolean',
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public static function typeLabels()
    {
        return [
            'hero_slider'     => '🖼️ Hero Slider',
            'offer_banner'    => '🎯 Offer Banner',
            'popup_banner'    => '💬 Popup Banner',
            'category_banner' => '📂 Category Banner',
        ];
    }

    public static function positionLabels()
    {
        return [
            'homepage'      => 'Homepage',
            'category_page' => 'Category Page',
            'checkout_page' => 'Checkout Page',
            'all_pages'     => 'All Pages',
        ];
    }

    public function isExpired()
    {
        return $this->end_date && $this->end_date->isPast();
    }
}