<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\ImagesType;
use App\Models\ImagesSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImagesSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('images_sizes')
        ->leftJoin('images_types', 'images_sizes.id_image_type', '=', 'images_types.id')
        ->select('images_sizes.*', 'images_types.name')
        ->orderBy('images_types.name','asc')
        ->get();
         return view("admin.imageSize.index" ,['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $type = ImagesType::get();
        return view('admin.imageSize.create', ['type' => $type]);
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
            'id_image_type' => ['required', 'string', 'max:255'],
            'size_image_cm' => ['required', 'string', 'max:255'],

        ]);
        $member = new ImagesSize;
        $member->id_image_type = $request['id_image_type'];
        $member->paper = $request['paper'];
        $member->size_image_cm = $request['size_image_cm'];



        $member->save();
        return redirect('image-size')->with('status',"image Size Added Successfully");
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
        $type = ImagesType::get();
        $date = ImagesSize::find($id);
        return view('admin.imageSize.edit', compact('type','date'));
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
        $validated = $request->validate([
            'id_image_type' => ['required', 'string', 'max:255'],
            'size_image_cm' => ['required', 'string', 'max:255'],

        ]);
        $member =  ImagesSize::find($id);
        $member->id_image_type = $request['id_image_type'];
        $member->paper = $request['paper'];
        $member->size_image_cm = $request['size_image_cm'];



        $member->save();
        return redirect('image-size')->with('status',"image Size Update Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flight = ImagesSize::find($id);


        $flight->delete();
        return redirect('/image-size')->with('status',"image size delete Successfully");
    }
}