<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MadeOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_order',
        'id_image_type',
        'size',
        'number_peo',
        'color',
        'description',
        'image',
        'price',
    ];
}
