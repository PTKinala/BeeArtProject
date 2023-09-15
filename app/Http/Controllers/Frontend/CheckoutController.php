<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Bank;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        return view('frontend.checkout', compact('cartitems','bank'));
    }

    public function placeorder(Request $request)
    {


        $order = new Order();
        $order->user_id = Auth::id();
        $order->fname = $request->input('fname');
        $order->lname = $request->input('lname');
        $order->email = $request->input('email');
        $order->phone = $request->input('phone');
        $order->address1 = $request->input('address1');
        $order->address2 = $request->input('address2');
        $order->city = $request->input('city');
        $order->state = $request->input('state');
        $order->country = $request->input('country');
        $order->pincode = $request->input('pincode');

        //placeorder

        // To calculate the total price
        $total = 0;
        $cartitems_total = Cart::where('user_id', Auth::id())->get();
        foreach($cartitems_total as $prod)
        {
            $total += $prod->products->selling_price;
        }

        $order->total_price = $total;

        $order->tracking_no = NULL;
        $order->save();
        $orderId = $order->id;
        $cartitems = Cart::where('user_id', Auth::id())->get();
        foreach($cartitems as $item)
        {
            OrderItem::create([
                'order_id' => $order->id,
                'prod_id' => $item->prod_id,
                'qty' => $item->prod_qty,
                'price' => $item->products->selling_price,
            ]);

            $prod = Product::where('id', $item->prod_id)->first();
            $prod->qty = $prod->qty - $item->prod_qty;
            $prod->update();
        }
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
        $order->address2 = $request->input('address2');
        $order->city = $request->input('city');
        $order->state = $request->input('state');
        $order->country = $request->input('country');
        $order->pincode = $request->input('pincode');
        $order->save();
        return redirect('/view-order/'.$id)->with('status', "Order update Successfully");
    }

    function destory($id)  {

        $orderId =   DB::table('order_items')
        ->where('order_id',$id)
        ->get();

        $order =  OrderItem::find($orderId);
        $order->cancel_order = "2";
        $order->save();

        return redirect('/view-order/'.$id)->with('status', "Order destory Successfully");
    }
}
