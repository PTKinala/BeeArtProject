<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Bank;
use App\Models\OrderItem;
use App\Models\Address;
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

        foreach($cartitems as $item)
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
        $text2 =  "ราคารวม  ".$total;
        $text3 =  "รายละเอียด  ". implode(', ', $Description);
        $text4 =  "ชื่อ  ".$request->input('fname')."  ".$request->input('lname');
        $text5 =  "ที่อยู่จัดส่ง   ".$request->input('address1');
        $text6 =  "เบอร์ติดต่อ   ".$request->input('phone');
        $text7 =  NULL;
        $text8 =  NULL;
        $text9 =  NULL;



        $data = [$text,$text1,$text2,$text3,$text4,$text5,$text6,$text7,$text8,$text9];

        $mailController = app(MailController::class);
        $mailController->index($data);
        $mailUserController = app(MailController::class);
        $mailUserController->mailUser($data);
/**
 * ! 80-93 ทำไม
 */
        /* if(Auth::user()->address1 == NULL)
        {
            $user = User::where('id', Auth::id())->first();
            $user->name = $request->input('fname');
            $user->lname = $request->input('lname');
            $user->phone = $request->input('phone');
            $user->address1 = $request->input('address1');
            $user->address2 = $request->input('address2');
            $user->city = $request->input('city');
            $user->state = $request->input('state');
            $user->country = $request->input('country');
            $user->pincode = $request->input('pincode');
            $user->update();
        } */

        $cartitems = Cart::where('user_id', Auth::id())->get();
        Cart::destroy($cartitems);
        //$orderId
        return redirect('/view-order/'.$orderId)->with('status', "Order placed Successfully");

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
        /**
         * ! ยังไม่สามารถเเก้ไขจำนวนกับราคาได้
          */
   /*      $order =  OrderItem::find($data[0]->id);
        $order->price = $request->input('price');
        $order->qty = $request->input('qty');
        $order->save(); */


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


        $text =  "เเก้ไข รายการสั่งซื้อ " .implode(', ', $Order_list);;
        $text1 =  "รายการสั่งซื้อเลขที่  " .$id;
        $text2 =  "ราคารวม  ".$total;
        $text3 =  "รายละเอียด  ". implode(', ', $Description);
        $text4 =  "ชื่อ  ".$request->input('fname')."  ".$request->input('lname');
        $text5 =  "ที่อยู่จัดส่ง   ".$request->input('address1');
        $text6 =  "เบอร์ติดต่อ   ".$request->input('phone');
        $text7 =  NULL;
        $text8 =  NULL;
        $text9 =  NULL;



        $data = [$text,$text1,$text2,$text3,$text4,$text5,$text6,$text7,$text8,$text9];

        $mailController = app(MailController::class);
        $mailController->index($data);

        return redirect('/view-order/'.$id)->with('status', "Order update Successfully");
    }

    function destory($id)  {

     /*    $orderId =   DB::table('order_items')
        ->where('order_id',$id)
        ->get(); */

        $order =  Order::find($id);
        $order->cancel_order = "1";
        $order->save();

        return redirect('/view-order/'.$id)->with('status', "Order cancel_order Successfully");
    }
}