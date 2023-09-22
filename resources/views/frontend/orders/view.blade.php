@extends('layouts.front')

@section('title')
    My Orders
@endsection

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4 class="text-white mt-2">รายการสั่งซื้อ
                            <a href="{{ url('my-orders') }}" class="btn btn-primary text-whtie float-end">Back</a>
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 order-details">
                                <h4>Shipping Details</h4>
                                <hr>
                                <label for="">First Name</label>
                                <div class="border">{{ $orders->fname }}</div>
                                <label for="">Last Name</label>
                                <div class="border">{{ $orders->lname }}</div>
                                <label for="">Email</label>
                                <div class="border">{{ $orders->email }}</div>
                                <label for="">Contact No.</label>
                                <div class="border">{{ $orders->phone }}</div>
                                <label for="">Shipping Address</label>
                                <div class="border">
                                    {{ $orders->address1 }},<br>
                                    {{ $orders->road }},<br>
                                    {{ $orders->subdistrict }},
                                    {{ $orders->district }},
                                    {{ $orders->province }}
                                </div>
                                <label for="">Zip code</label>
                                <div class="border">{{ $orders->zipcode }}</div>

                                <h5 class="mt-4 mb-3 d-flex justify-content-between col-6">ช่องทางชำระเงิน </h5>
                                @foreach ($bank as $_bank)
                                    <div class="row">
                                        <div class="col-3">
                                            <p>ชื่อธนาคาร: <span class="ml-bank-name-4">{{ $_bank->bank_name }}</span>
                                            </p>

                                        </div>
                                        <div class="col-6">
                                            <p>ชื่อบัญชี: <span class="ml-bank-name-4">{{ $_bank->account_name }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
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
                                                            class="bank-qrcode clickable-image cursor-pointer">
                                                    @endif
                                                </span>
                                            </p>
                                        </div>

                                    </div>
                                @endforeach
                            </div>

                            {{-- ! สั่งชื้อ --}}
                            @if (count($orders->orderitems) > 0)
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Image</th>
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
                                    <h4 class="px-2 mt-3">Grand Total: <span
                                            class="float-end">{{ number_format($orders->total_price, 2) }}
                                            บาท</span></h4>
                                    <div class="px-2"><i>รหัสสินค้า</i></div>
                                    <div class="px-2">{{ $orders->order_code }}</div>
                                    <div class="px-2"><i>รหัสการจัดส่ง</i></div>
                                    <div class="px-2">
                                        @if ($orders->tracking_no)
                                            {{ $orders->tracking_no }}
                                        @else
                                            อยู่ระหว่างรอจัดส่ง
                                        @endif
                                    </div>
                                    <label class="mt-3" for="">ยืนยันรับของ</label>
                                    @if ($orders->status == 4)
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

                                    <div class="px-2 mt-3">
                                        สถานะ:
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
                                        @if ($orders->cancel_order == 0)
                                            <div class="px-2  row">
                                                <div class="px-2 mt-3 col-1">
                                                    <a href="{{ url('edit-item-orders/' . $orders->id) }}"
                                                        class="btn btn-outline-secondary btn-sm">Edit
                                                    </a>
                                                </div>
                                                <div class="px-2 mt-3 col-1">
                                                    <a href="{{ url('destory-item-orders/' . $orders->id) }}"
                                                        class="btn btn-outline-danger btn-sm">ยกเลิก</a>
                                                </div>
                                        @endif
                                    @endif

                                    @if ($orders->status > '0' && ($orders->status != '5' && $orders->status != '5'))
                                        <div class="px-4 mt-3 col-3">
                                            <a href="{{ url('request-return/' . $orders->id) }}"
                                                class="btn btn-outline-warning btn-sm">คำร้องขอคืน</a>
                                        </div>
                                    @endif



                                    @if ($orders->status == 0 || $orders->status == 2)
                                        <div>
                                            <a href="{{ url('uploader-slip/' . $orders->id) }}"
                                                class="btn btn-primary mt-3">uplode สลิป</a>
                                        </div>
                                    @endif







                                    @foreach ($dataSlip as $_data)
                                        <p class="mt-4">จำนวนเงิน &nbsp; &nbsp; {{ number_format($_data->price, 2) }}
                                            บาท
                                        </p>
                                        <p class="mt-4">วันที่ uplode &nbsp; &nbsp; {{ $_data->date }}</p>
                                        <p>เวลาที่ uplode &nbsp; &nbsp; {{ $_data->time }}</p>
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


                                    @foreach ($dataRequest as $request)
                                        <div class="mt-5 col-3 mb-3">
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
                            @endif


                            {{-- ! สั่งทำ --}}
                            @if (count($madeOrders) > 0)
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>รายละเอียด</th>
                                                <th>กระดาษ/ขนาด</th>
                                                <th>color_type</th>
                                                <th>Image</th>

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
                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                    <div class="px-2"><i>รหัสสินค้า</i></div>
                                    <div class="px-2">{{ $madeOrders[0]->order_code }}</div>
                                    <div class="px-2"><i>รหัสการจัดส่ง</i></div>
                                    <div class="px-2">
                                        @if ($madeOrders[0]->tracking_no)
                                            {{ $madeOrders[0]->tracking_no }}
                                        @else
                                            อยู่ระหว่างรอจัดส่ง
                                        @endif
                                    </div>
                                    <div class="px-2">รายละเอียดเพิ่มเติม</div>
                                    <div class="px-2">{{ $madeOrders[0]->description }}</div>
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
                                        สถานะ:
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
                                                                <span
                                                                    style="color: rgb(6, 16, 155)">เริ่ิ่มดำเนินการ</span>
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
                                    <h4 class="px-2 mt-3">Grand Total: <span class="float-end">
                                            @if ($madeOrders[0]->total_price)
                                                {{ number_format($madeOrders[0]->total_price, 2) }} บาท
                                            @else
                                                รอการประเมิน
                                            @endif
                                        </span></h4>

                                    <h6> ราคามัดจำ <span class="float-end">
                                            {{ number_format(($madeOrders[0]->total_price * $deposit) / 100, 2) }}
                                            บาท</span> </h6>
                                    <div class="row">
                                        @if ($madeOrders[0]->tracking_no == null)
                                            @if ($madeOrders[0]->cancel_order == 0)
                                                <div class="px-2 mt-3 col-1">
                                                    <a href="{{ url('edit-made-orders/' . $madeOrders[0]->id) }}"
                                                        class="btn btn-outline-secondary btn-sm">Edit</a>
                                                </div>
                                                <div class="px-2 mt-3 col-1">
                                                    <a href="{{ url('destory-item-orders/' . $madeOrders[0]->id) }}"
                                                        class="btn btn-outline-danger btn-sm">ยกเลิก</a>
                                                </div>
                                            @endif
                                        @endif

                                    </div>
                                    @if (
                                        $madeOrders[0]->total_price != null &&
                                            ($madeOrders[0]->status == '1' ||
                                                $madeOrders[0]->status == '3' ||
                                                $madeOrders[0]->status == '5' ||
                                                $madeOrders[0]->status == '7'))
                                        <a href="{{ url('uploader-slip/' . $orders->id) }}"
                                            class="btn btn-primary mt-3 ">uplode
                                            สลิป</a>
                                    @endif


                                    @foreach ($dataSlip as $_data)
                                        <p class="mt-4">จำนวนเงิน &nbsp; &nbsp; {{ number_format($_data->price, 2) }}
                                            บาท</p>
                                        <p class="mt-4">วันที่ uplode &nbsp; &nbsp; {{ $_data->date }}</p>
                                        <p>เวลาที่ uplode &nbsp; &nbsp; {{ $_data->time }}</p>
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
