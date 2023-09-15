<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;



class OrderController extends Controller
{
    public function index()
    {
       /*  $orders = Order::where('status', '0')->get(); */

        $orders = DB::table('orders')
        ->leftJoin('made_orders', 'orders.id', '=', 'made_orders.id_order')
        ->leftJoin('images_types', 'made_orders.id_image_type', '=', 'images_types.id')
        ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
         ->leftJoin('products', 'order_items.prod_id', '=', 'products.id')
         ->select('orders.*', 'images_types.name','products.name AS products_name')
        ->where('orders.status',0)
        ->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function orderhistory()
    {
       /*  $orders = Order::where('status', '1')->get(); */
        $orders = DB::table('orders')
        ->leftJoin('made_orders', 'orders.id', '=', 'made_orders.id_order')
        ->leftJoin('images_types', 'made_orders.id_image_type', '=', 'images_types.id')
        ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
         ->leftJoin('products', 'order_items.prod_id', '=', 'products.id')
         ->select('orders.*', 'images_types.name','products.name AS products_name')
        ->where('orders.status',1)
        ->get();
        return view('admin.orders.history', compact('orders'));
    }

    public function view($id)
    {
        $orders = Order::where('id', $id)->first();
        return view('admin.orders.view', compact('orders'));
    }

    public function updateorder(Request $request, $id)
    {
        $orders = Order::find($id);
        $orders->status = $request->input('order_status');
        $orders->update();
        return redirect('orders')->with('status', "Order Updated Successfully");
    }




}
