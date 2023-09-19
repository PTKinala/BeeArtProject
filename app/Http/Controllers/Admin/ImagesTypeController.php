<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;


use Illuminate\Http\Request;
use App\Models\ImagesType;
use Illuminate\Support\Str;


class ImagesTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $imageType = ImagesType::get();
        return view("admin.imageType.index", ['imageType' => $imageType]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.imageType.create");
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
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg,webp'],
            'name' => ['required', 'string', 'max:255'],

        ]);

        $dateText = Str::random(6);
        $member = new ImagesType;
        $member->name = $request['name'];
        $member->status = $request->input('status') == TRUE ? "1": "0";

        // image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data =   $image->move(public_path() . '/assets/uploads/imageType', $dateText . $image->getClientOriginalName());
            $member->image =  $dateText . $image->getClientOriginalName();
        }
        $member->save();
        return redirect('image-type')->with('status',"image type Added Successfully");
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
        $imageType = ImagesType::find($id);
        return view("admin.imageType.edit",compact('imageType'));
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
            'image' => [ 'image', 'mimes:jpg,png,jpeg,webp'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $dateText = Str::random(6);
        $member = ImagesType::find($id);
        $member->name = $request['name'];
        $member->status = $request->input('status') == TRUE ? "1": "0";
        if ($request->hasFile('image')) {
            if ($member->image) {
                $image_path = public_path() . '/assets/uploads/imageType/' . $member->image;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }

            }
            //ลบภาพ

            //add ภาพ
            $image = $request->file('image');
            $data =   $image->move(public_path() . '/assets/uploads/imageType', $dateText . $image->getClientOriginalName());
            $member->image =  $dateText . $image->getClientOriginalName();
        }
        $member->save();
        return redirect('image-type')->with('status',"image type Update Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $flight = ImagesType::find($id);


        if ($flight->image) {
            $image_path = public_path() . '/assets/uploads/imageType/' . $flight->image;
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        $flight->delete();
        return redirect('/image-type')->with('status',"image type delete Successfully");
    }
}