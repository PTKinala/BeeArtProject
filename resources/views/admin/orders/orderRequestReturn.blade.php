@extends('layouts.admin')

@section('title')
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h1 class="text-white">รายการสั่งซื้อ
                            <span class=" float-end">
                                <a href="{{ 'orders' }}" class="btn btn-warning ">รายการสั่งซื้อ</a>
                                <a href="{{ 'order-history' }}" class="btn btn-warning ">คำสั่งซื้อสำเร็จแล้ว</a>
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
                                        <td>{{ $item->status == '0' ? 'pending' : 'completed' }}</td>
                                        <td>
                                            <a href="{{ url('admin/request-admin/' . $item->id) }}"
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
