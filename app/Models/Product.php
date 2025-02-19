<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'thumbnail',
        'category_id',
        'itemVariations',
        'customChoices',
        'flatChoices',
        'minNumOfChoices',
        'maxNumOfChoices',
        'choiceGroupName',
        'minNumOfChoicesGroup',
        'maxNumOfChoicesGroup',

    ];
    protected $casts = [
        'itemVariations' => 'array',
        // 'customChoices' => 'array',
        // 'flatChoices' => 'array',
    ];
}
