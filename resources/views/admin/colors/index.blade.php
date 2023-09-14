@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="text-white">Colors</h3>
            {{--    <a href="{{ url('/create-bank-account') }}" class="btn btn-info">เพิ่ม Bank Account</a> --}}
        </div>
        <div class="card-body  table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>ประเภทภาพ</th>
                        <th>ประภาพสี</th>
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
                                {{ $item->color_type }}
                            </td>

                            <td>
                                <a href="{{ url('edit-color-type/' . $item->id) }}"
                                    class="btn btn-primary btn-sm">Edit</a><br>
                                <a href="{{ url('delete-color-type/' . $item->id) }}" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
