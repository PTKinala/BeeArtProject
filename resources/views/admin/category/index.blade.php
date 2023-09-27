@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h1 class="text-white">รายการหมวดหมู่</h1>
        </div>
        <div class="card-body  table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="fs-3">
                    <tr>
                        <th>Id</th>
                        <th>หมวดหมู่</th>
                        <th>รายละเอียดหมวดหมู่</th>
                        <th>รูปประกอบ</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="fs-5">
                    @foreach ($category as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>
                                <img src="{{ asset('assets/uploads/category/'.$item->image) }}" class="cate-image" alt="Image here">
                            </td>
                            <td>
                                <a href="{{ url('edit-cate/'.$item->id) }}" class="btn btn-primary">Edit</a><br>
                                <a href="{{ url('delete-category/'.$item->id) }}" onclick="return confirm('ยืนยันการลบ')" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
