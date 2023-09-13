@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="text-white">Image Type</h3>
            {{--    <a href="{{ url('/create-bank-account') }}" class="btn btn-info">เพิ่ม Bank Account</a> --}}
        </div>
        <div class="card-body  table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>ประเภทภาพ</th>
                        <th>ภาพ</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    
                    ?>
                    @foreach ($imageType as $item)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $item->name }}</td>

                            <td>
                                @if ($item->image)
                                    <img src="{{ URL::asset('/assets/uploads/imageType/' . $item->image) }}"
                                        class="qrcode-image" alt="...">
                                @endif

                            </td>
                            <td>
                                <a href="{{ url('edit-image-type/' . $item->id) }}"
                                    class="btn btn-primary btn-sm">Edit</a><br>
                                <a href="{{ url('delete-image-type/' . $item->id) }}"
                                    class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
