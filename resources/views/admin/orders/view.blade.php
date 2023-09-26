@extends('layouts.admin')

@section('title')
    My Orders
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h1 class="text-white">รายละเอียดคำสั่งซื้อ
                            <a href="{{ url('orders') }}" class="btn btn-warning text-whtie float-end">Back</a>
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
                            </div>
                            <div class="col-md-6">


                                @if (count($orders->orderitems) > 0)
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
                                                    <td>{{ number_format($item->price, 2) }}</td>
                                                    <td>
                                                        <img src="{{ asset('assets/uploads/products/' . $item->products->image) }}"
                                                            width="50px" alt="Product Image"
                                                            class="clickable-image cursor-pointer">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <h4 class="px-2">ราคารวม: <span
                                            class="float-end">{{ number_format($orders->total_price, 2) }}</span>
                                    </h4>
                                    <div class="px-2 mt-3"><h4>รหัสสินค้า</h4></div>
                                    <div class="px-2">{{ $orders->order_code }}</div>
                                    <div class="px-2 mt-3">
                                        <h4>สถานะ:</h4>

                                        {{--
                                        @if ($orders->cancel_order == 0)
                                            <span style="color: green"> กำลังดำเนินงาน</span>
                                        @elseif ($orders->cancel_order == 1)
                                            <span style="color: red"> ยกเลิกเรียบร้อย</span>
                                        @endif --}}


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
                                @endif



                                {{-- ! ส่วนของสั่งทำ  --}}
                                @if (count($madeOrders) > 0)
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>รายละเอียด</th>
                                                <th>กระดาษ/ขนาด</th>
                                                <th>เทคนิคสี</th>
                                                <th>รูปอ้างอิง</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($madeOrders as $item)
                                                <tr>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->paper }}
                                                        {{ ' ' }}{{ $item->size_image_cm }}
                                                    </td>
                                                    <td>{{ $item->color_type }}</td>
                                                    <td>
                                                        <img src="{{ asset('assets/uploads/madeOrder/' . $item->image) }}"
                                                            width="50px" alt="Product Image"
                                                            class="clickable-image cursor-pointer">
                                                    </td>
                                                    <td>

                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                    <div class="px-2"><h4>รายละเอียดเพิ่มเติม</h4></div>
                                    <div class="px-2">{{ $madeOrders[0]->description }}</div>
                                    <div class="px-2"><h4>รหัสสินค้า</h4></div>
                                    <div class="px-2">{{ $madeOrders[0]->order_code }}</div>
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

                                    <h4 class="px-2 mt-3">ราคารวม: <span class="float-end">
                                            @if ($madeOrders[0]->total_price)
                                                {{ number_format($madeOrders[0]->total_price, 2) }}
                                            @else
                                                รอการประเมิน
                                            @endif

                                        </span></h4>

                                    <label for="">ราคาชิ้นงาน</label>
                                    <form action="{{ url('update-price-order/' . $orders->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="price" class="form-control" step="0.01"
                                            pattern="\d+(\.\d{2})?" value="{{ $madeOrders[0]->total_price }}"
                                            placeholder="100" required>
                                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                                    </form>
                                @endif

                                </h4>


                                <h4 class="mt-3">เลขรหัสขนส่ง</h4>
                                <form action="{{ url('update-tracking_no/' . $orders->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="tracking_no" class="form-control"
                                        value="{{ $orders->tracking_no }}" placeholder="รหัสขนส่ง">
                                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                                </form>


                                
                                @if (count($madeOrders) > 0  && $madeOrders[0]->status == 4)
                                    <form action="{{ url('update-order-succeed/' . $orders->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success mt-3">เสร็จสิ้นการดำเนินการ</button>
                                    </form>
                                @endif



                                @if ($orders->cancel_order == 2)
                                    <a href="{{ url('update-cancel_order-open/' . $orders->id) }}" type="button"
                                        class="btn btn-secondary"
                                        onclick="return confirm('คุณต้องการซ่อนปุ่มแก้ไขหรือยกเลิกใช่หรือไม่?')">เปิด
                                        ปุ่มเเก้ไขหรือยกเลิก</a>
                                @else
                                    <a href="{{ url('update-cancel_order/' . $orders->id) }}" type="button"
                                        class="btn btn-warning"
                                        onclick="return confirm('คุณต้องการซ่อนปุ่มแก้ไขหรือยกเลิกใช่หรือไม่?')">ซ่อน
                                        ปุ่มเเก้ไขหรือยกเลิก</a>
                                @endif
                                <div>
                                    <label for="" class="mt-3">รายละเอียดการโอนเงิน</label>
                                </div>
                                @foreach ($slipData as $_data)
                                    <p class="mt-4">จำนวนเงิน &nbsp; &nbsp; {{ number_format($_data->price, 2) }} บาท
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
                                        {{--  --}}
                                    </p>
                                    <div>

                                        @if ($_data->status_slip == null)
                                            <form action="{{ url('check-update-slip/' . $_data->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select class="form-select @error('slip_status') is-invalid @enderror"
                                                    name="slip_status" required>
                                                    <option {{ $_data->status_slip == '0' ? 'selected ' : '' }} disabled>
                                                        ยังไม่ได้ตรวจสอบสลิป
                                                    </option>
                                                    <option {{ $_data->status_slip == '3' ? 'selected ' : '' }}
                                                        value="3">
                                                        สลิปถูกต้อง
                                                    </option>
                                                    <option {{ $_data->status_slip == '2' ? 'selected ' : '' }}
                                                        value="2">
                                                        สลิปไม่ถูกต้อง
                                                    </option>
                                                </select>
                                                @error('slip_status')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <button type="submit" class="btn btn-primary mt-3">Update</button>
                                            </form>
                                        @endif

                                    </div>

                                    <div>
                                        <img src="{{ URL::asset('/assets/uploads/slip/' . $_data->image) }}"
                                            width="150px" height="200px" alt="..."
                                            class="clickable-image cursor-pointer">
                                    </div>
                                @endforeach



                            </div>
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
