@extends('layouts.front')

@section('title')
    Bee Art Gallery
@endsection

@section('content')
    <div class="py-3 mb-4 shadow-sm bg-secondary">
        <div class="container">
            <h5 class="mb-0">
                <a href="{{ url('shop') }}" class="text-white"> Collections </a>
            </h5>
        </div>
    </div>
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mb-3">Make Art</h1>
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
                                    <h4 class="position-absolute top-50 start-50 translate-middle">
                                        {{ $item->name }}
                                    </h4>

                                </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showSwal() {
            console.log("888");
            swal({
                text: "Login to continue",
                icon: "error",
                confirmButton: true,
                confirmButtonText: "OK",
            })
        }
    </script>
@endsection
