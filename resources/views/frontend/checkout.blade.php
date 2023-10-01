@extends('layouts.front')

@section('title')
    checkout
@endsection

@section('content')
    <div class="container mt-3">
        <form action="{{ url('place-order') }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            {{-- contact form --}}
                            <h6>รายละเอียดที่อยู่จัดส่ง</h6>
                            <hr>
                            <div class="row checkout-form">
                                <div class="col-md-6">
                                    <label for="">ชื่อ</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('fname', isset($dataAddress[0]->fname) ? $dataAddress[0]->fname : '') }}"
                                        name="fname"required placeholder="ชื่อ">
                                </div>
                                <div class="col-md-6">
                                    <label for="">นามสกุล</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('lname', isset($dataAddress[0]->lname) ? $dataAddress[0]->lname : '') }}"
                                        name="lname"required placeholder="นามสกุล">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">E-mail</label>
                                    <input type="email" class="form-control" value="{{ Auth::user()->email }}"
                                        name="email"required placeholder="E-mail">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">โทรศัพท์</label>
                                    <input type="number" class="form-control"
                                        value="{{ old('phone', isset($dataAddress[0]->phone) ? $dataAddress[0]->phone : '') }}"
                                        name="phone"required placeholder="โทรศัพท์">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">ที่อยู่</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('address', isset($dataAddress[0]->address) ? $dataAddress[0]->address : '') }}"
                                        name="address1"required placeholder="ที่อยู่">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">ถนน</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('road', isset($dataAddress[0]->road) ? $dataAddress[0]->road : '') }}"
                                        name="road" required placeholder="ถนน">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">ตำบล/แขวง</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('subdistrict', isset($dataAddress[0]->subdistrict) ? $dataAddress[0]->subdistrict : '') }}"
                                        name="subdistrict"required placeholder="ตำบล/แขวง">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">อำเภอ/เขต</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('district', isset($dataAddress[0]->district) ? $dataAddress[0]->district : '') }}"
                                        name="district"required placeholder="อำเภอ/เขต">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">จังหวัด</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('province', isset($dataAddress[0]->province) ? $dataAddress[0]->province : '') }}"
                                        name="province"required placeholder="จังหวัด">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">รหัสไปรษณีย์</label>
                                    <input type="number" class="form-control"
                                        value="{{ old('zipcode', isset($dataAddress[0]->zipcode) ? $dataAddress[0]->zipcode : '') }}"
                                        name="zipcode"required placeholder="กรอกรหัสไปรษณีย์">
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <p>หมายเหตุการจัดส่ง: </p>
                                            <span class="ml-bank-name-4">1. ทางเราจะจัดส่งโดย kerry เท่านั้น</span><br>
                                            <span class="ml-bank-name-4">2. การจัดส่งจะดำเนินการหลังจากมีการยืนยันการชำระเงินแล้วเท่านั้น</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <h6>รายการสั่งซื้อ</h6>
                            <hr>
                            @if ($cartitems->count() > 0)
                                @php
                                $total = 0;
                                @endphp
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>สินค้า</th>
                                            <th>จำนวน</th>
                                            <th>ราคาต่อชิ้น</th>
                                            <th>ราคารวม</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartitems as $item)
                                            <tr>
                                                <td>{{ $item->products->name }}</td>
                                                <td>{{ $item->prod_qty }}</td>
                                                <td>{{ number_format($item->products->selling_price, 2) }} บาท</td>
                                                <td>{{ number_format($item->products->selling_price * $item->prod_qty, 2) }}
                                                    บาท</td>
                                            </tr>
                                            @php
                                            $total += $item->products->selling_price * $item->prod_qty;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>

                                <h5>ราคารวมสุทธิ : {{ number_format($total, 2) }} บาท</h5>
                            @else
                                <div class="card-body text-center">
                                    <h2>
                                        <i class="fas fa-shopping-cart"></i>
                                        ตะกร้าสินค้าของคุณว่างเปล่า เลือกงานศิลปะที่คุณต้องการได้เลย!
                                    </h2>
                                </div>
                            @endif
                            <hr>
                            <button type="submit" class="btn btn-primary float-end w-100">ยืนยันคำสั่งซื้อ</button>
                        </div>
                    </div>

                    <h5 class="mt-4 mb-4">ช่องทางชำระเงิน</h5>
                        <div class="row">
                            <div class="col-13">
                                <p>หมายเหตุการชำระเงิน: <br>
                                    <span class="ml-bank-name-4">กรุณาชำระเงินภายใน 24 ชั่วโมง หากหลังจากนั้นคำสั่งซื้อจะถูกยกเลิก</span>
                                </p>
                            </div>
                        </div>
                    @foreach ($bank as $_bank)
                        <div class="row">
                            <div class="col-6">
                                <p>ชื่อธนาคาร: <span class="ml-bank-name-4">{{ $_bank->bank_name }}</span>
                                </p>

                            </div>
                            <div class="col-6">
                                <p>ชื่อบัญชี: <span class="ml-bank-name-4">{{ $_bank->account_name }}</span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p>เลขบัญชี: <span class="ml-bank-name-4">{{ $_bank->account_number }}</span>
                                </p>

                            </div>
                            <div class="col-6">
                                <p>สาขา: <span class="ml-bank-name-4">{{ $_bank->branch }}</span></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <p>qrcode: <span class="ml-bank-name-4">
                                        @if ($_bank->image)
                                            <img src="{{ URL::asset('/assets/uploads/bank/' . $_bank->image) }}"
                                                class="bank-qrcode clickable-image cursor-pointer" alt="...">
                                        @endif
                                    </span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </form>
    </div>
        <!-- The Modal -->
        <div id="myModal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="img01">
            <div id="caption"></div>
        </div>
    
        <script>
            var modal = document.getElementById("myModal");
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");
    
            // รับรายการภาพทั้งหมดที่มีคลาส "clickable-image"
            var images = document.querySelectorAll(".clickable-image");
    
            // เพิ่มการตรวจสอบการคลิกสำหรับแต่ละรูปภาพ
            images.forEach(function(img) {
                img.onclick = function() {
                    modal.style.display = "block";
                    modalImg.src = this.src;
                    captionText.innerHTML = this.alt;
                }
            });
    
            var span = document.getElementsByClassName("close")[0];
    
            span.onclick = function() {
                modal.style.display = "none";
            }
        </script>
@endsection
