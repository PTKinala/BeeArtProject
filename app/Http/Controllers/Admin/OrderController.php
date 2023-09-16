<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Slip;
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
        $slipData = DB::table('slips')
        ->where('idOrder',$id)
        ->get();

        $madeOrders = DB::table('orders')
        ->leftJoin('made_orders', 'orders.id', '=', 'made_orders.id_order')
        ->leftJoin('images_types', 'made_orders.id_image_type', '=', 'images_types.id')
        ->leftJoin('images_sizes', 'made_orders.size', '=', 'images_sizes.id')
        ->join('colors_types', 'made_orders.color', '=', 'colors_types.id')
        ->select('orders.*', 'made_orders.id AS made_orders_id','made_orders.description','made_orders.image',
        'made_orders.description'
        ,'images_types.name','images_sizes.paper',
        'images_sizes.size_image_cm','colors_types.color_type')
        ->where('orders.id',$id)
        ->get();
        return view('admin.orders.view', compact('orders','slipData','madeOrders'));
    }

    public function updateorder(Request $request, $id)
    {
        $orders = Order::find($id);
        $orders->status = $request->input('order_status');
        $orders->update();
        return redirect('orders')->with('status', "Order Updated Successfully");
    }
    public function updateTracking_no(Request $request, $id)
    {
        $orders = Order::find($id);
        $orders->tracking_no = $request->input('tracking_no');
        $orders->update();


        return redirect('/admin/view-order/'.$id)->with('status', "tracking_no Updated Successfully");

    }
    public function updateCancel_order(Request $request, $id)
    {
        $orders = Order::find($id);
        $orders->cancel_order = "2";
        $orders->update();


        return redirect('/admin/view-order/'.$id)->with('status', "cancel_order Updated Successfully");

    }
    public function updateCancel_order_open(Request $request, $id)
    {
        $orders = Order::find($id);
        $orders->cancel_order = "0";
        $orders->update();


        return redirect('/admin/view-order/'.$id)->with('status', "cancel_order Updated Successfully");

    }
    public function checkUpdateSlip(Request $request, $id)
    {

        $validated = $request->validate([
            'slip_status' => ['required', 'string', 'max:255'],
        ]);

        $orders = DB::table('slips')
        ->where('idOrder',$id)
        ->get();

        $slip = Slip::find( $orders[0]->id);
        $slip->status_slip = $request['slip_status'];
        $slip->update();


        return redirect('/admin/view-order/'.$id)->with('status', "status_slip Updated Successfully");

    }




}
