@extends('layouts.front')

@section('title')
    My Profile
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="mt-2">รายละเอียดส่วนตัวของคุณ</h1>
                    @if (count($user_address) > 0)
                        <a href="{{url('/edit-address',$user_address[0]->id)}}" type="button" class="btn btn-primary float-end">แก้ไขที่อยู่</a>
                    @else
                        <a href="{{url('/address')}}" type="button" class="btn btn-primary float-end">เพิ่มที่อยู่</a>
                    @endif
                </div>
                <div class="card-body">
                    @foreach ($user_address as $item)
                    <div class="col-sm-8">
                        <div class="card-block">
                            <div class="row">
                                <h4 class="text-muted m-t-40 p-b-5 b-b-default f-w-600">ข้อมูลทั่วไป</h4>
                                <div class="col-sm-6 mt-3">
                                    <h6 class="text-muted f-w-400">ชื่อ</h6>
                                    <p class="mb-10 f-w-600">{{ $item->fname }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <h6 class="text-muted f-w-400">นามสกุล</h6>
                                    <p class="m-b-10 f-w-600">{{ $item->lname }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <h6 class="text-muted f-w-400">อีเมล</h6>
                                    <p class="mb-10 f-w-600">{{$user->email}}</p>
                                </div>
                                <div class="col-sm-6">
                                    <h6 class="text-muted f-w-400">เบอร์</h6>
                                    <p class="m-b-10 f-w-600">{{ $item->phone }}</p>
                                </div>
                            </div>
                            <h6 class="m-b-20 p-b-5 b-b-default f-w-600"></h6>
                            <div class="row">
                                <h4 class="text-muted m-t-40 p-b-5 b-b-default f-w-600">รายละเอียดที่อยู่</h4>
                                <div class="col-sm-6 mt-3">
                                    <h6 class="text-muted f-w-400">ที่อยู่</h6>
                                    <p class="mb-10 f-w-600">{{ $item->address }}</p>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <h6 class="text-muted f-w-400">ถนน</h6>
                                    <p class="mb-10 f-w-600">{{ $item->road }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <h6 class="text-muted f-w-400">ตำบล/แขวง</h6>
                                    <p class="m-b-10 f-w-600">{{ $item->subdistrict }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <h6 class="text-muted f-w-400">อำเภอ/เขต</h6>
                                    <p class="mb-10 f-w-600">{{ $item->district }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <h6 class="text-muted f-w-400">จังหวัด</h6>
                                    <p class="m-b-10 f-w-600">{{ $item->province }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <h6 class="text-muted f-w-400">รหัสไปรษณีย์</h6>
                                    <p class="mb-10 f-w-600">{{ $item->zipcode }}</p>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        </div>
    </div>
</div>            
@endsection
