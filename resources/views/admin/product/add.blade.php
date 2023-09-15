@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h4 class="text-white">Add Product</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('insert-product') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group mb-3">
                        <label for="">Category</label>
                        <select class="form-select" name="cate_id">
                            <option value="">Select a Category</option>
                            @foreach ($category as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-check col-md-2 mb-3">
                        <input type="checkbox" name="status">
                        <label for="">Status</label>
                    </div>
                    <div class="form-check col-md-2 mb-3">
                        <input type="checkbox" name="trending">
                        <label for="">Trending</label>
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <label for="">Description</label>
                        <textarea name="description" id="" rows="5" class="form-control"></textarea>
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="">Original_price</label>
                        <input type="number" class="form-control" name="original_price">
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="">Selling_price</label>
                        <input type="number" class="form-control" name="selling_price">
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="">Quantity</label>
                        <input type="number" class="form-control" name="qty">
                    </div>

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
