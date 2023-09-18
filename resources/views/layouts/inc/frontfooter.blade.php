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
                <img src="{{ asset('assets/image/logo.png') }}" class="float:left" style="width: 50px; height: 50px;" alt="">
                Bee Art Gallery
            </h6>
            <p>
              Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ut earum, magni dolorum quisquam pariatur sequi. Deserunt ullam quaerat porro saepe similique quibusdam hic repudiandae at odit. Placeat, pariatur? Voluptas, nisi!
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">
              Shopping
            </h6>
            <p>
              <a class="text-reset {{ Request::is('shop') ? 'active':''}}" aria-current="page" href="{{ url('shop') }}">Shop</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Make Art</a>
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">
              Useful links
            </h6>
            <p>
                <a class="text-reset {{ Request::is('/') ? 'active':''}}" aria-current="page" href="{{ url('/') }}">Home</a>
            </p>
            <p>
              <a href="#!" class="text-reset">Profile</a>
            </p>
            <p>
              <a class="text-reset" href="{{ url('my-orders') }}">Orders</a>
            </p>
            <p>
              <a href="#!" class="text-reset">About Us</a>
            </p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
            <p><i class="fas fa-home me-3"></i> New York, NY 10012, US</p>
            <p>
              <i class="fas fa-envelope me-3"></i>
              info@example.com
            </p>
            <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
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
        © <script>
            document.write(new Date().getFullYear())
        </script> Copyright:
      <a class="text-reset fw-bold {{ Request::is('/') ? 'active':''}}" aria-current="page" href="{{ url('/') }}">BeeArt Online</a>
    </div>


      <!-- Right -->
      <div class="text-center p-4 fs-4">
        <a href="https://www.facebook.com/openingtowatch" target="blank" class="me-4 text-reset">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="#" class="me-4 text-reset">
            <i class="fab fa-line"></i>
        </a>
        <a href="#" class="me-4 text-reset">
          <i class="fab fa-google"></i>
        </a>
      </div>
      <!-- Right -->

    </section>
    <!-- Section: Social media -->
    <!-- Copyright -->
  </footer>
  <!-- Footer -->
