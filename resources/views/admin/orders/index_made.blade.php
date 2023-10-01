@extends('layouts.admin')

@section('title')
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h1 class="text-white">รายการสั่งทำ
                            <span class=" float-end">
                                <a href="{{ 'order-slip-made' }}" class="btn btn-warning">สลิปการชำระเงิน</a>
                                <a href="{{ 'order-history-made' }}" class="btn btn-warning ">คำสั่งซื้อสำเร็จแล้ว</a>
                            </span>
                        </h1>
                    </div>
                    <div class="card-body">
                        <div class="mt-3 mb-4 col-3">
                            <form method="POST" action="/orders-post-add" id="myForm">
                                @csrf
                                <select class="form-select" name="selectStatus" aria-label="Default select example"
                                    id="mySelect" onchange="submitForm()">
                                    <option selected disabled>เลือกสถานะ</option>
                                    <option value="0">รอการประเมินราคา</option>
                                    <option value="1">รอการชำระเงินมัดจำ</option>
                                    <option value="2">รอตรวจสอบหลักฐานการโอนเงินมัดจำ</option>
                                    <option value="3">เริ่ิ่มดำเนินการ</option>
                                    <option value="4">เสร็จสิ้นการดำเนินการ/รอการชำระเงิน</option>
                                    <option value="5">เสร็จสิ้นการดำเนินการ/รอการชำระเงิน</option>
                                    <option value="6">รอตรวจสอบหลักฐานการโอนเงิน (เงินก้อนสุดท้าย)</option>
                                    <option value="7">สลิปไม่ผ่าน</option>
                                    <option value="8">กำลังจัดส่งงานศิลปะ</option>
                                    <option value="9">รอรับงานศิลปะ</option>
                                </select>
                            </form>


                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Order Date</th>
                                    <th>รหัสการสั่งซื้อ</th>
                                    <th>Tracking Number</th>
                                    <th>ราคา</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $item)
                                    <tr>
                                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                        <td>
                                            {{ $item->order_code }}
                                        </td>
                                        <td>
                                            @if ($item->tracking_no)
                                                {{ $item->tracking_no }}
                                            @else
                                                ยังไม่มีรหัสขนส่ง
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->total_price)
                                                {{ number_format($item->total_price, 2) }} บาท
                                            @else
                                                รอการประเมิน
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->cancel_order == 1)
                                                <span style="color: red"> ยกเลิกเรียบร้อย</span>
                                            @else
                                                @if ($item->status == 0)
                                                    <span style="color: #979797">รอการประเมินราคา</span>
                                                @else
                                                    @if ($item->status == 1)
                                                        <span style="color: #656565">รอการชำระเงินมัดจำ</span>
                                                    @else
                                                        @if ($item->status == 2 || $item->status == 6)
                                                            <span style="color: #2c2b2b">รอตรวจสอบหลักฐานการโอนเงิน</span>
                                                        @else
                                                            @if ($item->status == 3 || $item->status == 7)
                                                                <span style="color: #800000">สลิปไม่ผ่าน</span>
                                                            @else
                                                                @if ($item->status == 4)
                                                                    <span
                                                                        style="color: rgb(6, 16, 155)">เริ่มดำเนินการ</span>
                                                                @else
                                                                    @if ($item->status == 5)
                                                                        <span
                                                                            style="color: #48a83f">เสร็จสิ้นการดำเนินการ/รอการชำระเงิน</span>
                                                                    @else
                                                                        @if ($item->status == 8)
                                                                            <span
                                                                                style="color: green">กำลังจัดส่งงานศิลปะ</span>
                                                                        @else
                                                                            @if ($item->status == 9)
                                                                                <span
                                                                                    style="color: rgb(6, 16, 155)">รอรับงานศิลปะ</span>
                                                                            @else
                                                                                @if ($item->status == 10)
                                                                                    <span
                                                                                        style="color: #48a83f">จัดส่งสำเร็จ</span>
                                                                                @elseif ($item->status == 11)
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
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/view-order/' . $item->id) }}"
                                                class="btn btn-primary">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function submitForm() {
            // รับแบบฟอร์ม
            var form = document.getElementById("myForm");
            // ส่งแบบฟอร์ม
            form.submit();
        }
    </script>

@endsection
