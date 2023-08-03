<!DOCTYPE html>
<html lang="zxx">

<head>
	<!-- head -->
	@include('front-end.pages.head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    @include('front-end.pages.header')

     {{--  @include('front-end.header_cart')  --}}

     <!-- Cart -->
    <div class="wrap-header-cart js-panel-cart">
        <div class="s-full js-hide-cart"></div>
            <div class="header-cart">
                <div class="header-cart-title ">
                    <h2>Giỏ hàng</h2>
                    <div class="js-hide-cart">
                    <i class="fa fa-close"></i>
                    </div>
                </div>

                <div class="header-cart-content">
                    @php $sumPriceCart = 0; @endphp
                    <ul class="header-cart-wrapitem">
                        @if (count($products) > 0)
                            @foreach ($products as $key => $cart)

                            {{--  @php
                                $sumPriceCart += $product->price_sale != 0 ? $product->price;
                            @endphp  --}}
                        <li class="header-cart-item">
                            <div class="header-cart-item-img">
                                <img src="{{asset('/storage/images/products/'.$cart->sp_AnhDaiDien) }}" alt="IMG">
                            </div>

                            <div class="header-cart-item-txt">
                                <a href="/product/{{ $cart->id }}" class="header-cart-item-name" style="width: 80px">
                                    {{ $cart->sp_TenSanPham }}
                                </a>

                                <span class="header-cart-item-info">
                                    {{ $carts[$cart->id] }} x {{ number_format($cart->sp_Gia) }}<sup><ins>đ</ins></sup>
                                </span>
                            </div>
                        </li>

                        @endforeach
                @endif
                    </ul>

                    <div style="width: 100%">
                        <div class="header-cart-buttons">
                            <a href="/carts" class="primary-btn">Xem giỏ hàng <span class="arrow_right"></span></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Giỏ hàng</h4>
                        <div class="breadcrumb__links">
                            <a href="/">Trang chủ</a>
                            <a href="/shop">Cửa hàng</a>
                            <span>Giỏ hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    @if(Session::has('flash_message'))
        <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show text-center" role="alert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            {!! session('flash_message') !!}
        </div>

    @elseif(Session::has('flash_message_error'))
        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show text-center" role="alert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            {!! session('flash_message_error') !!}
            @if(Session::has('flash_message_error_link'))
                <a href="/user/login">Đăng nhập tại đây</a>
            @endif
        </div>
    @elseif(Session::has('flash_message_error_err'))
        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show text-center" role="alert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            {!! session('flash_message_error_err') !!}
        </div>

    @endif

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <form class=" p-t-130 p-85" method="post">
            {{--  @include('admin.alert')  --}}
            @if (count ($products) != 0)
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="shopping__cart__table">
                        @php $total = 0; @endphp
                        <table>
                            <thead>
                                <tr>
                                    <th class="text-center">Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $key => $product)
                                    @php
                                        $price = $product->sp_Gia;
                                        $priceEnd = $price * $carts[$product->id];
                                        $total += $priceEnd;
                                    @endphp

                                <tr>
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__pic">
                                            <a href="/product/{{ $product->id }}">
                                                <img src="{{asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}" width="100px" height="100px"></a>
                                        </div>
                                        <div class="product__cart__item__text">
                                            <h6>{{ $product->sp_TenSanPham }}</h6>
                                            <h5>{{ number_format($price, 0, '', '.') }} đ</h5>
                                        </div>
                                    </td>
                                    <td class="quantity__item">
                                        <div class="quantity">
                                            <div class="pro-qty-2">
                                                <input type="number" name="num_product[{{ $product->id }}]" value="{{ $carts[$product->id] }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cart__price">{{ number_format($priceEnd, 0, '', '.') }} đ</td>
                                    <td class="cart__close">
                                        <a href="/carts/delete/{{ $product->id }}" onclick ='return confirm("Bạn chắc chắn muốn xóa sản phẩm khỏi giỏ hàng?")'><i class="fa fa-trash" style='color: red'></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn">
                                <a href="/shop">Tiếp tục mua sắm</a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn update__btn">
                                <button type="submit" class="btn btn-dark btn-lg" formaction="/update-cart"><i class="fa fa-spinner"></i> Cập nhật giỏ hàng</button>
                                {{--  <a href="#"><i class="fa fa-spinner"></i>Cập nhật giỏ hàng</a>  --}}
                                @csrf
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart__total">
                        <h4 class="order__title">Tổng tiền</h4>
                        <ul>
                            <li>Tổng cộng : <span>{{ number_format($total, 0, '', '.') }} đ</span></li>
                            <li>Vận chuyển : <span>{{ number_format(25000, 0, '', '.') }} đ</span></li>
                            @if($coupons)
                            <li>
                                @foreach($coupons as $key => $cou)
                                    @if($cou['mgg_LoaiGiamGia'] == 2)
                                        Mã giảm: <span>{{ $cou['mgg_GiaTri'] }} %</span>
                                        @php
                                            $total_coupon = ($total * $cou['mgg_GiaTri'])/100;
                                        @endphp
                                        <li>Tổng tiền được giảm <span>{{ number_format($total_coupon, 0, '', '.') }} đ</span></li><hr style="Border: solid 1px black;">
                                        <li>Tiền thanh toán<span>{{ number_format($total - $total_coupon + 25000, 0, '', '.') }} đ</span></li>
                                    @elseif($cou['mgg_LoaiGiamGia'] == 1)
                                        Mã giảm: <span>{{ number_format($cou['mgg_GiaTri'], 0, '', '.') }} đ</span>
                                        @php
                                            $total_coupon = $total - $cou['mgg_GiaTri'];
                                        @endphp
                                        <li>Tổng tiền được giảm <span>{{ number_format($cou['mgg_GiaTri'], 0, '', '.') }} đ</span></li><hr style="Border: solid 1px black;">
                                        <li>Tiền thanh toán<span>{{ number_format($total_coupon + 25000, 0, '', '.') }} đ</span></li>
                                   @endif
                                @endforeach
                            @else
                                <li>Mã giảm : <span>0</span></li>
                                <li>Tổng tiền được giảm <span>0</span></li><hr style="Border: solid 1px black;">
                                <li>Tiền thanh toán<span>{{ number_format($total + 25000, 0, '', '.') }} đ</span></li>
                                @endif
                            </li>
                        </ul>
                        <a href="/checkout"  class="primary-btn">Thanh toán</a>
                    </div>
                </div>
            </div>

        </div>
        </form><br>

        <div class="col-lg-8">
            <div class="container">
            <div class="cart__discount container">
                <h6>Mã giảm giá</h6>
                @php
                    $cou = $cou ?? ['mgg_MaGiamGia' => ''];
                @endphp
                <form action="check_coupon" method="POST">
                    @csrf
                    <input type="text" name="coupon" style="color: black" placeholder="Nhập mã giảm giá" value="{{ old($cou['mgg_MaGiamGia'], $cou['mgg_MaGiamGia']) }}">
                    <button type="submit">Áp dụng</button>
                </form>
                @if($coupons)
                    <a href="/delete_coupon">Xóa mã giảm giá</a>
                @endif
            </div>
            </div>
        </div>

        @else
    <div class="text-center"><h2>Giỏ hàng trống</h2></div>
    @endif
    </section>
    <!-- Shopping Cart Section End -->

    @include('front-end.pages.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>
