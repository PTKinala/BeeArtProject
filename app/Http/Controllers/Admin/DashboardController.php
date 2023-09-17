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
        $currentYear = date('Y'); // ดึงปีปัจจุบัน


        $total_month = DB::table('orders')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->select(
            DB::raw('MONTH(orders.created_at) as month'),
            DB::raw('SUM(orders.total_price) as total_price')
        )
        ->whereYear('orders.created_at', $currentYear) // กรองตามปีปัจจุบัน
        ->groupBy(DB::raw('MONTH(orders.created_at)'))
        ->get();
        return response()->json(['total_month' => $total_month]);



    }
    public function graphSalesHire()
    {
        $currentYear = date('Y'); // ดึงปีปัจจุบัน


        $total_month = DB::table('orders')
        ->join('made_orders', 'orders.id', '=', 'made_orders.id_order')
        ->select(
            DB::raw('MONTH(orders.created_at) as month'),
            DB::raw('SUM(orders.total_price) as total_price')
        )
        ->whereYear('orders.created_at', $currentYear) // กรองตามปีปัจจุบัน
        ->groupBy(DB::raw('MONTH(orders.created_at)'))
        ->get();

        return response()->json(['total_month' => $total_month]);



    }
}