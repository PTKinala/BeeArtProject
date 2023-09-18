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
        $featured_products = Product::where('trending', '1')->take(10)->get();
        $popular_category = Category::where('popular', '1')->take(6)->get();
        return view('frontend.index', compact('featured_products', 'popular_category'));
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
        $image_type = ImagesType::get();
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
            if ($id == 2 ) {
                $number_peo =  DB::table('number_people')->get();
            }

            $dataAddress = Address::where('id_user', Auth::id())->get();


           return view('frontend.make_art_buy',compact('data','dataColor','number_peo','dataAddress'));

    }


    public function uploaderSlip($id)
    {


        return view('frontend.uploader_slip',compact('id'));




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

        return redirect('/view-order/'.$request['idOrder'])->with('status', "uploader slip Successfully");



    }


    public function requestReturn(Request $request,$id)
    {

        return view('frontend.request_return' ,compact('id'));
    }


    public function storeRequestReturn(Request $request) {

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

        return redirect('/view-order/'.$request['idOrder'])->with('status', "Request Return Successfully");



    }



}