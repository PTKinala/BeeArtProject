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
                        <th>ชื่อธนาคาร</th>
                        <th>ชื่อบัญชี</th>
                        <th>เลขบัญชี</th>
                        <th>สาขา</th>
                        <th>Qrcode</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    
                    ?>
                    {{--   @foreach ($bank as $item)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $item->bank_name }}</td>
                            <td>{{ $item->account_name }}</td>
                            <td>{{ $item->account_number }}</td>
                            <td>{{ $item->branch }}</td>
                            <td>
                                @if ($item->image)
                                    <img src="{{ URL::asset('/assets/uploads/bank/' . $item->image) }}" class="qrcode-image"
                                        alt="...">
                                @endif

                            </td>
                            <td>
                                <a href="{{ url('edit-bank-account/' . $item->id) }}"
                                    class="btn btn-primary btn-sm">Edit</a><br>
                                <a href="{{ url('delete-bank-account/' . $item->id) }}"
                                    class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
@endsection
