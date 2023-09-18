@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card w-auto">
                    <div class="card-header bg-primary">
                        <h4 class="text-white">User Details
                            <a href="{{ url('users') }}" class="btn btn-warning float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="row">{{--  {{ $users->id }} --}}

                            <div class="col-md-4 mt-3">
                                <label for="">Email</label>
                                <div class="p-2 ">{{ $users->email }}</div>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="">สถานะ </label>
                                <div class="p-2 ">{{ $users->role_as == '0' ? 'User' : 'Admin' }}</div>
                            </div>
                            @if (Auth::id() != $users->id)
                                <form action="{{ url('update-status-user', $users->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <label for="">สถานะ</label>
                                    <select class="form-select" name="status_user" required>

                                        <option {{ $users->role_as == '0' ? 'selected ' : '' }} value="0">User
                                        </option>
                                        <option {{ $users->role_as == '1' ? 'selected ' : '' }} value="1">Admin
                                        </option>
                                    </select>
                                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                                </form>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
