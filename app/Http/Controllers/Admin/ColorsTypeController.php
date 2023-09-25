<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Models\ImagesType;
use App\Models\ColorsType;
use Illuminate\Support\Facades\DB;

class ColorsTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('colors_types')
        ->leftJoin('images_types', 'colors_types.id_image_type', '=', 'images_types.id')
        ->select('colors_types.*', 'images_types.name')
        ->orderBy('images_types.name','asc')
        ->get();
        return view('admin.colors.index' , compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = ImagesType::get();
        return view('admin.colors.create', compact('type'));
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
            'color_type' => ['required', 'string', 'max:255'],

        ]);
        $member = new ColorsType;
        $member->id_image_type = $request['id_image_type'];
        $member->color_type = $request['color_type'];




        $member->save();
        return redirect('/color-type')->with('status',"เพิ่มเทคนิคสีสำเร็จ");
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
        $data = ColorsType::find($id);
        return view('admin.colors.edit', compact('type','data'));
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
            'color_type' => ['required', 'string', 'max:255'],

        ]);
        $member =  ColorsType::find($id);;
        $member->id_image_type = $request['id_image_type'];
        $member->color_type = $request['color_type'];




        $member->save();
        return redirect('/color-type')->with('status',"แก้ไขเทคนิคสีสำเร็จ");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flight = ColorsType::find($id);


        $flight->delete();
        return redirect('/color-type')->with('status',"ลบเทคนิคสีสำเร็จ");
    }
}