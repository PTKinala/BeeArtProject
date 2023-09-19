@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h4 class="text-white">Edit Image Type</h4>
        </div>
        <div class="card-body justify-content-center">
            <form action="{{ url('update-image-type', $imageType->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-md-8 mb-3">
                        <label for="">ชื่อประเภทภาพ</label>
                        <input type="text" value="{{ $imageType->name }}"
                            class="form-control @error('name') is-invalid @enderror" name="name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-check col-md-8 mb-3">
                        <input type="checkbox" {{ $imageType->status == '1' ? 'checked' : '' }} name="status">
                        <label for="">Status</label>
                    </div>
                    <div class="form-group col-md-8 mb-3">
                        <label for="">image</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-12 mb-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
