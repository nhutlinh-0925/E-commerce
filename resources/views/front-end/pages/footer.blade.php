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

{{--Data-table danh sách các đơn hàng --}}
<script type="text/javascript">
    $(function () {
        @if (Auth::check())
        var userId = {{ Auth('web')->user()->id }};
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/user/purchase_order/" + userId,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'pdh_DiaChiGiao', name: 'pdh_DiaChiGiao'},
                {data: 'pdh_TrangThai', name: 'pdh_TrangThai', render: function(data, type, row) {
                        if (data == 1) {
                            return '<p class="btn btn-info" style="width: 160px">Chờ duyệt <i class="fa fa-clock-o"></i></p>';
                        } else if (data == 2) {
                            return '<p class="btn btn-primary" style="width: 160px">Đã duyệt <i class="fa fa-check-circle-o"></i></p>';
                        } else if (data == 3) {
                            return '<p class="btn btn-warning" style="width: 160px">Đang vận chuyển <i class="fa fa-bus"></i></p>';
                        } else if (data == 4) {
                            return '<p class="btn btn-success" style="width: 160px">Giao thành công <i class="fa fa-calendar-check-o"></i></p>';
                        } else if (data == 5) {
                            return '<p class="btn btn-danger" style="width: 160px">Hủy đơn <i class="fa fa-times-circle"></i></p>';
                        } else if (data == 6) {
                            return '<p class="btn btn-danger" style="width: 160px">Giao thất bại <i class="fa fa-times-circle"></i></p>';
                        } else {
                            return '';
                        }
                    }},
                {data: 'pdh_TongTien', name: 'pdh_TongTien', render: function(data, type, row) {
                        var formattedAmount = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(data);
                        return '<span style="color: red; font-weight: bold;">' + formattedAmount + '</span>';
                    }},
                {data: 'phuong_thuc_thanh_toan_id', name: 'phuong_thuc_thanh_toan_id', render: function(data, type, row) {
                        if (data == 1) {
                            return '<p style="color:green;"><b>Nhận hàng trả tiền</b></p>';
                        } else if (data == 2) {
                            return '<p style="color:green;"><b>Thanh toán PayPal</b></p>';
                        } else if (data == 3) {
                            return '<p style="color:green;"><b>Thanh toán VNPay</b></p>';
                        } else if (data == 4) {
                            return '<p style="color:green;"><b>Thanh toán Momo</b></p>';
                        } else {
                            return '';
                        }
                    }},
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            // Chuyển đổi dữ liệu ngày tháng thành đối tượng Date
                            var date = new Date(data);

                            // Lấy thông tin về giờ, phút, giây, ngày, tháng, năm
                            var hours = date.getHours();
                            var minutes = date.getMinutes();
                            var seconds = date.getSeconds();
                            var day = date.getDate();
                            var month = date.getMonth() + 1; // Tháng bắt đầu từ 0, cần cộng thêm 1
                            var year = date.getFullYear();

                            // Định dạng thành chuỗi 'H:i:s d/m/Y'
                            var formattedDate = day + '-' + month + '-' + year + ',' + ' '+ hours + ':' + minutes + ':' + seconds + ' ' ;
                            return formattedDate;
                        } else {
                            return data;
                        }
                    }
                },

                {
                    data: 'updated_at',
                    name: 'updated_at',
                    render: function(data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            // Chuyển đổi dữ liệu ngày tháng thành đối tượng Date
                            var date = new Date(data);

                            // Lấy thông tin về giờ, phút, giây, ngày, tháng, năm
                            var hours = date.getHours();
                            var minutes = date.getMinutes();
                            var seconds = date.getSeconds();
                            var day = date.getDate();
                            var month = date.getMonth() + 1; // Tháng bắt đầu từ 0, cần cộng thêm 1
                            var year = date.getFullYear();

                            // Định dạng thành chuỗi 'H:i:s d/m/Y'
                            var formattedDate = day + '-' + month + '-' + year + ',' + ' '+ hours + ':' + minutes + ':' + seconds + ' ' ;
                            return formattedDate;
                        } else {
                            return data;
                        }
                    }
                },

                {data: null, name: 'actions', render: function(data, type, row) {
                        return '<a class="btn btn-primary" text-center" style="font-size: 10px" href="/user/purchase_order/order_detail/' + data.id + '"><i class="fa fa-eye"></i></a>';
                    }},
            ],
            order: [[0, 'desc']]
        });
        @endif
    });
