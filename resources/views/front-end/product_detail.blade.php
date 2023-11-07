<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- head -->
    @include('front-end.pages.head')
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">--}}

{{--    <link rel="icon" type="image/png" href="images/icons/favicon.png"/>--}}
{{--    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">--}}
{{--    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">--}}
{{--    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">--}}
{{--    <link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">--}}

{{--    <link rel="stylesheet" type="text/css" href="/template/front-end/vendor/animate/animate.css">--}}
{{--    <link rel="stylesheet" type="text/css" href="/template/front-end/vendor/css-hamburgers/hamburgers.min.css">--}}
{{--    <link rel="stylesheet" type="text/css" href="/template/front-end/vendor/animsition/css/animsition.min.css">--}}
{{--    <link rel="stylesheet" type="text/css" href="/template/front-end/vendor/select2/select2.min.css">--}}
{{--    <link rel="stylesheet" type="text/css" href="/template/front-end/vendor/daterangepicker/daterangepicker.css">--}}
    <link rel="stylesheet" type="text/css" href="/template/front-end/vendor/slick/slick.css">
{{--    <link rel="stylesheet" type="text/css" href="/template/front-end/vendor/MagnificPopup/magnific-popup.css">--}}
{{--    <link rel="stylesheet" type="text/css" href="/template/front-end/vendor/perfect-scrollbar/perfect-scrollbar.css">--}}

    <link rel="stylesheet" type="text/css" href="/template/front-end/vendor/util.css">
    <link rel="stylesheet" type="text/css" href="/template/front-end/vendor/main.css">
</head>

<body>
    @include('front-end.pages.header')

    @include('front-end.header_cart')

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Chi tiết sản phẩm</h4>
                        <div class="breadcrumb__links">
                            <a href="/">Trang chủ</a>
                            <a href="/shop">Cửa hàng</a>
                            <span>Chi tiết sản phẩm</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    <br><br>

        <!-- Product Detail -->
        <section class="sec-product-detail bg0 p-t-65 p-b-60">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-7 p-b-30">
                        <div class="p-l-25 p-r-30 p-lr-0-lg">
                            <div class="wrap-slick3 flex-sb flex-w">
                                <div class="wrap-slick3-dots"></div>
                                <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                                <div class="slick3 gallery-lb">
                                    <div class="item-slick3" data-thumb="{{ asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}">
                                        <div class="product__details__pic__item">
                                            <img src="{{ asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}" width="800px" height="550px">
                                            <a href="{{ $product->sp_Video }}" class="video-popup"><i class="fa fa-play"></i></a>
                                        </div>
                                    </div>
                                    <div class="item-slick3" data-thumb="{{ asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}">
                                        <div class="wrap-pic-w pos-relative">
                                            <img src="{{ asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}" alt="">

                                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{ asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}">
                                                <i class="fa fa-expand"></i>
                                            </a>
                                        </div>
                                    </div>
                                    @foreach ($images as $index => $image)
                                    <div class="item-slick3" data-thumb="{{ asset('/storage/images/product/detail/' . $image->ha_Ten) }}">
                                        <div class="wrap-pic-w pos-relative">
                                            <img src="{{ asset('/storage/images/product/detail/' . $image->ha_Ten) }}" alt="IMG-PRODUCT">

                                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{ asset('/storage/images/product/detail/' . $image->ha_Ten) }}">
                                                <i class="fa fa-expand"></i>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-5 p-b-30">
                        <form action="/add-cart" method="post">
                            <div class="row d-flex justify-content-center">
                                <div class="col-lg-8">
                                    <p class="product__details__text">
                                        <h4>{{ $product->sp_TenSanPham }}</h4>
                                        <div class="rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $rating_round)
                                                    <span class="fa fa-star " style="color: #ff9705;"></span>
                                                @else
                                                    <span class="fa fa-star " style="color: #ccc;"></span>
                                                @endif
                                            @endfor
                                            <span> - {{ $review->count() }} Đánh giá</span>
                                        </div>
                                        @php
                                            $price_reduced = 0;
                                            $price = $product->sp_Gia;
                                            $price_reduced = $price + $price*10/100;
                                        @endphp
                                        <h3>{{ number_format($product->sp_Gia) }}<sup><ins>đ</ins></sup>
                                            <span><strike style="color: grey">{{ number_format($price_reduced, 0, '', '.') }}</strike><sup><ins style="color: grey">đ</ins></sup></span>
                                        </h3>
                                            <p>
                                                @if($total_size > 0)
                                                Tình trạng: Còn hàng <b id="total-quantity2">{{ $total_size }}</b> trong kho
                                                @elseif($total_size == 0)
                                                Tình trạng: <b style="color: red">Hết hàng</b>
                                                 @endif
                                            </p>

                                        @if($total_size > 0)
                                            <span><b>Chọn Size:</b></span>
                                            <div>
                                                @foreach($sizes as $item)
                                                    <input type="radio" class="size-input2" name="product_size" data-quantity2="{{ $item->spkt_soLuongHang }}" value="{{$item->kich_thuoc_id}}" required>
                                                    <label>Size {{ $item->kichthuoc->kt_TenKichThuoc }}</label><br>
                                                @endforeach
                                            </div>


                                        <div class="product__details__cart__option">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <input name="num_product" type="text" value="1" min="1">
                                                </div>
                                            </div>
                                            <button type="submit"  class="primary-btn-detail">Thêm vào giỏ hàng </button>
                                            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                                        </div>
                                        @elseif($total_size == 0)
                                        @endif
                                        <div class="product__details__btns__option">
                                            <a href="{{ route('user.wish_lish_show',$product->id) }}" class="wishlist-link" data-product-id="{{ $product->id }}">
                                                <i class="fa fa-heart" style="color: blue;"></i>
                                                Yêu thích
                                            </a>
                                            <a href="#"><i class="fa fa-exchange"></i> So sánh</a>
                                        </div>
                                        <div class="product__details__last__option">
                                            <h5><span>Thanh toán an toàn</span></h5>
                                            <img src="/template/front-end/img/shop-details/details-payment.png" alt="">
                                            <ul>
                                                {{--                                    <li><span>SKU:</span> #000{{ $product->id }}</li>--}}
                                                <li><span>Danh mục:</span> {{$product->danhmuc->dmsp_TenDanhMuc}}</li>
                                                <li><span>Thương hiệu:</span> {{$product->thuonghieu->thsp_TenThuongHieu}}</li>
                                                <li>
                                                    <span>Tag:</span>
                                                    @php
                                                        $tags = $product->sp_Tag;
                                                        $tags = explode(",",$tags);
                                                    @endphp
                                                    @foreach($tags as $tag)
                                                        <a style="color: black" href="{{ url('/tag/' . Str::slug($tag)) }}">{{ $tag }},</a>
                                                    @endforeach
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <div class="product__details__content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-5" role="tab">Mô tả</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-6" role="tab">Đánh giá({{ $review->count() }})</a>
                                </li>
                                {{--  <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-7" role="tab">Thông tin thêm</a>
                                </li>  --}}
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-5" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <p class="note">{{ $product->sp_MoTa }}</p>
                                        <div class="product__details__tab__content__item">
                                            <h5>Thông tin sản phẩm</h5>
                                            <p>{{ $product->sp_NoiDung }}<p>
                                        </div>
                                        <div class="product__details__tab__content__item">
                                            <h5>Chất liệu</h5>
                                            <p>{{ $product->sp_ChatLieu }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-6" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <div class="product__details__tab__content__item">
{{--                                            <div class="row">--}}
                                                <div class="component_rating_content" style="display: flex;align-items: center;border-radius: 5px;border: 1px solid #dedede">
                                                    <div class="rating_item" style="width: 10%; position: relative; display: grid; text-align: center;">
                                                        <span class="fa fa-star" style="font-size: 100px; color: #ff9705;"></span>
                                                        <b style="color: red; font-size: 20px;">{{ $roundedRating }}</b>
                                                    </div>

                                                    <?php
                                                    $ratingCounts = [0, 0, 0, 0, 0]; // Mảng đếm số lượng đánh giá cho mỗi số sao (1-5)
                                                    foreach ($rating_products as $rating_product) {
                                                        $ratingCounts[$rating_product->dg_SoSao - 1]++;
                                                    }
                                                    $totalRatings = count($rating_products);
                                                    $percentageRatings = [];
                                                    for ($i = 0; $i < 5; $i++) {
                                                        $percentage = ($totalRatings > 0) ? ($ratingCounts[$i] / $totalRatings) * 100 : 0;
                                                        $percentageRatings[] = $percentage;
                                                    }
                                                    ?>


                                                    <div class="list_rating" style="width: 100%;padding: 20px">
                                                        @for($i = 5; $i >= 1; $i--)
                                                        <div class="item_rating" style="display: flex;align-items: center">
                                                            <div style="width: 4%;font-size: 14px">
                                                                {{ $i }} <span class="fa fa-star" style="color: #ff9705;"></span>
                                                            </div>
                                                            <div style="width: 100%;margin: 0 20px">
                                                                <span style="width: 100%;height: 8px;display: block;border: 1px solid #dedede;border-radius: 5px;background-color: #dedede">
                                                                    <b style="width: {{ $percentageRatings[$i-1] }}%;background-color: #f25800;
                                                                              display: block;border-radius: 5px;
                                                                              height: 100%">
                                                                    </b>
                                                                </span>
                                                            </div>
                                                            <div style="width: 6%">
                                                                <p>{{ round($percentageRatings[$i-1]) }} %</p>
                                                            </div>
                                                        </div>
                                                        @endfor
                                                    </div>


                                                </div>
{{--                                            </div>--}}
                                            <br>

                                            @foreach($review as $rv)
{{--                                            <div class="row">--}}
                                                <div class="row cm">
                                                    <div class="col-1">
                                                        <div class="blog__details__author__pic custom-avatar" style="width: 55px">
                                                            <img src="{{ asset('/storage/images/avatar/customers/'.$rv->khachhang->avatar) }}" class="rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="col-11">
                                                        <div class="blog__details__author__text">
                                                            <h5>{{ $rv->khachhang->kh_Ten }}</h5>
                                                            <p>Lúc {{ $rv->created_at->format('H:i:s d/m/Y') }}</p><br>
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= $rv->dg_SoSao)
                                                                    <span class="fa fa-star " style="color: #ff9705;"></span>
                                                                @else
                                                                    <span class="fa fa-star " style="color: #ccc;"></span>
                                                                @endif
                                                            @endfor
                                                            <br><p>{{ $rv->dg_MucDanhGia }}</p>
                                                        </div>
                                                    </div>
                                                </div>
{{--                                            </div>--}}
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{--    </section>--}}
    <!-- Shop Details Section End -->

    <!-- Related Section Begin -->
    <section class="related spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="related-title">Sản phẩm liên quan</h3>
                </div>
            </div>
            <div class="row">
                @foreach ($product_related as $product_relate)
                    @php
                        $avgRating = \App\Models\ĐanhGia::where('san_pham_id', $product_relate->id)->avg('dg_SoSao');
                        $roundedAvgRating = ceil($avgRating);
                    @endphp
                <div class="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg">
                            <a href="/product/{{ $product_relate->id }}">
                                <img src="{{asset('/storage/images/products/'.$product_relate->sp_AnhDaiDien) }}">
                            <ul class="product__hover">
                                <li><a href="{{ route('user.wish_lish_show',$product_relate->id) }}" class="wishlist-link" data-product-id="{{ $product_relate->id }}">
                                        <i class="fa fa-heart" style="color: blue;"></i>
                                    </a>
                                </li>
                                <li><a href="#"><img src="/template/front-end/img/icon/compare.png" alt=""> <span>Compare</span></a></li>
                                <li><a href="#"><img src="/template/front-end/img/icon/search.png" alt=""></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6 class="text-center">{{ $product_relate->sp_TenSanPham }}</h6>
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
                            <h5 class="text-center">{{ number_format($product_relate->sp_Gia) }}<sup><ins>đ</ins></sup></h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Related Section End -->

    @include('front-end.pages.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    @if(session()->has('success_message'))
        <style>
            .my-custom-icon {
                color: #ff0000; /* Màu đỏ */
                font-size: 5px; /* Kích thước nhỏ hơn (16px) */
            }
        </style>

        <script>
            Swal.fire({
                title: 'Cảm ơn bạn!!!', // Tiêu đề của thông báo
                text: 'Đã thêm sản phẩm vào giỏ hàng!', // Nội dung của thông báo
                icon: 'success', // Icon của thông báo (success, error, warning, info, question)
                showConfirmButton: false, // Không hiển thị nút xác nhận
                timer: 2500, // Thời gian hiển thị thông báo (tính theo milliseconds)
                showCloseButton: true, // Hiển thị nút X để tắt thông báo
                customClass: {
                    icon: 'my-custom-icon' // Sử dụng lớp CSS tùy chỉnh cho icon
                },
                // background: '#ff0000', // Màu nền của thông báo
                padding: '3rem', // Khoảng cách lề bên trong thông báo
                borderRadius: '10px' // Độ cong của góc thông báo
            });
        </script>
    @elseif(session()->has('flash_message_error'))
        <style>
            .my-custom-icon {
                color: #ff0000; /* Màu đỏ */
                font-size: 5px; /* Kích thước nhỏ hơn (16px) */
            }
        </style>

        <script>
            Swal.fire({
                title: 'Rất tiết!!!', // Tiêu đề của thông báo
                text: 'Số lượng đã vượt quá trong kho!', // Nội dung của thông báo
                icon: 'success', // Icon của thông báo (success, error, warning, info, question)
                showConfirmButton: false, // Không hiển thị nút xác nhận
                timer: 2500, // Thời gian hiển thị thông báo (tính theo milliseconds)
                showCloseButton: true, // Hiển thị nút X để tắt thông báo
                customClass: {
                    icon: 'my-custom-icon' // Sử dụng lớp CSS tùy chỉnh cho icon
                },
                // background: '#ff0000', // Màu nền của thông báo
                padding: '3rem', // Khoảng cách lề bên trong thông báo
                borderRadius: '10px' // Độ cong của góc thông báo
            });
        </script>
    @elseif(session()->has('flash_message_error_qty'))
        <style>
            .my-custom-icon {
                color: #ff0000; /* Màu đỏ */
                font-size: 5px; /* Kích thước nhỏ hơn (16px) */
            }
        </style>

        <script>
            Swal.fire({
                title: 'Rất tiết!!!', // Tiêu đề của thông báo
                text: 'Số lượng hoặc sản phẩm không chính xác!', // Nội dung của thông báo
                icon: 'success', // Icon của thông báo (success, error, warning, info, question)
                showConfirmButton: false, // Không hiển thị nút xác nhận
                timer: 2500, // Thời gian hiển thị thông báo (tính theo milliseconds)
                showCloseButton: true, // Hiển thị nút X để tắt thông báo
                customClass: {
                    icon: 'my-custom-icon' // Sử dụng lớp CSS tùy chỉnh cho icon
                },
                // background: '#ff0000', // Màu nền của thông báo
                padding: '3rem', // Khoảng cách lề bên trong thông báo
                borderRadius: '10px' // Độ cong của góc thông báo
            });
        </script>
    @elseif(session()->has('success_message_review'))
        <style>
            .my-custom-icon {
                color: #ff0000; /* Màu đỏ */
                font-size: 5px; /* Kích thước nhỏ hơn (16px) */
            }
        </style>

        <script>
            Swal.fire({
                title: 'Cảm ơn bạn!!!', // Tiêu đề của thông báo
                text: 'Đã thêm đánh giá cho sản phẩm!', // Nội dung của thông báo
                icon: 'success', // Icon của thông báo (success, error, warning, info, question)
                showConfirmButton: false, // Không hiển thị nút xác nhận
                timer: 2500, // Thời gian hiển thị thông báo (tính theo milliseconds)
                showCloseButton: true, // Hiển thị nút X để tắt thông báo
                customClass: {
                    icon: 'my-custom-icon' // Sử dụng lớp CSS tùy chỉnh cho icon
                },
                // background: '#ff0000', // Màu nền của thông báo
                padding: '3rem', // Khoảng cách lề bên trong thông báo
                borderRadius: '10px' // Độ cong của góc thông báo
            });
        </script>
{{--    @elseif(session()->has('flash_message_error_review1'))--}}
{{--        <style>--}}
{{--            .my-custom-icon {--}}
{{--                color: #ff0000; /* Màu đỏ */--}}
{{--                font-size: 5px; /* Kích thước nhỏ hơn (16px) */--}}
{{--            }--}}
{{--        </style>--}}

{{--        <script>--}}
{{--            Swal.fire({--}}
{{--                title: 'Rất tiết!!!', // Tiêu đề của thông báo--}}
{{--                text: 'Bạn phải mua sản phẩm trước khi đánh giá!', // Nội dung của thông báo--}}
{{--                icon: 'success', // Icon của thông báo (success, error, warning, info, question)--}}
{{--                showConfirmButton: false, // Không hiển thị nút xác nhận--}}
{{--                timer: 2500, // Thời gian hiển thị thông báo (tính theo milliseconds)--}}
{{--                showCloseButton: true, // Hiển thị nút X để tắt thông báo--}}
{{--                customClass: {--}}
{{--                    icon: 'my-custom-icon' // Sử dụng lớp CSS tùy chỉnh cho icon--}}
{{--                },--}}
{{--                // background: '#ff0000', // Màu nền của thông báo--}}
{{--                padding: '3rem', // Khoảng cách lề bên trong thông báo--}}
{{--                borderRadius: '10px' // Độ cong của góc thông báo--}}
{{--            });--}}
{{--        </script>--}}
    @elseif(session()->has('flash_message_error_review2'))
        <style>
            .my-custom-icon {
                color: #ff0000; /* Màu đỏ */
                font-size: 5px; /* Kích thước nhỏ hơn (16px) */
            }
        </style>

        <script>
            Swal.fire({
                title: 'Rất tiết!!!', // Tiêu đề của thông báo
                html: 'Bạn cần <a href="/user/login">đăng nhập</a> để thêm đánh giá cho sản phẩm!', // Nội dung của thông báo với đường liên kết
                icon: 'success', // Icon của thông báo (success, error, warning, info, question)
                showConfirmButton: false, // Không hiển thị nút xác nhận
                timer: 6500, // Thời gian hiển thị thông báo (tính theo milliseconds)
                showCloseButton: true, // Hiển thị nút X để tắt thông báo
                customClass: {
                    icon: 'my-custom-icon' // Sử dụng lớp CSS tùy chỉnh cho icon
                },
                // background: '#ff0000', // Màu nền của thông báo
                padding: '3rem', // Khoảng cách lề bên trong thông báo
                borderRadius: '10px' // Độ cong của góc thông báo
            });
        </script>
    @endif

    <script>
        // Hàm kiểm tra xem sản phẩm có trong danh sách yêu thích hay không
        function isProductFavorited(productId) {
            return favoritedProducts.includes(productId);
        }

        // Hàm xử lý sự kiện khi nhấn vào biểu tượng trái tim
        function handleWishlistClick(event) {
            event.preventDefault();
            const heartIcon = event.currentTarget.querySelector('.fa-heart');
            const productId = parseInt(event.currentTarget.dataset.productId);

            // Kiểm tra xem người dùng đã đăng nhập hay chưa
            const isUserLoggedIn = @json(Auth::check());

            if (!isUserLoggedIn) {
                // Hiển thị thông báo lỗi khi chưa đăng nhập
                alert('Vui lòng đăng nhập để thêm sản phẩm vào danh sách yêu thích!');
                return;
            }

            if (isProductFavorited(productId)) {
                // Xóa sản phẩm khỏi danh sách yêu thích (đổi màu thành xanh)
                heartIcon.style.color = 'blue';

                // Giảm giá trị data-notify đi 1
                const notifyElement = document.querySelector('.js-show-wish');
                const currentNotifyValue = parseInt(notifyElement.getAttribute('data-notify'));
                notifyElement.setAttribute('data-notify', currentNotifyValue - 1);
            } else {
                // Thêm sản phẩm vào danh sách yêu thích (đổi màu thành đỏ)
                heartIcon.style.color = 'red';

                // Tăng giá trị data-notify lên 1
                const notifyElement = document.querySelector('.js-show-wish');
                const currentNotifyValue = parseInt(notifyElement.getAttribute('data-notify'));
                notifyElement.setAttribute('data-notify', currentNotifyValue + 1);
            }

            // Gửi yêu cầu AJAX đến route 'wish_lish_show' để thêm/xóa sản phẩm khỏi danh sách yêu thích
            fetch(event.currentTarget.href)
                .then(response => response.json())
                .then(data => {
                    // Cập nhật mảng favoritedProducts dựa trên phản hồi từ server
                    if (data.isFavorited) {
                        favoritedProducts.push(productId);
                    } else {
                        const index = favoritedProducts.indexOf(productId);
                        if (index !== -1) {
                            favoritedProducts.splice(index, 1);
                        }
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi xử lý yêu thích sản phẩm:', error);
                });
        }

        // Lấy danh sách các sản phẩm yêu thích từ model YeuThich
        const favoritedProducts = @json($favoritedProducts);

        // Lắng nghe sự kiện nhấn chuột vào các liên kết yêu thích
        const wishlistLinks = document.querySelectorAll('.wishlist-link');
        wishlistLinks.forEach(link => {
            link.addEventListener('click', handleWishlistClick);
            const productId = parseInt(link.dataset.productId);
            if (isProductFavorited(productId)) {
                // Nếu sản phẩm đã được yêu thích (có trong mảng favoritedProducts), đổi màu thành đỏ
                link.querySelector('.fa-heart').style.color = 'red';
            }
        });
    </script>


{{--    <script src="/template/front-end/vendor/jquery/jquery-3.2.1.min.js"></script>--}}
{{--    <script src="/template/front-end/vendor/animsition/js/animsition.min.js"></script>--}}
{{--    <script src="/template/front-end/vendor/bootstrap/js/popper.js"></script>--}}
{{--    <script src="/template/front-end/vendor/bootstrap/js/bootstrap.min.js"></script>--}}
{{--    <script src="/template/front-end/vendor/select2/select2.min.js"></script>--}}
{{--    <script>--}}
{{--        $(".js-select2").each(function(){--}}
{{--            $(this).select2({--}}
{{--                minimumResultsForSearch: 20,--}}
{{--                dropdownParent: $(this).next('.dropDownSelect2')--}}
{{--            });--}}
{{--        })--}}
{{--    </script>--}}

{{--    <script src="/template/front-end/vendor/daterangepicker/moment.min.js"></script>--}}
{{--    <script src="/template/front-end/vendor/daterangepicker/daterangepicker.js"></script>--}}
    <script src="/template/front-end/vendor/slick/slick.min.js"></script>
    <script src="/template/front-end/vendor/slick-custom.js"></script>
    <script src="/template/front-end/vendor/parallax100/parallax100.js"></script>
    <script>
        $('.parallax100').parallax100();
    </script>
{{--    <script src="/template/front-end/vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>--}}
    <script>
        $('.gallery-lb').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: 'a', // the selector for gallery item
                type: 'image',
                gallery: {
                    enabled:true
                },
                mainClass: 'mfp-fade'
            });
        });
    </script>

    {{--    <script src="/template/front-end/vendor/isotope/isotope.pkgd.min.js"></script>--}}
{{--    <script src="/template/front-end/vendor/sweetalert/sweetalert.min.js"></script>--}}
{{--    <script src="/template/front-end/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>--}}
{{--    <script src="/template/front-end/vendor/main.js"></script>--}}

    <script>
        var sizeInputs = document.querySelectorAll('.size-input2');
        var totalQuantityDisplay = document.getElementById('total-quantity2');

        sizeInputs.forEach(function(input) {
            input.addEventListener('change', function() {
                var quantity = this.getAttribute('data-quantity2');
                // Cập nhật giá trị `$total_size`
                totalQuantityDisplay.textContent = quantity;
            });
        });
    </script>

</body>

</html>
