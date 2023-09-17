@extends('layouts.front')

@section('title')
    My Profile
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-secondary">
                    <h4 class="text-white">Address</h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('user-address') }}" method="POST">
                        {{ csrf_field() }}
                    <div class="mb-3" style="display: none">
                        <label for="exampleFormControlInput1" class="form-label">id_user</label>
                        <input value="{{$id}}" name="id_user" type="text" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" required>
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">ชื่อ</label>
                        <input name="fname" type="text" class="form-control" id="exampleFormControlInput1" placeholder="ชื่อ" required>
                      </div><div class="mb-3">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">นามสกุล</label>
                            <input name="lname" type="text" class="form-control" id="exampleFormControlInput1" placeholder="นามสกุล" required>
                          </div><div class="mb-3">
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">เบอร์โทรศัพท์</label>
                        <input name="phone" type="number" class="form-control" id="exampleFormControlInput1" placeholder="เบอร์โทรศัพท์" required>
                      </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">ที่อยู่</label>
                        <textarea name="address" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">ถนน</label>
                        <input name="road" type="text" class="form-control" id="exampleFormControlInput1" placeholder="ถนน">
                      </div><div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">ตำบล/แขวง</label>
                        <input name="subdistrict" type="text" class="form-control" id="exampleFormControlInput1" placeholder="ตำบล/แขวง" required>
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">อำเภอ/เขต</label>
                        <input name="district" type="text" class="form-control" id="exampleFormControlInput1" placeholder="อำเภอ/เขต" required>
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">จังหวัด</label>
                        <input name="province" type="text" class="form-control" id="exampleFormControlInput1" placeholder="จังหวัด" required>
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">รหัสไปรษณีย์</label>
                        <input name="zipcode" type="text" class="form-control" id="exampleFormControlInput1" placeholder="รหัสไปรษณีย์" required>
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
