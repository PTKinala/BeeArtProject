<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Bank;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $bank = Bank::get();


        return view('admin.bank.index',['bank' => $bank]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.bank.create");
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
            'image' => [ 'image', 'mimes:jpg,png,jpeg,webp'],
            'bank_name' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:255'],
            'branch' => ['required', 'string', 'max:255'],

        ]);

        $dateText = Str::random(6);
        $member = new Bank;
        $member->bank_name = $request['bank_name'];
        $member->account_name = $request['account_name'];
        $member->account_number = $request['account_number'];
        $member->branch = $request['branch'];
        // image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data =   $image->move(public_path() . '/assets/uploads/bank', $dateText . $image->getClientOriginalName());
            $member->image =  $dateText . $image->getClientOriginalName();
        }
        $member->save();
        return redirect('bank-account')->with('status',"Bank Account Added Successfully");
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
        $bank = Bank::find($id);
        return view('admin.bank.edit', compact('bank'));
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
            'bank_name' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:255'],
            'branch' => ['required', 'string', 'max:255'],

        ]);

        $dateText = Str::random(6);
        $member = Bank::find($id);;
        $member->bank_name = $request['bank_name'];
        $member->account_name = $request['account_name'];
        $member->account_number = $request['account_number'];
        $member->branch = $request['branch'];
        if ($request->hasFile('image')) {
            if ($member->image) {
                $image_path = public_path() . '/assets/uploads/bank/' . $member->image;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }

            }
            //ลบภาพ

            //add ภาพ
            $image = $request->file('image');
            $data =   $image->move(public_path() . '/assets/uploads/bank', $dateText . $image->getClientOriginalName());
            $member->image =  $dateText . $image->getClientOriginalName();
        }
        $member->save();
        return redirect('bank-account')->with('status',"Bank Account Update Successfully");


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flight = Bank::find($id);


        if ($flight->image) {
            $image_path = public_path() . '/assets/uploads/bank/' . $flight->image;
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        $flight->delete();
        return redirect('bank-account')->with('status',"Bank Account delete Successfully");
    }
}