@extends('layouts.admin')

@section('title')
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h1 class="text-white">{{ $massage }}
                            @if ($massage == 'รายการสั่งซื้อ')
                                <a href="{{ 'orders' }}"
                                    class="btn btn-warning float-end">รายการสั่งซื้อและงานจ้างใหม่</a>
                            @else
                                <a href="{{ 'orders-post-add' }}"
                                    class="btn btn-warning float-end">รายการสั่งซื้อและงานจ้างใหม่</a>
                            @endif

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
                                                @if ($item->status == 5)
                                                    <span style="color: #48a83f">จัดส่งสำเร็จ</span>
                                                @elseif ($item->status == 6)
                                                    <span style="color: #e51900">ปฏิเสธการรับของ</span>
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
