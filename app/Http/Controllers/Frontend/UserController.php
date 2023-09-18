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
        ->join('colors_types', 'made_orders.color', '=', 'colors_types.id')
        ->select('orders.*', 'made_orders.id AS made_orders_id','made_orders.description','made_orders.image',
        'made_orders.description'
        ,'images_types.name','images_sizes.paper',
        'images_sizes.size_image_cm','colors_types.color_type')
        ->where('orders.id',$id)
        ->get();

        $dataSlip = DB::table('slips')
        ->where('idOrder', $id)
        ->get();


        $dataRequest = DB::table('request_returns')
        ->where('idOrder', $id)
        ->get();


        $dataDeposit = DB::table('deposit_price')
        ->get();
        $deposit =  $dataDeposit[0]->deposit;



        return view('frontend.orders.view', compact('orders','bank','madeOrders','dataSlip','dataRequest','deposit'));
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

        return redirect('/users')->with('status', "role_as update Successfully");
    }


}