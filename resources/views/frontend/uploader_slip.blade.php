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
                                <h4>Uploader Slip</h4>
                                <hr>
                                <form action="{{ url('insert-image-slip') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="text" name="idOrder" value="{{ $id }}" class="form-contro"
                                        style="display: none">
                                    <div class="form-group ">
                                        <label for="" class="form-label">image Slip</label>
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
