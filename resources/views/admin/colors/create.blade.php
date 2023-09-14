@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h4 class="text-white">Add Colors</h4>
        </div>
        <div class="card-body justify-content-center">
            <form action="{{ url('insert-color-type') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-md-8 mb-3">
                        <label for="">ประเภทภาพ</label>
                        <select class="form-select @error('id_image_type') is-invalid @enderror" name="id_image_type"
                            aria-label="Default select example">
                            <option selected disabled>เลือก ประเภทภาพ</option>
                            @foreach ($type as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach

                        </select>
                        @error('id_image_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-8 mb-3">
                        <label for="">ประเภทสี</label>
                        <input type="text" class="form-control @error('color_type') is-invalid @enderror"
                            placeholder="color" name="color_type">
                        @error('color_type')
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


    @include('admin.imageSize.scriptSize');
@endsection
