@extends('layouts.front')

@section('title')
    My Profile
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mt-2">แก้ไขรายละเอียดที่อยู่ของคุณ</h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('update-address',$edit_address->id) }}" method="POST">
                        {{ csrf_field() }}
                        @method('PUT')
                        <div class="mb-3">
                          <label for="exampleFormControlInput1" class="form-label">ชื่อ</label>
                          <input value="{{$edit_address->fname}}" name="fname" type="text" class="form-control" id="exampleFormControlInput1" placeholder="ชื่อ">
                        </div><div class="mb-3">
                          <div class="mb-3">
                              <label for="exampleFormControlInput1" class="form-label">นามสกุล</label>
                              <input value="{{$edit_address->lname}}" name="lname" type="text" class="form-control" id="exampleFormControlInput1" placeholder="นามสกุล">
                            </div><div class="mb-3">
                        <div class="mb-3">
                          <label for="exampleFormControlInput1" class="form-label">เบอร์โทรศัพท์</label>
                          <input value="{{$edit_address->phone}}" name="phone" type="number" class="form-control" id="exampleFormControlInput1" placeholder="เบอร์โทรศัพท์" required>
                        </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">ที่อยู่</label>
                        <textarea name="address" class="form-control" id="exampleFormControlTextarea1" rows="3" required>{{$edit_address->address}}</textarea>
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">ถนน</label>
                        <input value="{{$edit_address->road}}" name="road" type="text" class="form-control" id="exampleFormControlInput1" placeholder="ถนน">
                      </div><div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">ตำบล/แขวง</label>
                        <input value="{{$edit_address->subdistrict}}" name="subdistrict" type="text" class="form-control" id="exampleFormControlInput1" placeholder="ตำบล/แขวง" required>
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">อำเภอ/เขต</label>
                        <input value="{{$edit_address->district}}" name="district" type="text" class="form-control" id="exampleFormControlInput1" placeholder="อำเภอ/เขต" required>
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">จังหวัด</label>
                        <input value="{{$edit_address->province}}" name="province" type="text" class="form-control" id="exampleFormControlInput1" placeholder="จังหวัด" required>
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">รหัสไปรษณีย์</label>
                        <input value="{{$edit_address->zipcode}}" name="zipcode" type="text" class="form-control" id="exampleFormControlInput1" placeholder="รหัสไปรษณีย์" required>
                      </div>
                      <button type="submit" class="btn btn-primary">submit</button>
                      </form>
                      
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>            
@endsection
