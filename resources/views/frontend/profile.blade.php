@extends('layouts.front')

@section('title')
    My Profile
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-secondary">
                    <h4 class="text-white">My Profile</h4>
                </div>
                <div class="card-body">
                    @if (count($user_address) > 0)
                        <a href="{{url('/edit-address',$user_address[0]->id)}}" type="button" class="btn btn-primary">แก้ไขที่อยู่</a>
                    @else
                        <a href="{{url('/address')}}" type="button" class="btn btn-primary">เพิ่มที่อยู่</a>
                    @endif
                    
                    
                    <h5 class="mt-3">ชื่อ..{{$user->name}}</h5>
                    <P>email..{{$user->email}}</P>

                    @foreach ($user_address as $item)
                    <p>ชื่อ..{{ $item->fname }}</p>
                    <p>นามสกุล..{{ $item->lname }}</p>
                    <p>เบอร์โทรศัพท์..{{ $item->phone }}</p>
                    <P>ที่อยู่..{{ $item->address }}</P>
                    <p>ถนน..{{ $item->road }}</p>
                    <p>ตำบล/แขวง..{{ $item->subdistrict }}</p>
                    <p>อำเภอ/เขต..{{ $item->district }}</p>
                    <p>จังหวัด..{{ $item->province }}</p>
                    <p>รหัสไปรษณีย์..{{ $item->zipcode }}</p>
                    @endforeach
                    <a href="{{url('/change-pass')}}">เปลี่ยนรหัสผ่าน</a>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>            
@endsection
