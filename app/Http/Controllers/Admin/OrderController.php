<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Slip;
use App\Models\RequestReturn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



class OrderController extends Controller
{
    public function index()
    {
        $orders2 = Order::where('status', '0')->get();
     /*   $orders = DB::table('orders')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->leftJoin('slips', 'order_items.order_id', '=', 'slips.idOrder')
        ->select('orders.id','orders.order_code', 'orders.total_price','orders.status','orders.tracking_no' ,'orders.created_at','orders.cancel_order')
        ->selectRaw('MAX(slips.image) as image')
        ->selectRaw('MAX(slips.date) as date')
        ->selectRaw('MAX(slips.time) as time')
        ->selectRaw('MAX(slips.status_slip) as status_slip')
        ->where('orders.status', '0')
        ->orderBy('orders.id', 'desc')
        ->groupBy('orders.id', 'orders.order_code', 'orders.total_price','orders.status','orders.tracking_no','orders.created_at','orders.cancel_order')

       ->get();
 */

            $orders = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->select('orders.*')
            ->where('orders.status','<','5')
            ->orderBy('orders.id', 'desc')
            ->get();


       /* dd($orders,count( $orders2)); */

        return view('admin.orders.index', compact('orders'));
    }


    public function ordersPostAdd()
    {
       /*  $orders = Order::where('status', '0')->orderBy('id', 'desc')->get(); */
        $orders = DB::table('orders')
        ->join('made_orders', 'orders.id', '=', 'made_orders.id_order')
        ->select('orders.*')
        ->where('orders.status','<','5')
        ->orderBy('orders.id', 'desc')
        ->get();

        return view('admin.orders.index_made', compact('orders'));
    }

    public function orderhistory()
    {
      /*  $orders = Order::where('status', '1')->orderBy('id', 'desc')->get(); */
        // $orders = DB::table('orders')
        // ->leftJoin('made_orders', 'orders.id', '=', 'made_orders.id_order')
        // ->leftJoin('images_types', 'made_orders.id_image_type', '=', 'images_types.id')
        // ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
        //  ->leftJoin('products', 'order_items.prod_id', '=', 'products.id')
        //  ->select('orders.*', 'images_types.name','products.name AS products_name')
        // ->where('orders.status',1)
        // ->get();

        $orders = DB::table('orders')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->select('orders.*')
        ->where('orders.status','>','4')
        ->orderBy('orders.id', 'desc')
        ->get();
        $massage = "รายการสั่งซื้อ";
        return view('admin.orders.history', compact('orders','massage'));
    }


    public function orderHistoryMade()
    {
      /*  $orders = Order::where('status', '1')->orderBy('id', 'desc')->get(); */
        // $orders = DB::table('orders')
        // ->leftJoin('made_orders', 'orders.id', '=', 'made_orders.id_order')
        // ->leftJoin('images_types', 'made_orders.id_image_type', '=', 'images_types.id')
        // ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
        //  ->leftJoin('products', 'order_items.prod_id', '=', 'products.id')
        //  ->select('orders.*', 'images_types.name','products.name AS products_name')
        // ->where('orders.status',1)
        // ->get();

        $orders = DB::table('orders')
        ->join('made_orders', 'orders.id', '=', 'made_orders.id_order')
        ->select('orders.*')
        ->where('orders.status','>','9')
        ->orderBy('orders.id', 'desc')
        ->get();

         $massage = "รายการสั่งทำ";
        return view('admin.orders.history', compact('orders','massage'));
    }

    public function orderLisp() {

        $orders = DB::table('orders')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->join('slips', 'orders.id', '=', 'slips.idOrder')
        ->select('orders.*', 'slips.image','slips.date','slips.time','slips.status_slip')
        ->where('orders.status',1)
        ->orderBy('orders.id', 'desc')
        ->get();



        return view('admin.orders.orderSlip', compact('orders'));
    }


