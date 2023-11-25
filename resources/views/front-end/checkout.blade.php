<!DOCTYPE html>
<html lang="zxx">

<head>
	<!-- head -->
	@include('front-end.pages.head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
{{--    <script src="https://www.paypal.com/sdk/js?client-id=AWFAg8kchI1mIZgePx33BVQu3_iLcR1LxI84fIqTsR3lFPtECaybaXLkzVALnuvmUN_tvCVJv17gP73b"></script>--}}


</head>

<body>
    @include('front-end.pages.header')
<!-- Cart -->
    <div class="wrap-header-cart js-panel-cart">
        <div class="s-full js-hide-cart"></div>
        <div class="header-cart">
            <div class="header-cart-title ">
                @if (count($products) > 0)
                    <h2>Giỏ hàng</h2>
                @else
                    <h2>Giỏ hàng trống</h2>
                @endif
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
                                    <img src="{{ asset('/storage/images/products/' . $cart->sp_AnhDaiDien) }}" alt="IMG">
                                </div>

                                <div class="header-cart-item-txt">
                                    <a href="/product/{{ $cart->id }}" class="header-cart-item-name" style="width: 100px">
                                        {{ $cart->sp_TenSanPham }}
                                        <p>Size: {{ $cart->kt_TenKichThuoc }}</p>
                                    </a>

                                    <span class="header-cart-item-info">
                                        @if (isset($gh[$key]) && isset($gh[$key]['qty']))
                                            {{ $gh[$key]['qty'] }} x {{ number_format($cart->sp_Gia) }}<sup><ins>đ</ins></sup>
                                        @endif
                                        </span>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>

                <div style="width: 100%">
                    <div class="header-cart-buttons">
                        <a href="/user/carts" class="primary-btn">Xem giỏ hàng <span class="arrow_right"></span></a>
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
                        <h4>Thanh toán</h4>
                        <div class="breadcrumb__links">
                            <a href="/">Trang chủ</a>
                            <a href="/shop">Cửa hàng</a>
                            <a href="/user/carts">Giỏ hàng</a>
                            <span>Thanh toán</span>
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
                <form action="/user/carts/checkout" method="post">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <h3 style="color: red">Thanh toán đơn hàng của ở đây</h3>
                            <br>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p><b>Họ và tên</b><span>*</span></p>
                                        <input type="text" name="kh_Ten" style="color: black" placeholder="Nhập họ tên của bạn" value="{{ $khachhang->kh_Ten }}" disabled>
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
                                        <input type="text" name="kh_SoDienThoai" style="color: black" placeholder="Nhập số điện thoại của bạn" value="{{ old('kh_SoDienThoai', $khachhang->kh_SoDienThoai ?? '') }}" >
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
                                <select class="form-control choo" name="dc_DiaChi" id="" required>
                                    <option disabled selected>--- Chọn Địa chỉ ---</option>
                                    @foreach ($address as $ad)
                                        <option value="{{ $ad->id }}">
                                            {{ $ad->dc_DiaChi }}
                                        </option>
                                    @endforeach
                                </select>
                                @error ('dc_DiaChi')
                                <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <br><br>
                            <a href="/user/setting/{{Auth::user()->id}}" class="btn btn-primary">Thêm địa chỉ</a>
                            <br>
                            <a href="/user/carts">Xem lại giỏ hàng?</a>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                @php $total = 0; @endphp
                                @foreach ($products as $product)
                                    @php
                                        $price = $product->sp_Gia;
                                        $quantity = $product->qty;
                                        $priceEnd = $price * $quantity;
                                        $total += $priceEnd;
                                    @endphp
                                @endforeach
                                <h5 class="order__title">Tổng tiền</h5>

                                <div class="checkout__order__products">Tiền hàng: <span style="color: red"><b>{{ number_format($total, 0, '', '.') }} đ</b></span></div>
                                <div class="checkout__order__products">
                                    Phí vận chuyển: <span class="total_free" style="color: red;font-weight: bold;">{{ number_format(25000, 0, '', '.') }} đ</span>
                                </div>

                                @if($coupons)
                                    <div class="checkout__order__products">
                                        @foreach($coupons as $key => $cou)
                                            @if($cou['mgg_LoaiGiamGia'] == 2)
                                                <div class="checkout__order__products">Mã giảm: <span style="color: red"><b>{{ $cou['mgg_GiaTri'] }} %</b></span></div>
                                                @php
                                                    $total_coupon1 = ($total * $cou['mgg_GiaTri'])/100;//160k
                                                    $total_coupon2 = $cou['mgg_GiamToiDa'];//100
                                                    if($total_coupon1 > $total_coupon2)
                                                        $total_coupon = $total_coupon2;
                                                    elseif($total_coupon1 < $total_coupon2)
                                                        $total_coupon = $total_coupon1;
                                                    elseif($total_coupon1 == $total_coupon2)
                                                        $total_coupon = $total_coupon2;
                                                @endphp
                                                <div class="checkout__order__products">Mã giảm được <span style="color: red"><b>{{ number_format($total_coupon, 0, '', '.') }} đ</b></span></div>
                                                <div class="checkout__order__products">Tổng tiền được giảm <span class="total_coupon" style="color: red;font-weight: bold;">{{ number_format($total_coupon, 0, '', '.') }} đ</span></div><hr style="Border: solid 1px black;">
                                                <div class="checkout__order__products">Tiền thanh toán<span class="total_payment" style="color: red;font-weight: bold;">{{ number_format($total - $total_coupon + 25000, 0, '', '.') }} đ</span></div>
                                                @php
                                                    $vnd_to_usd = ($total - (($total * $cou['mgg_GiaTri'])/100) + 25000)/23990 ;
                                                    $total_paypal = round($vnd_to_usd,2);
                                                    Session::put('total_paypal',$total_paypal);
                                                @endphp
                                            @elseif($cou['mgg_LoaiGiamGia'] == 1)
                                                <div class="checkout__order__products">Mã giảm: <span style="color: red"><b>{{ number_format($cou['mgg_GiaTri'], 0, '', '.') }} đ</b></span></div>
                                                @php
                                                    $total_coupon = $total - $cou['mgg_GiaTri'];
                                                @endphp
                                                <div class="checkout__order__products">Tổng tiền được giảm <span class="total_coupon" style="color: red;font-weight: bold;">{{ number_format($cou['mgg_GiaTri'] , 0, '', '.') }} đ</span></div><hr style="Border: solid 1px black;">
                                                <div class="checkout__order__products">Tiền thanh toán<span class="total_payment" style="color: red;font-weight: bold;">{{ number_format($total_coupon + 25000, 0, '', '.') }} đ</span></div>
                                                @php
                                                    $vnd_to_usd = ((($total * $cou['mgg_GiaTri'])/100) + 25000)/23990 ;
                                                    $total_paypal = round($vnd_to_usd,2);
                                                    Session::put('total_paypal',$total_paypal);
                                                @endphp
                                            @endif
                                        @endforeach
                                @else
                                    <div class="checkout__order__products">Mã giảm : <span style="color: red"><b>0</b></span></div>
                                    <div class="checkout__order__products">Tổng tiền được giảm <span style="color: red"><b>0</b></span></div><hr style="Border: solid 1px black;">
                                    <div class="checkout__order__products">Tiền thanh toán<span class="total_payment" style="color: red;font-weight: bold;">{{ number_format($total+25000, 0, '', '.') }} đ</span></div>
                                    @php
                                        $vnd_to_usd = ($total + 25000)/23990 ;
                                        $total_paypal = round($vnd_to_usd,2);
                                        Session::put('total_paypal',$total_paypal);
                                    @endphp
                                @endif
                                    </div>

                                    <h5 class="order__title">PHƯƠNG THỨC THANH TOÁN</h5>
                                    <div class="form-group">
                                        <label for="phuong_thuc_thanh_toan_id"><b>Phương thức thanh toán</b></label>
                                        <input type="hidden" id="vnd_to_usd" value="{{round($vnd_to_usd,2) }}">
                                        <input type="hidden" name="total_vnpay" id="total_vnpay">
                                        <select name="phuong_thuc_thanh_toan_id" id="phuong_thuc_thanh_toan_id" class="form-control" >
                                            <option value="" selected>Chọn phương thức thanh toán</option>
                                            @foreach ($payments as $payment)
                                                <option value="{{ $payment->id }}" data-payment-method="{{ $payment->pttt_TenPhuongThucThanhToan }}">{{ $payment->pttt_MoTa }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    @error ('phuong_thuc_thanh_toan_id')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                    <br><br><br>
                                    <a href="" ><img src="/template/front-end/img/payment.png" alt="" width="300px"></a>
                                    <br><br>
                                <button class="site-btn" type="submit">Xử lý đặt hàng</button>
                            </div>
                        </div>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

{{--    @include('front-end.pages.footer')--}}
    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__widget">
                            <h6>BALO VIET</h6>
                        </div>
                        <p>Balo Việt không ngừng đổi mới để mang đến cho khách hàng thời trang độc đáo và mới lạ.</p>
                        <a href="#"><img src="/template/front-end/img/payment.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Mua sắm</h6>
                        <ul>
                            <li><a href="#">Cửa hàng</a></li>
                            <li><a href="#">Thịnh hành</a></li>
                            <li><a href="#">Phụ kiện</a></li>
                            <li><a href="#">Khuyến mãi</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Về chúng tôi</h6>
                        <ul>
                            <li><a href="#">Liên lạc </a></li>
                            <li><a href="#">Thanh toán</a></li>
                            <li><a href="#">Vận chuyển</a></li>
                            <li><a href="#">Hoàn trả</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h6>Tin tức</h6>
                        <div class="footer__newslatter">
                            <p>Hãy là người đầu tiên biết về hàng mới, tin tức và khuyến mại!</p>
                            <form action="#">
                                <input type="text" placeholder="Email của bạn">
                                <button type="button"><span class="icon_mail_alt"></span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="footer__copyright__text">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <p>Bản quyền ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                        </p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="/template/front-end/js/jquery-3.3.1.min.js"></script>
    <script src="/template/front-end/js/bootstrap.min.js"></script>
    <script src="/template/front-end/js/jquery.nice-select.min.js"></script>
    <script src="/template/front-end/js/jquery.nicescroll.min.js"></script>
    <script src="/template/front-end/js/jquery.magnific-popup.min.js"></script>
    <script src="/template/front-end/js/jquery.countdown.min.js"></script>
    <script src="/template/front-end/js/jquery.slicknav.js"></script>
    <script src="/template/front-end/js/mixitup.min.js"></script>
    <script src="/template/front-end/js/owl.carousel.min.js"></script>
    <script src="/template/front-end/js/main.js"></script>
    {{--  <script src="/template/front-end/js/main2.js"></script>  --}}

{{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>--}}
{{--    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>--}}
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
{{--    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>--}}

{{--    Chọn địa chỉ ra phí ship   --}}
    <script type="text/javascript">
        $(document).ready(function () {
            $("select[name='dc_DiaChi']").on('change', function () {
                // alert('ok');
                var selectedAddressId = $(this).val();
                var _token = $('input[name="_token"]').val();
                // alert(selectedAddressId);
                // alert(_token);

                // Gửi yêu cầu AJAX đến máy chủ để lấy thông tin vận chuyển
                $.ajax({
                    url : '{{ url('/user/get_ship')}}', // Đường dẫn xử lý yêu cầu AJAX
                    method: 'POST',
                    data: {
                        address_id: selectedAddressId, // Gửi id của địa chỉ được chọn
                        _token:_token
                    },
                    success: function (response) {
                        // Thay thế nội dung của thẻ span có class là 'phivanchuyen' bằng thông tin vận chuyển
                        var formattedAmount = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(response.pvc_PhiVanChuyen);
                        $(".total_free").html(formattedAmount);

                        // Tính total_coupon sau khi nhận được formattedAmount từ AJAX
                        var total = {{ $total }}; // Lấy giá trị $total từ code PHP

                        // Tính tổng tiền được giảm từ mã giảm giá và phí vận chuyển
                        var total_coupon = 0;

                        @if($coupons)
                            @foreach($coupons as $key => $cou)
                                @if($cou['mgg_LoaiGiamGia'] == 2)
                                    var total_coupon1 = (total * {{ $cou['mgg_GiaTri'] }}) / 100;
                                    var total_coupon2 = {{ $cou['mgg_GiamToiDa'] }};

                                    if (total_coupon1 > total_coupon2) {
                                        total_coupon = total_coupon2;
                                    } else if (total_coupon1 < total_coupon2) {
                                        total_coupon = total_coupon1;
                                    } else if (total_coupon1 === total_coupon2) {
                                        total_coupon = total_coupon2;
                                    }
                                @elseif($cou['mgg_LoaiGiamGia'] == 1)
                                    total_coupon += {{ $cou['mgg_GiaTri'] }};
                                @endif
                            @endforeach
                        @else
                            total_coupon = 0;
                        @endif


                        // Tính total_payment sau khi đã có giá trị formattedAmount và total_coupon
                        var total_payment = total + response.pvc_PhiVanChuyen - total_coupon;

                        // Hiển thị total_coupon và total_payment sau khi tính toán
                        var formattedTotalCoupon = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total_coupon);
                        var formattedTotalPayment = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total_payment);

                        $(".total_coupon").html(formattedTotalCoupon);
                        $(".total_payment").html(formattedTotalPayment);

                        $("#total_vnpay").val(total_payment);
                    },
                    error: function () {
                        // Xử lý lỗi (nếu có)
                    }
                });
            });
        });
    </script>

{{--    Chat FB   --}}

    <!-- Messenger Plugin chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin chat code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "177913452061491");
        chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml            : true,
                version          : 'v18.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>
