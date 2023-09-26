@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-primary">
            <h1 class="text-white">แก้ไขรายละเอียดงานศิลปะ</h1>
        </div>
        <div class="card-body">
            <form action="{{ url('update-product/' . $products->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="form-group mb-3">
                        <label for="">Category</label>
                        <select class="form-select" name="cate_id">
                            @foreach ($category as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $products->cate_id ? 'selected' : '' }}>
                                    {{ $item->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <label for="">Name</label>
                        <input type="text" class="form-control" value="{{ $products->name }}" name="name">
                    </div>

                    <div class="form-check col-md-2 mb-3">
                        <input type="checkbox" {{ $products->status == '1' ? 'checked' : '' }} name="status">
                        <label for="">Status</label>
                    </div>
                    <div class="form-check col-md-2 mb-3">
                        <input type="checkbox" {{ $products->trending == '1' ? 'checked' : '' }} name="trending">
                        <label for="">Trending</label>
                    </div>

                    <div class="form-group col-md-12 mb-3">
                        <label for="">Description</label>
                        <textarea name="description" id="" rows="5" class="form-control">{{ $products->description }}</textarea>
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        <label for="">Original_price</label>
                        <input type="number" class="form-control" value="{{ $products->original_price }}"
                            name="original_price">
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        <label for="">Selling_price</label>
                        <input type="number" class="form-control" value="{{ $products->selling_price }}"
                            name="selling_price">
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        <label for="">Quantity</label>
                        <input type="number" class="form-control" value="{{ $products->qty }}" name="qty">
                    </div>



                    @if ($products->image)
                        <img src="{{ asset('assets/uploads/products/' . $products->image) }}" class="w-20 mb-3 clickable-image cursor-pointer"
                            alt="products image">
                    @endif

                    <div class="form-group col-md-12 mb-3">
                        <input type="file" name="image" class="form-control-file">
                    </div>
                    <div class="form-group col-md-12 mb-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
        <!-- The Modal -->
        <div id="myModal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="img01">
            <div id="caption"></div>
        </div>
    
        <script>
            var modal = document.getElementById("myModal");
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");
    
            // รับรายการภาพทั้งหมดที่มีคลาส "clickable-image"
            var images = document.querySelectorAll(".clickable-image");
    
            // เพิ่มการตรวจสอบการคลิกสำหรับแต่ละรูปภาพ
            images.forEach(function(img) {
                img.onclick = function() {
                    modal.style.display = "block";
                    modalImg.src = this.src;
                    captionText.innerHTML = this.alt;
                }
            });
    
            var span = document.getElementsByClassName("close")[0];
    
            span.onclick = function() {
                modal.style.display = "none";
            }
        </script>
@endsection
