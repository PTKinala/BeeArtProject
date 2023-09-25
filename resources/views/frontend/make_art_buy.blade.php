@extends('layouts.front')

@section('title')
    Bee Art Gallery
@endsection

@section('content')
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mb-3">งานสั่งทำ</h1>
                    <div class="container mt-3">
                        <form action="{{ url('insert-made-order') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            {{-- contact form --}}
                                            <h6>รายละเอียด</h6>
                                            <hr>
                                            <div class="row checkout-form">
                                                <div class="col-md-6">
                                                    <label for="">ชื่อ</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('fname', isset($dataAddress[0]->fname) ? $dataAddress[0]->fname : '') }}"
                                                        name="fname"required placeholder="Enter First Name">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">นามสกุล</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('lname', isset($dataAddress[0]->lname) ? $dataAddress[0]->lname : '') }}"
                                                        name="lname"required placeholder="Enter Last Name">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">อีเมล</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ Auth::user()->email }}" name="email"required
                                                        placeholder="Enter E-mail">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">เบอร์</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('phone', isset($dataAddress[0]->phone) ? $dataAddress[0]->phone : '') }}"
                                                        name="phone"required placeholder="Enter Phone Number">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">ที่อยู่</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('address', isset($dataAddress[0]->address) ? $dataAddress[0]->address : '') }}"
                                                        name="address1"required placeholder="ที่อยู่">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">ถนน</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('road', isset($dataAddress[0]->road) ? $dataAddress[0]->road : '') }}"
                                                        name="road" required placeholder="ถนน">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">ตำบล/แขวง</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('subdistrict', isset($dataAddress[0]->subdistrict) ? $dataAddress[0]->subdistrict : '') }}"
                                                        name="subdistrict"required placeholder="ตำบล/แขวง">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">อำเภอ/เขต</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('district', isset($dataAddress[0]->district) ? $dataAddress[0]->district : '') }}"
                                                        name="district"required placeholder="อำเภอ/เขต">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">จังหวัด</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('province', isset($dataAddress[0]->province) ? $dataAddress[0]->province : '') }}"
                                                        name="province"required placeholder="จังหวัด">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">รหัสไปรษณีย์</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('zipcode', isset($dataAddress[0]->zipcode) ? $dataAddress[0]->zipcode : '') }}"
                                                        name="zipcode"required placeholder="กรอกรหัสไปรษณีย์">
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
                                                        required placeholder="Enter First Name" disabled>
                                                    <input type="text" class="form-control" style="display: none"
                                                        value="{{ $data[0]->id }}" name="id_image_type" required
                                                        placeholder="Enter First Name">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">กระดาษเเละขนาดภาพ</label>
                                                    <select class="form-select @error('size') is-invalid @enderror"
                                                        name="size" aria-label="Size 3 select example" required>
                                                        <option selected disabled>เลือก กระดาษเเละขนาดภาพ</option>
                                                        @foreach ($data as $item)
                                                            <option value="{{ $item->size_id }}">{{ $item->paper }}
                                                                &nbsp; {{ $item->size_image_cm }} cm
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                    @error('size')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                {{-- @if ($number_peo)
                                                    <div class="col-md-12 mt-3">
                                                        <label for="">จำนวนคน</label>
                                                        <select class="form-select @error('color') is-invalid @enderror"
                                                            name="number_peo" aria-label="Size 3 select example" required>
                                                            <option selected disabled>เลือก จำนวน</option>
                                                            @foreach ($number_peo as $item)
                                                                <option value="{{ $item->number_pre }}">
                                                                    {{ $item->number_pre }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif --}}
                                                <div class="col-md-6 mt-3">
                                                    <label for="">ประเภทสี</label>
                                                    <select class="form-select @error('color') is-invalid @enderror"
                                                        name="color" aria-label="Size 3 select example" required>
                                                        <option selected disabled>เลือก ประภาทสี</option>
                                                        @foreach ($dataColor as $item)
                                                            <option value="{{ $item->color_id }}">{{ $item->color_type }}

                                                            </option>
                                                        @endforeach

                                                    </select>
                                                    @error('color')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label for="">ภาพอ้างอิง</label>
                                                    <input type="file"
                                                        class="form-control @error('image') is-invalid @enderror"
                                                        name="image" required>
                                                    @error('image')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>


                                                <div class="col-md-12 mt-3">
                                                    <label for="">เขียนคำอธิบาย</label>
                                                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" required></textarea>
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
