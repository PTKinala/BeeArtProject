@extends('layouts.admin')

@section('title')
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4 class="text-white">อนุมัติคำขอคืนเงิน
                            <span class=" float-end">
                                <a href="{{ url('/admin/request-admin', $id) }}" class="btn btn-warning ">back</a>

                            </span>
                        </h4>
                    </div>
                    <div class="p-5">
                        <form action="{{ url('update-approve-request/' . $id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <label for="exampleFormControlInput1" class="form-label">สถานะการคืนเงิน </label>
                            <select class="form-select @error('statusRequest') is-invalid @enderror" name="statusRequest">

                                <option disabled>เลือกสถานะการคืนเงิน</option>
                                <option value="1">อนุมัติการคืนเงิน</option>
                                <option value="0">ไม่อนุมัติการคืนเงิน</option>


                            </select>
                            @error('statusRequest')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="comment"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">จำนวนเงิน</label>
                                <input type="number" class="form-control" id="exampleFormControlTextarea1" rows="3"
                                    step="0.01" pattern="\d+(\.\d{2})?" name="price" placeholder="2000" required>

                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <label for="">image สลิป</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    placeholder="40.1*118.8" name="image">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
