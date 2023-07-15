<!DOCTYPE html>
<html lang="zxx">

<head>
	<!-- head -->
	@include('front-end.pages.head')
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
{{--            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>--}}
            {!! session('flash_message') !!}
        </div>

    @elseif(Session::has('flash_message_error'))
        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show text-center" role="alert">
            {{--            <button type="button" data-bs-dismiss="alert" aria-label="Close"><i class="fa fa-times"></i></button>--}}
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
{{--                            <h6 class="coupon__code"><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click--}}
{{--                            here</a> to enter your code</h6>--}}
                            <h3 style="color: red">Thanh toán đơn hàng của ở đây</h3>
{{--                            <h6>Vui lòng đăng nhập để thanh toán nhanh hơn</h6>--}}
                            <br>
{{--                            <h6 class="checkout__title">Billing Details</h6>--}}
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p><b>Họ và tên</b><span>*</span></p>
                                        <input type="text" name="kh_Ten" style="color: black" placeholder="Nhập họ tên của bạn" value="{{ $khachhang->kh_Ten }}">
                                        @error ('kh_Ten')
                                        <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p><b>Email</b><span>*</span></p>
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" style="color: black" type="text" name="email" placeholder="Nhập email của bạn" value="{{Auth::user()->email}}">
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
                                        <input type="text" name="kh_SoDienThoai" style="color: black" placeholder="Nhập số điện thoại của bạn" value="{{ $khachhang->kh_SoDienThoai }}" >
                                        @error ('kh_SoDienThoai')
                                        <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p><b>Ghi chú</b><span>*</span></p>
                                        <input type="text" name="pdh_GhiChu" style="color: black" placeholder="Nhập ghi chú thêm cho đơn hàng (nếu có)....">
                                    </div>
                                </div>
                            </div>
{{--                            <div class="checkout__input__checkbox">--}}
{{--                                <label for="acc">--}}
{{--                                    Create an account?--}}
{{--                                    <input type="checkbox" id="acc">--}}
{{--                                    <span class="checkmark"></span>--}}
{{--                                </label>--}}
{{--                                <p>Create an account by entering the information below. If you are a returning customer--}}
{{--                                please login at the top of the page</p>--}}
{{--                            </div>--}}
                            <div class="checkout__input">
                                <p><b>Địa chỉ giao hàng</b><span>*</span></p>
                                <input type="text">
                            </div>
                            <button  type="button" class="btn btn-primary">Thêm địa chỉ</button>
                            <br>
                            <a href="/carts">Xem lại giỏ hàng?</a>
{{--                            <div class="checkout__input__checkbox">--}}
{{--                                <label for="diff-acc">--}}
{{--                                    Note about your order, e.g, special noe for delivery--}}
{{--                                    <input type="checkbox" id="diff-acc">--}}
{{--                                    <span class="checkmark"></span>--}}
{{--                                </label>--}}
{{--                            </div>--}}
{{--                            <div class="checkout__input">--}}
{{--                                <p>Order notes<span>*</span></p>--}}
{{--                                <input type="text"--}}
{{--                                placeholder="Notes about your order, e.g. special notes for delivery.">--}}
{{--                            </div>--}}
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
                                <div class="checkout__order__products">Tiền hàng: <span>{{ number_format($total, 0, '', '.') }}VNĐ</span></div>
                                <div class="checkout__order__products">Phí vận chuyển: <span>Total</span></div>
                                <div class="checkout__order__products">Mã giảm: <span>Total</span></div>
                                <div class="checkout__order__products">Tổng tiền được giảm: <span>Total</span></div><hr style="Border: solid 1px black;">
                                <div class="checkout__order__products">Tiền thanh toán: <span>Total</span></div>
{{--                                <ul class="checkout__total__products">--}}
{{--                                    <li>01. Vanilla salted caramel <span>$ 300.0</span></li>--}}
{{--                                    <li>02. German chocolate <span>$ 170.0</span></li>--}}
{{--                                    <li>03. Sweet autumn <span>$ 170.0</span></li>--}}
{{--                                    <li>04. Cluten free mini dozen <span>$ 110.0</span></li>--}}
{{--                                </ul>--}}
                                <h5 class="order__title">PHƯƠNG THỨC THANH TOÁN</h5>
{{--                                <ul class="checkout__total__all">--}}
{{--                                    <li>Subtotal <span>$750.99</span></li>--}}
{{--                                    <li>Total <span>$750.99</span></li>--}}
{{--                                </ul>--}}
{{--                                <div class="checkout__input__checkbox">--}}
{{--                                    <label for="acc-or">--}}
{{--                                        Create an account?--}}
{{--                                        <input type="checkbox" id="acc-or">--}}
{{--                                        <span class="checkmark"></span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}



{{--                                <div class="checkout__input__checkbox">--}}
{{--                                    <label for="payment">--}}
{{--                                        Thanh toán khi nhận hàng--}}
{{--                                        <input type="checkbox" id="payment">--}}
{{--                                        <span class="checkmark"></span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                                <div class="checkout__input__checkbox">--}}
{{--                                    <label for="paypal">--}}
{{--                                        Paypal--}}
{{--                                        <input type="checkbox" id="paypal">--}}
{{--                                        <span class="checkmark"></span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                                <div class="checkout__input__checkbox">--}}
{{--                                    <label for="paypal">--}}
{{--                                        VNPay--}}
{{--                                        <input type="checkbox" id="paypal">--}}
{{--                                        <span class="checkmark"></span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                                <div class="checkout__input__checkbox">--}}
{{--                                    <label for="paypal">--}}
{{--                                        OnePal--}}
{{--                                        <input type="checkbox" id="paypal">--}}
{{--                                        <span class="checkmark"></span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}

                                <div class="form-group">
{{--                                    <label for="gender" class="col-md-6 control-label">Giới tính<span class="text-danger">(*)</span></label>--}}
                                    <div class="col-md-10">
                                        <input type="radio" name="pdh_PhuongThucThanhToan" value="0">
                                        <label>Thanh toán khi nhận hàng</label>
                                        <input type="radio" name="pdh_PhuongThucThanhToan" value="1">
                                        <label>Paypal</label><br>
                                        <input type="radio" name="pdh_PhuongThucThanhToan" value="2">
                                        <label>VNPay</label><br>
                                        <input type="radio" name="pdh_PhuongThucThanhToan" value="3">
                                        <label>OnePal</label><br>
{{--                                        @error ('gender')--}}
{{--                                        <span style="color: red;">{{ $message }}</span>--}}
{{--                                        @enderror--}}
                                    </div>
                                    <br>
                                <a href=""><img src="/template/front-end/img/payment.png" alt="" width="300px"></a>
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

</body>

</html>
