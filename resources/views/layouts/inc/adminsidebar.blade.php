<!-- admin navbar -->
<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main">
    <!-- navbar header -->
    <div class="sidenav-header text-center text-xl">
        <a class="navbar-brand" href="{{ url('/dashboard') }}">
            <h2 class="text-white">Dashboard</h2>
        </a>
    </div>
    <!-- navbar menu -->
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <!-- navbar menu list -->
        <ul class="navbar-nav">
            <!-- navbar CRUD system menu -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Report</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('dashboard') ? 'bg-gradient-primary ' : '' }}"
                    href="{{ url('/dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">กราฟสรุปยอดขาย</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">sale management
                </h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('orders') ? 'bg-gradient-primary' : '' }}"
                    href="{{ url('orders') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">รายการสั่งซื้อ</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('orders-post-add') ? 'bg-gradient-primary' : '' }}"
                    href="{{ url('orders-post-add') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">post_add</i>
                    </div>
                    <span class="nav-link-text ms-1">รายการสั่งทำ</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white  {{ Request::is('bank-account') ? 'bg-gradient-primary' : '' }}"
                    href="{{ url('bank-account') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">account_balance</i>
                    </div>
                    <span class="nav-link-text ms-1">บัญชีธนาคาร</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white  {{ Request::is('add-bank-account') ? 'bg-gradient-primary' : '' }}"
                    href="{{ url('add-bank-account') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">add_circle</i>
                    </div>
                    <span class="nav-link-text ms-1">เพิ่มบัญชีธนาคาร</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">CRUD</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('users') ? 'bg-gradient-primary' : '' }}"
                    href="{{ url('users') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">group</i>
                    </div>
                    <span class="nav-link-text ms-1">การจัดการสมาชิก</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white  {{ Request::is('categories') ? 'bg-gradient-primary' : '' }}"
                    href="{{ url('categories') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">category</i>
                    </div>
                    <span class="nav-link-text ms-1">หมวดหมู่</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white  {{ Request::is('add-category') ? 'bg-gradient-primary' : '' }}"
                    href="{{ url('add-category') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">add_circle</i>
                    </div>
                    <span class="nav-link-text ms-1">เพิ่มหมวดหมู่</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white  {{ Request::is('products') ? 'bg-gradient-primary' : '' }}"
                    href="{{ url('products') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">inventory</i>
                    </div>
                    <span class="nav-link-text ms-1">รายการงานศิลปะ</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white  {{ Request::is('add-products') ? 'bg-gradient-primary' : '' }}"
                    href="{{ url('add-products') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">add_circle</i>
                    </div>
                    <span class="nav-link-text ms-1">เพิ่มงานศิลปะ</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white  {{ Request::is('image-type') ? 'bg-gradient-primary' : '' }}"
                    href="{{ url('image-type') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">perm_media</i>

                    </div>
                    <span class="nav-link-text ms-1">ประเภทงานสั่งทำ</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white  {{ Request::is('add-image-type') ? 'bg-gradient-primary' : '' }}"
                    href="{{ url('add-image-type') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">add_circle</i>
                    </div>
                    <span class="nav-link-text ms-1">เพิ่มประเภทงานสั่งทำ</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white  {{ Request::is('image-size') ? 'bg-gradient-primary' : '' }}"
                    href="{{ url('image-size') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">fullscreen</i>

                    </div>
                    <span class="nav-link-text ms-1">รูปแบบกระดาษและขนาดรูป</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white  {{ Request::is('add-image-size') ? 'bg-gradient-primary' : '' }}"
                    href="{{ url('add-image-size') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">add_circle</i>
                    </div>
                    <span class="nav-link-text ms-1">เพิ่มรูปแบบกระดาษและขนาดรูป</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white  {{ Request::is('color-type') ? 'bg-gradient-primary' : '' }}"
                    href="{{ url('color-type') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">palette</i>

                    </div>
                    <span class="nav-link-text ms-1">เทคนิคสี</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white  {{ Request::is('add-color-type') ? 'bg-gradient-primary' : '' }}"
                    href="{{ url('add-color-type') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">add_circle</i>
                    </div>
                    <span class="nav-link-text ms-1">เพิ่มเทคนิคสี</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
