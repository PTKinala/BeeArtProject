@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="text-white">Image Size</h3>
            {{--    <a href="{{ url('/create-bank-account') }}" class="btn btn-info">เพิ่ม Bank Account</a> --}}
        </div>
        <div class="card-body  table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>ประเภทภาพ</th>
                        <th>กระดาษ</th>
                        <th>ขนาดภาพ</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    
                    ?>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                @if ($item->paper)
                                    {{ $item->paper }}
                                @endif
                            </td>
                            <td>{{ $item->size_image_cm }}</td>
                            <td>
                                <a href="{{ url('edit-image-size/' . $item->id) }}"
                                    class="btn btn-primary btn-sm">Edit</a><br>
                                <a href="{{ url('delete-image-size/' . $item->id) }}" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
