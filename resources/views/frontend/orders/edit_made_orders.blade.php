@extends('layouts.front')

@section('title')
    Bee Art Gallery
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
                    <h1 class="mb-3">แก้ไขรายละเอียด</h1>
                    <div class="container mt-3">
                        <form action="{{ url('update-made-order', $madeOrders[0]->id) }}" method="POST"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            {{-- contact form --}}
                                            <h6>รายละเอียดการจัดส่ง</h6>
                                            <hr>
                                            <div class="row checkout-form">
                                                <div class="col-md-6">
                                                    <label for="">ชื่อ</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $madeOrders[0]->fname }}" name="fname"required
                                                        placeholder="Enter First Name">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">นามสกุล</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $madeOrders[0]->lname }}" name="lname"required
                                                        placeholder="Enter Last Name">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">อีเมล</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $madeOrders[0]->email }}" name="email"required
                                                        placeholder="Enter E-mail">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">เบอร์</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $madeOrders[0]->phone }}" name="phone"required
                                                        placeholder="Enter Phone Number">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">ที่อยู่</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $madeOrders[0]->address1 }}" name="address1"required
                                                        placeholder="ที่อยู่">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">ถนน</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $madeOrders[0]->road }}" name="road" required
                                                        placeholder="ถนน">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">ตำบล/แขวง</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $madeOrders[0]->subdistrict }}" name="subdistrict"required
                                                        placeholder="ตำบล/แขวง">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">อำเภอ/เขต</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $madeOrders[0]->district }}" name="district"required
                                                        placeholder="อำเภอ/เขต">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">จังหวัด</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $madeOrders[0]->province }}" name="province" required
                                                        placeholder="จังหวัด">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">รหัสไปรษณีย์</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $madeOrders[0]->zipcode }}" name="zipcode" required
                                                        placeholder="กรอกรหัสไปรษณีย์">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            {{-- contact form --}}
                                            <h6>รายละเอียดคำสั่งซื้อ</h6>
                                            <hr>

                                            @foreach ($madeOrders as $_made)
                                                <div class="row checkout-form mb-3">
                                                    <div class="col-md-6">
                                                        <label for="">ประเภทภาพ</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $data[0]->name }}" required
                                                            placeholder="Enter First Name" disabled>
                                                        <input type="text" class="form-control" style="display: none"
                                                            value="{{ $data[0]->id }}" name="id_image_type[]" required
                                                            placeholder="Enter First Name">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="">เลือก กระดาษเเละขนาดภาพ</label>
                                                        <select class="form-select @error('size[]') is-invalid @enderror"
                                                            name="size[]" aria-label="Size 3 select example" required>
                                                            @foreach ($data as $item)
                                                                @if ($_made->size == $item->size_id)
                                                                    <option value="{{ $item->size_id }}" selected>
                                                                        {{ $item->paper }}
                                                                        &nbsp; {{ $item->size_image_cm }} cm
                                                                    </option>
                                                                @else
                                                                    <option value="{{ $item->size_id }}">
                                                                        {{ $item->paper }}
                                                                        &nbsp; {{ $item->size_image_cm }} cm
                                                                    </option>
                                                                @endif
                                                            @endforeach

                                                        </select>
                                                        @error('size[]')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-md-6 mt-3">
                                                        <label for="">เลือก ประเภทสี</label>
                                                        <select class="form-select @error('color[]') is-invalid @enderror"
                                                            name="color[]" aria-label="Size 3 select example" required>
                                                            @foreach ($dataColor as $item)
                                                                @if ($_made->color == $item->color_id)
                                                                    <option value="{{ $item->color_id }}" selected>
                                                                        {{ $item->color_type }}

                                                                    </option>
                                                                @else
                                                                    <option value="{{ $item->color_id }}">
                                                                        {{ $item->color_type }}

                                                                    </option>
                                                                @endif
                                                            @endforeach

                                                        </select>
                                                        @error('color[]')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <label for="">ภาพอ้างอิง</label>
                                                        <input type="file"
                                                            class="form-control @error('image[]') is-invalid @enderror"
                                                            name="image[]">
                                                        @error('image[]')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>


                                                    <div class="col-md-12 mt-3">
                                                        <label for="">เขียนคำอธิบาย</label>
                                                        <textarea class="form-control" name="description[]" id="exampleFormControlTextarea1" rows="3" required>{{ $_made->description }}</textarea>
                                                    </div>


                                                </div>
                                            @endforeach

                                            <br>
                                            <br>
                                            <button type="submit"
                                                class="btn btn-primary float-end w-100">ยึนยันคำสั่งซื้อ</button>
                                        </div>

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
