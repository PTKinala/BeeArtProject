@extends('layouts.front')

@section('title')
    BeeArtShop
@endsection

@section('content')
    <div class="py-3 mb-4 shadow-sm bg-secondary">
        <div class="container">
            <h5 class="mb-0">
                <a href="{{ url('shop') }}" class="text-white"> Collections </a>
            </h5>
        </div>
    </div>
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mb-3">Make Art Buy</h1>
                    <div class="container mt-3">
                        <form action="{{ url('place-order') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            {{-- contact form --}}
                                            <h6>Basic Details</h6>
                                            <hr>
                                            <div class="row checkout-form">
                                                <div class="col-md-6">
                                                    <label for="">First Name</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->name }}" name="fname"required
                                                        placeholder="Enter First Name">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Last Name</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->lname }}" name="lname"required
                                                        placeholder="Enter Last Name">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">E-mail</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->email }}" name="email"required
                                                        placeholder="Enter E-mail">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">Phone Number</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->phone }}" name="phone"required
                                                        placeholder="Enter Phone Number">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">Address 1</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->address1 }}" name="address1"required
                                                        placeholder="Enter Address 1">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">Address 2</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->address2 }}" name="address2" required
                                                        placeholder="Enter Address 2">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">City</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->city }}" name="city"required
                                                        placeholder="Enter City">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">State</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->state }}" name="state"required
                                                        placeholder="Enter State">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">Country</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->country }}" name="country"required
                                                        placeholder="Enter Country">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">Pin Code</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->pincode }}" name="pincode"required
                                                        placeholder="Enter Pin Code">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            {{-- contact form --}}
                                            <h6>Order details</h6>
                                            <hr>
                                            <div class="row checkout-form">
                                                <div class="col-md-6">
                                                    <label for="">ประเภทภาพ</label>
                                                    <input type="text" class="form-control" value="{{ $data[0]->name }}"
                                                        name="name"required placeholder="Enter First Name" disabled>
                                                    <input type="text" class="form-control" style="display: none"
                                                        value="{{ $data[0]->id }}" required
                                                        placeholder="Enter First Name">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">กระดาษเเละขนาดภาพ</label>
                                                    {{--   <input type="text" class="form-control"
                                                        value="{{ Auth::user()->lname }}" name="lname"required
                                                        placeholder="Enter Last Name"> --}}
                                                    <select class="form-select" aria-label="Size 3 select example">
                                                        <option selected disabled>เลือก กระดาษเเละขนาดภาพ</option>
                                                        @foreach ($data as $item)
                                                            <option value="{{ $item->size_id }}">{{ $item->paper }}
                                                                &nbsp; {{ $item->size_image_cm }} cm
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">E-mail</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->email }}" name="email"required
                                                        placeholder="Enter E-mail">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">Phone Number</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->phone }}" name="phone"required
                                                        placeholder="Enter Phone Number">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">Address 1</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->address1 }}" name="address1"required
                                                        placeholder="Enter Address 1">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">Address 2</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->address2 }}" name="address2" required
                                                        placeholder="Enter Address 2">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">City</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->city }}" name="city"required
                                                        placeholder="Enter City">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">State</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->state }}" name="state"required
                                                        placeholder="Enter State">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">Country</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->country }}" name="country"required
                                                        placeholder="Enter Country">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">Pin Code</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->pincode }}" name="pincode"required
                                                        placeholder="Enter Pin Code">
                                                </div>

                                            </div>
                                            <br>
                                            <br>
                                            <button type="submit" class="btn btn-primary float-end w-100">Place
                                                Order</button>
                                        </div>

                                        {{-- <div class="card-body">
                                            <h6>Order Details</h6>
                                            <hr>



                                            <button type="submit" class="btn btn-primary float-end w-100">Place
                                                Order</button>
                                        </div> --}}
                                    </div>





                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
