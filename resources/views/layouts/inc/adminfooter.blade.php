<!-- Admin Footer -->
<footer class="footer py-4">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
            <!-- Footer credit -->
            <div class="col-lg-6 mb-lg-0 mb-4 d-flex">
                <div class="copyright text-center text-sm text-muted text-lg-start">
                    © <script>
                        document.write(new Date().getFullYear())
                    </script> Copyright:
                  <a class="text-reset fw-bold {{ Request::is('/') ? 'active':''}}" aria-current="page" href="{{ url('/') }}">BeeArt Online</a>
                </div>
            </div>
            <!-- Footer GotoPages -->
            <div class="col-lg-6">
                <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="{{ url('/') }}">BeeArt</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="{{ url('shop') }}">งานศิลปะ</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/make-art') }}" class="nav-link text-muted">งานสั่งทำ</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
