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
                        <h4 class="text-white mt-2">รายการสั่งซื้อ</h4>
                    </div>
                    <div class="card-body">
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
                                                    <span style="color: #979797">รอการชำระเงิน</span>
                                                @else
                                                    @if ($item->status == 1)
                                                        <span style="color: #2f2f2f">รอตรวจสอบหลักฐานการโอนเงิน</span>
                                                    @else
                                                        @if ($item->status == 2)
                                                            <span style="color: #800000">สลิปไม่ผ่าน</span>
                                                        @else
                                                            @if ($item->status == 3)
                                                                <span style="color: green">กำลังจัดส่งงานศิลปะ</span>
                                                            @else
                                                                @if ($item->status == 4)
                                                                    <span
                                                                        style="color: rgb(6, 16, 155)">รอรับงานศิลปะ</span>
                                                                @else
                                                                    @if ($item->status == 5)
                                                                        <span style="color: #48a83f">จัดส่งสำเร็จ</span>
                                                                    @elseif ($item->status == 6)
                                                                        <span style="color: #e51900">ปฏิเสธการรับของ</span>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('view-order/' . $item->id) }}" class="btn btn-primary">View</a>

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
