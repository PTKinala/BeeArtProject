@extends('layouts.front')

    @section('title')
        Welcome to Bee Art Gallery
    @endsection

    @section('content')
        @include('layouts.inc.frontslider')

        {{-- New Arrived carousel --}}
        <div class="py-5">
            <div class="container">
                <div class="row">
                    <h1 class="fw-bold text-center">งานศิลปะมาใหม่</h1>
                    <span class="fw-bold text-center mb-3">New Collection</span>
                    <div class="owl-carousel featured-carousel owl-theme">
                        @foreach ($featured_products as $prod)
                            <div class="item">
                                <div class="card">
                                    <a href="{{ url('category/'.$prod->category->slug.'/'.$prod->slug) }}">
                                    <img src="{{ asset('assets/uploads/products/'.$prod->image) }}" alt="Product Image">
                                    <div class="card-body">
                                        <span>{{ $prod->category->name }}</span><br>
                                        <h4>{{ $prod->name}}</h4>
                                        <h5>{{ $prod->selling_price }} บาท</h5>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="active">
            
            <a class="nav-link {{ Request::is('/make-art') ? 'active' : '' }}" href="{{ url('/make-art') }}">
            <h1 class="fw-bold text-center">สร้างสรรค์ผลงานศิลปะ</h1>
            <img src="{{ asset('assets/image/Banner1.png') }}" class="d-block w-75 mx-auto" alt="">
            </a>
        </div>

        {{-- Category --}}
        <div class="py-5">
            <div class="container">
                <div class="row">
                    <h1 class="fw-bold text-center mb-3">หมวดหมู่</h1>
                        <div class="owl-carousel featured-carousel owl-theme">
                            @foreach ($popular_category as $cate)
                                <div class="item">
                                    <a href="{{ url('category/'.$cate->slug) }}" class="link-light">
                                    <div class="col-md-12 text-center text-white fw-bold position-relative">
                                        <img src="{{ asset('assets/uploads/category/'.$cate->image) }}" alt="Category Image">
                                        <h4 class="position-absolute top-50 start-50 translate-middle">{{ $cate->name}}</h4>
                                    </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script>
            $('.featured-carousel').owlCarousel({
                loop:true,
                margin:10,
                nav:true,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:3
                    },
                    1000:{
                        items:4
                    }
                }
            })
        </script>
    @endsection
