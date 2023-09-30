<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Slip;
use App\Models\User;
use App\Models\RequestReturn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\MailController;



class OrderController extends Controller
{
    public function index()
    {
        // $orders2 = Order::where('status', '0')->get();
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

            // $orders = DB::table('orders')
            // ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            // ->select('orders.*')
            // ->where('orders.status','<','5')
            // ->whereNull('orders.cancel_order')
            // ->orWhere('orders.cancel_order','2')
            // ->orderBy('orders.id', 'desc')
            // ->get();

            $orders = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->select('orders.*')
            ->where('orders.status', '<', '5')
            ->where(function ($query) {
                $query->where('orders.cancel_order', '!=', '1')
                      ->orWhereNull('orders.cancel_order');
            })
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
        ->where('orders.status','<','10')
        ->where(function ($query) {
            $query->where('orders.cancel_order', '!=', '1')
                  ->orWhereNull('orders.cancel_order');
        })

        ->orderBy('orders.id', 'desc')
        ->groupBy('orders.order_code')
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
        ->orWhere('orders.cancel_order','1')
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
        ->orWhere('orders.cancel_order','1')
        ->orderBy('orders.id', 'desc')
        ->get();

         $massage = "รายการสั่งทำ";
        return view('admin.orders.historyMade', compact('orders','massage'));
    }

    public function orderLisp() {

        $orders = DB::table('orders')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->join('slips', 'orders.id', '=', 'slips.idOrder')
        ->select('orders.*', 'slips.image','slips.date','slips.time','slips.status_slip')
        ->whereNull('slips.status_slip')
        ->where('orders.status' ,'<',5)
        ->orderBy('orders.id', 'desc')
        ->get();


        $massage = "รายการสั่งซื้อ";
        return view('admin.orders.orderSlip', compact('orders','massage'));
    }
    public function orderLispMade() {

        $orders = DB::table('orders')
        ->join('made_orders', 'orders.id', '=', 'made_orders.id_order')
        ->join('slips', 'made_orders.id_order', '=', 'slips.idOrder')
        ->select('orders.*', 'slips.image','slips.date','slips.time','slips.status_slip')
        ->whereNull('slips.status_slip')
        ->where('orders.status' ,'<',10)
        ->orderBy('orders.id', 'desc')
        ->get();


        $massage = "รายการสั่งทำ";
        return view('admin.orders.orderSlipMade', compact('orders','massage'));
    }


    public function requestReturnAdmin() {
        $orders = DB::table('orders')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->join('request_returns', 'orders.id', '=', 'request_returns.idOrder')
        ->select('orders.*', 'request_returns.bank','request_returns.bankName','request_returns.account_number',
        'request_returns.branch','request_returns.reason','request_returns.statusRequest' ,'request_returns.comment','request_returns.image','request_returns.image_order')
        ->get();


        return view('admin.orders.orderRequestReturn', compact('orders'));
    }

