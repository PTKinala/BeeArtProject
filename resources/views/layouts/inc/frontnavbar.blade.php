    <!-- Header Navbar -->
    <nav class="navbar navbar-light bg-light navbar-expand-lg sticky-top shadow px-5">
        <div class="container-fluid">
            <a class="navbar-brand fs-2" href="{{ url('/') }}">
                <img src="{{ asset('assets/image/logo.png') }}" class="float:left" style="width: 50px; height: 50px;"
                    alt="">
                Bee Art Gallery
            </a>

            <!-- responsive Navbar -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Navbar -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item px-2">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" aria-current="page"
                            href="{{ url('/') }}">หน้าแรก</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link {{ Request::is('shop') ? 'active' : '' }}"
                            href="{{ url('shop') }}">งานศิลปะ</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link {{ Request::is('/make-art') ? 'active' : '' }}"
                            href="{{ url('/make-art') }}">งานสั่งทำ</a>
                    </li>

                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item px-2">
                                <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-user"></i> เข้าสู่ระบบ </a>
                            </li>
                            <li class="nav-item px-2">
                                <a class="nav-link" href="{{ route('register') }}"> สมัครสมาชิก </a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item px-2 dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('my-profile') }}">
                                    โปรไฟล์
                                </a>
                                <a class="dropdown-item" href="{{url('/change-pass')}}">
                                    เปลี่ยนรหัสผ่าน
                                </a>
                                <a class="dropdown-item" href="{{ url('my-orders') }}">
                                    รายการสั่งซื้อและสั่งทำ
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('ออกจากระบบ') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link" href="{{ url('cart') }}">
                                <i class="fas fa-shopping-cart"></i> ตะกร้าสินค้า
                                <?php
                                $countCart = DB::table('carts')
                                    ->where('user_id', Auth::user()->id)
                                    ->count();
                                ?>

                                @if ($countCart > 0)
                                    <span class="badge badge-pill bg-primary cart-count">
                                        {!! $countCart !!}
                                    </span>
                                @endif

                            </a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
