<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreType extends Model
{
    use HasFactory;

    public function storeType()
    {
        return $this->belongsTo(Store::class);
    }
}