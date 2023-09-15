<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MadeOrder;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MailController;

class MadeOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function someMethod($data)
    {

        $data  = ["สั่งวาดรูปขาว ดำ"," 50*80","A4"];
        // ใช้ Controller Dependency Injection เพื่อเรียกใช้ MailController@index
        $mailController = app(MailController::class);
        return $mailController->index($data);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        /* dd($request['number_peo']); */

        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg,webp'],
            'id_image_type' => ['required', 'string', 'max:255'],
            'size' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        // สร้าง Order

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
        $order->total_price = NULL;
        $order->message = NULL;
        $order->tracking_no = 'tno.'.rand(1111,9999);
        $order->save();

        // รายละเอียดสินค้าสั่งทำ
        $orderId = $order->id;
        //dd($request->all());
        $member = new MadeOrder;
        $member->id_order =  $orderId;
        $member->id_image_type = $request['id_image_type'];
        $member->size = $request['size'];
        $member->number_peo = $request['number_peo'];
        $member->color = $request['color'];
        $member->description = $request['description'];
        $member->status_e_d = 0;
        $rand_number =  rand(1111,9999);
        // image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data =   $image->move(public_path() . '/assets/uploads/madeOrder', $rand_number . $image->getClientOriginalName());
            $member->image =  $rand_number . $image->getClientOriginalName();
        }



        $member->save();


        $dataType = DB::table('images_types')
        ->leftJoin('images_sizes', 'images_types.id', '=', 'images_sizes.id_image_type')
        ->leftJoin('colors_types', 'images_types.id', '=', 'colors_types.id_image_type')
        ->select('images_types.*', 'images_sizes.id AS size_id' ,'images_sizes.paper',
        'images_sizes.size_image_cm','colors_types.color_type')
        ->where('images_types.id', $request['id_image_type'])
        ->where('images_sizes.id', $request['size'])
        ->where('colors_types.id', $request['color'])
        ->get();

        $text =  "สั่งทำภาพ";

        $data = [$text,$dataType[0]->name,$dataType[0]->size_image_cm,$dataType[0]->paper,$dataType[0]->color_type,
        $request['number_peo'],$request['description'] ,$request->input('fname'),$request->input('lname'),$request->input('phone')];

        $mailController = app(MailController::class);
        $mailController->index($data);


        return redirect('/view-order/'.$orderId)->with('status', "Order placed Successfully");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
