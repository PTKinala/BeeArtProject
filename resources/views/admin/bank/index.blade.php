@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h1 class="text-white">บัญชีธนาคาร</h1>
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
                    @foreach ($bank as $item)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $item->bank_name }}</td>
                            <td>{{ $item->account_name }}</td>
                            <td>{{ $item->account_number }}</td>
                            <td>{{ $item->branch }}</td>
                            <td>
                                @if ($item->image)
                                    <img src="{{ URL::asset('/assets/uploads/bank/' . $item->image) }}" class="qrcode-image clickable-image cursor-pointer"
                                        alt="...">
                                @endif

                            </td>
                            <td>
                                <a href="{{ url('edit-bank-account/' . $item->id) }}"
                                    class="btn btn-primary btn-sm">Edit</a><br>
                                <a href="{{ url('delete-bank-account/' . $item->id) }}" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="img01">
        <div id="caption"></div>
    </div>

    <script>
        var modal = document.getElementById("myModal");
        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");

        // รับรายการภาพทั้งหมดที่มีคลาส "clickable-image"
        var images = document.querySelectorAll(".clickable-image");

        // เพิ่มการตรวจสอบการคลิกสำหรับแต่ละรูปภาพ
        images.forEach(function(img) {
            img.onclick = function() {
                modal.style.display = "block";
                modalImg.src = this.src;
                captionText.innerHTML = this.alt;
            }
        });

        var span = document.getElementsByClassName("close")[0];

        span.onclick = function() {
            modal.style.display = "none";
        }
    </script>
@endsection
