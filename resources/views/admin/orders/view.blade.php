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
                        <h4 class="text-white">Order View
                            <a href="{{ url('orders') }}" class="btn btn-warning text-whtie float-end">Back</a>
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
                            </div>
                            <div class="col-md-6">
                                @if (count($orders->orderitems) > 0)
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
                                                    <td>{{ number_format($item->price, 2) }}</td>
                                                    <td>
                                                        <img src="{{ asset('assets/uploads/products/' . $item->products->image) }}"
                                                            width="50px" alt="Product Image">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <h4 class="px-2">Grand Total: <span
                                            class="float-end">{{ number_format($orders->total_price, 2) }}</span>
                                @endif

                                @if (count($madeOrders) > 0)
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
                                                    <td>{{ $item->paper }}
                                                        {{ ' ' }}{{ $item->size_image_cm }}
                                                    </td>
                                                    <td>{{ $item->color_type }}</td>
                                                    <td>
                                                        <img src="{{ asset('assets/uploads/madeOrder/' . $item->image) }}"
                                                            width="50px" alt="Product Image">
                                                    </td>
                                                    <td>

                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                    <div class="px-2">รายละเอียดเพิ่มเติม</div>
                                    <div class="px-2">{{ $madeOrders[0]->description }}</div>
                                    <div class="px-2 mt-3">
                                        สถานะ:


                                        @if ($madeOrders[0]->cancel_order == 0)
                                            <span style="color: green"> กำลังดำเนินงาน</span>
                                        @elseif ($madeOrders[0]->cancel_order == 1)
                                            <span style="color: red"> ยกเลิกเรียบร้อย</span>
                                        @endif
                                    </div>
                                    <h4 class="px-2 mt-3">Grand Total: <span class="float-end">รอการประเมิน</span></h4>
                                @endif

                                </h4>
                                <label for="">Order Status</label>
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
                                <label for="">เลขรหัสขนส่ง</label>
                                <form action="{{ url('update-tracking_no/' . $orders->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="tracking_no" class="form-control"
                                        value="{{ $orders->tracking_no }}" placeholder="รหัสขนส่ง">
                                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                                </form>

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
                                    <p class="mt-4">จำนวนเงิน &nbsp; &nbsp; {{ number_format($_data->price, 2) }} บาท</p>
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
                                        <form action="{{ url('check-update-slip/' . $orders->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select class="form-select @error('slip_status') is-invalid @enderror"
                                                name="slip_status" required>
                                                <option {{ $_data->status_slip == '0' ? 'selected ' : '' }} disabled>
                                                    ยังไม่ได้ตรวจสอบสลิป
                                                </option>
                                                <option {{ $_data->status_slip == '1' ? 'selected ' : '' }} value="1">
                                                    สลิปถูกต้อง
                                                </option>
                                                <option {{ $_data->status_slip == '2' ? 'selected ' : '' }} value="2">
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
                                    </div>
                                    <div>
                                        <img src="{{ URL::asset('/assets/uploads/slip/' . $_data->image) }}" width="150px"
                                            height="200px" alt="..." id="myImg">
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

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById("myImg");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");
        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        }

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }
    </script>
@endsection
