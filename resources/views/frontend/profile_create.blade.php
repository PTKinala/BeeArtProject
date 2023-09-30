@extends('layouts.front')

@section('title')
    My Profile
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header mt-3">
                    <h4>เพิ่มที่อยู่ในการจัดส่ง</h4>
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
                      </div>

                      {{-- <div class="mb-3">
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
                      </div> --}}

                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">จังหวัด</label>
                        <select id="input_province" class="form-control" name="province">
                            <option value="">กรุณาเลือกจังหวัดที่ต้องการเปลี่ยน</option>
                            @foreach($provinces as $item)
                            <option value="{{ $item->province }}">{{ $item->province }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">อำเภอ/เขต</label>
                        <select id="input_amphoe" class="form-control" name="district">
                            <option value="">กรุณาเลือกเขต/อำเภอที่ต้องการเปลี่ยน</option>
                            @foreach($amphoes as $item)
                            <option value="{{ $item->amphoe }}">{{ $item->amphoe }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">ตำบล/แขวง</label>
                        <select id="input_tambon" class="form-control" name="subdistrict">
                            <option value="">กรุณาเลือกแขวง/ตำบลที่ต้องการเปลี่ยน</option>
                            @foreach($tambons as $item)
                            <option value="{{ $item->tambon }}">{{ $item->tambon }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">รหัสไปรษณีย์</label>
                        <input id="input_zipcode" class="form-control" name="zipcode" placeholder="รหัสไปรษณีย์" />
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
