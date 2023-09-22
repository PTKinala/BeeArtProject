@extends('layouts.front')

@section('title')
    Bee Art Gallery
@endsection

@section('content')
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mb-3">หมวดหมู่ 55</h1>
                    <div class="row">
                        @foreach ($category as $item)
                            <div class="col-md-3 mb-3">
                                <a href="{{ url('category/' . $item->slug) }}" class="link-light">
                                    <div class="card">

                                        <img src="{{ asset('assets/uploads/category/' . $item->image) }}"
                                            class="text-center fw-bold position-relative" alt="Category Image">

                                        <h4
                                            class="position-absolute top-50 start-50 translate-middle background-text-image">
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
@endsection
