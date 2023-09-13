@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h4 class="text-white">Add Image Size</h4>
        </div>
        <div class="card-body justify-content-center">
            <form action="{{ url('insert-image-size') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-md-8 mb-3">
                        <label for="">ประเภทภาพ</label>
                        <select class="form-select @error('id_image_type') is-invalid @enderror" name="id_image_type"
                            aria-label="Default select example">
                            <option selected disabled>เลือก ประเภทภาพ</option>
                            @foreach ($type as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach

                        </select>
                        @error('id_image_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-8 mb-3">
                        <label for="">ขนาดภาพ เซนติเมตร</label>
                        <input type="text" class="form-control @error('size_image_cm') is-invalid @enderror"
                            placeholder="40.1*118.8" name="size_image_cm">
                        @error('size_image_cm')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-8 mb-3" id="numberDiv">
                        <label for="">จำนวนคน</label>
                        <input type="number" class="form-control " name="number">
                    </div>


                    <div class="form-group col-md-12 mb-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // คัดเลือกเลือกบรรทัด
            var select = $('select[name="id_image_type"]');

            // กำหนดการแสดงหรือซ่อนเมื่อเลือกอย่างใดอย่างหนึ่ง
            select.change(function() {
                if (select.val() == '2') {
                    $('#numberDiv').show(); // แสดง div ถ้าค่าเลือกคือ 'ภาพเหมือน'
                } else {
                    $('#numberDiv').hide(); // ซ่อน div ในกรณีอื่น ๆ
                }
            });

            // ตรวจสอบค่าเริ่มต้นเพื่อแสดงหรือซ่อน
            if (select.val() == '2') {
                $('#numberDiv').show(); // แสดง div หากค่าเริ่มต้นเป็น 'ภาพเหมือน'
            } else {
                $('#numberDiv').hide(); // ซ่อน div หากค่าเริ่มต้นไม่ใช่ 'ภาพเหมือน'
            }
        });
    </script>
@endsection
