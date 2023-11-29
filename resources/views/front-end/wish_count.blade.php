<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- head -->
    @include('front-end.pages.head')
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
                    <h4>Sẩn phẩm yêu thích</h4>
                    <div class="breadcrumb__links">
                        <a href="/">Trang chủ</a>
                        <a href="/shop">Cửa hàng</a>
                        <span>Sản phẩm yêu thích</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shop Section Begin -->
<section class="shop spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="shop__sidebar">
                    {{--                    <div class="shop__sidebar__search">--}}
                    {{--                        <form action="#">--}}
                    {{--                            <input type="text" placeholder="Search...">--}}
                    {{--                            <button type="submit"><span class="icon_search"></span></button>--}}
                    {{--                        </form>--}}
                    {{--                    </div>--}}
                    <div class="shop__sidebar__accordion">
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseOne">DANH MỤC SẢN PHẨM</a>
                                </div>
                                <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__categories">
                                            <ul class="nice-scroll">
                                                @foreach ($category_product as $item)
                                                    <li><a href="/danhmuc-sanpham/{{ $item->id }}">{{ $item->dmsp_TenDanhMuc }} <span class="count-check">({{ $item->products->count() }})</span> </a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseTwo">THƯƠNG HIỆU SẢN PHẨM</a>
                                </div>
                                <div id="collapseTwo" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__brand">
                                            <ul>
                                                @foreach ($brand as $item)
                                                    <li><a href="/thuonghieu-sanpham/{{ $item->id }}">{{ $item->thsp_TenThuongHieu }} </a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseThree">Tags</a>
                                </div>
                                <div id="collapseThree" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__tags">
                                            @foreach($limitedArray as $item)
                                                @php
                                                    $slug = Str::slug($item);
                                                @endphp
                                                <a href="/tag/{{$slug}}">{{ $item }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">

                <div class="shop__product__option">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 style="text-align: center">Sản phẩm yêu thích</h2>
                            <div style="text-align: center;">
                                <p style="border-bottom: 3px solid blue; display: inline-block; padding-bottom: 5px;">
                                    Có <b>{{ count($yt) }} sản phẩm</b> cho danh sách yêu thích
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach ($yt as $product)
                        @php
                            $avgRating = \App\Models\ĐanhGia::where('san_pham_id', $product->sanpham->id)->avg('dg_SoSao');
                            $roundedAvgRating = ceil($avgRating);
                        @endphp
                        <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" >
                                        <a href="/product/{{ $product->sanpham->id }}">
                                            <img src="{{asset('/storage/images/products/'.$product->sanpham->sp_AnhDaiDien) }}"></a>
                                        <ul class="product__hover">
                                            <li><a href="{{ route('user.wish_lish_show',$product->sanpham->id) }}" class="wishlist-link" data-product-id="{{ $product->sanpham->id }}">
                                                    <i class="fa fa-heart" style="color: blue;"></i> <span>Yêu thích</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6 class="text-center">{{ $product->sanpham->sp_TenSanPham }}</h6>
                                        <a href="#" class="xemnhanh" data-toggle="modal" data-target="#xemnhanh" data-product_id="{{ $product->sanpham->id }}">Xem nhanh</a>
                                        <div class="text-center rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $roundedAvgRating)
                                                    <span class="fa fa-star " style="color: #ff9705;"></span>
                                                @else
                                                    <span class="fa fa-star " style="color: #ccc;"></span>
                                                @endif
                                            @endfor
                                        </div>
                                        <h5 class="text-center">{{ number_format($product->sanpham->sp_Gia) }}<sup><ins>đ</ins></sup></h5>
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

                <div class="d-flex justify-content-center">
                    {!! $yt->links() !!}
                </div>

            </div>
        </div>
    </div>
</section>
<!-- Shop Section End -->

@include('front-end.pages.footer')

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
            timer: 2000, // Thời gian hiển thị thông báo (tính theo milliseconds)
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
@elseif(session()->has('flash_message_login'))
    <style>
        .my-custom-icon {
            color: #ff0000; /* Màu đỏ */
            font-size: 5px; /* Kích thước nhỏ hơn (16px) */
        }
    </style>

    <script>
        Swal.fire({
            title: 'Rất tiết!!!', // Tiêu đề của thông báo
            html: 'Bạn cần <a href="/user/login">đăng nhập</a> để thêm sản phẩm vào giỏ hàng', // Nội dung của thông báo với đường liên kết
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

{{--    Mục yêu thích  --}}
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
            // Hiển thị thông báo đã xóa sản phẩm khỏi yêu thích
            alert('Sản phẩm đã được xóa khỏi danh sách yêu thích!');
        } else {
            // Thêm sản phẩm vào danh sách yêu thích (đổi màu thành đỏ)
            heartIcon.style.color = 'red';

            // Tăng giá trị data-notify lên 1
            const notifyElement = document.querySelector('.js-show-wish');
            const currentNotifyValue = parseInt(notifyElement.getAttribute('data-notify'));
            notifyElement.setAttribute('data-notify', currentNotifyValue + 1);
            // Hiển thị thông báo đã thêm sản phẩm vào yêu thích
            alert('Sản phẩm đã được thêm vào danh sách yêu thích!');
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
