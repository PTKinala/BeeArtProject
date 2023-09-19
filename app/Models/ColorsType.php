<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorsType extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_image_type',
        'color_type',
        'status',
    ];
}