<?php

namespace App\Http\Controllers\frontend;

use App\Models\Product;
use App\Models\Category;
use App\Models\ImagesType;
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

           return view('frontend.make_art_buy',compact('data','dataColor','number_peo'));

    }




}