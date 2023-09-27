@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h1 class="text-white">เพิ่มงานศิลปะ</h1>
        </div>
        <div class="card-body">
            <form action="{{ url('insert-product') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group mb-3">
                        <label for="">หมวดหมู่</label>
                        <select class="form-select" name="cate_id">
                            <option value="">เลือกหมวดหมู่</option>
                            @foreach ($category as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <label for="">ผลงานศิลปะ</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-check col-md-2 mb-3">
                        <input type="checkbox" name="status">
                        <label for="">สถานะการแสดงผล</label>
                    </div>
                    <div class="form-check col-md-2 mb-3">
                        <input type="checkbox" name="trending">
                        <label for="">สถานะผลงานใหม่</label>
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <label for="">รายละเอียดผลงานศิลปะ</label>
                        <textarea name="description" id="" rows="5" class="form-control"></textarea>
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="">ราคาจริง</label>
                        <input type="number" class="form-control" name="original_price">
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="">ราคาขาย</label>
                        <input type="number" class="form-control" name="selling_price">
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="">จำนวนชิ้นงาน</label>
                        <input type="number" class="form-control" name="qty">
                    </div>

                    <div class="form-group col-md-12 mb-3">
                        <label for="">รูปผลงานศิลปะ</label><br>
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
