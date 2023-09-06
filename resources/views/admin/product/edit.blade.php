@extends('layouts.admin')

@section('content')

    <div class="card">
        <div class="card-header bg-primary">
            <h4 class="text-white">Update/Edit Product</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('update-product/'.$products->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="form-group mb-3">
                        <label for="">Category</label>
                        <select class="form-select" name="cate_id">
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $products->cate_id ? 'selected' : '' }}> {{ $item->name }} </option>
                                @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="">Name</label>
                        <input type="text" class="form-control" value="{{ $products->name }}" name="name">
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="">Slug</label>
                        <input type="text" class="form-control" value="{{ $products->slug }}" name="slug">
                    </div>
                    <div class="form-check col-md-2 mb-3">
                        <input type="checkbox" {{ $products->status == "1" ? 'checked':''}} name="status">
                        <label for="">Status</label>
                    </div>
                    <div class="form-check col-md-2 mb-3">
                        <input type="checkbox" {{ $products->trending == "1" ? 'checked':''}} name="trending">
                        <label for="">Trending</label>
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <label for="">Small Description</label>
                        <textarea name="small_description" id="" rows="5" class="form-control">{{ $products->small_description }}</textarea>
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <label for="">Description</label>
                        <textarea name="description" id="" rows="5" class="form-control">{{ $products->description }}</textarea>
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="">Original_price</label>
                        <input type="number" class="form-control" value="{{ $products->original_price }}" name="original_price">
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="">Selling_price</label>
                        <input type="number" class="form-control" value="{{ $products->selling_price }}" name="selling_price">
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="">Quantity</label>
                        <input type="number" class="form-control" value="{{ $products->qty }}" name="qty">
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="">Tax</label>
                        <input type="number" class="form-control" value="{{ $products->tax }}" name="tax">
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <label for="">Meta Title</label>
                        <input type="text" class="form-control" value="{{ $products->meta_title }}" name="meta_title" >
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <label for="">Meta Keywords</label>
                        <textarea name="meta_keywords" id="" rows="3" class="form-control">{{ $products->meta_keywords }}</textarea>
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <label for="">Meta Description</label>
                        <textarea name="meta_description" id="" rows="3" class="form-control">{{ $products->meta_descrip }}</textarea>
                    </div>

                    @if ($products->image)
                        <img src="{{ asset('assets/uploads/products/'.$products->image) }}" class="w-20 mb-3" alt="products image">
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
