<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'cate_id',
        'name',
        'status',
        'trending',
        'description',
        'original_price',
        'selling_price',
        'qty',
        'slug',
        'image',


    ];



    public function category()
    {
    return $this->belongsTo(Category::class, 'cate_id','id');
    }
}
