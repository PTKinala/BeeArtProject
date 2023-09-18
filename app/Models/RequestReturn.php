<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestReturn extends Model
{
    use HasFactory;
    protected $fillable = [
        'idOrder',
        'bank',
        'bankName',
        'account_number',
        'branch',
        'reason',
        'statusRequest',
        'comment',
        'price',
        'image',
    ];
}