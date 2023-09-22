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
                        <h1 class="text-white">รายการสั่งซื้อ
                            <a href="{{ 'orders' }}" class="btn btn-warning float-end">รายการสั่งซื้อ</a>
                        </h1>
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
                                                อยู่ระหว่างรอจัดส่ง
                                            @endif
                                        </td>
                                        <td>{{ number_format($item->total_price, 2) }}</td>
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
