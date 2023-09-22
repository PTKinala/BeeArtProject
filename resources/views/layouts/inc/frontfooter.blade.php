<!-- Footer -->
<footer class="text-center text-lg-start text-muted">

    <!-- Section: Links  -->
    <section class="">
        <div class="container text-center text-md-start mt-5">
            <!-- Grid row -->
            <div class="row mt-3">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                    <!-- Content -->
                    <h6 class="fw-bold mb-4">
                        <img src="{{ asset('assets/image/logo.png') }}" class="float:left"
                            style="width: 50px; height: 50px;" alt="">
                        Bee Art Gallery
                    </h6>
                    <p>
                        วาดภาพคน วิว ทิวทัศน์ งานศิลปะ DIY และอื่นๆ ที่อยู่ในงานศิลปะ
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">
                        สินค้าและบริการ
                    </h6>
                    <p>
                        <a class="text-reset {{ Request::is('shop') ? 'active' : '' }}" aria-current="page"
                            href="{{ url('shop') }}">งานศิลปะ</a>
                    </p>
                    <p>
                        <a class="text-reset {{ Request::is('/make-art') ? 'active' : '' }}"
                            href="{{ url('/make-art') }}">งานสั่งทำ</a>
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">
                        ลิงค์ที่เกี่ยวข้อง
                    </h6>
                    <p>
                        <a class="text-reset {{ Request::is('/') ? 'active' : '' }}" aria-current="page"
                            href="{{ url('/') }}">หน้าแรก</a>
                    </p>
                    <p>
                        <a href="{{ url('my-profile') }}" class="text-reset">ข้อมูลที่อยู่</a>
                    </p>
                    <p>
                        <a class="text-reset" href="{{ url('my-orders') }}">รายการสั่งซื้อและงานจ้าง</a>
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">ติดต่อ</h6>
                    <a href="https://www.facebook.com/openingtowatch" target="blank" class="text-reset">
                        <p><i class="fab fa-facebook-f me-2"></i>วาดภาพคนเหมือน</p>
                    </a>
                    <p><i class="fas fa-envelope me-2"></i>beeartonline@gmail.com</p>
                    <p><i class="fas fa-phone me-2"></i>06-3765-6412</p>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
    </section>
    <!-- Section: Links  -->


    <!-- Section: Social media -->
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom bg-light ">

        <!-- Copyright -->
        <div class="text-center p-4">
            ©
            <script>
                document.write(new Date().getFullYear())
            </script> Copyright:
            <a class="text-reset fw-bold {{ Request::is('/') ? 'active' : '' }}" aria-current="page"
                href="{{ url('/') }}">BeeArt Online</a>
        </div>

    </section>
    <!-- Section: Social media -->
    <!-- Copyright -->
</footer>
<!-- Footer -->
