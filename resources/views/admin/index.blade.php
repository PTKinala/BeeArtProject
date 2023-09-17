@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h1 class="text-white">Sales Reports</h1>
            <button type="button" class="btn btn-success" onclick="orderSales()">ยอดขายคำสั่งซื้อ</button>
            <button type="button" class="btn btn-success" onclick="salesHire()">ยอดขายงานจ้าง</button>
            <button type="button" class="btn btn-success">ยอดขายรวม</button>
        </div>

        <div class="card-body">
            <div class="chart-center">
                <canvas id="myChart" style="width:100%;max-width:1200px "></canvas>
            </div>
        </div>
    </div>

    <script>
        /*    var xValues = ["เดือน1", "เดือน2", "เดือน3", "เดือน4", "เดือน5", "เดือน6", "เดือน7", "เดือน8", "เดือน9", "เดือน10",
                                                                                "เดือน11", "เดือน12"
                                                                            ];
                                                                            var yValues = [5000, 4000, 3000, 2000, 1000];
                                                                            var barColors = ["red", "green", "blue", "orange", "brown"];

                                                                            new Chart("myChart", {
                                                                                type: "bar",
                                                                                data: {
                                                                                    labels: xValues,
                                                                                    datasets: [{
                                                                                        backgroundColor: barColors,
                                                                                        data: yValues
                                                                                    }]
                                                                                },
                                                                                options: {
                                                                                    legend: {
                                                                                        display: false
                                                                                    },
                                                                                    title: {
                                                                                        display: true,
                                                                                        text: "ยอดขายรายเดือน ปี xxxx"
                                                                                    }
                                                                                }
                                                                            });
                                                                     */
        var thaiMonthNames = [
            "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน",
            "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม",
            "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
        ];
        var barColors = ["red", "green", "blue", "orange", "brown", "purple", "pink", "gray", "teal", "cyan", "magenta",
            "lime"
        ];
        var currentYear = new Date().getFullYear();


        function orderSales() {
            $.ajax({
                method: "GET",
                url: "/graph-order-sale",
                success: function(response) {
                    console.log("response", response.total_month);


                    var xValues = [];
                    var yValues = [];

                    response.total_month.forEach(function(monthData, index) {
                        var thaiMonth = thaiMonthNames[monthData.month - 1];
                        xValues.push(thaiMonth);
                        yValues.push(monthData.total_price);
                        // ใช้สีจากอาร์เรย์ barColors ตามลำดับหรือตามความเหมาะสม
                        var color = barColors[index % barColors.length];
                        barColors.push(color);
                    });


                    // ...

                    new Chart("myChart", {
                        type: "bar",
                        data: {
                            labels: xValues,
                            datasets: [{
                                backgroundColor: barColors,
                                data: yValues
                            }]
                        },
                        options: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: "ยอดขายรายเดือน ปี " + currentYear // แสดงปีปัจจุบัน
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        callback: function(value, index, values) {
                                            return value.toLocaleString() + ' บาท';
                                        }
                                    }
                                }]
                            },
                            tooltips: {
                                callbacks: {
                                    label: function(tooltipItem, data) {
                                        return data.datasets[tooltipItem.datasetIndex].label +
                                            ': ' + tooltipItem.yLabel.toLocaleString() + ' บาท';
                                    }
                                }
                            }
                        }
                    });


                    // คุณสามารถทำสิ่งอื่น ๆ กับข้อมูล response ที่ได้รับได้ที่นี่
                },
            });
        }

        function salesHire() {

            console.log("4444");
        }
    </script>
@endsection
