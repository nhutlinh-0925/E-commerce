<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- head -->
    @include('front-end.pages.head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    @include('front-end.pages.header')

    @include('front-end.header_cart')

    <!-- Shop Details Section Begin -->
    <section class="shop-details">
        <div class="product__details__pic">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="/">Trang chủ</a>
                            <a href="/shop">Cửa hàng</a>
                            <span>Chi tiết sản phẩm</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
                                    <div class="product__thumb__pic set-bg">
                                        <img src="{{ asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}" width="100px" height="100px">
                                    </div>
                                </a>
                            </li>
                            @php
                                $tabIndex = 2;
                            @endphp
                            @foreach ($images as $index => $image)
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-{{ $tabIndex }}" role="tab">
                                        <div class="product__thumb__pic set-bg" data-setbg="{{ asset('/storage/images/product/detail/' . $image->ha_Ten) }}" width="100px" height="100px">
                                        </div>
                                    </a>
                                </li>
                                @php
                                    $tabIndex++;
                                @endphp
                            @endforeach

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-4" role="tab">
                                    <div class="product__thumb__pic set-bg" data-setbg="{{ asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}">
                                        <i class="fa fa-play"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__pic__item">
                                    <img src="{{ asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}" alt="" width="800px" height="550px">
                                </div>
                            </div>
                            @php
                                $tabIndex = 2;
                            @endphp
                            @foreach ($images as $index => $image)
                                <div class="tab-pane" id="tabs-{{ $tabIndex }}" role="tabpanel">
                                    <div class="product__details__pic__item">
                                        <img src="{{ asset('/storage/images/product/detail/' . $image->ha_Ten) }}" alt="" width="800px" height="550px">
                                    </div>
                                </div>
                                @php
                                    $tabIndex++;
                                @endphp
                            @endforeach
                            <div class="tab-pane" id="tabs-4" role="tabpanel">
                                <div class="product__details__pic__item">
                                    <img src="{{ asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}" width="800px" height="550px">
                                    <a href="{{ $product->sp_Video }}" class="video-popup"><i class="fa fa-play"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product__details__content">
            <div class="container">
                <form action="/add-cart" method="post">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="product__details__text">
                            <h4>{{ $product->sp_TenSanPham }}</h4>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                                <span> - 5 Reviews</span>
                            </div>
                            @php
                                $price_reduced = 0;
                                $price = $product->sp_Gia;
                                $price_reduced = $price + $price*10/100;
                            @endphp
                            <h3>{{ number_format($product->sp_Gia) }}<sup><ins>đ</ins></sup>
                                <span>{{ number_format($price_reduced, 0, '', '.') }}<sup><ins>đ</ins></sup></span>
                                <br>
                                <p>Tình trạng :
                                    @if($product->sp_SoLuongHang > 0)
                                        <b>Còn hàng </b>({{ $product->sp_SoLuongHang }} sản phẩm trong kho)
                                    @elseif($product->sp_SoLuongHang == 0)
                                        <b style="color: red">Hết hàng</b>
                                    @endif
                                </p>
                            </h3>
                            <div class="product__details__option">
                                <div class="product__details__option__size">
                                    <span>Size:</span>
                                    <label for="xxl">xxl
                                        <input type="radio" id="xxl">
                                    </label>
                                    <label class="active" for="xl">xl
                                        <input type="radio" id="xl">
                                    </label>
                                    <label for="l">l
                                        <input type="radio" id="l">
                                    </label>
                                    <label for="sm">s
                                        <input type="radio" id="sm">
                                    </label>
                                </div>
                                <div class="product__details__option__color">
                                    <span>Color:</span>
                                    <label class="c-1" for="sp-1">
                                        <input type="radio" id="sp-1">
                                    </label>
                                    <label class="c-2" for="sp-2">
                                        <input type="radio" id="sp-2">
                                    </label>
                                    <label class="c-3" for="sp-3">
                                        <input type="radio" id="sp-3">
                                    </label>
                                    <label class="c-4" for="sp-4">
                                        <input type="radio" id="sp-4">
                                    </label>
                                    <label class="c-9" for="sp-9">
                                        <input type="radio" id="sp-9">
                                    </label>
                                </div>
                            </div>
                            <div class="product__details__cart__option">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input name="num_product" type="text" value="1">
                                    </div>
                                </div>
                                {{--  <a href="#"  class="primary-btn">add to cart</a>  --}}
                                <button type="submit"  class="primary-btn">Thêm vào giỏ hàng </button>
                                <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                            </div>
                            <div class="product__details__btns__option">
                                <a href="{{ route('user.wish_lish_show',$product->id) }}" class="wishlist-link" data-product-id="{{ $product->id }}">
                                    <i class="fa fa-heart" style="color: blue;"></i>
                                    Yêu thích
                                </a>
                                <a href="#"><i class="fa fa-exchange"></i> So sánh</a>
                            </div>
                            <div class="product__details__last__option">
                                <h5><span>Đảm bảo thanh toán an toàn</span></h5>
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-5" role="tab">Mô tả</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-6" role="tab">Đánh giá(5)</a>
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
                                            {{--  <h5>Products Infomation</h5>
                                            <p>
                                                A Pocket PC is a handheld computer, which features many of the same
                                                capabilities as a modern PC. These handy little devices allow
                                                individuals to retrieve and store e-mail messages, create a contact
                                                file, coordinate appointments, surf the internet, exchange text messages
                                                and more. Every product that is labeled as a Pocket PC must be
                                                accompanied with specific software to operate the unit and must feature
                                            a touchscreen and touchpad.
                                            </p>
                                            <p>As is the case with any new technology product, the cost of a Pocket PC
                                                was substantial during it’s early release. For approximately $700.00,
                                                consumers could purchase one of top-of-the-line Pocket PCs in 2003.
                                                These days, customers are finding that prices have become much more
                                                reasonable now that the newness is wearing off. For approximately
                                            $350.00, a new Pocket PC can now be purchased.</p>  --}}
                                        </div>
                                        <div class="product__details__tab__content__item">
                                            {{--  <h5>Material used</h5>
                                            <p>Polyester is deemed lower quality due to its none natural quality’s. Made
                                                from synthetic materials, not natural like wool. Polyester suits become
                                                creased easily and are known for not being breathable. Polyester suits
                                                tend to have a shine to them compared to wool and cotton suits, this can
                                                make the suit look cheap. The texture of velvet is luxurious and
                                                breathable. Velvet is a great choice for dinner party jacket and can be
                                            worn all year round.</p>  --}}
                                        </div>
                                    </div>
                                </div>
                                {{--  <div class="tab-pane" id="tabs-7" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <p class="note">Nam tempus turpis at metus scelerisque placerat nulla deumantos
                                            solicitud felis. Pellentesque diam dolor, elementum etos lobortis des mollis
                                            ut risus. Sedcus faucibus an sullamcorper mattis drostique des commodo
                                        pharetras loremos.</p>
                                        <div class="product__details__tab__content__item">
                                            <h5>Products Infomation</h5>
                                            <p>A Pocket PC is a handheld computer, which features many of the same
                                                capabilities as a modern PC. These handy little devices allow
                                                individuals to retrieve and store e-mail messages, create a contact
                                                file, coordinate appointments, surf the internet, exchange text messages
                                                and more. Every product that is labeled as a Pocket PC must be
                                                accompanied with specific software to operate the unit and must feature
                                            a touchscreen and touchpad.</p>
                                            <p>As is the case with any new technology product, the cost of a Pocket PC
                                                was substantial during it’s early release. For approximately $700.00,
                                                consumers could purchase one of top-of-the-line Pocket PCs in 2003.
                                                These days, customers are finding that prices have become much more
                                                reasonable now that the newness is wearing off. For approximately
                                            $350.00, a new Pocket PC can now be purchased.</p>
                                        </div>
                                        <div class="product__details__tab__content__item">
                                            <h5>Material used</h5>
                                            <p>Polyester is deemed lower quality due to its none natural quality’s. Made
                                                from synthetic materials, not natural like wool. Polyester suits become
                                                creased easily and are known for not being breathable. Polyester suits
                                                tend to have a shine to them compared to wool and cotton suits, this can
                                                make the suit look cheap. The texture of velvet is luxurious and
                                                breathable. Velvet is a great choice for dinner party jacket and can be
                                            worn all year round.</p>
                                        </div>
                                    </div>
                                </div>  --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
                <div class="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                    <form action="/add-cart-shop" method="post">
                    @csrf
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
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <h5 class="text-center">{{ number_format($product_relate->sp_Gia) }}<sup><ins>đ</ins></sup></h5>
                            <input type="hidden" name="product_id" id="product_id" value="{{$product_relate->id}}">
                            <input type="hidden" name="num_product" value= "1">
                            <button type="submit" class="btn btn-info"  style="display: flex; justify-content: center; align-items: center; width: 140px; height: 30px; margin: 0 auto;">
                                + Thêm giỏ hàng
                            </button>
{{--                            <div class="product__color__select">--}}
{{--                                <label for="pc-1">--}}
{{--                                    <input type="radio" id="pc-1">--}}
{{--                                </label>--}}
{{--                                <label class="active black" for="pc-2">--}}
{{--                                    <input type="radio" id="pc-2">--}}
{{--                                </label>--}}
{{--                                <label class="grey" for="pc-3">--}}
{{--                                    <input type="radio" id="pc-3">--}}
{{--                                </label>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                    </form>
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
            } else {
                // Thêm sản phẩm vào danh sách yêu thích (đổi màu thành đỏ)
                heartIcon.style.color = 'red';
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
</body>

</html>
