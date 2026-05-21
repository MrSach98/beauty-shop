<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $fillable = [
        'name', 'states', 'base_charge',
        'free_above', 'cod_available', 'cod_charge', 'status'
    ];

    protected $casts = [
        'states'        => 'array',
        'cod_available' => 'boolean',
        'status'        => 'boolean',
    ];

    public static function indianStates()
    {
        return [
            'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar',
            'Chhattisgarh', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh',
            'Jharkhand', 'Karnataka', 'Kerala', 'Madhya Pradesh', 'Maharashtra',
            'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Punjab',
            'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura',
            'Uttar Pradesh', 'Uttarakhand', 'West Bengal',
            'Delhi', 'Jammu & Kashmir', 'Ladakh', 'Chandigarh',
            'Puducherry', 'Andaman & Nicobar Islands', 'Lakshadweep',
        ];
    }
}