    public function requestReturnAdmin() {
        $orders = DB::table('orders')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->join('request_returns', 'orders.id', '=', 'request_returns.idOrder')
        ->select('orders.*', 'request_returns.bank','request_returns.bankName','request_returns.account_number',
        'request_returns.branch','request_returns.reason','request_returns.statusRequest' ,'request_returns.comment','request_returns.image')
        ->get();



        return view('admin.orders.orderRequestReturn', compact('orders'));
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

    // public function updateorder(Request $request, $id)
    // {
    //     $orders = Order::find($id);
    //     $orders->status = $request->input('order_status');
    //     $orders->update();
    //     return redirect('orders')->with('status', "Order Updated Successfully");
    // }

    public function updateTracking_no(Request $request, $id)
    {
        $orders = Order::find($id);
        $orders->tracking_no = $request->input('tracking_no');


        $v = substr($orders->order_code, 0, 3);
        if ($v == "Ord") {  // เช็คว่าเป็นสั่งซื้อ
            $orders->status =  "4";
            $orders->update();
        }else { // สั่งทำ
            $orders->status =  "9";
            $orders->update();
        }





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



        $slip = Slip::find($id);
        // dd($id);
        $slip->status_slip = $request['slip_status'];
        $slip->update();




        $order_status = Order::find($slip->idOrder);
        $v = substr($order_status->order_code, 0, 3);

        if ($v == "Ord") {  // เช็คว่าเป็นสั่งซื้อ
            $order_status->status =  $request['slip_status'];
            $order_status->update();

        }else { // สั่งทำ

            if($order_status->status == 2) {
                $order_status->status =  $request['slip_status'] + 1;
                $order_status->update();
            }else {
                $order_status->status =  $request['slip_status'] + 5;
                $order_status->update();
            }

        }



        return redirect('/admin/view-order/'.$slip->idOrder)->with('status', "status_slip Updated Successfully");
    }



    public function OrderRequestAdmin(Request $request, $id)
    {


        $orders = Order::where('id', $id)->first();

        $requestData = DB::table('request_returns')
        ->where('idOrder',$id)
        ->get();

        return view('admin.orders.orderRequestAdmin', compact('orders','requestData'));
    }


    public function approveRequest(Request $request, $id)
    {
        $statusRequest = RequestReturn::find($id);
        $dataid = $statusRequest->idOrder;
        // dd($dataid);
        return view('admin.orders.approveRequest', compact('id','dataid'));

    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'image' => [ 'image', 'mimes:jpg,png,jpeg,webp'],
            'statusRequest' => ['required', 'string', 'max:255'],
        ]);


        $statusRequest = RequestReturn::find($id);
        $statusRequest->statusRequest = $request->input('statusRequest');
        $statusRequest->comment = $request->input('comment');
        $statusRequest->price = $request->input('price');
        $dateText = Str::random(6);
        if ($request->hasFile('image')) {
            if ($statusRequest->image) {
                $image_path = public_path() . '/assets/uploads/requestSlip/' . $statusRequest->image;
                if (file_exists($image_path)) {
                    unlink($image_path); // ลบไฟล์ถ้ามีอยู่
                }

            }
            //add ภาพ
            $image = $request->file('image');
            $data =   $image->move(public_path() . '/assets/uploads/requestSlip', $dateText . $image->getClientOriginalName());
            $statusRequest->image =  $dateText . $image->getClientOriginalName();
        }

        $statusRequest->update();

        return redirect('/admin/request-admin/'.$statusRequest->idOrder)->with('status', "Order placed Successfully");


    }


    public function updatePriceOrder(Request $request, $id)
    {


        $statusRequest = Order::find($id);
        $statusRequest->total_price = $request->input('price');
        $statusRequest->status =  "1";
        $statusRequest->update();


        return redirect('/admin/view-order/'.$id)->with('status', "update Price Order Successfully");
    }



    public function updateOrderSucceed(Request $request ,$id) {


        $orders = Order::find($id);
        $orders->status = "5";
        $orders->update();

        return redirect('/admin/view-order/'.$id)->with('status', "Order Status Updated Successfully");

    }


}