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
                      </div>
                      {{-- <div class="mb-3">
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
                      </div> --}}

                      <div  class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">จังหวัด</label>
                        <label for="exampleFormControlInput1" class="form-label">{{$edit_address->province}}</label>
                        <select id="input_province" name="province" class="form-control">
                            <option value="">กรุณาเลือกจังหวัด</option>
                            @foreach($provinces as $item)
                            <option value="{{ $item->province }}">{{ $item->province }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div  class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">อำเภอ/เขต</label>
                        <label for="exampleFormControlInput1" class="form-label">{{$edit_address->district}}</label>
                        <select id="input_amphoe" name="district" class="form-control">
                            <option value="">กรุณาเลือกเขต/อำเภอ</option>
                            @foreach($amphoes as $item)
                            <option value="{{ $item->amphoe }}">{{ $item->amphoe }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div  class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">ตำบล/แขวง</label>
                        <label for="exampleFormControlInput1" class="form-label">{{$edit_address->subdistrict}}</label>
                        <select id="input_tambon" name="subdistrict" class="form-control">
                            <option value="">กรุณาเลือกแขวง/ตำบล</option>
                            @foreach($tambons as $item)
                            <option value="{{ $item->tambon }}">{{ $item->tambon }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div  class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">รหัสไปรษณีย์</label>
                        <label for="exampleFormControlInput1" class="form-label">{{$edit_address->zipcode}}</label>
                        <input id="input_zipcode" name="zipcode" class="form-control" placeholder="รหัสไปรษณีย์" />
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

<script>
    function showAmphoes() {
        let input_province = document.querySelector("#input_province");
        let url = "{{ url('/api/amphoes') }}?province=" + input_province.value;
        console.log(url);
        // if(input_province.value == "") return;
        fetch(url)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                //UPDATE SELECT OPTION
                let input_amphoe = document.querySelector("#input_amphoe");
                input_amphoe.innerHTML = '<option value="">กรุณาเลือกเขต/อำเภอ</option>';
                for (let item of result) {
                    let option = document.createElement("option");
                    option.text = item.amphoe;
                    option.value = item.amphoe;
                    input_amphoe.appendChild(option);
                }
                //QUERY AMPHOES
                showTambons();
            });
    }
function showTambons() {
        let input_province = document.querySelector("#input_province");
        let input_amphoe = document.querySelector("#input_amphoe");
        let url = "{{ url('/api/tambons') }}?province=" + input_province.value + "&amphoe=" + input_amphoe.value;
        console.log(url);
        // if(input_province.value == "") return;
        // if(input_amphoe.value == "") return;
        fetch(url)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                //UPDATE SELECT OPTION
                let input_tambon = document.querySelector("#input_tambon");
                input_tambon.innerHTML = '<option value="">กรุณาเลือกแขวง/ตำบล</option>';
                for (let item of result) {
                    let option = document.createElement("option");
                    option.text = item.tambon;
                    option.value = item.tambon;
                    input_tambon.appendChild(option);
                }
                //QUERY AMPHOES
                showZipcode();
            });
    }
function showZipcode() {
        let input_province = document.querySelector("#input_province");
        let input_amphoe = document.querySelector("#input_amphoe");
        let input_tambon = document.querySelector("#input_tambon");
        let url = "{{ url('/api/zipcodes') }}?province=" + input_province.value + "&amphoe=" + input_amphoe.value + "&tambon=" + input_tambon.value;
        console.log(url);
        // if(input_province.value == "") return;
        // if(input_amphoe.value == "") return;
        // if(input_tambon.value == "") return;
        fetch(url)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                //UPDATE SELECT OPTION
                let input_zipcode = document.querySelector("#input_zipcode");
                input_zipcode.value = "";
                for (let item of result) {
                    input_zipcode.value = item.zipcode;
                    break;
                }
            });
}
//EVENTS
    document.querySelector('#input_province').addEventListener('change', (event) => {
        showAmphoes();
    });
    document.querySelector('#input_amphoe').addEventListener('change', (event) => {
        showTambons();
    });
    document.querySelector('#input_tambon').addEventListener('change', (event) => {
        showZipcode();
    });
</script>
@endsection
