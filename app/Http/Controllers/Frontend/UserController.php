<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Bank;
use App\Models\User;
use App\Models\MadeOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MailController;

class UserController extends Controller
{
    public function index()
    {
         $orders = Order::where('user_id',Auth::id())->orderBy('id', 'desc')->get();


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
        ->join('colors_types', 'made_orders.color', '=', 'colors_types.id')
        ->select('orders.*', 'made_orders.id AS made_orders_id','made_orders.description','made_orders.image',
        'made_orders.description'
        ,'images_types.name','images_sizes.paper',
        'images_sizes.size_image_cm','colors_types.color_type')
        ->where('orders.id',$id)
        ->get();

        $dataSlip = DB::table('slips')
        ->where('idOrder', $id)
        ->orderBy('id', 'desc')
        ->get();


        $dataRequest = DB::table('request_returns')
        ->where('idOrder', $id)
        ->get();


        $dataDeposit = DB::table('deposit_price')
        ->get();
        $deposit =  $dataDeposit[0]->deposit;

        //  = whereDate('updated_at', Order::now()->subDays(1))
        // $expired->updated_at->diffInDays(today());
        // $expired = DB::table('orders')
        //     ->whereRaw('TIMESTAMPDIFF(HOUR, updated_at, NOW()) > 24')
        //     ->get();

            $idsToShowReturn = DB::table('orders')
                ->select('id')
                ->where(function ($query) {
                    $query->where('status', '=', 5);
                })
                ->whereRaw('TIMESTAMPDIFF(HOUR, updated_at, NOW()) < 24')
                ->get();

        // dd($idsToShowReturn);




        return view('frontend.orders.view', compact('orders','bank','madeOrders','dataSlip','dataRequest','deposit','idsToShowReturn'));
    }

    public function updateorder(Request $request, $id)
    {
        $orders = Order::find($id);
        $orders->status = $request->input('order_status');
        $orders->update();


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

        $order = DB::table('order_items')
        ->leftJoin('products', 'order_items.prod_id', '=', 'products.id')
        ->where('order_items.order_id',$id)
        ->get();

        $mail = User::find($madeOrders[0]->user_id);

          $v = substr($orders->order_code, 0, 3);
          if ($v == "Ord") {  // เช็คว่าเป็นสั่งซื้อ

              $text1 =  "สั่งซื้อภาพ";
              $text2 =  "ประเภทการสั่งซื้อ ".$order[0]->name;
              if ($request->input('order_status') == "5") {
                $text6 =  "สถานะการรับของ  ยืนยันรับของ";
            }else{
                $text6 =  "สถานะการรับของ  ปฏิเสธการรับของ";
            }
          }else { // สั่งทำ

              $text1 =  "สั่งทำภาพ";
              $text2 =  "รหัสสินค้าสั่งทำ". $madeOrders[0]->name;
            if ($request->input('order_status') == "10") {
                $text6 =  "สถานะการรับของ  ยืนยันรับของ";
            }else{
                $text6 =  "สถานะการรับของ  ปฏิเสธการรับของ";
            }
          }


        $text3 =  "รหัสสินค้าสั่งทำ". $madeOrders[0]->order_code;
        $text4 =  "ราคา  ".$madeOrders[0]->total_price." บาท";
        $text5 =  "เลขรหัสขนส่ง ".$madeOrders[0]->tracking_no;
        $text7 =  NULL;
        $text8 =  NULL;
        $text9 =  NULL;
        $text10 = NULL;
        $data = [$text1,$text2,$text3,$text4,$text5,$text6,$text7,$text8,$text9,$text10];
        $customer_mailAdminController = app(MailController::class);
        $customer_mailAdminController->customer_mail($mail->email ,$data);
        $customer_mailAdminController->index($data);


        return redirect('/view-order/'.$id)->with('status', "คำสั่งซื้ออัพเดทสถานะสำเร็จ");
    }


    public function priceOrdersCalculate(Request $request) {

        $ordersText = $request->input('ordersText');
        $qtyValue = $request->input('qtyValue');


        $data = DB::table('order_items')
        ->leftJoin('products', 'order_items.prod_id', '=', 'products.id')
        ->where('order_items.order_id',$ordersText)
        ->get();



        if ($data[0]->original_price == $data[0]->selling_price) {
            $original = $data[0]->original_price * $qtyValue;
            return response()->json(['price' =>  $original]);
        } else {
            $selling = $data[0]->selling_price * $qtyValue;
            return response()->json(['price' => $selling]);
        }

    }


    public function update(Request $request ,$id) {


        $statusRequest = User::find($id);
        $statusRequest->role_as = $request->input('status_user');
        $statusRequest->update();

        return redirect('/users')->with('status', "เปลี่ยนสถานะผู้ใช้งานสำเร็จ");
    }







}