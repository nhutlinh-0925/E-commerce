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
                    <h4>Cửa hàng</h4>
                    <div class="breadcrumb__links">
                        <a href="/">Trang chủ</a>
                        <a href="/shop">Cửa hàng</a>
                        <span>Danh mục sản phẩm</span>
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
                                    <a data-toggle="collapse" data-target="#collapseThree">Khoảng giá</a>
                                </div>
                                <div id="collapseThree" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__price">
                                            <ul id="price">
                                                <li><a href="{{Request::url()}}?sort_by=1000">Dưới 1,000,000đ</a></li>
                                                <li><a href="{{Request::url()}}?sort_by=1000_2000">Từ 1,000,000đ - 2,000,000đ</a></li>
                                                <li><a href="{{Request::url()}}?sort_by=2000_3000">Từ 2,000,000đ - 3,000,000đ</a></li>
                                                <li><a href="{{Request::url()}}?sort_by=3000">Trên 3,000,000đ</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--  <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseFour">Size</a>
                                </div>
                                <div id="collapseFour" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__size">
                                            <label for="xs">xs
                                                <input type="radio" id="xs">
                                            </label>
                                            <label for="sm">s
                                                <input type="radio" id="sm">
                                            </label>
                                            <label for="md">m
                                                <input type="radio" id="md">
                                            </label>
                                            <label for="xl">xl
                                                <input type="radio" id="xl">
                                            </label>
                                            <label for="2xl">2xl
                                                <input type="radio" id="2xl">
                                            </label>
                                            <label for="xxl">xxl
                                                <input type="radio" id="xxl">
                                            </label>
                                            <label for="3xl">3xl
                                                <input type="radio" id="3xl">
                                            </label>
                                            <label for="4xl">4xl
                                                <input type="radio" id="4xl">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>  --}}
                            {{--  <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseFive">Colors</a>
                                </div>
                                <div id="collapseFive" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__color">
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
                                            <label class="c-5" for="sp-5">
                                                <input type="radio" id="sp-5">
                                            </label>
                                            <label class="c-6" for="sp-6">
                                                <input type="radio" id="sp-6">
                                            </label>
                                            <label class="c-7" for="sp-7">
                                                <input type="radio" id="sp-7">
                                            </label>
                                            <label class="c-8" for="sp-8">
                                                <input type="radio" id="sp-8">
                                            </label>
                                            <label class="c-9" for="sp-9">
                                                <input type="radio" id="sp-9">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>  --}}
                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseSix">Tags</a>
                                </div>
                                <div id="collapseSix" class="collapse show" data-parent="#accordionExample">
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
                            <h2 style="text-align: center">Danh mục sản phẩm</h2>
                            <div style="text-align: center;">
                                <p style="border-bottom: 3px solid blue; display: inline-block; padding-bottom: 5px;">
                                    Có <b>{{ count($sp) }} sản phẩm</b> cho danh mục
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="shop__product__option">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="shop__product__option__left">
                                <h5>Danh mục sản phẩm: <b>"{{ $cate_pro->dmsp_TenDanhMuc }}"</b></h5>
                            </div>
                        </div>
                        <div class="col-lg-3">
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach ($sp as $product)
                        @php
                            $avgRating = \App\Models\ĐanhGia::where('san_pham_id', $product->id)->avg('dg_SoSao');
                            $roundedAvgRating = ceil($avgRating);
                        @endphp
                    <div class="col-lg-4 col-md-6 col-sm-6">
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
                </div>

                <div class="d-flex justify-content-center">
                    {!! $sp->links() !!}
                </div>

            </div>
        </div>
    </div>
</section>
<!-- Shop Section End -->

@include('front-end.pages.footer')
<script type="text/javascript">
    $(document).ready(function (){
        $('#price').on('change',function (){
            var url = $(this).val();
            if(url){
                window.location = url;
            }
            return false;
        });
    });
</script>
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

</body>

</html>
