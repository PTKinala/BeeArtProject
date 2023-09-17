<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function users()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function viewuser($id)
    {
        $users = User::find($id);
        return view('admin.users.view', compact('users'));
    }
    public function graphOrderSale()
    {


        $total_month = DB::table('orders')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->select(
            DB::raw('MONTH(orders.created_at) as month'),
            DB::raw('SUM(orders.total_price) as total_price')
        )
        ->groupBy(DB::raw('MONTH(orders.created_at)'))
        ->get();


        return response()->json(['total_month' => $total_month]);


       /*  graph-order-sale
        $users = User::find($id);
        return view('admin.users.view', compact('users')); */
    }
}
