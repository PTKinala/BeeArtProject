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
                            <h6>รายละเอียดการจัดส่ง</h6>
                            <hr>
                            <div class="row checkout-form">
                                <div class="col-md-6">
                                    <label for="">ชื่อ</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->name }}"
                                        name="fname"required placeholder="ชื่อ">
                                </div>
                                <div class="col-md-6">
                                    <label for="">นามสกุล</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->lname }}"
                                        name="lname"required placeholder="นามสกุล">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">E-mail</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->email }}"
                                        name="email"required placeholder="E-mail">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">โทรศัพท์</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->phone }}"
                                        name="phone"required placeholder="โทรศัพท์">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">ที่อยู่</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->address1 }}"
                                        name="address1"required placeholder="ที่อยู่">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">ถนน</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->address2 }}"
                                        name="road" required placeholder="ถนน">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">ตำบล/แขวง</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->city }}"
                                        name="subdistrict"required placeholder="ตำบล/แขวง">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">อำเภอ/เขต</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->state }}"
                                        name="district"required placeholder="อำเภอ/เขต">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">จังหวัด</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->country }}"
                                        name="province"required placeholder="จังหวัด">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">รหัสไปรษณีย์</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->pincode }}"
                                        name="zipcode"required placeholder="กรอกรหัสไปรษณีย์">
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
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>สินค้า</th>
                                            <th>จำนวน</th>
                                            <th>ราคา</th>
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
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="card-body text-center">
                                    <h2>
                                        <i class="fas fa-shopping-cart"></i>
                                        ตะกล้าสินค้าว่างเปล่า
                                    </h2>
                                </div>
                            @endif
                            <hr>
                            <button type="submit" class="btn btn-primary float-end w-100">ยืนยันคำสั่งซื้อ</button>
                        </div>
                    </div>

                    <h5 class="mt-4 mb-4">ช่องทางชำระเงิน</h5>
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
                                                class="bank-qrcode" alt="...">
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
@endsection
