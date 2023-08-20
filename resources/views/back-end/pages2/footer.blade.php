<!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="credits"></div>
  </footer>
<!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="/template/back-end2/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="/template/back-end2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/template/back-end2/vendor/chart.js/chart.umd.js"></script>
  <script src="/template/back-end2/vendor/echarts/echarts.min.js"></script>
  <script src="/template/back-end2/vendor/quill/quill.min.js"></script>
  <script src="/template/back-end2/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="/template/back-end2/vendor/tinymce/tinymce.min.js"></script>
  <script src="/template/back-end2/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="/template/back-end2/js/main.js"></script>

<!-- Include jQuery -->
<script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
{{--<script src="/template/front-end/js/jquery-3.3.1.min.js"></script>--}}
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


  {{--  <script rel="javascript" type="text/javascript" href="js/jquery-1.11.3.min.js"></script>  --}}
  {{--  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>  --}}
  {{--  <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>  --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
{{--<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>--}}

{{--<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>--}}
{{--<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>--}}

<!-- Include jQuery -->
{{--<script src="//code.jquery.com/jquery-3.6.0.min.js"></script>--}}

<!-- Include Morris.js -->
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


<script type="text/javascript">
    $(document).ready(function (){
        chart30daysorder();
        var chart = new Morris.Bar({
            element: 'chart',
            lineColor: ['#819C79', '#FC8710','#FF6541','#A4ADD3','#766B56'],
            parseTime: false,
            hideHover:"auto",
            xkey: 'period',
            ykeys: ['order','sales','profit','quantity'],
            labels: ['đơn hàng','doanh số','lợi nhuận','số lượng']
        });

        function chart30daysorder(){
            var _token = $('input[name="_token"]').val();
            //alert('hi');
            //alert(_token);
            $.ajax({
                url:"{{url('/admin/days-order')}}",
                method: "POST",
                dataType:"JSON",
                data:{_token:_token},

                success:function (data) {
                    //console.log(data);
                    chart.setData(data);
                }
            });
        };

        $('.dashboard-filter').change(function () {
            var dashboard_value = $(this).val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{url('/admin/dashboard-filter')}}",
                method: "POST",
                dataType: "JSON",
                data: { dashboard_value: dashboard_value, _token: _token },

                success: function (data) {
                    chart.setData(data);
                }
            });
        });

        $('#btn-dashboard-filter').click(function () {
            var _token = $('input[name="_token"]').val();
            // var from_date = $('#datepicker').val();
            // var to_date = $('#datepicker2').val();
            // Chuyển đổi ngày tháng từ MM/DD/YYYY sang YYYY-MM-DD
            var from_date = moment($('#datepicker').val(), 'MM/DD/YYYY').format('YYYY-MM-DD');
            var to_date = moment($('#datepicker2').val(), 'MM/DD/YYYY').format('YYYY-MM-DD');
            //alert(from_date);

            $.ajax({
                url: "{{url('/admin/filter-by-date')}}",
                method: "POST",
                dataType: "JSON",
                data: { from_date: from_date, to_date: to_date, _token: _token },

                success: function (data) {
                    chart.setData(data);
                }
            });
        });

    });
</script>

