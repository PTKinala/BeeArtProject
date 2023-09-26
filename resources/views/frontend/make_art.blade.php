@extends('layouts.front')

@section('title')
    Bee Art Gallery
@endsection

@section('content')
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mb-3">งานสั่งทำ</h1>
                    <div class="row">
                        @foreach ($image_type as $item)
                            <div class="col-md-3 mb-3 cursor-pointer">
                                @if (Auth::check())
                                    <a href="{{ url('make-art-buy/' . $item->id) }}">
                                    @else
                                        <a class="link-light" onclick="showSwal()">
                                @endif

                                <div class="card">

                                    <img src="{{ asset('assets/uploads/imageType/' . $item->image) }}"
                                        class="text-center fw-bold position-relative" alt="Category Image">
                                    <h4 class="position-absolute top-50 start-50 translate-middle background-text-image text-white">
                                        {{ $item->name }}
                                    </h4>

                                </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <h5 class="mb-3 mt-3">หมายเหตุ หากท่านต้องการให้เราสร้างสรรค์งานศิลปะที่นอกเหนือจากที่แสดงอยู่นี้</h5>
                    <h5 class="mb-3">กรุณาติดต่อช่องทางต่อไปนี้</h5>
                    <a href="https://www.facebook.com/openingtowatch" target="blank" class="text-reset">
                        <p><i class="fab fa-facebook-f me-2"></i>Bee Art</p>
                    </a>
                    <p><i class="fas fa-envelope me-2"></i>beeartonline@gmail.com</p>
                    <p><i class="fas fa-phone me-2"></i>06-3765-6412</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showSwal() {
            console.log("888");
            swal({
                text: "กรุณาเข้าสู่ระบบ",
                icon: "error",
                confirmButton: true,
                confirmButtonText: "OK",
            })
        }
    </script>
@endsection
