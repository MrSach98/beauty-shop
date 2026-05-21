<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order_value', 'max_discount',
        'usage_limit', 'usage_per_user', 'used_count',
        'applicable_on', 'applicable_ids', 'user_restriction',
        'start_date', 'end_date', 'status'
    ];

    protected $casts = [
        'applicable_ids' => 'array',
        'status'         => 'boolean',
        'start_date'     => 'date',
        'end_date'       => 'date',
    ];

    public function isExpired()
    {
        return $this->end_date && $this->end_date->isPast();
    }

    public function isUsageLimitReached()
    {
        return $this->usage_limit && $this->used_count >= $this->usage_limit;
    }

    public function isValid()
    {
        if (!$this->status)               return false;
        if ($this->isExpired())           return false;
        if ($this->isUsageLimitReached()) return false;
        if ($this->start_date && $this->start_date->isFuture()) return false;
        return true;
    }
}