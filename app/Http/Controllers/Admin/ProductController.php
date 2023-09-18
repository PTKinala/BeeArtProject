<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

    public function add()
    {
        $category = Category::all();
        return view('admin.product.add', compact('category'));
    }

    public function insert(Request $request)
    {
        $products = new Product();
        if ($request->hasFile('image'))
        {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move(public_path('assets/uploads/products/'), $filename);
            $products->image = $filename;
        }
        $products->cate_id = $request->input('cate_id');
        $products->name = $request->input('name');
        $products->status = $request->input('status') == TRUE ? "1": "0";
        $products->trending = $request->input('trending') == TRUE ? "1": "0";
        $products->description = $request->input('description');
        $products->original_price = $request->input('original_price');
        $products->selling_price = $request->input('selling_price');
        $products->slug = $request->input('name');
        $products->qty = $request->input('qty');


        $products->save();
        return redirect('products')->with('status',"Product Added Successfully");

        //Name  status trending  description original_price selling_price qty


    }

    public function edit($id)
    {
        $category = Category::all();
        $products = product::find($id);
        return view('admin.product.edit', compact('products', 'category'));
    }

    public function update(Request $request, $id)
    {
        $products = product::find($id);
        if ($request->hasFile('image'))
        {
            $path = 'assets/uploads/products/'.$products->image;
            if (File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move(public_path('assets/uploads/products/'), $filename);
            $products->image = $filename;
        }
        $products->cate_id = $request->input('cate_id');
        $products->name = $request->input('name');
        $products->status = $request->input('status') == TRUE ? "1": "0";
        $products->trending = $request->input('trending') == TRUE ? "1": "0";
        $products->description = $request->input('description');
        $products->original_price = $request->input('original_price');
        $products->selling_price = $request->input('selling_price');
        $products->slug = $request->input('name');

        $products->update();
        return redirect('products')->with('status',"Product Updated Successfully");
    }

    public function destory($id)
    {
        $products = Product::find($id);
        if($products->image)
        {
            $path = 'assets/uploads/products/'.$products->image;
            if (File::exists($path))
            {
                File::delete($path);
            }
        }
        $products->delete();
        return redirect('products')->with('status',"products Deleted Successfully");;
    }
}