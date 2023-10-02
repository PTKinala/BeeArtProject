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
                        <h1 class="mt-2">รายการสั่งซื้อ/สั่งทำ
                            <a href="{{ url('my-orders') }}" class="btn btn-primary text-whtie float-end">Back</a>
                        </h1>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 order-details">
                                <h4>ส่งหลักฐานการชำระเงิน</h4>
                                <hr>

                                @foreach ($order as $item)
                                <div>
                                    <p>ชื่อภาพ : {{ $item->name }}</p>
                                    <p>จำนวน : {{ $item->qty }}</p>
                                    <p>ราคาต่อชิ้น : {{ $item->price }}</p>
                                    
                                </div>
                                @endforeach
                                
                                @foreach ($made_order as $item)
                                    <div>
                                        <p>ประเภทงานสั่งทำ : {{ $item->name }}</p>
                                        <p>กระดาษ & ขนาดภาพ : {{ $item->paper }} {{ $item->size_image_cm }}</p>
                                        <p>สีที่ใช้ : {{ $item->color_type }}</p>
                                        <p>ราคาต่อชิ้น : {{ $item->price }}</p>
                                    </div>
                                @endforeach
                                <?php
                                    $total = 0;
                                    $deposit_price = 0;
                                    if (count($order) > 0){
                                        $deposit_price = $order[0]->total_price;
                                        $total = $order[0]->total_price;
                                    }
                                    if (count($made_order) > 0){
                                        $total = $made_order[0]->total_price;
                                        $deposit_price = ($made_order[0]->total_price * $deposit[0]->deposit) / 100;
                                    }
                                ?>

                                <p>ราคารวม : {{ number_format($total , 2) }} บาท</p>

                                <p id="total" style="display: none">{{ $total }}</p>
                                <p id="depositPrice" style="display: none">{{ $deposit_price }}</p>
                                @if (count($dataSlipCount) > 0)
                                    @if (count($made_order) > 0)
                                        <p id="deposit">ราคาคงเหลือ : {{ number_format($deposit_price , 2) }} บาท</p>
                                    @endif
                                @else
                                    @if (count($made_order) > 0)
                                        <p id="deposit">ราคามัดจำ : {{ number_format($deposit_price , 2) }} บาท</p>
                                    @endif
                                @endif


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
                                            <input type="number" class="form-control" value="{{ $deposit_price }}"
                                                step="0.01" pattern="\d+(\.\d{2})?" name="price" required placeholder="0" id="amountInput">
                                        </div>
                                    </div>

                                    @if (count($dataSlipCount) < 1)
                                        @if ($v_code == 'Mad')
                                            <div class="form-check full-amount">
                                                <input class="form-check-input ml-3" type="checkbox" name="full_amount" id="flexCheckChecked" onchange="updateAmount()">
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    โอนเเบบราคาเต็ม
                                                </label>
                                            </div>
                                        @endif
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
                                        <button type="submit" class="btn btn-success">ส่งหลักฐานการชำระเงิน</button>
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

        var total = 0;
        document.addEventListener("DOMContentLoaded", function() {
            // Get the initial text content when the page is loaded
            total = document.getElementById('total').textContent;
            console.log(total);
        });

        var depositPrice = 0;
        document.addEventListener("DOMContentLoaded", function() {
            // Get the initial text content when the page is loaded
            depositPrice = document.getElementById('depositPrice').textContent;
            console.log(depositPrice);
        });

        function updateAmount() {
            var amountInput = document.getElementById('amountInput');
            var total = document.getElementById('total').textContent; // fixed typo
            var depositPrice = document.getElementById('depositPrice').textContent; // fixed typo
            var checkbox = document.getElementById('flexCheckChecked');

            // Check if the checkbox is checked
            if (checkbox.checked) {
                // Update the value of the input to the deposit value
                amountInput.value = total;
            } else {
                // Reset the value to the original total value
                amountInput.value = depositPrice;
            }
        }
    </script>
@endsection
