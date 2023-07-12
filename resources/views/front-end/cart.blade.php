<!DOCTYPE html>
<html lang="zxx">

<head>
	<!-- head -->
	@include('front-end.pages.head')
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


    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shopping Cart</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.html">Home</a>
                            <a href="./shop.html">Shop</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

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
                                <tr >
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
                                            <img src="{{asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}" width="100px" height="100px">
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
                                    <td class="cart__price">{{ number_format($priceEnd, 0, '', '.') }}</td>
                                    <td class="cart__close">
                                        <a href="/carts/delete/{{ $product->id }}"><i class="fa fa-trash" style='color: red'></i></a>
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
                    <div class="cart__discount">
                        <h6>Discount codes</h6>
                        <form action="#">
                            <input type="text" placeholder="Coupon code">
                            <button type="submit">Apply</button>
                        </form>
                    </div>
                    <div class="cart__total">
                        <h6>Cart total</h6>
                        <ul>
                            <li>Tổng cộng <span>{{ number_format($total, 0, '', '.') }}VNĐ</span></li>
                            <li>Vận chuyển <span>Free</span></li>
                            <li>Mã giảm <span>0</span></li>
                            <li>Tổng tiền được giảm <span>0</span></li><hr style="Border: solid 1px black;">
                            <li>Tiền thanh toán<span>{{ number_format($total, 0, '', '.') }}VNĐ</span></li>
                        </ul>
                        <a href="/checkout" class="primary-btn">Thanh toán</a>
                    </div>
                </div>
            </div>
        </div>
        </form>
        @else
    <div class="text-center"><h2>Giỏ hàng trống</h2></div>
    @endif
    </section>
    <!-- Shopping Cart Section End -->

    @include('front-end.pages.footer')

</body>

</html>
