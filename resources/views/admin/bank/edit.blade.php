@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h4 class="text-white">Edit Bank Account</h4>
        </div>
        <div class="card-body justify-content-center">
            <form action="{{ url('update-bank-account', $bank->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-md-8 mb-3">
                        <label for="">ชื่อธนาคาร</label>
                        <input type="text" class="form-control  @error('bank_name') is-invalid @enderror"
                            value="{{ $bank->bank_name }}" name="bank_name">
                        @error('bank_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-8 mb-3">
                        <label for="">ชื่อบัญชี</label>
                        <input type="text" class="form-control @error('account_name') is-invalid @enderror"
                            value="{{ $bank->account_name }}" name="account_name">
                        @error('account_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-8 mb-3">
                        <label for="">เลขบัญชี</label>
                        <input type="text" class="form-control  @error('account_number') is-invalid @enderror"
                            value="{{ $bank->account_number }}" name="account_number">
                        @error('account_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-8 mb-3">
                        <label for="">สาขา</label>
                        <input type="text" class="form-control @error('branch') is-invalid @enderror"
                            value="{{ $bank->branch }}" name="branch">
                        @error('branch')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-8 mb-3">
                        <label for="">qrcode</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="form-group col-md-12 mb-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
