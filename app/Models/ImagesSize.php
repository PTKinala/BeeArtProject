<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagesSize extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_image_type',
        'paper',
        'size_image_cm',
    ];
}