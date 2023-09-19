@extends('layouts.admin')

@section('content')

    <div class="card">
        <div class="card-header bg-primary">
            <h4 class="text-white">Edit/Update Category</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('update-category/'.$category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="">Name</label>
                        <input type="text" value="{{ $category->name }}" class="form-control" name="name">
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="">Slug</label>
                        <input type="text" value="{{ $category->slug }}" class="form-control" name="slug">
                    </div>
                    <div class="form-check col-md-2 mb-3">
                        <input type="checkbox" {{ $category->status == "1" ? 'checked':''}} name="status">
                        <label for="">Status</label>
                    </div>
                    <div class="form-check col-md-2 mb-3">
                        <input type="checkbox" {{ $category->popular == "1" ? 'checked':'' }} name="popular">
                        <label for="">Popular</label>
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <label for="">Description</label>
                        <textarea name="description" id="" rows="5" class="form-control"> {{ $category->description }} </textarea>
                    </div>
                    @if ($category->image)
                        <img src="{{ asset('assets/uploads/category/'.$category->image) }}" class="w-20 mb-3" alt="category image">
                    @endif

                    <div class="form-group col-md-12 mb-3">
                        <input type="file" name="image" class="form-control-file">
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
