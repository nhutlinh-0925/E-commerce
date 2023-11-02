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
                        <form action="/add-cart-shop" method="post">
                        @csrf
                        <div class="product__item">
                            <div class="product__item__pic set-bg" >
                                <a href="/product/{{ $product->id }}">
                                    <img src="{{asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}"></a>
{{--                                <span class="label">Hot</span>--}}
                                <ul class="product__hover">
                                    <li><a href="{{ route('user.wish_lish_show',$product->id) }}" class="wishlist-link" data-product-id="{{ $product->id }}">
                                            <i class="fa fa-heart" style="color: blue;"></i>
                                        </a>
                                    </li>
                                    <li><a href="#"><img src="/template/front-end/img/icon/compare.png" alt=""> <span>Compare</span></a>
                                    </li>
                                    <li><a href="#"><img src="/template/front-end/img/icon/search.png" alt=""></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6 class="text-center">{{ $product->sp_TenSanPham }}</h6>
                                <a href="#" class="add-cart">Xem nhanh</a>
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
                                <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}">
                                <input type="hidden" name="num_product" value= "1">
                                <button type="submit" class="btn btn-info"  style="display: flex; justify-content: center; align-items: center; width: 140px; height: 30px; margin: 0 auto;">
                                    + Thêm giỏ hàng
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                @endforeach

                @foreach ($new_arrivals as $product)
                        @php
                            $avgRating = \App\Models\ĐanhGia::where('san_pham_id', $product->id)->avg('dg_SoSao');
                            $roundedAvgRating = ceil($avgRating);
                        @endphp
                    <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix new_arrivals">
                        <form action="/add-cart-shop" method="post">
                        @csrf
                            <div class="product__item">
                                <div class="product__item__pic set-bg" >
                                    <a href="/product/{{ $product->id }}">
                                        <img src="{{asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}"></a>
                                    {{--                                <span class="label">Hot</span>--}}
                                    <ul class="product__hover">
                                        <li><a href="{{ route('user.wish_lish_show',$product->id) }}" class="wishlist-link" data-product-id="{{ $product->id }}">
                                                <i class="fa fa-heart" style="color: blue;"></i>
                                            </a>
                                        </li>
                                        <li><a href="#"><img src="/template/front-end/img/icon/compare.png" alt=""> <span>Compare</span></a></li>
                                        <li><a href="#"><img src="/template/front-end/img/icon/search.png" alt=""></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6 class="text-center">{{ $product->sp_TenSanPham }}</h6>
                                    <a href="#" class="add-cart">Xem nhanh</a>
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
                                    <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}">
                                    <input type="hidden" name="num_product" value= "1">
                                    <button type="submit" class="btn btn-info"  style="display: flex; justify-content: center; align-items: center; width: 140px; height: 30px; margin: 0 auto;">
                                        + Thêm giỏ hàng
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach

                @foreach ($most_views as $product)
                        @php
                            $avgRating = \App\Models\ĐanhGia::where('san_pham_id', $product->id)->avg('dg_SoSao');
                            $roundedAvgRating = ceil($avgRating);
                        @endphp
                    <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix most_views">
                        <form action="/add-cart-shop" method="post">
                        @csrf
                        <div class="product__item">
                            <div class="product__item__pic set-bg" >
                                <a href="/product/{{ $product->id }}">
                                    <img src="{{asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}"></a>
                                <ul class="product__hover">
                                    <li><a href="{{ route('user.wish_lish_show',$product->id) }}" class="wishlist-link" data-product-id="{{ $product->id }}">
                                            <i class="fa fa-heart" style="color: blue;"></i>
                                        </a>
                                    </li>
                                    <li><a href="#"><img src="/template/front-end/img/icon/compare.png" alt=""> <span>Compare</span></a>
                                    </li>
                                    <li><a href="#"><img src="/template/front-end/img/icon/search.png" alt=""></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6 class="text-center">{{ $product->sp_TenSanPham }}</h6>
                                <a href="#" class="add-cart">Xem nhanh</a>
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
                                <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}">
                                <input type="hidden" name="num_product" value= "1">
                                <button type="submit" class="btn btn-info"  style="display: flex; justify-content: center; align-items: center; width: 140px; height: 30px; margin: 0 auto;">
                                    + Thêm giỏ hàng
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Product Section End -->
