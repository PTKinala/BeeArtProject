<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Bank;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\MadeOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MailController;

class CheckoutController extends Controller
{
    public function index()
    {
        $oldcartitems = Cart::where('user_id', Auth::id())->get();

        foreach ($oldcartitems as $item)
        {
            if(!Product::where('id', $item->prod_id)->where('qty','>=',$item->prod_qty)->exists()){
                $removeItem = Cart::where('user_id',Auth::id())->where('prod_id', $item->prod_id)->first();
                $removeItem->delete();
            }
        }
        $cartitems = Cart::where('user_id', Auth::id())->get();

        $bank = Bank::get();
        $dataAddress = Address::where('id_user', Auth::id())->get();

        return view('frontend.checkout', compact('cartitems','bank','dataAddress'));
    }

    public function placeorder(Request $request)
    {

        $rand_code_ord =  "Ord-".rand(111111,999999);
        $order = new Order();
        $order->user_id = Auth::id();
        $order->order_code = $rand_code_ord;
        $order->fname = $request->input('fname');
        $order->lname = $request->input('lname');
        $order->email = $request->input('email');
        $order->phone = $request->input('phone');
        $order->address1 = $request->input('address1');
        $order->road = $request->input('road');
        $order->subdistrict = $request->input('subdistrict');
        $order->district = $request->input('district');
        $order->province = $request->input('province');
        $order->zipcode = $request->input('zipcode');

        //placeorder

        // To calculate the total price
        $total = 0;
        $cartitems_total = Cart::where('user_id', Auth::id())->get();


        $Order_list = [];
        $Description = [];
        foreach($cartitems_total as $prod)
        {
            $product_name = $prod->products->name; // ดึงชื่อสินค้า
            $product_description = $prod->products->description; // ดึงชื่อสินค้า
            $Order_list[] = $product_name;
            $Description[] = $product_description;

            $total += $prod->products->selling_price * $prod->prod_qty;
        }


        $order->total_price = $total;

        $order->tracking_no = NULL;
        $order->save();

        $orderId = $order->id;

        foreach($cartitems_total as $item)
        {
            OrderItem::create([
                'order_id' => $orderId,
                'prod_id' => $item->prod_id,
                'qty' => $item->prod_qty,
                'price' => $item->products->selling_price,
            ]);

            $prod = Product::where('id', $item->prod_id)->first();
            $prod->qty = $prod->qty - $item->prod_qty;
            $prod->update();
        }

        // ส่วนของการส่งเมล์



        $text =  "รายการสั่งซื้อ " .implode(', ', $Order_list);;
        $text1 =  "รหัสการสั่งซื้อ " .$rand_code_ord;
        $text2 =  "ราคารวม  ".$total." บาท";
        $text3 =  "รายละเอียดการจัดส่ง";
        $text4 =  "ชื่อ  ".$request->input('fname')." ".$request->input('lname');
        $text5 =  "ที่อยู่จัดส่ง   ".$request->input('address1')." ".$request->input('road');
        $text6 =  $request->input('subdistrict')." ".$request->input('district');
        $text7 =  $request->input('province')." ".$request->input('zipcode');
        $text8 =  "เบอร์ติดต่อ   ".$request->input('phone');
        $text9 =  NULL;
        $gmail = Auth::user()->email;

        $data = [$text,$text1,$text2,$text3,$text4,$text5,$text6,$text7,$text8,$text9];

        $customer_mailController = app(MailController::class);
        $customer_mailController->customer_mail($gmail,$data);
        $customer_mailController->index($data);


        $save_address = Address::where('id_user', Auth::id())->get();

        if(count($save_address) == '0')
        {
            $address =  new Address;
            $address->id_user = Auth::id();
            $address->fname = $request->input('fname');
            $address->lname = $request->input('lname');
            $address->address = $request->input('address1');
            $address->road = $request->input('road');
            $address->subdistrict = $request->input('subdistrict');
            $address->district = $request->input('district');
            $address->province = $request->input('province');
            $address->zipcode = $request->input('zipcode');
            $address->phone = $request->input('phone');
            $address->save();
        }

        $cartitems = Cart::where('user_id', Auth::id())->get();
        Cart::destroy($cartitems);
        //$orderId
        return redirect('/view-order/'.$orderId)->with('status', "ยืนยันการสั่งซื้อเรียบร้อยแล้ว");

    }

