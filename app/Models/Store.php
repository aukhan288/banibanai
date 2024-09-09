<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; 

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'store_type_id',
        'thumbnail',
        'min_delevery_time',
        'min_order',
        'rating',
        'opning_time',
        'address',
        'lat',
        'long',
        'ntn',
        'delivery_type',
        'delivery_fee',
        'delivery_radius',
        'commission',
        'platform_fee',
        'venu_fee',
    ];


    public function storeType()
    {
        return $this->belongsTo(StoreType::class, 'store_type_id');
    }
}
