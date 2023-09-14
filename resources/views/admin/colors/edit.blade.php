@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h4 class="text-white">Edit Color Type</h4>
        </div>
        <div class="card-body justify-content-center">
            <form action="{{ url('update-color-type', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-md-8 mb-3">
                        <label for="">ประเภทภาพ</label>
                        <select class="form-select @error('id_image_type') is-invalid @enderror" name="id_image_type"
                            aria-label="Default select example">
                            <option selected disabled>เลือก ประเภทภาพ</option>
                            @foreach ($type as $item)
                                @if ($data->id_image_type == $item->id)
                                    <option value="{{ $item->id }}" selected>{{ $item->name }} </option>
                                @else
                                    <option value="{{ $item->id }}">{{ $item->name }} </option>
                                @endif
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
                            placeholder="color" value="{{ $data->color_type }}" name="color_type">
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




    @include('admin.imageSize.scriptSize')
@endsection
