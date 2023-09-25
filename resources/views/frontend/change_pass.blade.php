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
                    <h1 class="mt-3">เปลี่ยนรหัสผ่านใหม่</h1>
                </div>
                <div class="card-body">
                    <form action="{{ url('update-pass',$id) }}" method="POST">
                        {{ csrf_field() }}
                        @method('PUT')
                      <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">รหัสผ่านใหม่</label>
                        <input name="password" type="password" class="form-control" id="exampleFormControlInput1" placeholder="New Password" required>
                      </div>
                      <button type="submit" class="btn btn-primary">ยืนยัน</button>
                      </form>
                      
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>            
@endsection
