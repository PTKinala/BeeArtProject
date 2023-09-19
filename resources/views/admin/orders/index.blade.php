@extends('layouts.admin')

@section('title')
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h1 class="text-white">รายการคำซื้อและงานจ้าง
                            <span class=" float-end">
                                <a href="{{ 'request-return-admin' }}" class="btn btn-warning ">คำร้องขอคืนเงิน</a>
                                <a href="{{ 'order-slip' }}" class="btn btn-warning">Slip</a>
                                <a href="{{ 'order-history' }}" class="btn btn-warning ">completed Orders</a>
                            </span>
                        </h1>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Order Date</th>
                                    <th>รหัสการสั่งซื้อ</th>
                                    <th>Tracking Number</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
                                            @if ($item->cancel_order == 1)
                                                <span style="color: red"> ยกเลิกเรียบร้อย</span>
                                            @else
                                                @if ($item->tracking_no)
                                                    {{ $item->tracking_no }}
                                                @else
                                                    อยู่ระหว่างรอจัดส่ง
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->total_price)
                                                {{ number_format($item->total_price, 2) }} บาท
                                            @else
                                                รอการประเมิน
                                            @endif
                                        </td>
                                        <td>{{ $item->status == '0' ? 'pending' : 'completed' }}</td>
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