<script type="text/javascript">
    $(document).ready(function (){
        var donut = Morris.Donut({
            element: 'donut',
            resize: true,
            colors: [
                '#ce616a',
                '#61a1ce',
                '#ce8f61',
                '#f5b942',
                '#4842f5'
            ],

            data: [
                {label: "Sản phẩm", value: {{ $product_tk}} },
                {label: "Bài viết", value: {{ $post_tk}} },
                {label: "Đơn hàng", value: {{ $order_tk}} },
                {label: "Nhân viên", value: {{ $employess_tk}} },
                {label: "Khách hàng", value: {{ $customer_tk}} },
            ]
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $("#datepicker").datepicker({
            prevText: "Tháng trước",
            nextText: "Tháng sau",
            dataFormat: "yy-mm-dd",
            dayNamesMin: ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật"],
            duration: "slow"
        });
        $("#datepicker2").datepicker({
            prevText: "Tháng trước",
            nextText: "Tháng sau",
            dataFormat: "yy-mm-dd",
            dayNamesMin: ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật"],
            duration: "slow"
        });
    });
</script>

<script type="text/javascript">
    $('#keywords').keyup(function (){
        var query = $(this).val();
        //alert(query);
        if(query != ''){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{url('/admin/warehouses/autocomplete-ajax')}}",
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

    var inputField = $('#keywords');
    var clearButton = $('#clear-input'); // Nút xóa nội dung
    // Bắt sự kiện khi nút xóa nội dung được bấm
    clearButton.on('click', function () {
        inputField.val(''); // Xóa nội dung trường nhập liệu
    });


    $(document).ready(function() {
        // Biến để lưu trữ tổng số lượng và tổng tiền
        var totalQuantity = 0;
        var totalPrice = 0;

        // Hàm để cập nhật tổng số lượng và tổng tiền
        function updateTotals() {
            totalQuantity = 0;
            //totalPrice = 0;

            // Duyệt qua từng sản phẩm trong bảng và tính tổng
            $('#product-table tbody tr').each(function () {
                var quantity = parseInt($(this).find('.quantity-input').val());
                //alert(quantity);
                if (!isNaN(quantity) && quantity >= 1) {
                    totalQuantity += quantity;
                }
            });

            // Cập nhật giá trị vào bảng
            $('#total-quantity').text(totalQuantity);
            //$('#total-price').text(new Intl.NumberFormat('vi-VN').format(totalPrice));

            // Cập nhật giá trị của các trường ctpnh_SoLuongNhap và pnh_TongTien
            $('[name="ctpnh_SoLuongNhap"]').val(totalQuantity);
            $('[name="pnh_TongTien"]').val(totalPrice);
        }

        // Bắt sự kiện khi nút "Thêm" được bấm
        $(document).on('click', '.btn-add-product', function() {
            var productId = $(this).data('product-id');
            var productName = $(this).data('product-name');
            var productImage = $(this).data('product-image');
            var imageUrl = "{{ url('/storage/images/products/') }}" + '/' + productImage;

            // Kiểm tra xem sản phẩm đã có trong bảng chưa
            var $existingRow = $('#product-table tbody').find('[data-product-id="' + productId + '"]');

            if ($existingRow.length > 0) {
                // Sản phẩm đã có trong bảng, tăng số lượng
                var $quantityInput = $existingRow.find('.quantity-input');
                var currentQuantity = parseInt($quantityInput.val());
                $quantityInput.val(currentQuantity + 1);
            } else {
                // Sản phẩm chưa có trong bảng, thêm dòng mới
                var newRow = '<tr data-product-id="' + productId + '">' +
                    '<td style="text-align: center;">#' + productId + '</td>' +
                    '<td style="text-align: center;">' + productName + '</td>' +
                    '<td style="text-align: center;">' +
                    '<a><img src="' + imageUrl + '" height="40px"></a>' +
                    '</td>' +
                    '<td style="text-align: center;"><input type="text" autocomplete="off" required class="price-input" style="width: 80px" name="product_price[' + productId + ']" value=""></td>' +
                    '<td style="text-align: center;"><input type="number" style="width: 40px" class="quantity-input" name="product_quantity[' + productId + ']" value="1" min="1"></td>' +
                    '<td style="text-align: center;">' +
                    '<button type="button" class="btn btn-primary btn-update-product" data-product-id="' + productId + '">Cập nhật</button>' +
                    '<span style="margin: 0 5px;"></span>' + // Khoảng cách giữa nút
                    '<button class="btn btn-danger btn-remove-product" data-product-id="' + productId + '">Xóa</button>' +
                    '</td>' +
                    '</tr>';

                $('#product-table tbody').append(newRow);
            }

            // Cập nhật tổng số lượng và tổng tiền
            updateTotals();

        });

        // Hàm định dạng số thành tiền tệ Việt Nam (VND)
        function formatCurrency(number) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
        }


        // Bắt sự kiện khi người dùng thay đổi giá trị trường nhập liệu
        $(document).on('input', '.price-input', function() {
            // Lấy giá trị nhập liệu từ trường nhập liệu
            var inputValue = $(this).val();

            // Loại bỏ tất cả dấu phẩy và dấu chấm
            var numericValue = inputValue.replace(/[,\.]/g, '');

            // Chuyển đổi giá trị thành số
            var numericPrice = parseFloat(numericValue);

            // Kiểm tra xem số lượng có hợp lệ hay không
            if (!isNaN(numericPrice) && numericPrice >= 0) {
                // Lấy số lượng của sản phẩm
                var $quantityInput = $(this).closest('tr').find('.quantity-input');
                var quantity = parseInt($quantityInput.val());

                // Kiểm tra xem số lượng có hợp lệ hay không
                if (!isNaN(quantity) && quantity >= 1) {
                    // Tính toán tổng tiền cho sản phẩm
                    var totalProductPrice = numericPrice * quantity;

                    // Cập nhật giá trị đã định dạng vào trường giá nhập
                    $(this).val(new Intl.NumberFormat('vi-VN').format(numericPrice));

                    // Cập nhật tổng tiền cho sản phẩm
                    var $totalProductPrice = $(this).closest('tr').find('.total-product-price');
                    $totalProductPrice.text(new Intl.NumberFormat('vi-VN').format(totalProductPrice));
                    //alert(totalProductPrice);
                    //$('#total-price').text(formatCurrency(totalProductPrice));
                    updateTotal();
                    // Cập nhật tổng tiền toàn bộ
                    updateTotal();
                }
            }
        });

        // Hàm để cập nhật tổng tiền và tổng số lượng
        function updateTotal() {
            totalQuantity = 0;
            totalPrice = 0;

            // Duyệt qua từng sản phẩm trong bảng và tính tổng
            $('#product-table tbody tr').each(function () {
                var quantity = parseInt($(this).find('.quantity-input').val());
                var price = parseFloat($(this).find('.price-input').val().replace(/[,\.]/g, '').replace(/[^0-9\.]/g, ''));

                if (!isNaN(quantity) && quantity >= 1 && !isNaN(price) && price >= 0) {
                    totalQuantity += quantity;
                    totalPrice += price * quantity;
                }
            });

            // Cập nhật giá trị vào bảng
            $('#total-quantity').text(totalQuantity);
            $('#total-price').text(new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(totalPrice));
            // $('#total-price').text(new Intl.NumberFormat('vi-VN').format(totalPrice));

            // Cập nhật giá trị của các trường ctpnh_SoLuongNhap và pnh_TongTien
            $('[name="ctpnh_SoLuongNhap"]').val(totalQuantity);
            $('[name="pnh_TongTien"]').val(totalPrice);
        }

        // Bắt sự kiện khi nút "Xóa" trên bảng sản phẩm được bấm
        $(document).on('click', '.btn-remove-product', function() {
            var productId = $(this).data('product-id');
            // Xóa dòng sản phẩm khỏi bảng
            alert('Bạn có chắc chắn xóa sản phẩm');
            $('#product-table tbody').find('[data-product-id="' + productId + '"]').remove();

            updateTotal();
            // Cập nhật tổng tiền toàn bộ
            updateTotal();
        });

        // Bắt sự kiện khi nút "Cập nhật" trên bảng sản phẩm được bấm
        $(document).on('click', '.btn-update-product', function() {
            var productId = $(this).data('product-id');
            var productName = $(this).data('product-name');
            var $quantityInput = $('[data-product-id="' + productId + '"]').find('input[name^="product_quantity"]');
            // Lấy giá trị số lượng từ trường nhập liệu
            var newQuantity = parseInt($quantityInput.val());

            updateTotal();
            // Cập nhật tổng tiền toàn bộ
            updateTotal();

            // Kiểm tra giá trị số lượng mới và thực hiện các thao tác cập nhật dựa trên nó
            if (!isNaN(newQuantity) && newQuantity >= 1) {
                // Thực hiện các thao tác cập nhật ở đây
                // Ví dụ: có thể gửi dữ liệu cập nhật lên máy chủ thông qua AJAX
                alert('Đã cập nhật số lượng sản phẩm thành công');
            } else {
                alert('Số lượng không hợp lệ.');
            }


        });
    });

</script>


  @yield('footer')