</script>

{{-- Sản phẩm gợi ý --}}
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

{{-- Tìm kiếm sản phẩm bằng giọng nói --}}
<script type="text/javascript">
    var message = document.querySelector('#message');

    var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
    var SpeechGrammarList = SpeechGrammarList || webkitSpeechGrammarList;

    var grammar = '#JSGF V1.0;'

    var recognition = new SpeechRecognition();
    var speechRecognitionList = new SpeechGrammarList();
    speechRecognitionList.addFromString(grammar, 1);
    recognition.grammars = speechRecognitionList;
    recognition.lang = 'vi-VN';
    recognition.interimResult = false;

    recognition.continuous = true;

    recognition.onresult = function(event) {
        var lastResult = event.results.length - 1;
        var content = event.results[lastResult][0].transcript
        // console.log(content);
        document.getElementById('search-input').value = content;
        document.getElementById('search-form').submit();
    }

    recognition.onspeeched = function() {
        recognition.stop();
    }

    recognition.onerror = function() {
        console.log(event.error);
        const microphone = document.querySelector('.microphone');
        microphone.classList.remove('recording')
    }

    document.querySelector('.microphone').addEventListener('click', function() {
        recognition.start();
        const microphone = document.querySelector('.microphone');
        microphone.classList.add('recording');
    })
</script>

{{-- Đánh giá sao cho sản phẩm --}}
<script type="text/javascript">
    // Xử lý khi hover chuột vào ngôi sao
    $(document).on('mouseenter', '.rating', function () {
        var index = $(this).data("index");
        var product_id = $(this).data('product_id');

        // Loại bỏ màu nền của tất cả các sao
        remove_background(product_id);

        // Đặt màu nền cho các sao được hover
        for (var count = 1; count <= index; count++) {
            $('#' + product_id + '-' + count).css('color', '#ffcc00');
        }

        // Cập nhật giá trị dg_SoSao
        $('#dg_SoSao').val(index);
    });

    // Xử lý khi rời chuột khỏi ngôi sao
    $(document).on('mouseleave', '.rating', function () {
        var product_id = $(this).data('product_id');

        // Đặt màu nền dựa trên giá trị dg_SoSao
        for (var count = 1; count <= $('#dg_SoSao').val(); count++) {
            $('#' + product_id + '-' + count).css('color', '#ffcc00');
        }
    });

    // Xử lý khi click vào ngôi sao
    $(document).on('click', '.rating', function () {
        var index = $(this).data("index");
        var product_id = $(this).data('product_id');

        // Đặt màu nền cho các sao được click
        for (var count = 1; count <= index; count++) {
            $('#' + product_id + '-' + count).css('color', '#ffcc00');
        }

        // Loại bỏ màu nền của các sao không được click
        for (var count = index + 1; count <= 5; count++) {
            $('#' + product_id + '-' + count).css('color', '#ccc');
        }


    });

    // Hàm loại bỏ màu nền của tất cả các sao
    function remove_background(product_id) {
        for (var count = 1; count <= 5; count++) {
            $('#' + product_id + '-' + count).css('color', '#ccc');
        }
    }

</script>

{{-- Đánh giá sao cho đơn hàng --}}
<script type="text/javascript">
    // Xử lý khi hover chuột vào ngôi sao
    $(document).on('mouseenter', '.rating_feedback', function () {
        var index = $(this).data("index");
        var order_id = $(this).data('order_id');

        // Loại bỏ màu nền của tất cả các sao
        remove_background(order_id);

        // Đặt màu nền cho các sao được hover
        for (var count = 1; count <= index; count++) {
            $('#' + order_id + '-' + count).css('color', '#ffcc00');
        }

        // Cập nhật giá trị ph_SoSao
        $('#ph_SoSao').val(index);
    });

    // Xử lý khi rời chuột khỏi ngôi sao
    $(document).on('mouseleave', '.rating_feedback', function () {
        var order_id = $(this).data('order_id');

        // Đặt màu nền dựa trên giá trị ph_SoSao
        for (var count = 1; count <= $('#ph_SoSao').val(); count++) {
            $('#' + order_id + '-' + count).css('color', '#ffcc00');
        }
    });

    // Xử lý khi click vào ngôi sao
    $(document).on('click', '.rating_feedback', function () {
        var index = $(this).data("index");
        var order_id = $(this).data('order_id');

        // Đặt màu nền cho các sao được click
        for (var count = 1; count <= index; count++) {
            $('#' + order_id + '-' + count).css('color', '#ffcc00');
        }

        // Loại bỏ màu nền của các sao không được click
        for (var count = index + 1; count <= 5; count++) {
            $('#' + order_id + '-' + count).css('color', '#ccc');
        }


    });

    // Hàm loại bỏ màu nền của tất cả các sao
    function remove_background(order_id) {
        for (var count = 1; count <= 5; count++) {
            $('#' + order_id + '-' + count).css('color', '#ccc');
        }
    }

