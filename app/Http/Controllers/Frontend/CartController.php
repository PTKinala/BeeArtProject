<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addProduct(Request $request)
    {
        $product_id = $request->input('product_id');
        $product_qty = $request->input('product_qty');

        if (Auth::check())
        {
            $prod_check = Product::where('id',$product_id)->first();

            if ($prod_check)
            {
                if (Cart::where('prod_id',$product_id)->where('user_id',Auth::id())->exists())
                {
                    return response() -> json(['status' => "error", "message" => $prod_check->name."  Already Added to cart"]);
                }
                else
                {
                    $cartitem = new Cart();
                    $cartitem->prod_id = $product_id;
                    $cartitem->user_id = Auth::id();
                    $cartitem->prod_qty = $product_qty;
                    $cartitem->save();





                    return response() -> json(['status' => "success", "message" => $prod_check->name." Added to cart"  ]);
                }
            }
        }
        else
        {
            return response() -> json(['status' => "error", "message" => "กรุณาเข้าสู่ระบบ"]);
        }
    }

    public function viewCart()
    {
        $cartitems = Cart::where('user_id', Auth::id())->get();
        return view('frontend.cart', compact('cartitems'));
    }

    public function deleteproduct(Request $request)
    {
        if (Auth::check())
        {
            $prod_id = $request->input('prod_id');
            if (Cart::where('prod_id', $prod_id)->where('user_id', Auth::id())->exists())
            {
                $cartItem = Cart::where('prod_id',$prod_id)->where('user_id', Auth::id())->first();
                $cartItem->delete();
                return response() -> json(['status' => "ลบสินค้าเรียบร้อยแล้ว"]);
            }
        }
        else
        {
            return response() -> json(['status' => "กรุณาเข้าสู่ระบบ"]);
        }
    }

    public function updatecart(Request $request)
    {
        $prod_id = $request->input('prod_id');
        $prod_qty = $request->input('prod_qty');

        if(Auth::check())
        {
            if (Cart::where('prod_id', $prod_id)->where('user_id', Auth::id())->exists())
            {
                $cart = Cart::where('prod_id', $prod_id)->where('user_id', Auth::id())->first();
                $cart->prod_qty = $prod_qty;
                $cart->update();
                return response()->json(['status'=>"Quantity updated"]);
            }
        }
    }

    public function cartcount()
    {
        $cartcount = Cart::where('user_id', Auth::id())->count();
        return response()->json(['count' => $cartcount]);
    }



}