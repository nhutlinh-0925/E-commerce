<!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__option">
            <div class="offcanvas__top__hover">
                <span>Tài khoản <i class="arrow_carrot-down"></i></span>
                <ul>
                     @if (Auth::check())
                        <a class="dropdown-item" href="">Xin chào {{ $khachhang->kh_Ten }}</a>
                        {{--  <a class="dropdown-item" href="/purchase_order/{{Auth::user()->id}}">Đơn hàng</a>  --}}
                        <a class="dropdown-item" href="{{  route('user.logout')}}"><i class="fa-sharp fa-solid fa-right-from-bracket"></i>Đăng xuất</a>
                    @else
                        <a href="{{  route('user.login')}}">Đăng nhập</a>
                        <a href="{{  route('user.register')}}">Đăng kí</a>
                    @endif
                </ul>
            </div>
            <div class="offcanvas__links">
                <a href="#">FAQs</a>
            </div>
            <div class="offcanvas__top__hover">
                <span>Usd <i class="arrow_carrot-down"></i></span>
                <ul>
                    <li>USD</li>
                    <li>EUR</li>
                    <li>USD</li>
                </ul>
            </div>
        </div>

        <div class="offcanvas__nav__option">
            <a href="#" class="search-switch"><img src="/template/front-end/img/icon/search.png" alt=""></a>
            <a href="#"><img src="/template/front-end/img/icon/heart.png" alt=""></a>
            <a href="#"><img src="/template/front-end/img/icon/cart.png" alt=""> <span>0</span></a>
            <div class="price">$0.00</div>
        </div>
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__text">
            <p>Free1 shipping, 30-day return or refund guarantee.</p>
        </div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-7">
                        <div class="header__top__left">
                            <p>Free2 shipping, 30-day return or refund guarantee.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5">
                        <div class="header__top__right">
                            <div class="header__top__hover">
                                @if (Auth::check())
                                <span>Tài khoản : {{ $khachhang->kh_Ten }}<i class="arrow_carrot-down"></i></span>
                                @else
                                    <span>Tài khoản <i class="arrow_carrot-down"></i></span>
                                @endif
                                <ul>
                                    @if (Auth::check())
{{--                                        <a class="dropdown-item" href="">Mục cài đặt</a>--}}
                                        <a class="dropdown-item" href="/purchase_order/{{ $khachhang->id }}">Đơn hàng</a>
                                        <a class="dropdown-item" href="{{  route('user.logout')}}"><i class="fa-sharp fa-solid fa-right-from-bracket"></i>Đăng xuất</a>
                                    @else
                                        <a class="dropdown-item" href="{{  route('user.login')}}" style="font-weight: bold;">Đăng nhập</a>
                                        <a class="dropdown-item" href="{{  route('user.register')}}" style="font-weight: bold;">Đăng kí</a>
                                    @endif
                                </ul>
                            </div>
                            @if (Auth::check())
                            <div class="header__top__links">
                                <a href="/user/setting/{{ $khachhang->id }}">Cài đặt</a>
                            </div>
                            @else
                                <div class="header__top__links">
                                    <a href="#">FAQs</a>
                                </div>
                            @endif

                            <div class="header__top__hover">
                                <span>Usd <i class="arrow_carrot-down"></i></span>
                                <ul>
                                    <li>USD</li>
                                    <li>EUR</li>
                                    <li>USD</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
{{--                <div class="col-lg-1">--}}
{{--                    <div class="header__logo">--}}
{{--                        <a href="/"><img src="/template/front-end/img/logo.png" alt=""></a>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-7">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li class="active"><a href="/">Trang chủ</a></li>
                            <li ><a href="/shop">Cửa hàng</a></li>
                            <li ><a href="/blog">Tin tức</a></li>
                            <li><a href="#">Về Chúng tôi</a></li>
                            <li ><a href="/contact">Liên lạc</a></li>
                        </ul>
                    </nav>
                </div>

                {{--  <div class="col-lg-3 col-md-3">
                    <div class="header__nav__option">
                        <form action="#" style="width: 100px">
                            <input type="text" placeholder="Search..." style="width: 100px">
                            <button type="submit"><span class="icon_search"></span></button>
                        </form>
                        <a href="#" class="search-switch"><img src="/template/front-end/img/icon/heart.png" alt=""></a>
                        <div class="js-show-cart"
                            data-notify="{{ !is_null(\Illuminate\Support\Facades\Session::get('carts')) ? count(\Illuminate\Support\Facades\Session::get('carts')) : 0 }}">
                            <i class="fa fa-facebook"></i>
                        </div>
                    </div>
                </div>  --}}

                <div class="col-5">
                    <div class="header__nav__option">
                        <div class="inline-block-container">
                            <form action="/search" style="display: inline-block; margin-right:40px;" method="POST">
                                @csrf
                                <input type="text" placeholder="Tìm kiếm sản phẩm" style="width: 240px;" name="keywords_submit" id="keywords">

                                <button type="submit" ><i class="fa fa-search"></i></button>
                                <div id="search-ajax"></div>
                            </form>
                            <a href="#" class="search-switch"><img src="/template/front-end/img/icon/heart.png" alt=""></a>
                            <div class="js-show-cart"
                                data-notify="{{ !is_null(\Illuminate\Support\Facades\Session::get('carts')) ? count(\Illuminate\Support\Facades\Session::get('carts')) : 0 }}">
                                <i class="fa fa-cart-plus"></i>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </header>
    <!-- Header Section End -->

