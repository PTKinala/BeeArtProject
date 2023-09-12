<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        return view('frontend.orders.view', compact('orders','bank'));
    }
}