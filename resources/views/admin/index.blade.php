@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h1 class="text-white">Sales Reports</h1>
            <button type="button" class="btn btn-success">ยอดขายคำสั่งซื้อ</button>
            <button type="button" class="btn btn-success">ยอดขายงานจ้าง</button>
            <button type="button" class="btn btn-success">ยอดขายรวม</button>
        </div>

        <div class="card-body">
            <div class="chart-center">
            <canvas id="myChart" style="width:100%;max-width:1200px "></canvas>
            </div>
        </div>
    </div>

    <script>
        var xValues = ["เดือน1", "เดือน2", "เดือน3", "เดือน4", "เดือน5", "เดือน6", "เดือน7", "เดือน8", "เดือน9", "เดือน10", "เดือน11", "เดือน12"];
        var yValues = [5000, 4000, 3000, 2000, 1000];
        var barColors = ["red", "green","blue","orange","brown"];
        
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
            legend: {display: false},
            title: {
              display: true,
              text: "ยอดขายรายเดือน ปี xxxx"
            }
          }
        });
        </script>

@endsection
