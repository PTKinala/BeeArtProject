@extends('layouts.front')

@section('title')
    My Orders
@endsection

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="mt-2">รายการสั่งซื้อ
                            <a href="{{ url('my-orders') }}" class="btn btn-primary text-whtie float-end">Back</a>
                        </h1>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 order-details">
                                <h4>ส่งหลักฐานการชำระเงิน</h4>
                                <hr>
                                <form action="{{ url('insert-image-slip') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="text" name="idOrder" value="{{ $id }}" class="form-contro"
                                        style="display: none">
                                    <div class="form-group ">
                                        <label for="" class="form-label">สลิปหลักฐานการโอนเงิน</label>
                                        <input type="file" name="image"
                                            class="form-control @error('image') is-invalid @enderror" required>
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="row mt-3">
                                        <div class="mb-3 col-6">
                                            <label for="exampleFormControlInput1" class="form-label">จำนวนเงิน</label>
                                            <input type="number" class="form-control" id="exampleFormControlInput1"
                                                step="0.01" pattern="\d+(\.\d{2})?" name="price" required
                                                placeholder="1500">
                                        </div>
                                    </div>
                                    @if ($v_code == 'Mad')
                                        <div class="form-check full-amount">
                                            <input class="form-check-input  ml-3" type="checkbox" name="full_amount"
                                                id="flexCheckChecked">
                                            <label class="form-check-label" for="flexCheckChecked">
                                                โอนเเบบราคาเต็ม
                                            </label>
                                        </div>
                                    @endif
                                    <div class="row mt-3">
                                        <div class="mb-3 col-6">
                                            <label for="exampleFormControlInput1" class="form-label">วันที่โอน</label>
                                            <input type="text" class="form-control" id="exampleFormControlInput1"
                                                name="date" required placeholder="30-12-2023">
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label for="exampleFormControlInput1" class="form-label">เวลาที่โอน</label>
                                            <input type="text" class="form-control" name="time"
                                                id="exampleFormControlInput1" required placeholder="19.30">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 mb-3">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
