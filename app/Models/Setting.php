<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group'];

    public static function get($key, $default = null)
    {
        return Cache::rememberForever('setting_'.$key, function() use ($key, $default) {
            $s = static::where('key', $key)->first();
            return $s ? $s->value : $default;
        });
    }

    public static function set($key, $value, $group = 'general')
    {
        Cache::forget('setting_'.$key);
        return static::updateOrCreate(
            ['key'   => $key],
            ['value' => $value, 'group' => $group]
        );
    }

    public static function getGroup($group)
    {
        return static::where('group', $group)
                     ->pluck('value', 'key')
                     ->toArray();
    }
}