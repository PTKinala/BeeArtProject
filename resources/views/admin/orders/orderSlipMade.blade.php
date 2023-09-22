@extends('layouts.admin')

@section('title')
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        {{--  <h1 class="text-white">รายการสั่งซื้อ
                            <span class=" float-end">
                                <a href="{{ 'orders' }}" class="btn btn-warning ">รายการสั่งซื้อ</a>
                                <a href="{{ 'order-history' }}" class="btn btn-warning ">คำสั่งซื้อสำเร็จแล้ว</a>
                            </span>
                        </h1> --}}
                        <h1 class="text-white">รายการสั่งทำ
                            <a href="{{ 'orders-post-add' }}" class="btn btn-warning float-end">รายการสั่งทำ</a>
                        </h1>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Order Date</th>
                                    <th>รหัสการสั่งทำ</th>
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
                                                อยู่ระหว่างรอจัดส่ง
                                            @endif
                                        </td>
                                        <td>{{ number_format($item->total_price, 2) }}</td>
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
                                                                        style="color: rgb(6, 16, 155)">เริ่ิ่มดำเนินการ</span>
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
@endsection
