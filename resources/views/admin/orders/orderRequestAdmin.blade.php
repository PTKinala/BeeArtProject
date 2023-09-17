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

                                        @foreach ($requestData as $_data)
                                            <div class="mt-3 row justify-content-between">
                                                <p class="col-6">ข้อมูลคำร้องขอคึนเงิน </p>
                                                <a href="{{ url('/admin/approve-request', $_data->id) }}"
                                                    style="font-size: 14px; color: blue;" class="col-6">อนุมัติคำขอ</a>
                                            </div>


                                            <div class="mt-2">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>ธนาคาร &nbsp; &nbsp; {{ $_data->bank }}</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p>ชื่อบัญชี &nbsp; &nbsp;{{ $_data->bankName }}</p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>เลขที่บัญชี &nbsp; &nbsp;{{ $_data->account_number }}</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p>สาขา &nbsp; &nbsp;{{ $_data->branch }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p>เหตุผลการขอคึนเงิน &nbsp; &nbsp;{{ $_data->reason }}</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p>สถานะการคืนเงิน
                                                        </p>
                                                        @if ($_data->statusRequest == '0')
                                                            <p style="color: red">ไม่อนุมัติการคืนเงิน</p>
                                                        @elseif ($_data->statusRequest == '1')
                                                            <p style="color: green">อนุมัติการคืนเงิน</p>
                                                        @else
                                                            <p></p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <p>เหตุผลการ&nbsp; อนุมัติ/ไม่อนุมัติ &nbsp;
                                                            &nbsp;{{ $_data->comment }}
                                                        </p>
                                                    </div>

                                                </div>
                                                <div>
                                                    <img src="{{ URL::asset('/assets/uploads/requestSlip/' . $_data->image) }}"
                                                        width="150px" height="200px" alt="..." id="myImg">
                                                </div>
                                            </div>
                                        @endforeach
                                @endif


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