    public function view($id)
    {

        $orders = Order::where('id', $id)->first();

        $slipData = DB::table('slips')
        ->orderBy('id', 'desc')
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





        return redirect('/admin/view-order/'.$id)->with('status', "เพิ่มหมายเลขพัสดุสำเร็จ");

    }
    public function updateCancel_order(Request $request, $id)
    {
        $orders = Order::find($id);
        $orders->cancel_order = "2";
        $orders->update();


        return redirect('/admin/view-order/'.$id)->with('status', "ยกเลิกคำสั่งซื้อสำเร็จ");

    }
    public function updateCancel_order_open(Request $request, $id)
    {
        $orders = Order::find($id);
        $orders->cancel_order = NULL;
        $orders->update();


        return redirect('/admin/view-order/'.$id)->with('status', "ยกเลิกคำสั่งซื้อสำเร็จ");

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

        // ส่งเมล์ให้ user อัพเดต สถานะสลิป
        $madeOrders = DB::table('orders')
        ->leftJoin('made_orders', 'orders.id', '=', 'made_orders.id_order')
        ->leftJoin('images_types', 'made_orders.id_image_type', '=', 'images_types.id')
        ->leftJoin('images_sizes', 'made_orders.size', '=', 'images_sizes.id')
        ->leftJoin('colors_types', 'made_orders.color', '=', 'colors_types.id')
        ->select('orders.*', 'made_orders.id AS made_orders_id','made_orders.description','made_orders.image',
        'made_orders.id_image_type', 'made_orders.size', 'made_orders.number_peo', 'made_orders.color',
        'made_orders.description'
        ,'images_types.name','images_sizes.paper',
        'images_sizes.size_image_cm','colors_types.color_type')
        ->where('orders.id',$slip->idOrder)
        ->get();

        $order = DB::table('order_items')
        ->leftJoin('products', 'order_items.prod_id', '=', 'products.id')
        ->where('order_items.order_id',$slip->idOrder)
        ->get();
        $mail = User::find($madeOrders[0]->user_id);

        if ($v == "Ord") {  // เช็คว่าเป็นสั่งซื้อ
            $order_status->status =  $request['slip_status'];
            $order_status->update();
            $text1 =  "สั่งซื้อภาพ";
            $text2 =  "ประเภทการสั่งซื้อ".$order[0]->name;
            if ($request['slip_status'] == 2) {
                $text7 =  "สถานะ    สลิปไม่ผ่าน";
            }else{
                $text7 =  "สถานะ   กำลังจัดส่งงานศิลปะ";
            }

        }else { // สั่งทำ

            if($order_status->status == 2) {
                $order_status->status =  $request['slip_status'] + 1;
                $order_status->update();
                $text1 =  "สั่งทำภาพ";
                if ($request['slip_status']+1 == "3") {
                    $text7 =  "สถานะ    สลิปไม่ผ่าน";
                }else{
                    $text7 =  "สถานะ   เริ่ิ่มดำเนินการ";
                }
                $text2 =  "ประเภทการสั่งทำ".$madeOrders[0]->name;
            }else {
                $order_status->status =  $request['slip_status'] + 5;
                $order_status->update();
                $text1 =  "สั่งทำภาพ";
                if ($request['slip_status']+5 == "7") {
                    $text7 =  "สถานะ    สลิปไม่ผ่าน";
                }else{
                    $text7 =  "สถานะ   กำลังจัดส่งงานศิลปะ";
                }
                $text2 =  "ประเภทการสั่งทำ".$madeOrders[0]->name;
            }

        }

        $text3 =  "รหัสสินค้าสั่งทำ". $slip->idOrder;
        $text4 =  "ราคาประเมิน  ".$madeOrders[0]->total_price." บาท";
        $text5 =  "จำนวนเงินที่โอน ". $madeOrders[0]->total_price ;
        $text6 =  "รูปเเบบการโอน   โอนราคาเต็ม";
        $text8 =  "วันเวลาที่โอน " .$slip->date." ".$slip->time;
        $text9 =  NULL;
        $text10 = NULL;
        $data = [$text1,$text2,$text3,$text4,$text5,$text6,$text7,$text8,$text9,$text10];
        $customer_mailAdminController = app(MailController::class);
        $customer_mailAdminController->customer_mail($mail->email ,$data);



        return redirect('/admin/view-order/'.$slip->idOrder)->with('status', "สถานะการชำระเงินถูกอัพเดทแล้ว");
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
        if ($request->input('statusRequest') == 1) {
            $order_stat = Order::find($statusRequest->idOrder);
            $order_stat->cancel_order = "1";
            $order_stat->update();
        }
        return redirect('/admin/request-admin/'.$statusRequest->idOrder)->with('status', "เพิ่มหลักฐานการคืนเงินสำเร็จ");


    }


    public function updatePriceOrder(Request $request, $id)
    {


        $statusRequest = Order::find($id);
        $statusRequest->total_price = $request->input('price');
        $statusRequest->status =  "1";
        $statusRequest->update();


        // ส่งเมล์ให้ user  ประเมินราคา
        $madeOrders = DB::table('orders')
        ->leftJoin('made_orders', 'orders.id', '=', 'made_orders.id_order')
        ->leftJoin('images_types', 'made_orders.id_image_type', '=', 'images_types.id')
        ->leftJoin('images_sizes', 'made_orders.size', '=', 'images_sizes.id')
        ->leftJoin('colors_types', 'made_orders.color', '=', 'colors_types.id')
        ->select('orders.*', 'made_orders.id AS made_orders_id','made_orders.description','made_orders.image',
        'made_orders.id_image_type', 'made_orders.size', 'made_orders.number_peo', 'made_orders.color',
        'made_orders.description'
        ,'images_types.name','images_sizes.paper',
        'images_sizes.size_image_cm','colors_types.color_type')
        ->where('orders.id',$id)
        ->get();

        $mail = User::find($madeOrders[0]->user_id);

        $text =  "ประเมินราคาสั่งทำภาพ";
        $text1 =  "ประเภทการสั่งทำ".$madeOrders[0]->name;
        $text2 =  "รหัสสั่งทำสินค้า".$madeOrders[0]->order_code;
        $text3 =  "ราคาประเมิน  ".$request->input('price')."  บาท";
        $text4 =  "สถานะ   รอการชำระเงินมัดจำ";
        $text5 =  NULL;
        $text6 =  NULL;
        $text7 =  NULL;
        $text8 =  NULL;
        $text9 =  NULL;
        $data = [$text,$text1,$text2,$text3,$text4,$text5,$text6,$text7,$text8,$text9];
        $customer_mailController = app(MailController::class);
        $customer_mailController->customer_mail($mail->email,$data);


        return redirect('/admin/view-order/'.$id)->with('status', "เพิ่มราคาประเมินสำเร็จ");
    }



    public function updateOrderSucceed(Request $request ,$id) {


        $orders = Order::find($id);

        if ($orders->full_amount == "on") {
            $orders->status = "8";
            $orders->update();
        }else {
            $orders->status = "5";
            $orders->update();
        }


        return redirect('/admin/view-order/'.$id)->with('status', "เพิ่มสถานะสำเร็จ");

    }
    public function updateOrderAdmin(Request $request ,$id) {


        $orders = Order::find($id);
        $orders->status = $request->input('order_status');
        $orders->update();

        return redirect('/admin/view-order/'.$id)->with('status', "คำสั่งซื้ออัพเดทสถานะสำเร็จ");

    }


}