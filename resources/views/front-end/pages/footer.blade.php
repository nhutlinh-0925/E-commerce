<!-- Footer Section Begin -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__logo">
                            <a href="#"><img src="/template/front-end/img/footer-logo.png" alt=""></a>
                        </div>
                        <p>The customer is at the heart of our unique business model, which includes design.</p>
                        <a href="#"><img src="/template/front-end/img/payment.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Shopping</h6>
                        <ul>
                            <li><a href="#">Clothing Store</a></li>
                            <li><a href="#">Trending Shoes</a></li>
                            <li><a href="#">Accessories</a></li>
                            <li><a href="#">Sale</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="footer__widget">
                        <h6>Shopping</h6>
                        <ul>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Payment Methods</a></li>
                            <li><a href="#">Delivary</a></li>
                            <li><a href="#">Return & Exchanges</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 offset-lg-1 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h6>NewLetter</h6>
                        <div class="footer__newslatter">
                            <p>Be the first to know about new arrivals, look books, sales & promos!</p>
                            <form action="#">
                                <input type="text" placeholder="Your email">
                                <button type="submit"><span class="icon_mail_alt"></span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="footer__copyright__text">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <p>Copyright ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>2020
                            All rights reserved | This template is made with <i class="fa fa-heart-o"
                            aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                        </p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search End -->

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

    {{--  <script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>  --}}
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>--}}
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(function () {
        @if (Auth::check())
        var userId = {{ $khachhang->id }};
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/purchase_order/" + userId,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'pdh_TrangThai', name: 'pdh_TrangThai', render: function(data, type, row) {
                        if (data == 1) {
                            return '<p>Chờ duyệt</p>';
                        } else if (data == 2) {
                            return '<p>Đã duyệt</p>';
                        } else if (data == 3) {
                            return '<p>Đang vận chuyê</p>';
                        } else if (data == 4) {
                            return '<p>Giao thành công</p>';
                        } else if (data == 5) {
                            return '<p>Hủy đơn</p>';
                        } else {
                            return '';
                        }
                    }},
                {data: 'pdh_TongTien', name: 'pdh_TongTien', render: function(data, type, row) {
                        var formattedAmount = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(data);
                        return formattedAmount;
                    }},
                {data: 'phuong_thuc_thanh_toan_id', name: 'phuong_thuc_thanh_toan_id', render: function(data, type, row) {
                        if (data == 1) {
                            return '<p>Nhận hàng trả tiền</p>';
                        } else if (data == 2) {
                            return '<p>Thanh toán qua PayPay</p>';
                        } else if (data == 3) {
                            return '<p>Thanh toán qua VNPay</p>';
                        } else if (data == 4) {
                            return '<p>Thanh toán qua OnePal</p>';
                        } else {
                            return '';
                        }
                    }},
                {data: 'created_at', name: 'created_at'},
                {data: null, name: 'actions', render: function(data, type, row) {
                        return '<a class="btn btn-info text-center" href="/purchase_order/order_detail/' + data.id + '"><i class="fa fa-eye"></i></a>';
                    }},
            ]
        });
        @endif
    });
</script>

<script type="text/javascript">
    $('#keywords').keyup(function (){
        var query = $(this).val();
        // alert(query);
        if(query != ''){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{url('/autocomplete-ajax')}}",
                method:"POST",
                data:{query:query, _token:_token},
                success:function (data) {
                    $('#search-ajax').fadeIn();
                    $('#search-ajax').html(data);
                }
            });
        }else{
            $('#search-ajax').fadeOut();
        }
    });
    $(document).on('click','li',function (){
        $('#keywords').val($(this).text());
        $('#search-ajax').fadeOut();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    @yield('footer')
