@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h1 class="text-white">รายการงานศิลปะ</h1>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="fs-3">
                    <tr>
                        <th>Id</th>
                        <th>หมวดหมู่</th>
                        <th>ชื่อ</th>
                        <th>จำนวนสินค้า</th>
                        <th>ราคาขาย</th>
                        <th>รูปสินค้า</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="fs-5 table-bordered">
                    @foreach ($products as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->qty }} ชิ้น</td>
                            <td>{{ $item->selling_price }} บาท</td>
                            <td>
                                <img src="{{ asset('assets/uploads/products/' . $item->image) }}" class="cate-image"
                                    alt="Image here">
                            </td>
                            <td>
                                <a href="{{ url('edit-prod/' . $item->id) }}" class="btn btn-primary">แก้ไขรายละเอียด</a><br>
                                <a href="{{ url('delete-product/' . $item->id) }}" class="btn btn-danger">ลบสินค้า</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
