@extends('layouts.front')

@section('title')
    My Orders
@endsection

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="mt-2">รายการสั่งซื้อ/สั่งทำ
                            <a href="{{ url('my-orders') }}" class="btn btn-primary text-whtie float-end">Back</a>
                        </h1>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 order-details">
                                <h4>รายละเอียดที่อยู่จัดส่ง</h4>
                                <hr>
                                <label for="">ชื่อ</label>
                                <div class="border">{{ $orders->fname }}</div>
                                <label for="">นามสกุล</label>
                                <div class="border">{{ $orders->lname }}</div>
                                <label for="">อีเมล</label>
                                <div class="border">{{ $orders->email }}</div>
                                <label for="">เบอร์</label>
                                <div class="border">{{ $orders->phone }}</div>
                                <label for="">ที่อยู่</label>
                                <div class="border">
                                    {{ $orders->address1 }},<br>
                                    {{ $orders->road }},<br>
                                    {{ $orders->subdistrict }},
                                    {{ $orders->district }},
                                    {{ $orders->province }}
                                </div>
                                <label for="">รหัสไปรษณีย์</label>
                                <div class="border">{{ $orders->zipcode }}</div>

                                @if (count($madeOrders) > 0)
                                    @if ($madeOrders[0]->cancel_order != 1)
                                        @if (
                                            $madeOrders[0]->total_price != null &&
                                                ($madeOrders[0]->status == '1' ||
                                                    $madeOrders[0]->status == '3' ||
                                                    $madeOrders[0]->status == '5' ||
                                                    $madeOrders[0]->status == '7'))
                                            <a href="{{ url('uploader-slip/' . $orders->id) }}"
                                                class="btn btn-primary mt-3 ">ส่งหลักฐานการโอนเงิน</a>
                                        @endif
                                    @endif
                                @endif
                                @if ($orders)
                                    @if ($orders->cancel_order != 1)
                                        @if ($orders->total_price != null && ($orders->status == '0' || $orders->status == '2'))
                                            <a href="{{ url('uploader-slip/' . $orders->id) }}"
                                                class="btn btn-primary mt-3 ">ส่งหลักฐานการโอนเงิน</a>
                                        @endif
                                    @endif
                                @endif
                                <h5 class="mt-4 mb-3 d-flex justify-content-between col-12">ช่องทางชำระเงิน</h5>
                                <div class="row">
                                    <div class="col-13">
                                        <p>หมายเหตุการชำระเงิน: <br>
                                            <span class="ml-bank-name-4">กรุณาชำระเงินภายใน 24 ชั่วโมง
                                                หากหลังจากนั้นคำสั่งซื้อจะถูกยกเลิก</span>
                                        </p>
                                    </div>
                                </div>
                                @foreach ($bank as $_bank)
                                    <div class="row">
                                        <div class="col-12">
                                            <p>qrcode: <span class="ml-bank-name-4">
                                                    @if ($_bank->image)
                                                        <img src="{{ URL::asset('/assets/uploads/bank/' . $_bank->image) }}"
                                                            class="bank-qrcode clickable-image cursor-pointer">
                                                    @endif
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <p>ชื่อธนาคาร: <span class="ml-bank-name-4">{{ $_bank->bank_name }}</span>
                                            </p>

                                        </div>
                                        <div class="col-6">
                                            <p>ชื่อบัญชี: <span class="ml-bank-name-4">{{ $_bank->account_name }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row  mb-3">
                                        <div class="col-4">
                                            <p>เลขบัญชี: <span class="ml-bank-name-4">{{ $_bank->account_number }}</span>
                                            </p>

                                        </div>
                                        <div class="col-6">
                                            <p>สาขา: <span class="ml-bank-name-4">{{ $_bank->branch }}</span></p>
                                        </div>
                                    </div>
                                @endforeach

                                @foreach ($dataRequest as $request)
                                    <div class="mt-5 col-12 mb-3">
                                        <h5>คำร้องขอคืนเงิน</h5>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-6">
                                            <p class="">ธนาคาร &nbsp; &nbsp;{{ $request->bank }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p>ชื่อบัญชี &nbsp; &nbsp; {{ $request->bankName }}</p>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-6">
                                            <p>เลขที่บัญชี &nbsp; &nbsp; {{ $request->account_number }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p>สาขา &nbsp; &nbsp; {{ $request->branch }}</p>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-6">
                                            <p>เหตุผล &nbsp; &nbsp; {{ $request->reason }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p>สถานะคำร้อง &nbsp; &nbsp; {{ $request->statusRequest }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p>เหตุผลของสถานะ &nbsp; &nbsp; {{ $request->comment }}</p>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        @if ($request->image_order)
                                            <div>
                                                <p>รูปหลักฐาน</p>
                                                <img src="{{ URL::asset('/assets/uploads/slip_user/' . $request->image_order) }}"
                                                    width="150px" height="200px" alt="..."
                                                    class="clickable-image cursor-pointer">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        @if ($request->image)
                                            <div>
                                                <p>รูปสลิปการโอน</p>
                                                <img src="{{ URL::asset('/assets/uploads/requestSlip/' . $request->image) }}"
                                                    width="150px" height="200px" alt="..."
                                                    class="clickable-image cursor-pointer">
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            {{-- ! สั่งชื้อ --}}
                            @if (count($orders->orderitems) > 0)
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ชื่อ</th>
                                                <th>จำนวน</th>
                                                <th>ราคา</th>
                                                <th>ภาพ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders->orderitems as $item)
                                                <tr>
                                                    <td>{{ $item->products->name }}</td>
                                                    <td>{{ $item->qty }}</td>
                                                    <td>{{ number_format($item->price, 2) }} บาท</td>
                                                    <td>
                                                        <img src="{{ asset('assets/uploads/products/' . $item->products->image) }}"
                                                            width="50px" alt="Product Image"
                                                            class="clickable-image cursor-pointer">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <h4 class="px-2 mt-3">ราคารวม: <span
                                            class="float-end">{{ number_format($orders->total_price, 2) }}
                                            บาท</span></h4>
                                    <div class="px-2 mt-3">
                                        <h4>รหัสคำสั่งซื้อ</h4>
                                    </div>
                                    <div class="px-2">{{ $orders->order_code }}</div>
                                    <div class="px-2 mt-3">
                                        <h4>รหัสการจัดส่ง</h4>
                                    </div>
                                    <div class="px-2">
                                        @if ($orders->tracking_no)
                                            <a href="https://th.kerryexpress.com/th/track/"
                                                target="_blank">{{ $orders->tracking_no }}</a>
                                        @else
                                            -
                                        @endif
                                    </div>

                                    @if ($orders->status == 4)
                                        <label class="mt-3" for="">ยืนยันรับของ</label>
                                        <form action="{{ url('update-order/' . $orders->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select class="form-select" name="order_status">
                                                <option {{ $orders->status == '5' ? 'selected ' : '' }} value="5">
                                                    ยืนยันรับของ
                                                </option>
                                                <option {{ $orders->status == '6' ? 'selected ' : '' }} value="6">
                                                    ปฏิเสธการรับของ
                                                </option>
                                            </select>
                                            <button type="submit" class="btn btn-primary mt-3">Update</button>
                                        </form>
                                    @endif


                                    @if ($orders->status == '5' && $orders->updated_at->diffInHours(now()) < 24)
                                        <div class="px-4 mt-3 col-9">
                                            <a href="{{ url('request-return/' . $orders->id) }}"
                                                class="btn btn-outline-warning btn-sm">คำร้องขอคืน</a>
                                        </div>
                                    @endif


                                    <div class="px-2 mt-3">
                                        <h4>สถานะ:</h4>
                                        @if ($orders->cancel_order == 1)
                                            <span style="color: red"> ยกเลิกเรียบร้อย</span>
                                        @else
                                            @if ($orders->status == 0)
                                                <span style="color: #979797">รอการชำระเงิน</span>
                                            @else
                                                @if ($orders->status == 1)
                                                    <span style="color: #2f2f2f">รอตรวจสอบหลักฐานการโอนเงิน</span>
                                                @else
                                                    @if ($orders->status == 2)
                                                        <span style="color: #800000">สลิปไม่ผ่าน</span>
                                                    @else
                                                        @if ($orders->status == 3)
                                                            <span style="color: green">กำลังจัดส่งงานศิลปะ</span>
                                                        @else
                                                            @if ($orders->status == 4)
                                                                <span style="color: rgb(6, 16, 155)">รอรับงานศิลปะ</span>
                                                            @else
                                                                @if ($orders->status == 5)
                                                                    <span style="color: #48a83f">จัดส่งสำเร็จ</span>
                                                                @elseif ($orders->status == 6)
                                                                    <span style="color: #e51900">ปฏิเสธการรับของ</span>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    </div>

                                    @if ($orders->tracking_no == null)
                                        @if ($orders->cancel_order == null)
                                            <div class="px-2  row">
                                                <div class="px-2 mt-3 col-2">
                                                    <a href="{{ url('edit-item-orders/' . $orders->id) }}"
                                                        class="btn btn-outline-secondary btn-sm">แก้ไขที่อยู่
                                                    </a>
                                                </div>
                                                <div class="px-2 mt-3 col-3">
                                                    <a href="{{ url('destory-item-orders/' . $orders->id) }}"
                                                        class="btn btn-outline-danger btn-sm">ยกเลิกคำสั่งซื้อ</a>
                                                </div>
                                        @endif
                                    @endif








                                    @foreach ($dataSlip as $_data)
                                        <p class="mt-4">จำนวนเงิน &nbsp; &nbsp; {{ number_format($_data->price, 2) }}
                                            บาท
                                        </p>
                                        <p class="mt-4">วันที่ upload &nbsp; &nbsp; {{ $_data->date }}</p>
                                        <p>เวลาที่ upload &nbsp; &nbsp; {{ $_data->time }}</p>
                                        <p>สถานะการตรวจเช็ค&nbsp; &nbsp;
                                            @if ($_data->status_slip == null)
                                                <span style="color: blue">ยังไม่ได้ตรวจสอบ</span>
                                            @elseif ($_data->status_slip == 2)
                                                <span style="color: red">สลิปไม่ถูกต้อง</span>
                                            @elseif ($_data->status_slip == 3)
                                                <span style="color: green">สลิปผ่านเเล้ว </span>
                                            @endif
                                        </p>

                                        <div>
                                            <img src="{{ URL::asset('/assets/uploads/slip/' . $_data->image) }}"
                                                width="150px" height="200px" alt="..."
                                                class="clickable-image cursor-pointer">
                                        </div>
                                    @endforeach






                                </div>
                            @endif


                            {{-- ! สั่งทำ --}}
                            @if (count($madeOrders) > 0)
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ประเภทงาน</th>
                                                <th>กระดาษ/ขนาด</th>
                                                <th>เทคนิคสี</th>
                                                <th>รูปอ้างอิง</th>
                                                <th>ราคา</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($madeOrders as $item)
                                                <tr>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->paper }} {{ ' ' }}{{ $item->size_image_cm }}
                                                    </td>
                                                    <td>{{ $item->color_type }}</td>
                                                    <td>
                                                        <img src="{{ asset('assets/uploads/madeOrder/' . $item->image) }}"
                                                            width="50px" alt="Product Image"
                                                            class="clickable-image cursor-pointer">
                                                    </td>
                                                    <td>{{ number_format($item->price, 2) }} บาท</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="px-2">
                                        <h4>รายละเอียดเพิ่มเติม</h4>
                                    </div>
                                    <div class="px-2">{{ $madeOrders[0]->description }}</div>

                                    <h4 class="px-2 mt-3">ราคารวม: <span class="float-end">
                                            @if ($madeOrders[0]->total_price)
                                                {{ number_format($madeOrders[0]->total_price, 2) }} บาท
                                            @else
                                                รอการประเมิน
                                            @endif
                                        </span></h4>
                                    <div class="px-2">
                                        <h6> ราคามัดจำ <span class="float-end">
                                                {{ number_format(($madeOrders[0]->total_price * $deposit) / 100, 2) }}
                                                บาท</span> </h6>
                                        @if (count($dataSlipCount) > 0)
                                            <h6> ราคาคงเหลือ <span class="float-end">
                                                {{ number_format($madeOrders[0]->total_price - ($madeOrders[0]->total_price * $deposit) / 100, 2) }}
                                                บาท</span> </h6>
                                        @endif
                                    </div>

                                    <div class="px-2 mt-3">
                                        <h4>รหัสคำสั่งทำ</h4>
                                    </div>
                                    <div class="px-2">{{ $madeOrders[0]->order_code }}</div>
                                    <div class="px-2 mt-3">
                                        <h4>รหัสการจัดส่ง</h4>
                                    </div>
                                    <div class="px-2">
                                        @if ($madeOrders[0]->tracking_no)
                                            <a href="https://th.kerryexpress.com/th/track/"
                                                target="_blank">{{ $madeOrders[0]->tracking_no }}</a>
                                        @else
                                            -
                                        @endif
                                    </div>



                                    @if ($madeOrders[0]->status == 9)
                                        <label class="mt-3" for="">ยืนยันรับของ</label>
                                        <form action="{{ url('update-order/' . $madeOrders[0]->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select class="form-select" name="order_status">
                                                <option {{ $madeOrders[0]->status == '10' ? 'selected ' : '' }}
                                                    value="10">
                                                    ยืนยันรับของ
                                                </option>
                                                <option {{ $madeOrders[0]->status == '11' ? 'selected ' : '' }}
                                                    value="11">
                                                    ปฏิเสธการรับของ
                                                </option>
                                            </select>
                                            <button type="submit" class="btn btn-primary mt-3">Update</button>
                                        </form>
                                    @endif


                                    <div class="px-2 mt-3">
                                        <h4>สถานะ:</h4>
                                        @if ($madeOrders[0]->cancel_order == 1)
                                            <span style="color: red"> ยกเลิกเรียบร้อย</span>
                                        @else
                                            @if ($madeOrders[0]->status == 0)
                                                <span style="color: #979797">รอการประเมินราคา</span>
                                            @else
                                                @if ($madeOrders[0]->status == 1)
                                                    <span style="color: #656565">รอการชำระเงินมัดจำ</span>
                                                @else
                                                    @if ($madeOrders[0]->status == 2 || $madeOrders[0]->status == 6)
                                                        <span style="color: #2c2b2b">รอตรวจสอบหลักฐานการโอนเงิน</span>
                                                    @else
                                                        @if ($madeOrders[0]->status == 3 || $madeOrders[0]->status == 7)
                                                            <span style="color: #800000">สลิปไม่ผ่าน</span>
                                                        @else
                                                            @if ($madeOrders[0]->status == 4)
                                                                <span style="color: rgb(6, 16, 155)">เริ่มดำเนินการ</span>
                                                            @else
                                                                @if ($madeOrders[0]->status == 5)
                                                                    <span
                                                                        style="color: #48a83f">เสร็จสิ้นการดำเนินการ/รอการชำระเงิน</span>
                                                                @else
                                                                    @if ($madeOrders[0]->status == 8)
                                                                        <span
                                                                            style="color: green">กำลังจัดส่งงานศิลปะ</span>
                                                                    @else
                                                                        @if ($madeOrders[0]->status == 9)
                                                                            <span
                                                                                style="color: rgb(6, 16, 155)">รอรับงานศิลปะ</span>
                                                                        @else
                                                                            @if ($madeOrders[0]->status == 10)
                                                                                <span
                                                                                    style="color: #48a83f">จัดส่งสำเร็จ</span>
                                                                            @elseif ($madeOrders[0]->status == 11)
                                                                                <span
                                                                                    style="color: #e51900">ปฏิเสธการรับของ</span>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    </div>


                                    <div class="row">
                                        @if ($madeOrders[0]->tracking_no == null)
                                            @if ($madeOrders[0]->cancel_order == null)
                                                <div class="px-2 mt-3 col-3">
                                                    <a href="{{ url('edit-made-orders/' . $madeOrders[0]->id) }}"
                                                        class="btn btn-outline-secondary btn-sm">แก้ไขที่อยู่</a>
                                                </div>
                                                <div class="px-2 mt-3 col-4">
                                                    <a href="{{ url('destory-item-orders/' . $madeOrders[0]->id) }}"
                                                        class="btn btn-outline-danger btn-sm">ยกเลิกคำสั่งซื้อ</a>
                                                </div>
                                            @endif
                                        @endif
                                    </div>


                                    @foreach ($dataSlip as $_data)
                                        <p class="mt-4">จำนวนเงิน &nbsp; &nbsp; {{ number_format($_data->price, 2) }}
                                            บาท</p>
                                        <p class="mt-4">วันที่ upload &nbsp; &nbsp; {{ $_data->date }}</p>
                                        <p>เวลาที่ upload &nbsp; &nbsp; {{ $_data->time }}</p>
                                        <p>สถานะการตรวจเช็ค&nbsp; &nbsp;

                                            @if ($_data->status_slip == null)
                                                <span style="color: blue">ยังไม่ได้ตรวจสอบ</span>
                                            @elseif ($_data->status_slip == 2)
                                                <span style="color: red">สลิปไม่ถูกต้อง</span>
                                            @elseif ($_data->status_slip == 3)
                                                <span style="color: green">สลิปผ่านเเล้ว </span>
                                            @endif
                                        </p>
                                        <div>
                                            <img src="{{ URL::asset('/assets/uploads/slip/' . $_data->image) }}"
                                                width="150px" height="200px" alt="..."
                                                class="clickable-image cursor-pointer">
                                        </div>
                                    @endforeach

                                </div>
                            @endif


                        </div>

                    </div>
                </div>
            </div>
        </div>
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
