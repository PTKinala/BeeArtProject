<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MadeOrder;
use App\Models\Order;
use App\Models\Address;
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
        $validated = $request->validate([
            'image.*' => ['required', 'image', 'mimes:jpg,png,jpeg,webp'],
            'id_image_type.*' => ['required', 'string', 'max:255'],
            'size.*' => ['required', 'string', 'max:255'],
            'color.*' => ['required', 'string', 'max:255'],
            'description.*' => ['required', 'string', 'max:255'],
        ]);

        // สร้าง Order
        $rand_code_ord =  "Made-Ord-".rand(111111,999999);
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
        $order->total_price = NULL;
        $order->message = NULL;
        $order->tracking_no = NULL;
        $order->save();

        // รายละเอียดสินค้าสั่งทำ
        $orderId = $order->id;



        $id_image_types = $request['id_image_type'];
        $descriptions = $request['description'];
        $sizes = $request['size'];
        $colors = $request['color'];
        $images = $request->file('image');

            // วนลูปผ่านข้อมูลแต่ละรายการ
            foreach ($id_image_types as $key => $id_image_type) {
                $member = new MadeOrder;
                $member->id_order = $orderId;
                $member->id_image_type = $id_image_type;
                $member->description = $descriptions[$key];
                $member->size = $sizes[$key];
                $member->color = $colors[$key];

                // การอัปโหลดไฟล์ภาพ
                if (isset($images[$key]) && $images[$key]->isValid()) {
                    $rand_number = rand(1111, 9999);
                    $image = $images[$key];
                    $imagePath = public_path() . '/assets/uploads/madeOrder';
                    $imageName = $rand_number . $image->getClientOriginalName();
                    $image->move($imagePath, $imageName);
                    $member->image = $imageName;
                }

                $member->save();
            }





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


        // สั่ง email ให้ user
        $gmail = Auth::user()->email;
        $text =  "สั่งทำภาพ  ".$rand_code_ord;
        $text1 =  "รายละเอียด  ".$dataType[0]->name;
        $text2 =  "ขนาดของภาพ   ".$dataType[0]->size_image_cm;
        $text3 =  "กระดาษ   ".$dataType[0]->paper;
        $text4 =  "สี   ".$dataType[0]->color_type;
        $text5 =  "รายละเอียดเพิ่มเติม    ".NULL;
        $text6 =  NULL;
        $text7 =  NULL;
        $text8 =  NULL;
        $text9 =  NULL;
        $data = [$text,$text1,$text2,$text3,$text4,$text5,$text6,$text7,$text8,$text9];
        $customer_mailController = app(MailController::class);
        $customer_mailController->customer_mail( $gmail,$data);



        // สั่ง email ให้ admin
        $textAdmin1 =  "สั่งทำภาพ";
        $textAdmin2 =  "ประเภทการสั่งทำ".$dataType[0]->name;
        $textAdmin3 =  "รหัสสินค้าสั่งทำ". $rand_code_ord;
        $textAdmin4 =  "ราคาประเมิน ";
        $textAdmin5 =  "สถานะ   รอการประเมินราคา";
        $textAdmin6 =  "ชื่อ   ".$request->input('fname')." ".$request->input('lname');
        $textAdmin7 =  "เบอร์ติดต่อ   ".$request->input('phone');
        $textAdmin8 =  NULL;
        $textAdmin9 =  NULL;
        $textAdmin10 = NULL;
        $dataAdmin = [$textAdmin1,$textAdmin2,$textAdmin3,$textAdmin4,$textAdmin5,$textAdmin6,$textAdmin7,$textAdmin8,$textAdmin9,$textAdmin10];
        $customer_mailAdminController = app(MailController::class);
        $customer_mailAdminController->index($dataAdmin);

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


        return redirect('/view-order/'.$orderId)->with('status', "ยืนยันการสั่งทำภาพเรียบร้อยแล้ว");

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
        'made_orders.description'
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
        /* $number_peo_data = null;
        if ($madeOrders[0]->id_image_type == 2 ) {
            $number_peo_data =  DB::table('number_people')->get();
        }
 */

        return view('frontend.orders.edit_made_orders',compact('data','dataColor','madeOrders'));
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
            'image.*' => [ 'image', 'mimes:jpg,png,jpeg,webp'],
            'id_image_type.*' => ['required', 'string', 'max:255'],
            'size.*' => ['required', 'string', 'max:255'],
            'color.*' => ['required', 'string', 'max:255'],
            'description.*' => ['required', 'string', 'max:255'],
        ]);

        // สร้าง Order


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
        $order->save();

        // รายละเอียดสินค้าสั่งทำ

        //dd($request->all());
        $madeOrder = MadeOrder::where('id_order', $id)->get();

        $id_image_types = $request['id_image_type'];
        $descriptions = $request['description'];
        $sizes = $request['size'];
        $colors = $request['color'];
        $images = $request->file('image');

            // วนลูปผ่านข้อมูลแต่ละรายการ
            foreach ($id_image_types as $key => $id_image_type) {


                $member = MadeOrder::find($madeOrder[$key]->id);
                $member->id_image_type =  $id_image_types[$key];
                $member->size = $sizes[$key];
                $member->number_peo = NULL;
                $member->color = $colors[$key];
                $member->description = $descriptions[$key];

                // image
                if (isset($images[$key]) && $images[$key]->isValid()) {
                    $image_path = public_path() . '/assets/uploads/madeOrder/' .  $madeOrder[$key]->image;
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                    $rand_number = rand(1111, 9999);
                    $image = $images[$key];
                    $imagePath = public_path() . '/assets/uploads/madeOrder';
                    $imageName = $rand_number . $image->getClientOriginalName();
                    $image->move($imagePath, $imageName);
                    $member->image = $imageName;
                }


                $member->save();
            }






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

        $gmail = Auth::user()->email;
        $text =  "เเก้ไขการ สั่งทำภาพ";
        $text1 =  "รายละเอียดการเเก้ไข   ".$dataType[0]->name;
        $text2 =  "ขนาดของภาพ   ".$dataType[0]->size_image_cm;
        $text3 =  "กระดาษ   ".$dataType[0]->paper;
        $text4 =  "สี   ".$dataType[0]->color_type;
        $text5 =  "จำนวนคน(เฉพาะภาพเหมือน)   ".$request['number_peo'];
        $text6 =  "รายละเอียดเพิ่มเติม    ".NULL;
        $text7 =  "ชื่อ   ".$request->input('fname');
        $text8 =  "   ".$request->input('lname');
        $text9 =  "เบอร์ติดต่อ   ".$request->input('phone');



        $data = [$text,$text1,$text2,$text3,$text4,$text5,$text6,$text7,$text8,$text9];

        $customer_mailController = app(MailController::class);
        $customer_mailController->customer_mail($gmail, $data);
        $customer_mailController->index($data);
        // $mailController = app(MailController::class);
        // $mailController->index($data);




        return redirect('/view-order/'.$id)->with('status', "แก้ไขการสั่งทำภาพเรียบร้อยแล้ว");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDestory($id)
    {

    /*     $madeOrder = MadeOrder::where('id_order', $id)->get();
 */

        $member = Order::find($id);
        $member->status_e_d = "1";
        $member->save();
        return redirect('/view-order/'.$id)->with('status', "ยกเลิกการสั่งทำภาพเรียบร้อยแล้ว");
    }

    public function destroy($id)
    {

    }
}