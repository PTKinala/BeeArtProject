@extends('layouts.front')

@section('title')
    Cart
@endsection

@section('content')

    <div class="py-3 mb-4 shadow-sm bg-primary">
        <div class="container">
            <h5 class="mb-0 text-white">
                <a href="{{ url('/') }}" class="text-white">
                    หน้าแรก
                </a> /
                <a href="{{ url('cart') }}" class="text-white">
                    ตะกร้าสินค้า
                </a>
            </h5>
        </div>
    </div>

    <div class="container my-5">
        <div class="card shadow position-relative">
            @if ($cartitems->count() > 0)
                <div class="card-body">
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($cartitems as $item)
                        <div class="row product_data">
                            <div class="col-md-2 my-auto">
                                <img src="{{ asset('assets/uploads/products/' . $item->products->image) }}" height="70px"
                                    width="70px" alt="Image here">
                            </div>
                            <div class="col-md-3 my-auto">
                                <h3>{{ $item->products->name }}</h3>
                            </div>
                            <div class="col-md-2 my-auto">
                                <h3>{{ number_format($item->products->selling_price, 2) }} บาท</h3>
                            </div>
                            <div class="col-md-3 my-auto">
                                <input type="hidden" class="prod_id" value="{{ $item->prod_id }}">
                                @if ($item->products->qty >= $item->prod_qty)
                                    <label for="Quantity">Quantity</label>
                                    <div class="input-group text-center mb-3" style="width:130px;">
                                        <button class="input-group-text changeQuantity decrement-btn">-</button>
                                        <input type="text" name="quantity" class="form-control qty-input text-center"
                                            value="{{ $item->prod_qty }}">
                                        <button class="input-group-text changeQuantity increment-btn">+</button>
                                    </div>
                                    @php
                                        $total += $item->products->selling_price * $item->prod_qty;
                                    @endphp
                                     @else
                                     <button type="button" class="btn btn-secondary me-3 float-start" disabled>Out of Stock <i class="fas fa-shopping-cart"></i></button>
                                     @endif

                            </div>
                            <div class="col-md-2 my-auto">
                                <button class="btn btn-danger delete-cart-item"> <i class="fas fa-minus-circle"></i>
                                    ลบสินค้า</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <h5>ราคารวม : {{ number_format($total, 2) }} บาท
                        <a href="{{ url('checkout') }}" class="btn btn-outline-success float-end">ยืนยันคำสั่งซื้อ</a>
                    </h5>

                </div>
            @else
                <div class="card-body text-center py-5 my-5">
                    <h2>
                        <i class="fas fa-shopping-cart"></i>
                        ตะกล้าสินค้าว่างเปล่า
                    </h2>
                    <a href="{{ url('shop') }}"
                        class="btn btn-outline-primary m-3 position-absolute bottom-0 end-0">เลือกซื้อสินค้า</a>
                </div>
            @endif
        </div>
    </div>
@endsection