</script>

{{-- Modal xem nhanh --}}
<script type="text/javascript">
    $('.xemnhanh').click(function (){
        var product_id = $(this).data('product_id');
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{ url('/quick_view') }}",
            method: "POST",
            dataType: "JSON",
            data: {product_id:product_id, _token: _token},
            success:function (data) {
                $('#product_quickview_name').html(data.product_name);
                $('#product_quickview_price').html(data.product_price);
                $('#product_quickview_image').html(data.product_image);

                $('#product_quickview_category').html('<span>Danh mục:</span> ' + data.product_category);
                $('#product_quickview_brand').html('<span>Thương hiệu:</span> ' + data.product_brand);

                // Hiển thị đánh giá sao
                var ratingStarsHtml = '';
                for (var i = 1; i <= 5; i++) {
                    if (i <= data.product_rating_round) {
                        ratingStarsHtml += '<span class="fa fa-star" style="color: #ff9705;"></span>';
                    } else {
                        ratingStarsHtml += '<span class="fa fa-star" style="color: #ccc;"></span>';
                    }
                }
                $('#product_quickview_rating').html(ratingStarsHtml + ' - ' + data.product_review_count + ' Đánh giá');

                //Hiển thị thông tin tình trạng hàng
                if (data.product_total_size > 0) {
                    $('#product_quickview_stock').html('Tình trạng: Còn hàng <b id="total-quantity2">' + data.product_total_size + '</b> trong kho');
                } else {
                    $('#product_quickview_stock').html('Tình trạng: <b style="color: red">Hết hàng</b>');
                }

                // Hiển thị thông tin tình trạng hàng
                if (data.product_total_size > 0) {
                    // Hiển thị tùy chọn kích thước
                    var sizes = data.product_sizes;
                    var sizeOptionsHtml = '<span><b>Chọn Size:</b></span><div>';

                    sizes.forEach(function(size, index) {
                        sizeOptionsHtml += '<input type="radio" class="size-input2" name="product_size" data-quantity2="' + size.spkt_soLuongHang + '" value="' + size.kich_thuoc_id + '" required>';
                        sizeOptionsHtml += '<label>Size ' + data.product_size_names[index] + '</label><br>';
                    });

                    sizeOptionsHtml += '</div><div class="product__details__cart__option">';
                    sizeOptionsHtml += '<input name="num_product" type="number" min="1" value="1" required style="width: 40px">';
                    sizeOptionsHtml += '<button type="submit" class="primary-btn-detail">Thêm vào giỏ hàng </button>';
                    sizeOptionsHtml += '<input type="hidden" name="product_id" id="product_id" value="' + data.product_id + '">';
                    sizeOptionsHtml += '</div>';

                    $('#product_quickview_options').html(sizeOptionsHtml);

                    var sizeInputs = document.querySelectorAll('.size-input2');
                    var totalQuantityDisplay = document.getElementById('total-quantity2');

                    sizeInputs.forEach(function (input) {
                        input.addEventListener('change', function () {
                            var quantity = this.getAttribute('data-quantity2');
                            totalQuantityDisplay.textContent = quantity;
                        });
                    });

                } else {
                    $('#product_quickview_options').html('');
                }

            }
        });
    });

</script>

