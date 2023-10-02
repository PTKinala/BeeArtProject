<?php

namespace App\Http\Controllers\frontend;

use App\Models\Product;
use App\Models\Category;
use App\Models\ImagesType;
use App\Models\Slip;
use App\Models\Address;
use App\Models\Order;
use App\Models\RequestReturn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    public function index()
    {

        $this->cancelOrder();

        $featured_products = Product::where('trending', '1')->take(10)->get();
        $popular_category = Category::where('popular', '1')->take(6)->get();
        $image_type = ImagesType::where('status', 1)->get();

        return view('frontend.index', compact('featured_products', 'popular_category' ,'image_type'));
    }

    public function shop()
    {
        $category = Category::where('status','1')->get();

        return view('frontend.shop', compact('category'));
    }

    public function viewcategory($slug)
    {
        if(Category::where('slug', $slug)->exists())
        {
            $category = Category::where('slug', $slug)->first();
            $products = Product::where('cate_id', $category->id)->where('status','1')->get();
            return view('frontend.products.index', compact('category', 'products'));
        }
        else{
            return redirect('shop')->with('status', 'category doesnot exist');
        }
    }

    public function viewproduct($cate_slug, $prod_slug)
    {
        if(Category::where('slug', $cate_slug)->exists())
        {
            if (Product::where('slug', $prod_slug)->exists()) {
                $products = Product::where('slug', $prod_slug)->first();
                return view('frontend.products.view', compact('products'));
            }
            else {
                return redirect('/')->with('status', 'the link was broken product not found');
            }
        }
        else {
            return redirect('/')->with('status', 'the link was broken category not found');
        }
    }

    function makeArt() {

        $image_type = ImagesType::where('status', 1)->get();

        return view('frontend.make_art',compact('image_type'));
    }

    function makeArtBuy($id) {


            $data = DB::table('images_types')
            ->leftJoin('images_sizes', 'images_types.id', '=', 'images_sizes.id_image_type')
            ->select('images_types.*', 'images_sizes.id AS size_id' ,'images_sizes.paper','images_sizes.size_image_cm')
            ->where('images_types.id', $id);

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
            ->where('images_types.id', $id)
            ->orderBy('colors_types.color_type','asc')
            ->get();
            $number_peo = null;


            $dataAddress = Address::where('id_user', Auth::id())->get();


           return view('frontend.make_art_buy',compact('data','dataColor','number_peo','dataAddress'));

    }


    public function uploaderSlip($id)
    {
        $order_status = Order::find($id);
        $v_code = substr($order_status->order_code, 0, 3);
        $order = [];
        $made_order = [];
        $deposit = DB::table('deposit_price')->get();
        $dataSlipCount = DB::table('slips')
        ->where('idOrder', $id)
        ->where('status_slip', "3")
        ->orderBy('id', 'desc')
        ->get();

        if ($v_code == "Ord") {  // เช็คว่าเป็นสั่งซื้อ
            $order = DB::table('orders')
            ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
            ->leftJoin('products', 'order_items.prod_id', '=', 'products.id')
            ->select('orders.*', 'order_items.price' ,'order_items.qty','products.name')
            ->where('orders.id',$id)
            ->get();
        }else { 
            $made_order = DB::table('orders')
            ->leftJoin('made_orders', 'orders.id', '=', 'made_orders.id_order')
            ->leftJoin('images_types', 'made_orders.id_image_type', '=', 'images_types.id')
            ->leftJoin('images_sizes', 'made_orders.size', '=', 'images_sizes.id')
            ->leftJoin('colors_types', 'made_orders.color', '=', 'colors_types.id')
            ->select('orders.*', 'images_types.name' ,'colors_types.color_type', 'images_sizes.paper','images_sizes.size_image_cm','made_orders.price')
            ->where('orders.id',$id)
            ->get();
        }

        return view('frontend.uploader_slip',compact('id','v_code', 'order', 'made_order','deposit','dataSlipCount'));
    }

    public function store(Request $request)
    {


        $validated = $request->validate([
            'image' => [ 'image', 'mimes:jpg,png,jpeg,webp'],
        ]);


        $member = new Slip;
        $member->idOrder = $request['idOrder'];
        $member->date = $request['date'];
        $member->time = $request['time'];
        $member->price = $request['price'];
        $rand_number =  rand(1111,9999);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data =   $image->move(public_path() . '/assets/uploads/slip', $rand_number . $image->getClientOriginalName());
            $member->image =  $rand_number . $image->getClientOriginalName();
        }

        $member->save();



        $order_status = Order::find($request['idOrder']);


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
        ->where('orders.id',$request['idOrder'])
        ->get();


        $order = DB::table('order_items')
        ->leftJoin('products', 'order_items.prod_id', '=', 'products.id')
        ->where('order_items.order_id',$request['idOrder'])
        ->get();

        $v = substr($order_status->order_code, 0, 3);



        if ($v == "Ord") {  // เช็คว่าเป็นสั่งซื้อ
            $order_status->status =  "1";
            $order_status->full_amount = "on";
            $order_status->save();
            $textAdmin1 =  "สั่งซื้อภาพ";
            $textAdmin2 =  "ประเภทการสั่งทำ".$order[0]->name;
            $textAdmin6 =  "รูปเเบบการโอน   โอนราคาเต็ม";

        }else { // สั่งทำ

            if ($order_status->status < 4) {

                $order_status->status =  "2";
                $order_status->full_amount = $request['full_amount'];
                $order_status->save();
                $textAdmin1 =  "สั่งทำภาพ";
                $textAdmin6 = null;
                if($request['full_amount'] == "on"){
                    $textAdmin6 =  "รูปเเบบการโอน   โอนราคาเต็ม";
                }else{
                    $textAdmin6 =  "รูปเเบบการโอน   โอนมัดจำ";
                }
                $textAdmin2 =  "ประเภทการสั่งทำ".$madeOrders[0]->name;

            }else {
                $textAdmin1 =  "สั่งทำภาพ";
                $order_status->status =  "6";
                $order_status->full_amount = $request['full_amount'];
                $order_status->save();
                $textAdmin2 =  "ประเภทการสั่งทำ".$madeOrders[0]->name;
                $textAdmin6 = null;
                if($request['full_amount'] == "on"){
                    $textAdmin6 =  "รูปเเบบการโอน   โอนราคาเต็ม";
                }else{
                    $textAdmin6 =  "รูปเเบบการโอน   โอนมัดจำ  (ที่ค้างจ่าย)";
                }
            }

        }

        $textAdmin3 =  "รหัสสินค้าสั่งทำ". $madeOrders[0]->order_code;
        $textAdmin4 =  "ราคาประเมิน  ".$madeOrders[0]->total_price." บาท";
        $textAdmin5 =  "จำนวนเงินที่โอน ". $request['price'];


        $textAdmin7 =  "สถานะ   รอตรวจสอบหลักฐานการโอนเงิน";
        $textAdmin8 =  "วันเวลาที่โอน " . $request['date']." ".$request['time'];
        $textAdmin9 =  "ชื่อ   ".$madeOrders[0]->fname." ".$madeOrders[0]->lname;
        $textAdmin10 = "เบอร์ติดต่อ   ".$madeOrders[0]->phone;
        $dataAdmin = [$textAdmin1,$textAdmin2,$textAdmin3,$textAdmin4,$textAdmin5,$textAdmin6,$textAdmin7,$textAdmin8,$textAdmin9,$textAdmin10];
        $customer_mailAdminController = app(MailController::class);
        $customer_mailAdminController->index($dataAdmin);



        return redirect('/view-order/'.$request['idOrder'])->with('status', "เพิ่มหลักฐานการโอนเงินสำเร็จ");
    }


    public function requestReturn(Request $request,$id)
    {
        return view('frontend.request_return' ,compact('id'));
    }


    public function storeRequestReturn(Request $request) {

        $validated = $request->validate([
            'image_order' => [ 'image', 'mimes:jpg,png,jpeg,webp'],
        ]);

        $member = new RequestReturn;
        $member->idOrder = $request['idOrder'];
        $member->bank = $request['bank'];
        $member->bankName = $request['bankName'];
        $member->account_number = $request['account_number'];
        $member->branch = $request['branch'];
        $member->reason = $request['reason'];
        $member->statusRequest = NULL;
        $member->comment = NULL;
        $member->image = NULL;
        if ($request->hasFile('image_order')) {
            $rand_number =  rand(1111,9999);
            $image_order = $request->file('image_order');
            $data =   $image_order->move(public_path() . '/assets/uploads/slip_user', $rand_number . $image_order->getClientOriginalName());
            $member->image_order =  $rand_number . $image_order->getClientOriginalName();
        }
        $member->save();



        $member = Order::find( $request['idOrder']);

        $text =  "คำร้องขอคืนเงิน  ";
        $text2 =  "รหัส Order  ".$member->order_code;
        $text3 =  "จำนวนเงินที่ต้องการคืน  ".$member->total_price;
        $text4 =  "ชื่อ  ".$member->fname .$member->lname;
        $text5 =  "เบอร์ติดต่อ  ".$member->phone;
        $text6 =  "ธนาคาร  " .$request['bank'];
        $text7 =  "ชื่อบัญชี  ".$request['bankName'];
        $text8 =  "เลขที่บัญชี  ".$request['account_number'];
        $text9 =  "สาขา  ".$request['branch'] ;
        $text1 =  "เหตุผลคำร้องขอคืนเงิน  ". $request['reason'];




        $data = [$text,$text1,$text2,$text3,$text4,$text5,$text6,$text7,$text8,$text9];

        $customer_mailController = app(MailController::class);
        $customer_mailController->customer_mail($data);
        // $mailController = app(MailController::class);
        // $mailController->index($data);

        return redirect('/view-order/'.$request['idOrder'])->with('status', "เพิ่มคำร้องขอคืนเงินสำเร็จ");



    }

    public function cancelOrder()  {  // เคลีย orders ที่เกิด 24 ชม เเละยังไม่โอนโอน


        $idsToUpdateMad = DB::table('orders')  //  เคลีย orders  สั่งทำ
            ->whereNull('cancel_order')
                ->select('id')
                ->where(function ($query) {
                    $query->where('order_code', 'like', '%Mad%');
                })
                ->where(function ($query) {
                    $query->where('status', '=', 0);
                })
                ->whereRaw('TIMESTAMPDIFF(HOUR, created_at, NOW()) > 24')
                ->get()
                ->pluck('id');
                // dd($idsToUpdateMad);

        DB::table('orders')
        ->whereIn('id', $idsToUpdateMad)
        ->update(['cancel_order' => 1]);






        $idsToUpdateOrd = DB::table('orders') //เคลีย orders  สั่งซื้อ
            ->whereNull('cancel_order')
                ->select('id')
                ->where(function ($query) {
                    $query->where('order_code', 'like', '%Ord%');
                })
                ->where(function ($query) {
                    $query->where('status', '=', 0);
                })
                ->whereRaw('TIMESTAMPDIFF(HOUR, created_at, NOW()) > 24')
                ->get()
                ->pluck('id');

        DB::table('orders')
            ->whereIn('id', $idsToUpdateOrd)
            ->update(['cancel_order' => 1]);



    }



}