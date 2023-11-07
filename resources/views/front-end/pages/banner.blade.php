<!-- Hero Section Begin -->
    <section class="hero">
        <div class="hero__slider owl-carousel">
            @foreach ($sliders as $item)
            <div class="hero__items set-bg" data-setbg="{{ asset('/storage/images/sliders/' . $item->sl_HinhAnh) }}" style="height: 600px;width: 1400px">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6></h6>
                                <h2></h2>
                                <p></p><br>
                                <h3 style="color: red">{{ $item->sl_TieuDe }}</h3>
                                <br><br><br><br><br>
{{--                                <h2>{{ $item->sl_TieuDe }}</h2>--}}
{{--                                <p>{{ $item->sl_NoiDung }}</p>--}}
                                <a href="/shop" class="primary-btn">Mua ngay <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
    <section class="banner spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 offset-lg-4">
                    <div class="banner__item">
                        <div class="banner__item__pic">
                            <img src="/template/front-end/img/banner/banner-9.jpg" alt="" style="width: 450px;height: 450px">
                        </div>
                        <div class="banner__item__text">
                            <h2>Thời trang</h2>
                            <a href="/shop">Mua ngay</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="banner__item banner__item--middle">
                        <div class="banner__item__pic">
                            <img src="/template/front-end/img/banner/banner-10.webp" alt="" style="width: 450px;height: 450px">
                        </div>
                        <div class="banner__item__text">
                            <h2>Du lịch</h2>
                            <a href="/shop">Mua ngay</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="banner__item banner__item--last">
                        <div class="banner__item__pic">
                            <img src="/template/front-end/img/banner/banner-6.jpg" alt="" style="width: 450px;height: 450px">
                        </div>
                        <div class="banner__item__text">
                            <h2>Laptop</h2>
                            <a href="/shop">Mua ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->
