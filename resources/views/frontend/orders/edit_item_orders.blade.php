@extends('layouts.front')

@section('title')
    checkout
@endsection

@section('content')
    <div class="container mt-5">
        <form action="{{ url('update-item-orders', $orders->id) }}" method="POST">
            {{ csrf_field() }}
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            {{-- contact form --}}
                            <h6>Basic Details</h6>
                            <p id="orders-id">{{ $orders->id }}</p>
                            <hr>
                            <div class="row checkout-form">
                                <div class="col-md-6">
                                    <label for="">First Name </label>
                                    <input type="text" class="form-control" value="{{ $orders->fname }}"
                                        name="fname"required placeholder="Enter First Name">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Last Name</label>
                                    <input type="text" class="form-control" value="{{ $orders->lname }}"
                                        name="lname"required placeholder="Enter Last Name">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">E-mail</label>
                                    <input type="text" class="form-control" value="{{ $orders->email }}"
                                        name="email"required placeholder="Enter E-mail">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Phone Number</label>
                                    <input type="text" class="form-control" value="{{ $orders->phone }}"
                                        name="phone"required placeholder="Enter Phone Number">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Address 1</label>
                                    <input type="text" class="form-control" value="{{ $orders->address1 }}"
                                        name="address1"required placeholder="Enter Address 1">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Address 2</label>
                                    <input type="text" class="form-control" value="{{ $orders->address2 }}"
                                        name="address2" required placeholder="Enter Address 2">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">City</label>
                                    <input type="text" class="form-control" value="{{ $orders->city }}"
                                        name="city"required placeholder="Enter City">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">State</label>
                                    <input type="text" class="form-control" value="{{ $orders->state }}"
                                        name="state"required placeholder="Enter State">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Country</label>
                                    <input type="text" class="form-control" value="{{ $orders->country }}"
                                        name="country"required placeholder="Enter Country">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Pin Code</label>
                                    <input type="text" class="form-control" value="{{ $orders->pincode }}"
                                        name="pincode"required placeholder="Enter Pin Code">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h6>Order Details</h6>
                            <hr>

                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total Price</th>
                                        <th>Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders->orderitems as $item)
                                        <tr>
                                            <td>{{ $item->products->name }}</td>
                                            <td>
                                                <input type="number" class="form-control" value="{{ $item->qty }}"
                                                    id="qty-id" name="qty" id="qty-id" required
                                                    placeholder="Enter State">
                                                {{-- {{ $item->qty }} --}}
                                            </td>
                                            <td id="result-text">
                                                {{ number_format($item->price, 2) }} บาท
                                            </td>
                                            <td id="result-text">
                                                {{ number_format($item->price * $item->qty, 2) }} บาท
                                            </td>
                                            <input type="number" class="form-control" value="{{ $item->price }}"
                                                name="price" id="input-price-id" required placeholder="Enter State"
                                                style="display:none">
                                            <td>
                                                <img src="{{ asset('assets/uploads/products/' . $item->products->image) }}"
                                                    width="50px" alt="Product Image">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{--   <div class="card-body text-center">
                                <h2>Your
                                    <i class="fas fa-shopping-cart"></i>
                                    Cart is empty
                                </h2>
                            </div> --}}

                            <hr>
                            <button type="submit" class="btn btn-primary float-end w-100">Place Order</button>
                        </div>
                    </div>

                    <h5 class="mt-4 mb-4">ช่องทางชำระเงิน</h5>
                    @foreach ($bank as $_bank)
                        <div class="row">
                            <div class="col-6">
                                <p>ชื่อธนาคาร: <span class="ml-bank-name-4">{{ $_bank->bank_name }}</span>
                                </p>

                            </div>
                            <div class="col-6">
                                <p>ชื่อบัญชี: <span class="ml-bank-name-4">{{ $_bank->account_name }}</span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
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
        </form>
    </div>
@endsection