    function itemOrders($id)  {
        $orders = Order::where('id', $id)->where('user_id',Auth::id())->first();
        $bank = Bank::get();



        return view('frontend.orders.edit_item_orders',compact('orders','bank'));
    }

    function updateItemOrders(Request $request ,$id)  {

        $order =  Order::find($id);
        $order->fname = $request->input('fname');
        $order->lname = $request->input('lname');
        $order->email = $request->input('email');
        $order->phone = $request->input('phone');
        $order->address1 = $request->input('address1');
        $order->road = $request->input('road');
        $order->subdistrict = $request->input('subdistrict');
        $order->district = $request->input('district');
        $order->province = $request->input('province');
        $order->zipcode = $request->input('zipcode');
       /*  $order->total_price = $request->input('price'); */
        $order->save();


        // ส่วนของการส่งเมล์  price qty

        $data = DB::table('order_items')
        ->where('order_id',$id)
        ->get();

        $total = 0;

        $cartitems_total = Cart::where('user_id', Auth::id())->get();

        $Order_list = [];
        $Description = [];
        foreach($cartitems_total as $prod)
        {
           $Order_list[] = $product_name;
            $Description[] = $product_description;

            $total += $prod->products->selling_price * $prod->prod_qty;
        }

        $text =  "เเก้ไขที่อยู่การจัดส่ง " .implode(', ', $Order_list);;
        $text1 =  "รายการสั่งซื้อเลขที่ " .$id;
        $text2 =  "รายละเอียดการจัดส่ง";
        $text3 =  "ชื่อ  ".$request->input('fname')." ".$request->input('lname');
        $text4 =  "ที่อยู่จัดส่ง   ".$request->input('address1')." ".$request->input('road');
        $text5 =  $request->input('subdistrict')." ".$request->input('district');
        $text6 =  $request->input('province')." ".$request->input('zipcode');
        $text7 =  "เบอร์ติดต่อ   ".$request->input('phone');
        $text8 =  NULL;
        $text9 =  NULL;
        $gmail = Auth::user()->email;

        $data = [$text,$text1,$text2,$text3,$text4,$text5,$text6,$text7,$text8,$text9];

        $customer_mailController = app(MailController::class);
        $customer_mailController->customer_mail($gmail,$data);
        $customer_mailController->index($data);
        // $mailController = app(MailController::class);
        // $mailController->index($data);
        // $customer_mailController = app(MailController::class);
        // $customer_mailController->customer_mail($data);
            // $product_name = $prod->products->name; // ดึงชื่อสินค้า
            // $product_description = $prod->products->description; // ดึงชื่อสินค้า

            
        return redirect('/view-order/'.$id)->with('status', "แก้ไขรายการสั่งซื้อเรียบร้อยแล้ว");
    }

    function destory($id)  {

        $order =  Order::find($id);
        $order->cancel_order = "1";
        $order->save();

        $v = substr($order->order_code, 0, 3);
        if ($v == "Ord") {  // เช็คว่าเป็นสั่งซื้อ
            $orderitem = OrderItem::where('order_id',$id)->get();
            $product = Product::where('id',$orderitem[0]->prod_id)->get();
            if ($product) {
                $affected = DB::table('products')
                  ->where('id', $product[0]->id)
                  ->update(['qty' => intval($orderitem[0]->qty) + intval($product[0]->qty)]);
            }
        }

        return redirect('/view-order/'.$id)->with('status', "ยกเลิกรายการสั่งซื้อเรียบร้อยแล้ว");
    }
}