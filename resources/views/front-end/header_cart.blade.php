<!-- Cart -->
    <div class="wrap-header-cart js-panel-cart">
        <div class="s-full js-hide-cart"></div>
            <div class="header-cart">
                <div class="header-cart-title ">
                    @if (count($carts) > 0)
                    <h2>Giỏ hàng</h2>
                    @else
                    <h2>Giỏ hàng trống</h2>
                    @endif
                    <div class="js-hide-cart">
                    <i class="fa fa-close"></i>
                    </div>
                </div>
                @if (count($carts) > 0)
                <div class="header-cart-content">
                    @php $sumPriceCart = 0; @endphp
                    <ul class="header-cart-wrapitem">

                            @foreach ($carts as $key => $cart)
                                <li class="header-cart-item">
                                    <div class="header-cart-item-img">
                                        <img src="{{ asset('/storage/images/products/' . $cart->sp_AnhDaiDien) }}" alt="IMG">
                                    </div>

                                    <div class="header-cart-item-txt">
                                        <a href="/product/{{ $cart->id }}" class="header-cart-item-name" style="width: 100px">
                                            {{ $cart->sp_TenSanPham }}
                                            <p>Size: {{ $cart->kt_TenKichThuoc }}</p>
                                        </a>

                                        <span class="header-cart-item-info">
                                                {{ $gh[$key]['qty'] }} x {{ number_format($cart->sp_Gia) }}<sup><ins>đ</ins></sup>
                                        </span>
                                    </div>
                                </li>
                            @endforeach

                    </ul>

                    <div style="width: 100%">
                        <div class="header-cart-buttons">
                            <a href="/user/carts" class="primary-btn">Xem giỏ hàng <span class="arrow_right"></span></a>
                        </div>
                    </div>

                </div>
                @endif
            </div>
        </div>

