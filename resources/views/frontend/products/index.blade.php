@extends('layouts.front')

@section('title')
    {{ $category->name }}
@endsection

@section('content')
    <div class="py-3 mb-4 shadow-sm bg-secondary">
        <div class="container text-white">
            <h5 class="mb-0">
                <a href="{{ url('shop') }}" class="text-white"> Collections </a> /
                <a href="{{ url('category/' . $category->slug) }}" class="text-white"> {{ $category->name }} </a>
            </h5>
        </div>
    </div>
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="dropdown-center mb-5">
                        <h1>Art Shop</h1>
                        {{-- <span>sort by:
                        <button class="btn btn-link text-dark dropdown-toggle shadow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            catagory
                        </button>
                            <ul class="dropdown-menu rounded-0 shadow">
                                @foreach ($category as $cate)
                                    <li><a class="dropdown-item" href="{{ url('view-category/'.$cate->slug) }}">{{ $cate->name }}</a></li>
                                @endforeach
                            </ul>
                        </span> --}}
                    </div>

                    <div class="row row-cols-1 row-cols-md-4 g-4">
                        @foreach ($products as $prod)
                            <div class="col">
                                <div class="card">
                                    <a href="{{ url('category/' . $category->slug . '/' . $prod->slug) }}">
                                        <img class="card-img-top"
                                            src="{{ asset('assets/uploads/products/' . $prod->image) }}"
                                            alt="Product Image">
                                        <div class="card-body">
                                            <span>{{ $prod->category->name }}</span><br>
                                            <h4>{{ $prod->name }}</h4>
                                            <h5>
                                                @if ($prod->original_price == $prod->selling_price)
                                                    {{ number_format($prod->original_price, 2) }}
                                                @else
                                                    {{ number_format($prod->selling_price, 2) }}
                                                @endif
                                                บาท
                                            </h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
