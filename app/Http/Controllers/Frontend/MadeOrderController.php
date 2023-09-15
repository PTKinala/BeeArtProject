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



        // ส่วนของการส่งเมล์

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
        $text1 =  "รายละเอียดการ   ".$dataType[0]->name;
        $text2 =  "ขนาดของภาพ   ".$dataType[0]->size_image_cm;


        $data = [$text,$text1,$text2,$dataType[0]->paper,$dataType[0]->color_type,
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
        $madeOrders = DB::table('orders')
        ->leftJoin('made_orders', 'orders.id', '=', 'made_orders.id_order')
        ->leftJoin('images_types', 'made_orders.id_image_type', '=', 'images_types.id')
        ->leftJoin('images_sizes', 'made_orders.size', '=', 'images_sizes.id')
        ->leftJoin('colors_types', 'made_orders.color', '=', 'colors_types.id')
        ->select('orders.*', 'made_orders.id AS made_orders_id','made_orders.description','made_orders.image',
        'made_orders.id_image_type', 'made_orders.size', 'made_orders.number_peo', 'made_orders.color',
        'made_orders.description','made_orders.status_e_d'
        ,'images_types.name','images_sizes.paper',
        'images_sizes.size_image_cm','colors_types.color_type')
        ->where('orders.id',$id)
        ->get();



        $data = DB::table('images_types')
        ->leftJoin('images_sizes', 'images_types.id', '=', 'images_sizes.id_image_type')
        ->select('images_types.*', 'images_sizes.id AS size_id' ,'images_sizes.paper','images_sizes.size_image_cm')
        ->where('images_types.id', $madeOrders[0]->id_image_type);

       if ($id != 4 ) {
        $data = $data
        ->orderBy('images_sizes.paper','asc')->get();

       }else{
        $data = $data
        ->orderBy('images_types.created_at','asc')->get();

       }



       $dataColor = DB::table('images_types')
        ->leftJoin('colors_types', 'images_types.id', '=', 'colors_types.id_image_type')
        ->select('images_types.*', 'colors_types.id AS color_id' ,'colors_types.color_type')
        ->where('images_types.id', $madeOrders[0]->id_image_type)
        ->orderBy('colors_types.color_type','asc')
        ->get();
        $number_peo_data = null;
        if ($madeOrders[0]->id_image_type == 2 ) {
            $number_peo_data =  DB::table('number_people')->get();
        }


        return view('frontend.orders.edit_made_orders',compact('data','number_peo_data','dataColor','madeOrders'));
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

         /* dd($request['number_peo']); */

         $validated = $request->validate([
            'image' => [ 'image', 'mimes:jpg,png,jpeg,webp'],
            'id_image_type' => ['required', 'string', 'max:255'],
            'size' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        // สร้าง Order

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

        // รายละเอียดสินค้าสั่งทำ

        //dd($request->all());
        $madeOrder = MadeOrder::where('id_order', $id)->get();


        $member = MadeOrder::find($madeOrder[0]->id);
        $member->id_image_type = $request['id_image_type'];
        $member->size = $request['size'];
        $member->number_peo = $request['number_peo'];
        $member->color = $request['color'];
        $member->description = $request['description'];

        // image
        if ($request->hasFile('image')) {
            $rand_number =  rand(1111,9999);
            $image_path = public_path() . '/assets/uploads/madeOrder/' .  $madeOrder[0]->image;
            if (file_exists($image_path)) {
                unlink($image_path);
            }

            $image = $request->file('image');
            $data =   $image->move(public_path() . '/assets/uploads/madeOrder', $rand_number . $image->getClientOriginalName());
            $member->image =  $rand_number . $image->getClientOriginalName();
        }



        $member->save();



        // ส่วนของการส่งเมล์

        $dataType = DB::table('images_types')
        ->leftJoin('images_sizes', 'images_types.id', '=', 'images_sizes.id_image_type')
        ->leftJoin('colors_types', 'images_types.id', '=', 'colors_types.id_image_type')
        ->select('images_types.*', 'images_sizes.id AS size_id' ,'images_sizes.paper',
        'images_sizes.size_image_cm','colors_types.color_type')
        ->where('images_types.id', $request['id_image_type'])
        ->where('images_sizes.id', $request['size'])
        ->where('colors_types.id', $request['color'])
        ->get();


        $text =  "เเก้ไขการ สั่งทำภาพ";
        $text1 =  "รายละเอียดการเเก้ไข   ".$dataType[0]->name;



        $data = [$text,$text1,$dataType[0]->size_image_cm,$dataType[0]->paper,$dataType[0]->color_type,
        $request['number_peo'],$request['description'] ,$request->input('fname'),$request->input('lname'),$request->input('phone')];

        $mailController = app(MailController::class);
        $mailController->index($data);


        return redirect('/view-order/'.$id)->with('status', "Edit an order Successfully");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDestory($id)
    {

        $madeOrder = MadeOrder::where('id_order', $id)->get();


        $member = MadeOrder::find($madeOrder[0]->id);
        $member->status_e_d = "2";
        $member->save();
        return redirect('/view-order/'.$id)->with('status', "Cancel Order Successfully");
    }

    public function destroy($id)
    {

    }
}
