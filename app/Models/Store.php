<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; 

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'storeType',
        'storePurpose',
        'storeBankDetails',
        'storeOwner',
        'storeManager',
        'ntn',
        'thumbnail',
        'storeContactName',
        'storeContact1',
        'storeContact2',
        'storeContactMail',
        'address',
        'lat',
        'long',
        'opning_time',
        'closing_time',
        'min_order',
        'min_order_price',
        'deliveryFeetype',
        'delivery_amount_min',
        'delivery_amount_max',
        'delivery_radius',
        'deliveryBy',
        'orderTakingTime',
    
        'delivery_slots_start',
        'delivery_slots_end',

        'rating',        
        'commission',
        'platform_fee',
        'venu_fee',
    ];
    protected $casts = [
        'delivery_slots_start' => 'array',
        'delivery_slots_end' => 'array',
    ];

    public function storeType()
    {
        return $this->belongsTo(StoreType::class, 'store_type_id');
    }
    public function storeStatus()
    {
        return $this->belongsTo(StoreStatus::class, 'status');
    }
}
