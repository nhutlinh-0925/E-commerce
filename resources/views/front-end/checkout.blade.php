<!DOCTYPE html>
<html lang="zxx">

<head>
	<!-- head -->
	@include('front-end.pages.head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    @include('front-end.pages.header')
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
                        <li class="header-cart-item">
                            <div class="header-cart-item-img">
                                <img src="{{asset('/storage/images/products/'.$cart->sp_AnhDaiDien) }}" alt="IMG">
                            </div>

                            <div class="header-cart-item-txt">
                                <a href="#" class="header-cart-item-name">
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


{{--    @include('front-end.header_cart')--}}

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Check Out</h4>
                        <div class="breadcrumb__links">
                            <a href="/">Home</a>
                            <a href="/shop">Shop</a>
                            <span>Check Out</span>
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
        </div>

    @endif

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <form action="/carts/checkout" method="post">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <h3 style="color: red">Thanh toán đơn hàng của ở đây</h3>
                            <br>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p><b>Họ và tên</b><span>*</span></p>
                                        <input type="text" name="kh_Ten" style="color: black" placeholder="Nhập họ tên của bạn" value="{{ old('kh_Ten', $khachhang->kh_Ten ?? '') }}">
                                        @error ('kh_Ten')
                                        <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p><b>Email</b><span>*</span></p>
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" style="color: black" type="text" name="email"  value="{{Auth::user()->email}}" disabled>
                                        @error ('email')
                                        <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p><b>Số điện thoại</b><span>*</span></p>
                                        <input type="text" name="kh_SoDienThoai" style="color: black" placeholder="Nhập số điện thoại của bạn" value="{{ old('kh_SoDienThoai', $khachhang->kh_SoDienThoai ?? '') }}" required>
                                        @error ('kh_SoDienThoai')
                                        <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p><b>Ghi chú</b></p>
                                        <input type="text" name="pdh_GhiChu" style="color: black" placeholder="Nhập ghi chú thêm cho đơn hàng (nếu có)....">
                                    </div>
                                </div>

                            </div>
                            <div class="checkout__input">
                                <p><b>Địa chỉ giao hàng</b><span>*</span></p>
                                <input type="text">
                            </div>
                            <button  type="button" class="btn btn-primary">Thêm địa chỉ</button>
                            <br>
                            <a href="/carts">Xem lại giỏ hàng?</a>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                @php $total = 0; @endphp
                                @foreach ($products as $key => $product)
                                    @php
                                        $price = $product->sp_Gia;
                                        $priceEnd = $price * $carts[$product->id];
                                        $total += $priceEnd;
                                    @endphp
                                @endforeach
                                <h5 class="order__title">Tổng tiền</h5>

                                <div class="checkout__order__products">Tiền hàng: <span style="color: red"><b>{{ number_format($total, 0, '', '.') }} đ</b></span></div>
                                <div class="checkout__order__products">Phí vận chuyển: <span style="color: red"><b>Free</b></span></div>
                                @if($coupons)
                                    <div class="checkout__order__products">
                                        @foreach($coupons as $key => $cou)
                                            @if($cou['mgg_LoaiGiamGia'] == 2)
                                                <div class="checkout__order__products">Mã giảm: <span style="color: red"><b>{{ $cou['mgg_GiaTri'] }} %</b></span></div>
                                    @php
                                        $total_coupon = ($total * $cou['mgg_GiaTri'])/100;
                                    @endphp
                                    <div class="checkout__order__products">Tổng tiền được giảm <span style="color: red"><b>{{ number_format($total_coupon, 0, '', '.') }} đ</b></span></div><hr style="Border: solid 1px black;">
                                    <div class="checkout__order__products">Tiền thanh toán<span style="color: red"><b>{{ number_format($total - $total_coupon, 0, '', '.') }} đ</b></span></div>
                                @elseif($cou['mgg_LoaiGiamGia'] == 1)
                                                <div class="checkout__order__products">Mã giảm: <span style="color: red"><b>{{ number_format($cou['mgg_GiaTri'], 0, '', '.') }} đ</b></span></div>
                                    @php
                                        $total_coupon = $total - $cou['mgg_GiaTri'];
                                    @endphp
                                    <div class="checkout__order__products">Tổng tiền được giảm <span style="color: red"><b>{{ number_format($cou['mgg_GiaTri'], 0, '', '.') }} đ</b></span></div><hr style="Border: solid 1px black;">
                                    <div class="checkout__order__products">Tiền thanh toán<span style="color: red"><b>{{ number_format($total_coupon, 0, '', '.') }} đ</b></span></div>
                                @endif
                                @endforeach
                                @else
                                    <div class="checkout__order__products">Mã giảm : <span style="color: red"><b>0</b></span></div>
                                    <div class="checkout__order__products">Tổng tiền được giảm <span style="color: red"><b>0</b></span></div><hr style="Border: solid 1px black;">
                                    <div class="checkout__order__products">Tiền thanh toán<span style="color: red"><b>>{{ number_format($total, 0, '', '.') }} đ</b></span></div>
                                    @endif
                                    </div>
                                    <h5 class="order__title">PHƯƠNG THỨC THANH TOÁN</h5>
                                    <div class="form-group">
                                        <label for="pdh_PhuongThucThanhToan"><b>Phương thức thanh toán</b></label>
                                        <select name="pdh_PhuongThucThanhToan" required id="pdh_PhuongThucThanhToan" class="form-control">
                                            <option value="" selected>Chọn phương thức thanh toán</option>
                                            <option value="0">Thanh toán khi nhận hàng</option>
                                            <option value="1">Paypal</option>
                                            <option value="2">VNPay</option>
                                            <option value="3">OnePal</option>
                                        </select>
                                    </div><br><br><br>
                                    <a href="" ><img src="/template/front-end/img/payment.png" alt="" width="300px"></a>
                                    <br><br>
                                <button class="site-btn">Đặt hàng</button>
                            </div>
                        </div>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

    @include('front-end.pages.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