{{--  Sản phẩm vừa xem  --}}
<script>
    function pro_viewed(){
        if(localStorage.getItem('viewed') != null){
            var data = JSON.parse(localStorage.getItem('viewed'));
            //alert(data);

            data.reverse();

            document.getElementById('row_viewed').style.overflow = 'scroll';
            document.getElementById('row_viewed').style.height = '300px';

            for (i=0;i<data.length;i++){

                var name = data[i].name;
                var price = data[i].price;
                var image = data[i].image;

                $('#row_viewed').append('<div class="row" style="margin: 10px 0">' +
                    '<div class="col-md-5"><img width="125px" height="95px" src="' + image + '"></div>' +
                    '<div class="col-md-7">' +
                    '<p style="font-size: 15px">' + name + '<br>' + ' <span style="color: red; font-weight: bold;">' + price + '</span></p>' +
                    '</div>' +
                    '</div>');

            }
        }
    }

    pro_viewed();

    product_viewed();

    $('.product__item').on('click', function() {
        var id_product = $(this).data('product-id');
        product_viewed(id_product);
    });

    function product_viewed(id_product) {
        //alert(id_product);

        if(id_product != undefined){
            var id = id_product;
            var name = document.getElementById('viewed_product_name'+id).value;
            var price = document.getElementById('viewed_product_price'+id).value;
            var image = document.getElementById('viewed_product_image'+id).value;

            var newItem = {
                'id':id,
                'name':name,
                'price':price,
                'image':image
            }

            if(localStorage.getItem('viewed')==null){
                localStorage.setItem('viewed', '[]');
            }

            var old_data = JSON.parse(localStorage.getItem('viewed'));

            var matches = $.grep(old_data, function (obj){
                return obj.id == id;
            })

            if(matches.length){

            }else{
                old_data.push(newItem);

                $('#row_viewed').append('<div class="row" style="margin: 10px 0">' +
                    '<div class="col-md-5"><img width="125px" height="95px" src="' + newItem.image + '"></div>' +
                    '<div class="col-md-7">' +
                    '<p style="font-size: 12px">' + newItem.name + '<br>' + ' <span style="color: red; font-weight: bold;">' + newItem.price + '</span></p>' +
                    '</div>' +
                    '</div>');

            }

            localStorage.setItem('viewed', JSON.stringify(old_data));
        }

    }
</script>

{{--  Tin tức vừa xem  --}}
<script>
    function po_viewed(){
        if(localStorage.getItem('viewed_po') != null){
            var data = JSON.parse(localStorage.getItem('viewed_po'));
            //alert(data);

            data.reverse();

            document.getElementById('row_post_viewed').style.overflow = 'scroll';
            document.getElementById('row_post_viewed').style.height = '300px';

            for (i=0;i<data.length;i++){

                var title = data[i].title;
                var date = data[i].date;
                var image = data[i].image;

                $('#row_post_viewed').append('<div class="row" style="margin: 10px 0">' +
                    '<div class="col-md-5"><img width="125px" height="95px" src="' + image + '"></div>' +
                    '<div class="col-md-7">' +
                    '<p style="font-size: 15px">' + title + '<br>' + ' <span style="color: black; font-weight: bold;">' + date + '</span></p>' +
                    '</div>' +
                    '</div>');

            }
        }
    }

    po_viewed();

    post_viewed();

    $('.blog__item').on('click', function() {
        var id_post = $(this).data('post-id');
        post_viewed(id_post);
    });

    function post_viewed(id_post) {
        //alert(id_post);

        if(id_post != undefined){
            var id = id_post;
            var title = document.getElementById('viewed_post_title'+id).value;
            var date = document.getElementById('viewed_post_date'+id).value;
            var image = document.getElementById('viewed_post_image'+id).value;

            var newItem = {
                'id':id,
                'title':title,
                'date':date,
                'image':image
            }

            if(localStorage.getItem('viewed_po')==null){
                localStorage.setItem('viewed_po', '[]');
            }

            var old_data = JSON.parse(localStorage.getItem('viewed_po'));

            var matches = $.grep(old_data, function (obj){
                return obj.id == id;
            })

            if(matches.length){

            }else{
                old_data.push(newItem);

                $('#row_post_viewed').append('<div class="row" style="margin: 10px 0">' +
                    '<div class="col-md-5"><img width="125px" height="95px" src="' + newItem.image + '"></div>' +
                    '<div class="col-md-7">' +
                    '<p style="font-size: 12px">' + newItem.title + '<br>' + ' <span style="color: black; font-weight: bold;">' + newItem.date + '</span></p>' +
                    '</div>' +
                    '</div>');

            }

            localStorage.setItem('viewed_po', JSON.stringify(old_data));
        }

    }
</script>

<!-- Chat FB -->
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

@yield('footer')
