@extends('layouts.front')

@section('title')
    My Orders
@endsection

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h4 class="text-white">Order View
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
                                    <label class="mt-3" for="">Order Status</label>
                                    <form action="{{ url('update-order/' . $orders->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select class="form-select" name="order_status">
                                        <option {{ $orders->status == '0' ? 'selected ' : '' }} value="0">Pending
                                        </option>
                                        <option {{ $orders->status == '1' ? 'selected ' : '' }} value="1">Completed
                                        </option>
                                    </select>
                                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                                    </form>
                                    <div class="px-2 mt-3">
                                        สถานะ:
                                        @if ($orders->cancel_order == 0)
                                            <span style="color: green"> กำลังดำเนินงาน</span>
                                        @elseif ($orders->cancel_order == 1)
                                            <span style="color: red"> ยกเลิกเรียบร้อย</span>
                                        @else
                                            <span style="color: blue">อยู่ระหว่างขั้นตอนสุดท้าย</span>
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

                                            </div>
                                        @endif
                                    @endif
                                    <div class="px-2 mt-3 col-3">
                                        <a href="{{ url('request-return/' . $orders->id) }}"
                                            class="btn btn-outline-warning btn-sm">คำร้องขอคืน</a>
                                    </div>





                                    <a href="{{ url('uploader-slip/' . $orders->id) }}" class="btn btn-primary mt-3">uplode
                                        สลิป</a>

                                    @foreach ($dataSlip as $_data)
                                        <p class="mt-4">จำนวนเงิน &nbsp; &nbsp; {{ number_format($_data->price, 2) }} บาท
                                        </p>
                                        <p class="mt-4">วันที่ uplode &nbsp; &nbsp; {{ $_data->date }}</p>
                                        <p>เวลาที่ uplode &nbsp; &nbsp; {{ $_data->time }}</p>
                                        <p>สถานะการตรวจเช็ค&nbsp; &nbsp;
                                            @if ($_data->status_slip == 0)
                                                <span style="color: blue">ยังไม่ได้ตรวจสอบ</span>
                                            @elseif ($_data->status_slip == 1)
                                                <span style="color: green">สลิปผ่านเเล้ว</span>
                                            @else
                                                <span style="color: red">สลิปไม่ถูกต้อง</span>
                                            @endif
                                        </p>

                                        <div>
                                            <img src="{{ URL::asset('/assets/uploads/slip/' . $_data->image) }}"
                                                width="150px" height="200px" alt="..."
                                                class="clickable-image cursor-pointer">
                                        </div>
                                    @endforeach

                                    <div class="mt-5 col-3 mb-3">
                                        <h5>คำร้องขอคืนเงิน</h5>
                                    </div>
                                    @foreach ($dataRequest as $request)
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

                            @if (count($madeOrders) > 0)
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>รายละเอียด</th>
                                                <th>กระดาบ/ขนาด</th>
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
                                    <label class="mt-3" for="">Order Status</label>
                                    <form action="{{ url('update-order/' . $madeOrders[0]->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select class="form-select" name="order_status">
                                        <option {{ $madeOrders[0]->status == '0' ? 'selected ' : '' }} value="0">Pending
                                        </option>
                                        <option {{ $madeOrders[0]->status == '1' ? 'selected ' : '' }} value="1">Completed
                                        </option>
                                    </select>
                                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                                    </form>
                                    <div class="px-2 mt-3">
                                        สถานะ:


                                        @if ($madeOrders[0]->cancel_order == 0)
                                            <span style="color: green"> กำลังดำเนินงาน</span>
                                        @elseif ($madeOrders[0]->cancel_order == 1)
                                            <span style="color: red"> ยกเลิกเรียบร้อย</span>
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
                                    <a href="{{ url('uploader-slip/' . $orders->id) }}"
                                        class="btn btn-primary mt-3 ">uplode
                                        สลิป</a>
                                    @foreach ($dataSlip as $_data)
                                        <p class="mt-4">จำนวนเงิน &nbsp; &nbsp; {{ number_format($_data->price, 2) }}
                                            บาท</p>
                                        <p class="mt-4">วันที่ uplode &nbsp; &nbsp; {{ $_data->date }}</p>
                                        <p>เวลาที่ uplode &nbsp; &nbsp; {{ $_data->time }}</p>
                                        <p>สถานะการตรวจเช็ค&nbsp; &nbsp;
                                            @if ($_data->status_slip == 0)
                                                <span style="color: blue">ยังไม่ได้ตรวจสอบ</span>
                                            @elseif ($_data->status_slip == 1)
                                                <span style="color: green">สลิปผ่านเเล้ว</span>
                                            @else
                                                <span style="color: red">สลิปไม่ถูกต้อง</span>
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
