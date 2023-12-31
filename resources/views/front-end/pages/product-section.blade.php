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
                    @php
                        $avgRating = \App\Models\ĐanhGia::where('san_pham_id', $product->id)->avg('dg_SoSao');
                        $roundedAvgRating = ceil($avgRating);
                    @endphp
                    <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix bestseller">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" >
                                <a href="/product/{{ $product->id }}">
                                    <img src="{{asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}"></a>
{{--                                <span class="label">Hot</span>--}}
                                <ul class="product__hover">
                                    <li><a href="{{ route('user.wish_lish_show',$product->id) }}" class="wishlist-link" data-product-id="{{ $product->id }}">
                                            <i class="fa fa-heart" style="color: blue;"></i> <span>Yêu thích</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6 class="text-center">{{ $product->sp_TenSanPham }}</h6>
                                <a href="#" class="xemnhanh" data-toggle="modal" data-target="#xemnhanh" data-product_id="{{ $product->id }}">Xem nhanh</a>
                                <div class="text-center rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $roundedAvgRating)
                                            <span class="fa fa-star " style="color: #ff9705;"></span>
                                        @else
                                            <span class="fa fa-star " style="color: #ccc;"></span>
                                        @endif
                                    @endfor
                                </div>
                                <h5 class="text-center">{{ number_format($product->sp_Gia) }}<sup><ins>đ</ins></sup></h5>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Modal quick_view -->
                <div class="modal fade" id="xemnhanh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title product_quickview_title" id="" style="color: #8b1014;">Xem nhanh </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="/add-cart-quick_view" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <span id="product_quickview_image"></span>
                                        </div>

                                        <div class="col-md-7">
                                            <h4><span id="product_quickview_name"></span></h4>

                                            <div id="product_quickview_rating"></div>
                                            <h5 style="color: red"><span id="product_quickview_price"></span></h5>
                                            <p id="product_quickview_stock"></p>

                                            <div id="product_quickview_options"></div>
                                            <span id="product_quickview_category"></span><br>
                                            <span id="product_quickview_brand"></span><br>

                                            <p>Chia sẻ:
                                                <i class="fa fa-facebook"></i>
                                                <i class="fa fa-twitter"></i>
                                                <i class="fa fa-youtube-play"></i>
                                                <i class="fa fa-linkedin"></i>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @foreach ($new_arrivals as $product)
                        @php
                            $avgRating = \App\Models\ĐanhGia::where('san_pham_id', $product->id)->avg('dg_SoSao');
                            $roundedAvgRating = ceil($avgRating);
                        @endphp
                    <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix new_arrivals">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" >
                                    <a href="/product/{{ $product->id }}">
                                        <img src="{{asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}"></a>
                                    {{--                                <span class="label">Hot</span>--}}
                                    <ul class="product__hover">
                                        <li><a href="{{ route('user.wish_lish_show',$product->id) }}" class="wishlist-link" data-product-id="{{ $product->id }}">
                                                <i class="fa fa-heart" style="color: blue;"></i> <span>Yêu thích</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6 class="text-center">{{ $product->sp_TenSanPham }}</h6>
                                    <a href="#" class="xemnhanh" data-toggle="modal" data-target="#xemnhanh" data-product_id="{{ $product->id }}">Xem nhanh</a>
                                    <div class="text-center rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $roundedAvgRating)
                                                <span class="fa fa-star " style="color: #ff9705;"></span>
                                            @else
                                                <span class="fa fa-star " style="color: #ccc;"></span>
                                            @endif
                                        @endfor
                                    </div>
                                    <h5 class="text-center">{{ number_format($product->sp_Gia) }}<sup><ins>đ</ins></sup></h5>
                                </div>
                            </div>
                    </div>
                @endforeach
                <!-- Modal quick_view -->
                <div class="modal fade" id="xemnhanh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title product_quickview_title" id="" style="color: #8b1014;">Xem nhanh </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="/add-cart-quick_view" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <span id="product_quickview_image"></span>
                                        </div>

                                        <div class="col-md-7">
                                            <h4><span id="product_quickview_name"></span></h4>

                                            <div id="product_quickview_rating"></div>
                                            <h5 style="color: red"><span id="product_quickview_price"></span></h5>
                                            <p id="product_quickview_stock"></p>

                                            <div id="product_quickview_options"></div>
                                            <span id="product_quickview_category"></span><br>
                                            <span id="product_quickview_brand"></span><br>

                                            <p>Chia sẻ:
                                                <i class="fa fa-facebook"></i>
                                                <i class="fa fa-twitter"></i>
                                                <i class="fa fa-youtube-play"></i>
                                                <i class="fa fa-linkedin"></i>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @foreach ($most_views as $product)
                        @php
                            $avgRating = \App\Models\ĐanhGia::where('san_pham_id', $product->id)->avg('dg_SoSao');
                            $roundedAvgRating = ceil($avgRating);
                        @endphp
                    <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix most_views">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" >
                                <a href="/product/{{ $product->id }}">
                                    <img src="{{asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}"></a>
                                <ul class="product__hover">
                                    <li><a href="{{ route('user.wish_lish_show',$product->id) }}" class="wishlist-link" data-product-id="{{ $product->id }}">
                                            <i class="fa fa-heart" style="color: blue;"></i> <span>Yêu thích</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6 class="text-center">{{ $product->sp_TenSanPham }}</h6>
                                <a href="#" class="xemnhanh" data-toggle="modal" data-target="#xemnhanh" data-product_id="{{ $product->id }}">Xem nhanh</a>
                                <div class="text-center rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $roundedAvgRating)
                                            <span class="fa fa-star " style="color: #ff9705;"></span>
                                        @else
                                            <span class="fa fa-star " style="color: #ccc;"></span>
                                        @endif
                                    @endfor
                                </div>
                                <h5 class="text-center">{{ number_format($product->sp_Gia) }}<sup><ins>đ</ins></sup></h5>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Modal quick_view -->
                <div class="modal fade" id="xemnhanh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title product_quickview_title" id="" style="color: #8b1014;">Xem nhanh </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="/add-cart-quick_view" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <span id="product_quickview_image"></span>
                                        </div>

                                        <div class="col-md-7">
                                            <h4><span id="product_quickview_name"></span></h4>

                                            <div id="product_quickview_rating"></div>
                                            <h5 style="color: red"><span id="product_quickview_price"></span></h5>
                                            <p id="product_quickview_stock"></p>

                                            <div id="product_quickview_options"></div>
                                            <span id="product_quickview_category"></span><br>
                                            <span id="product_quickview_brand"></span><br>

                                            <p>Chia sẻ:
                                                <i class="fa fa-facebook"></i>
                                                <i class="fa fa-twitter"></i>
                                                <i class="fa fa-youtube-play"></i>
                                                <i class="fa fa-linkedin"></i>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Product Section End -->
