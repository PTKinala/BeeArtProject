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
                            @if (count($orders->orderitems) > 0)
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
                                                    <td>{{ number_format($item->price, 2) }} บาท</td>
                                                    <td>
                                                        <img src="{{ asset('assets/uploads/products/' . $item->products->image) }}"
                                                            width="50px" alt="Product Image">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <h4 class="px-2 mt-3">Grand Total: <span
                                            class="float-end">{{ number_format($orders->total_price, 2) }}
                                            บาท</span></h4>

                                    @foreach ($orders->orderitems as $item)
                                        @if ($loop->index == 1)
                                            <div class="px-2 mt-3">
                                                สถานะ:
                                                @if ($item->cancel_order == 0)
                                                    <span style="color: green"> กำลังดำเนินงาน</span>
                                                @else
                                                    <span style="color: red"> ยกเลิกเรียบร้อย</span>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach

                                    @if ($orders->tracking_no == null)
                                        @foreach ($orders->orderitems as $item)
                                            @if ($item->cancel_order == 0 && $loop->index == 1)
                                                <div class="px-2  row">
                                                    <div class="px-2 mt-3 col-1">
                                                        <a href="{{ url('edit-item-orders/' . $orders->id) }}"
                                                            class="btn btn-outline-secondary btn-sm">Edit
                                                        </a>
                                                    </div>
                                                    <div class="px-2 mt-3 col-1">
                                                        <a href="{{ url('destory-item-orders/' . $orders->id) }}"
                                                            class="btn btn-outline-danger btn-sm">ยกเลิก</a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif



                                </div>
                            @endif

                            @if (count($madeOrders) > 0)
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>รายละเอียด</th>
                                                <th>กระดาบ/ขนาด</th>
                                                <th>color_type</th>
                                                <th>Image</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($madeOrders as $item)
                                                <tr>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->paper }} {{ ' ' }}{{ $item->size_image_cm }}
                                                    </td>
                                                    <td>{{ $item->color_type }}</td>
                                                    <td>
                                                        <img src="{{ asset('assets/uploads/madeOrder/' . $item->image) }}"
                                                            width="50px" alt="Product Image">
                                                    </td>
                                                    <td>

                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>
                                    <div class="px-2">รายละเอียดเพิ่มเติม</div>
                                    <div class="px-2">{{ $madeOrders[0]->description }}</div>
                                    <div class="px-2 mt-3">
                                        สถานะ:
                                        @if ($item->status_e_d < 2)
                                            <span style="color: green"> กำลังดำเนินงาน</span>
                                        @else
                                            <span style="color: red"> ยกเลิกเรียบร้อย</span>
                                        @endif
                                    </div>
                                    <h4 class="px-2 mt-3">Grand Total: <span class="float-end">รอการประเมิน</span></h4>
                                    <div class="row">
                                        @if ($madeOrders[0]->tracking_no == null)
                                            @if ($madeOrders[0]->status_e_d == 0)
                                                <div class="px-2 mt-3 col-1">
                                                    <a href="{{ url('edit-made-orders/' . $madeOrders[0]->id) }}"
                                                        class="btn btn-outline-secondary btn-sm">Edit</a>
                                                </div>
                                                <div class="px-2 mt-3 col-1">
                                                    <a href="{{ url('delete-made-orders/' . $madeOrders[0]->id) }}"
                                                        class="btn btn-outline-danger btn-sm">ยกเลิก</a>
                                                </div>
                                            @endif
                                        @endif

                                    </div>

                                </div>
                            @endif

                            <h5 class="mt-4 mb-3 d-flex justify-content-between col-6">ช่องทางชำระเงิน </h5>
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
                            <div class="col-6">
                                <a href="#" class="btn btn-primary">uplode
                                    สลิป</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
