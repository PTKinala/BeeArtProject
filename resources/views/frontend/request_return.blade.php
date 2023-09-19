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
                    <h1 class="mb-3">คำร้องขอคึนเงิน</h1>
                    <div class="container mt-3">
                        <form action="{{ url('insert-request-return') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            {{-- contact form --}}
                                            <h6>ส่งคำร้องขอคึนเงิน </h6>
                                            <hr>
                                            <div class="row checkout-form">
                                                <div class="col-md-6" style="display: none">
                                                    <label for="">เลขสินค้า</label>
                                                    <input type="text" class="form-control" name="idOrder"
                                                        value="{{ $id }}" placeholder="Enter First Name">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">ธนาคาร</label>
                                                    <input type="text" class="form-control" name="bank"required
                                                        placeholder="Enter First Name">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">ชื่อบัญชี</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('fname', isset($dataAddress[0]->fname) ? $dataAddress[0]->fname : '') }}"
                                                        name="bankName"required placeholder="Enter First Name">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">เลขที่บัญชี</label>
                                                    <input type="text" class="form-control" name="account_number"required
                                                        placeholder="Enter First Name">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">สาขา</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('fname', isset($dataAddress[0]->fname) ? $dataAddress[0]->fname : '') }}"
                                                        name="branch"required placeholder="Enter First Name">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="">เหตุผลการขอคืนเงิน</label>
                                                    <textarea class="form-control" name="reason" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                </div>
                                                <div class="form-group ">
                                                    <label for="" class="form-label">image</label>
                                                    <input type="file" name="image_order"
                                                        class="form-control @error('image_order') is-invalid @enderror" required>
                                                    @error('image_order')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                            </div>
                                            <button type="submit" class="btn btn-primary float-end mt-3">ส่งคำร้อง</button>
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
