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
                        <a class="dropdown-item" href="">Xin chào {{ Auth('web')->user()->kh_Ten }}</a>
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
            <p>Hotline: 1800.6198 (8-22h, MIỄN PHÍ)</p>

        </div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-7">
                        <div class="header__top__left">
                            <p>Hotline: 1800.6198 (8-22h, MIỄN PHÍ) </p>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-5">
                        <div class="header__top__right">
                            <div class="header__top__hover">
                                @if (Auth::check())
                                <span>Tài khoản : {{ Auth('web')->user()->kh_Ten }}<i class="arrow_carrot-down"></i></span>
                                @else
                                <span>Tài khoản <i class="arrow_carrot-down"></i></span>
                                @endif
                                <ul>
                                    @if (Auth::check())
                                        <a class="dropdown-item" href="/user/purchase_order/{{ Auth('web')->user()->id }}">Đơn hàng</a>
                                        <a class="dropdown-item" href="{{  route('user.logout')}}"><i class="fa-sharp fa-solid fa-right-from-bracket"></i>Đăng xuất</a>
                                    @else
                                        <a class="dropdown-item" href="{{  route('user.login')}}" style="font-weight: bold;">Đăng nhập</a>
                                        <a class="dropdown-item" href="{{  route('user.register')}}" style="font-weight: bold;">Đăng kí</a>
                                    @endif
                                </ul>
                            </div>
                            @if (Auth::check())
                            <div class="header__top__links">
                                <a href="/user/warranty">Chính sách bảo hành</a>
                                <a href="/user/setting/{{ Auth('web')->user()->id }}">Cài đặt</a>
                            </div>
                            @else()
                            <div class="header__top__links">
                                <a href="/warranty">Chính sách bảo hành</a>
                            </div>
                            @endif

                            <div class="header__top__hover">
{{--                                <span>Usd <i class="arrow_carrot-down"></i></span>--}}
{{--                                <ul>--}}
{{--                                    <li>USD</li>--}}
{{--                                    <li>EUR</li>--}}
{{--                                    <li>USD</li>--}}
{{--                                </ul>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-7">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li class="active"><a href="/">Trang chủ</a></li>
                            <li><a href="/shop">Cửa hàng</a></li>
                            <li><a href="/blog">Tin tức</a></li>
                            <li><a href="/about">Về Chúng tôi</a></li>
                            <li><a href="/contact">Liên lạc</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="col-5">
                    <div class="header__nav__option d-flex align-items-center">
                        <!-- Form search 1 -->
                        <form action="/search" style="margin-right: 20px;" method="POST">
                            @csrf
                            <input autocomplete="off" placeholder="Tìm kiếm sản phẩm" style="width: 240px;" name="keywords_submit" id="keywords">
                            <button type="submit"><i class="fa fa-search"></i></button>
                            <div id="search-ajax"></div>
                        </form>

                        <!-- Form search 2 -->
                        @if (Auth::check())
                        <form id="search-form" action="{{ url('/user/search_microphone')}}" method="get" >
                            <div class="btn btn-white input-group-text border-0" type="submit" id="">
                                <div style="display:none">
                                    <input id="search-input" name="keywork" type="text">
                                </div>
                                <span class="microphone">
                                    <i class="fa fa-microphone"></i>
                                    <span class="recording-icon"></span>
                                </span>
                            </div>
                        </form>
                        @else()
                            <form id="search-form" action="{{ url('/search_microphone')}}" method="get" >
                                <div class="btn btn-white input-group-text border-0" type="submit" id="">
                                    <div style="display:none">
                                        <input id="search-input" name="keywork" type="text">
                                    </div>
                                    <span class="microphone">
                                    <i class="fa fa-microphone"></i>
                                    <span class="recording-icon"></span>
                                </span>
                                </div>
                            </form>
                        @endif

                        <!-- Wishlist and Cart icons -->
                        <div class="d-flex align-items-center ml-auto">
                            @if (Auth::check())
                                <div class="js-show-wish icon-header-noti-yt" data-notify="{{ count($wish_count) }}" style="margin-right: 30px;">
                                    <a href="/user/wish-list-count/{{ Auth('web')->user()->id }}">
                                        <i class="fa fa-heart" style="color: black; font-size: 24px"></i>
                                    </a>
                                </div>
                            @else()
                                <div class="js-show-wish icon-header-noti-yt" data-notify="0" style="margin-right: 30px;">
                                    <a href="" onclick='return confirm("Bạn cần đăng nhập để xem danh sách sản phẩm yêu thích !!!")'>
                                        <i class="fa fa-heart" style="color: black; font-size: 24px"></i>
                                    </a>
                                </div>
                            @endif

                            <div class="js-show-cart icon-header-noti" data-notify="{{ !is_null(\Illuminate\Support\Facades\Session::get('carts')) ? count(\Illuminate\Support\Facades\Session::get('carts')) : 0 }}">
                                <i class="fa fa-cart-plus" style="color: black; font-size: 24px"></i>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
{{--            <div class="canvas__open"><i class="fa fa-bars"></i></div>--}}
        </div>

    </header>
    <!-- Header Section End -->

