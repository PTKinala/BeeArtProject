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
                        <h4 class="text-white">Order View
                            <a href="{{ url('my-orders') }}" class="btn btn-primary text-whtie float-end">Back</a>
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
                                    {{ $orders->address2 }},<br>
                                    {{ $orders->city }},
                                    {{ $orders->state }},
                                    {{ $orders->country }}
                                </div>
                                <label for="">Zip code</label>
                                <div class="border">{{ $orders->pincode }}</div>
                            </div>
                            <div class="col-md-6">
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
                                                <td>{{ $item->price }} บาท</td>
                                                <td>
                                                    <img src="{{ asset('assets/uploads/products/' . $item->products->image) }}"
                                                        width="50px" alt="Product Image">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <h4 class="px-2">Grand Total: <span class="float-end">{{ $orders->total_price }}
                                        บาท</span></h4>
                            </div>
                            <h5 class="mt-4 mb-3">ช่องทางชำระเงิน</h5>
                            @foreach ($bank as $_bank)
                                <div class="row">
                                    <div class="col-3">
                                        <p>ชื่อธนาคาร: <span class="ml-bank-name-4">{{ $_bank->bank_name }}</span>
                                        </p>

                                    </div>
                                    <div class="col-6">
                                        <p>ชื่อบัญชี: <span class="ml-bank-name-4">{{ $_bank->account_name }}</span></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <p>เลขบัญชี: <span class="ml-bank-name-4">{{ $_bank->account_number }}</span>
                                        </p>

                                    </div>
                                    <div class="col-6">
                                        <p>สาขา: <span class="ml-bank-name-4">{{ $_bank->branch }}</span></p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <p>qrcode: <span class="ml-bank-name-4">
                                                @if ($_bank->image)
                                                    <img src="{{ URL::asset('/assets/uploads/bank/' . $_bank->image) }}"
                                                        class="bank-qrcode" alt="...">
                                                @endif
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
