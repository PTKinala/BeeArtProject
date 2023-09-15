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
                        <h4 class="text-white">My Orders</h4>
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
                                        <td>
                                            @if ($item->total_price)
                                                {{ $item->total_price }} บาท
                                            @else
                                                รอการประเมิน
                                            @endif
                                        </td>
                                        <td>{{ $item->status == '0' ? 'pending' : 'completed' }}</td>
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
