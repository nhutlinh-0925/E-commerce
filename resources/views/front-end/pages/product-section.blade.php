<!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="filter__controls">
                        <li class="active" data-filter=".bestseller">Bán chạy nhất</li>
                        <li data-filter=".new_arrivals">Hàng mới về</li>
                        <li data-filter=".most_views">Hàng xem nhiều</li>
                    </ul>
                </div>
            </div>
            <div class="row product__filter">
                @foreach ($bestseller as $product)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix bestseller">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" >
                                <a href="/product/{{ $product->id }}">
                                    <img src="{{asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}"></a>
{{--                                <span class="label">Hot</span>--}}
                                <ul class="product__hover">
                                    <li><a href="#"><img src="/template/front-end/img/icon/heart.png" alt=""></a></li>
                                    <li><a href="#"><img src="/template/front-end/img/icon/compare.png" alt=""> <span>Compare</span></a>
                                    </li>
                                    <li><a href="#"><img src="/template/front-end/img/icon/search.png" alt=""></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6>{{ $product->sp_TenSanPham }}</h6>
                                <a href="" class="add-cart">+ Add To Cart</a>
                                <div class="rating">
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <h5>{{ number_format($product->sp_Gia) }}<sup><ins>đ</ins></sup></h5>
                                <div class="product__color__select">
                                    <label for="pc-4">
                                        <input type="radio" id="pc-4">
                                    </label>
                                    <label class="active black" for="pc-5">
                                        <input type="radio" id="pc-5">
                                    </label>
                                    <label class="grey" for="pc-6">
                                        <input type="radio" id="pc-6">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @foreach ($new_arrivals as $product)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix new_arrivals">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" >
                                <a href="/product/{{ $product->id }}">
                                    <img src="{{asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}"></a>
                                {{--                                <span class="label">Hot</span>--}}
                                <ul class="product__hover">
                                    <li><a href="#"><img src="/template/front-end/img/icon/heart.png" alt=""></a></li>
                                    <li><a href="#"><img src="/template/front-end/img/icon/compare.png" alt=""> <span>Compare</span></a>
                                    </li>
                                    <li><a href="#"><img src="/template/front-end/img/icon/search.png" alt=""></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6>{{ $product->sp_TenSanPham }}</h6>
                                <a href="" class="add-cart">+ Add To Cart</a>
                                <div class="rating">
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <h5>{{ number_format($product->sp_Gia) }}<sup><ins>đ</ins></sup></h5>
                                <div class="product__color__select">
                                    <label for="pc-4">
                                        <input type="radio" id="pc-4">
                                    </label>
                                    <label class="active black" for="pc-5">
                                        <input type="radio" id="pc-5">
                                    </label>
                                    <label class="grey" for="pc-6">
                                        <input type="radio" id="pc-6">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @foreach ($most_views as $product)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix most_views">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" >
                                <a href="/product/{{ $product->id }}">
                                    <img src="{{asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}"></a>
                                {{--                                <span class="label">Hot</span>--}}
                                <ul class="product__hover">
                                    <li><a href="#"><img src="/template/front-end/img/icon/heart.png" alt=""></a></li>
                                    <li><a href="#"><img src="/template/front-end/img/icon/compare.png" alt=""> <span>Compare</span></a>
                                    </li>
                                    <li><a href="#"><img src="/template/front-end/img/icon/search.png" alt=""></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6>{{ $product->sp_TenSanPham }}</h6>
                                <a href="" class="add-cart">+ Add To Cart</a>
                                <div class="rating">
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <h5>{{ number_format($product->sp_Gia) }}<sup><ins>đ</ins></sup></h5>
                                <div class="product__color__select">
                                    <label for="pc-4">
                                        <input type="radio" id="pc-4">
                                    </label>
                                    <label class="active black" for="pc-5">
                                        <input type="radio" id="pc-5">
                                    </label>
                                    <label class="grey" for="pc-6">
                                        <input type="radio" id="pc-6">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Product Section End -->
