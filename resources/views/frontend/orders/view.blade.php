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
                                                            class="bank-qrcode" id="myImg">
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
                                                            width="50px" alt="Product Image">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <h4 class="px-2 mt-3">Grand Total: <span
                                            class="float-end">{{ number_format($orders->total_price, 2) }}
                                            บาท</span></h4>
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
                                                width="150px" height="200px" alt="..." id="myImg">
                                        </div>
                                    @endforeach

                                    <div class="mt-5 col-3 mb-3">
                                        <h5>คำร้องขอคืนเงิน</h5>
                                    </div>
                                    @foreach ($dataRequest as $request)
                                        <p>ธนาคาร {{ $request->bank }}</p>
                                        <p>ชื่อบัญชี {{ $request->bankName }}</p>
                                        <p>เลขที่บัญชี {{ $request->account_number }}</p>
                                        <p>สาขา {{ $request->branch }}</p>
                                        <p>เหตุผล {{ $request->reason }}</p>
                                        <p>สถานะคำร้อง {{ $request->statusRequest }}</p>
                                        <p>เหตุผลของสถานะ {{ $request->comment }}</p>
                                        <div>
                                            <img src="{{ URL::asset('/assets/uploads/requestSlip/' . $request->image) }}"
                                                width="150px" height="200px" alt="..." id="myImg2">
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
                                                width="150px" height="200px" alt="..." id="myImg">
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
