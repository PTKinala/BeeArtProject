<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Address;
use App\Models\Tambon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::where('id', Auth::id())->first();
        $user_address = Address::where('id_user', Auth::id())->get();
        // dd($user_address);
        return view('frontend.profile', compact('user', 'user_address'));
    }

    public function create()
    {
        $id = Auth::id();
            $provinces = Tambon::select('province')->distinct()->get();
            $amphoes = Tambon::select('amphoe')->distinct()->get();
            $tambons = Tambon::select('tambon')->distinct()->get();

        return view('frontend.profile_create', compact('id','provinces','amphoes','tambons'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $address =  new Address;
        $address->id_user = $request->input('id_user');
        $address->fname = $request->input('fname');
        $address->lname = $request->input('lname');
        $address->address = $request->input('address');
        $address->road = $request->input('road');
        $address->subdistrict = $request->input('subdistrict');
        $address->district = $request->input('district');
        $address->province = $request->input('province');
        $address->zipcode = $request->input('zipcode');
        $address->phone = $request->input('phone');
        $address->save();

        return redirect('/my-profile')->with('status', "ที่อยู่ถูกเพิ่มเรียบร้อยแล้ว");
    }

    public function edit($id)
    {
        $edit_address = Address::find($id);
        $provinces = Tambon::select('province')->distinct()->get();
        $amphoes = Tambon::select('amphoe')->distinct()->get();
        $tambons = Tambon::select('tambon')->distinct()->get();


        return view('frontend.profile_edit', compact('edit_address','provinces','amphoes','tambons'));
    }

    public function update(Request $request, $id)
    {

        $address =  Address::find($id);
        $address->fname = $request->input('fname');
        $address->lname = $request->input('lname');
        $address->address = $request->input('address');
        $address->road = $request->input('road');
        $address->subdistrict = $request->input('subdistrict');
        $address->district = $request->input('district');
        $address->province = $request->input('province');
        $address->zipcode = $request->input('zipcode');
        $address->phone = $request->input('phone');
        $address->save();

        return redirect('/my-profile')->with('status', "ที่อยู่ถูกแก้ไขเรียบร้อยแล้ว");
    }

    public function change_pass()
    {
        $id = Auth::id();
        return view('frontend.change_pass', compact('id'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }



    public function update_pass(Request $request, $id)
    {
        $id = User::find($id);
        $id->password = Hash::make($request->input('password'));
        $id->save();

        return redirect('/my-profile')->with('status', "รหัสผ่านถูกเปลี่ยนแล้ว");
    }


}
