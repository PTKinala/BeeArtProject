<?php

namespace App\Http\Controllers\frontend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        return view('frontend.make_art');
    }
}