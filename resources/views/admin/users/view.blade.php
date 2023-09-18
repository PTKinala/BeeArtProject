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
                        <div class="row"> {{ $users->id }}

                            <div class="col-md-4 mt-3">
                                <label for="">Email</label>
                                <div class="p-2 border">{{ $users->email }}</div>
                            </div>
                            {{--  <div class="col-md-4 mt-3">
                                <label for="">Role</label>
                                <div class="p-2 border">{{ $users->role_as == '0' ? 'User' : 'Admin' }}</div>
                            </div>

                            <div class="col-md-4 mt-3">
                                <label for="">Email</label>
                                <div class="p-2 border">{{ $users->email }}</div>
                            </div> --}}
                            <form action="{{ url('update-price-order/') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="number" name="price" class="form-control" placeholder="100" required>
                                <button type="submit" class="btn btn-primary mt-3">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
