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
                            <a href="{{ 'orders' }}" class="btn btn-warning float-end">รายการคำซื้อและงานจ้างใหม่</a>
                        </h1>
                        
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Order Date</th>
                                    <th>Name</th>
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
                                            @if ($item->name)
                                                {{ $item->name }}
                                            @else
                                                {{ $item->products_name }}
                                            @endif
                                        </td>
                                        <td>{{ $item->tracking_no }}</td>
                                        <td>{{ $item->total_price }}</td>
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
