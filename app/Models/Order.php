<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'order_code',
        'fname',
        'lname',
        'email',
        'phone',
        'address1',
        'road',
        'subdistrict',
        'district',
        'province',
        'zipcode',
        'total_price',
        'status',
        'message',
        'tracking_no',
        'cancel_order',
        'full_amount',
    ];



    public function orderitems()
    {
        return $this->hasMany(OrderItem::class);
    }
}