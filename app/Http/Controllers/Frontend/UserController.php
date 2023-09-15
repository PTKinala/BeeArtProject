<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Bank;
use App\Models\MadeOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id',Auth::id())->get();

        return view('frontend.orders.index', compact('orders'));
    }

    public function view($id)
    {
        $orders = Order::where('id', $id)->where('user_id',Auth::id())->first();
        $bank = Bank::get();

        $madeOrders = DB::table('orders')
        ->leftJoin('made_orders', 'orders.id', '=', 'made_orders.id_order')
        ->leftJoin('images_types', 'made_orders.id_image_type', '=', 'images_types.id')
        ->leftJoin('images_sizes', 'made_orders.size', '=', 'images_sizes.id')
        ->leftJoin('colors_types', 'made_orders.color', '=', 'colors_types.id')
        ->select('orders.*', 'made_orders.id AS made_orders_id','made_orders.description','made_orders.image',
        'made_orders.description','made_orders.status_e_d'
        ,'images_types.name','images_sizes.paper',
        'images_sizes.size_image_cm','colors_types.color_type')
        ->where('orders.id',$id)
        ->get();

        return view('frontend.orders.view', compact('orders','bank','madeOrders'));
    }
}
