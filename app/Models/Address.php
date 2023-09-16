<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'fname',
        'lname',
        'address',
        'road',
        'subdistrict',
        'district',
        'province',
        'zipcode',
        'phone',
    ];
}
