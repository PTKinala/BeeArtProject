@extends('layouts.admin')

@section('content')

    <div class="card">
        <div class="card-header bg-primary">
            <h1 class="text-white">เพิ่มหมวดหมู่</h1>
        </div>
        <div class="card-body">
            <form action="{{ url('insert-category') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="">ชื่อหมวดหมู่</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-check col-md-2 mb-3">
                        <input type="checkbox" name="status">
                        <label for="">สถานะการแสดงผล</label>
                    </div>
                    <div class="form-check col-md-2 mb-3">
                        <input type="checkbox" name="popular">
                        <label for="">สถานะแสดงหน้าหลัก</label>
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <label for="">รายละเอียดหมวดหมู่</label>
                        <textarea name="description" id="" rows="5" class="form-control"></textarea>
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
