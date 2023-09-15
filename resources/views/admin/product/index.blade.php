@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h4 class="text-white">Product Page</h4>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="fs-3">
                    <tr>
                        <th>Id</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Original Price</th>
                        <th>Selling Price</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="fs-5 table-bordered">
                    @foreach ($products as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->original_price }} บาท</td>
                            <td>{{ $item->selling_price }} บาท</td>
                            <td>
                                <img src="{{ asset('assets/uploads/products/' . $item->image) }}" class="cate-image"
                                    alt="Image here">
                            </td>
                            <td>
                                <a href="{{ url('edit-prod/' . $item->id) }}" class="btn btn-primary">Edit</a><br>
                                <a href="{{ url('delete-product/' . $item->id) }}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
