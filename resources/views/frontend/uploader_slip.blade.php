@extends('layouts.front')

@section('title')
    My Orders
@endsection

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="mt-2">รายการสั่งซื้อ
                            <a href="{{ url('my-orders') }}" class="btn btn-primary text-whtie float-end">Back</a>
                        </h1>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 order-details">
                                <h4>ส่งหลักฐานการชำระเงิน</h4>
                                <hr>
                                <form action="{{ url('insert-image-slip') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="text" name="idOrder" value="{{ $id }}" class="form-contro"
                                        style="display: none">
                                    <div class="form-group ">
                                        <label for="" class="form-label">สลิปหลักฐานการโอนเงิน</label>
                                        <input type="file" name="image"
                                            class="form-control @error('image') is-invalid @enderror" required>
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="row mt-3">
                                        <div class="mb-3 col-6">
                                            <label for="exampleFormControlInput1" class="form-label">จำนวนเงิน</label>
                                            <input type="number" class="form-control" id="exampleFormControlInput1"
                                                step="0.01" pattern="\d+(\.\d{2})?" name="price" required
                                                placeholder="0">
                                        </div>
                                    </div>
                                    @if ($v_code == 'Mad')
                                        <div class="form-check full-amount">
                                            <input class="form-check-input  ml-3" type="checkbox" name="full_amount"
                                                id="flexCheckChecked">
                                            <label class="form-check-label" for="flexCheckChecked">
                                                โอนเเบบราคาเต็ม
                                            </label>
                                        </div>
                                    @endif
                                    <div class="row mt-3">
                                        <div class="mb-3 col-6">
                                            <label for="exampleFormControlInput1" class="form-label">วันที่โอน</label>
                                            <input type="text" class="form-control datepicker" name="date" required
                                                placeholder="30/12/2023">
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label for="exampleFormControlInput1" class="form-label">เวลาที่โอน</label>
                                            <input type="text" class="form-control time-picker" name="time" required
                                                placeholder="19.30">
                                        </div>

                                    </div>
                                    <div class="form-group col-md-12 mb-3">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    <script type="text/javascript">
        $.datepicker.regional['th'] = {
            closeText: 'ปิด',
            prevText: '&#x3C;ก่อนหน้า',
            nextText: 'ถัดไป&#x3E;',
            currentText: 'วันนี้',
            monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
                'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
            ],
            monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.',
                'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'
            ],
            dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
            dayNamesShort: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
            dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
            weekHeader: 'Wk',
            dateFormat: 'dd/mm/yy', // รูปแบบวันที่
            firstDay: 0, // วันแรกของสัปดาห์ (0 = อาทิตย์, 1 = จันทร์, 2 = อังคาร, ฯลฯ)
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: '' // คำต่อท้ายปี
        };
        $.datepicker.setDefaults($.datepicker.regional['th']); // ตั้งค่า locale เป็นไทย
        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy', // รูปแบบวันที่
            yearRange: '1900:2099', // ช่วงปีที่เลือก
            changeMonth: true, // อนุญาตให้เปลี่ยนเดือน
            changeYear: true // อนุญาตให้เปลี่ยนปี
        });

        $('.time-picker').timepicker({
            timeFormat: 'H:i', // รูปแบบเวลาในรูปแบบชั่วโมง:นาที:วินาที (24 ชั่วโมง)
            showSeconds: true, // แสดงวินาที
            showMeridian: false, // ไม่แสดง AM/PM
            defaultTime: '00:01', // เวลาเริ่มต้น (1 วินาที)
            step: 1 // กำหนด interval ของวินาทีเป็น 1 วินาที

        });
    </script>
@endsection
