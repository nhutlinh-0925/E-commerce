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

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

{{--  Thống kê doanh thu trong 30 ngày  --}}
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
            labels: ['đơn hàng','doanh thu','lợi nhuận','số lượng sản phẩm']
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

                    // Reset totals
                    totalRevenue = 0;
                    totalProfit = 0;

                    // Loop through data and update chart
                    for (var i = 0; i < data.length; i++) {
                        totalRevenue += parseFloat(data[i].sales);
                        totalProfit += parseFloat(data[i].profit);
                    }

                    $("#total p:first-child").text("Tổng doanh thu: " + numberFormat(totalRevenue) + ' đ');
                    $("#total p:last-child").text("Tổng lợi nhuận: " + numberFormat(totalProfit) + ' đ');

                    // Hàm để định dạng số theo kiểu number_format
                    function numberFormat(number) {
                        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }

                }
            });
        };


        // select các ngày trong thống kê doanh thu
        $('.dashboard-filter').change(function () {
            var dashboard_value = $(this).val();
            var _token = $('input[name="_token"]').val();

            $('#doanhthu_loc').text(' | ' + dashboard_value);

            $.ajax({
                url: "{{url('/admin/dashboard-filter')}}",
                method: "POST",
                dataType: "JSON",
                data: { dashboard_value: dashboard_value, _token: _token },

                success: function (data) {
                    chart.setData(data);

                    // Reset totals
                    totalRevenue = 0;
                    totalProfit = 0;

                    // Loop through data and update chart
                    for (var i = 0; i < data.length; i++) {
                        totalRevenue += parseFloat(data[i].sales);
                        totalProfit += parseFloat(data[i].profit);
                    }

                    $("#total p:first-child").text("Tổng doanh thu: " + numberFormat(totalRevenue) + ' đ');
                    $("#total p:last-child").text("Tổng lợi nhuận: " + numberFormat(totalProfit) + ' đ');

                    // Hàm để định dạng số theo kiểu number_format
                    function numberFormat(number) {
                        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }


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
            $('#doanhthu_loc').text(' | ' + from_date + ' đến ' + to_date);

            $.ajax({
                url: "{{url('/admin/filter-by-date')}}",
                method: "POST",
                dataType: "JSON",
                data: { from_date: from_date, to_date: to_date, _token: _token },

                success: function (data) {
                    chart.setData(data);

                    // Reset totals
                    totalRevenue = 0;
                    totalProfit = 0;

                    // Loop through data and update chart
                    for (var i = 0; i < data.length; i++) {
                        totalRevenue += parseFloat(data[i].sales);
                        totalProfit += parseFloat(data[i].profit);
                    }

                    $("#total p:first-child").text("Tổng doanh thu: " + numberFormat(totalRevenue) + ' đ');
                    $("#total p:last-child").text("Tổng lợi nhuận: " + numberFormat(totalProfit) + ' đ');

                    // Hàm để định dạng số theo kiểu number_format
                    function numberFormat(number) {
                        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }
            });
        });

    });
</script>

{{--  Thống kê số lượng  --}}
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

{{--  Lựa chọn lịch của thống kê doanh thu  --}}
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

{{--   Thống kê doanh thu trong năm biểu đồ đường   --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Sử dụng Ajax để gửi yêu cầu đến route và nhận dữ liệu
        $.ajax({
            url : "{{ route('admin.getChartData') }}",
            method: 'GET',
            success: function (data) {
                // Cập nhật dữ liệu trong biểu đồ
                var lineChart = new Chart(document.querySelector('#lineChart'), {
                    type: 'line',
                    data: {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                        datasets: [{
                            label: 'Doanh thu',
                            data: data,
                            fill: false,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            },
        });
    });
</script>

{{--  Thống kê doanh thu trong năm biểu đồ ường khi select year  --}}

<script>
    document.addEventListener("DOMContentLoaded", () => {
        var lineChart = null;

        function updateChart(data) {
            // Loại bỏ các canvas hiện có
            var existingCanvases = document.querySelectorAll('.card-body canvas');
            existingCanvases.forEach(canvas => canvas.remove());

            // Tạo một canvas mới
            var newCanvas = document.createElement('canvas');
            newCanvas.id = 'lineChart'; // Sử dụng cùng một ID như trong việc tạo biểu đồ ban đầu
            newCanvas.style.maxHeight = '400px';
            document.querySelector('.lineChart').appendChild(newCanvas);

            // Cập nhật biểu đồ với dữ liệu mới
            lineChart = new Chart(newCanvas, {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: [{
                        label: 'Doanh thu',
                        data: data,
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Thêm lắng nghe sự kiện cho sự thay đổi của dropdown
        document.getElementById('yearFilter').addEventListener('change', function () {
            var selectedYear = this.value;

            if (selectedYear === '') {
                return;
            }

            document.getElementById('selectedYear').textContent = '| Năm ' + selectedYear;

            // Sử dụng Ajax để lấy dữ liệu cho năm đã chọn
            $.ajax({
                url: "{{ route('admin.getChartDataByYear') }}",
                method: 'GET',
                data: { year: selectedYear },
                success: function (data) {
                    // Cập nhật biểu đồ với dữ liệu mới
                    updateChart(data);
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        });

        // Kích hoạt sự kiện thay đổi khi trang được tải để hiển thị dữ liệu mặc định
        $('#yearFilter').change();
    });
</script>


{{--   Thống kê top sản phẩm bán chạy bằng table  --}}
<script>
    $(document).ready(function () {
        // Xử lý sự kiện khi người dùng chọn thời gian
        $('.selling').click(function (e) {
            e.preventDefault();
            var filter = $(this).parent().data('filter');
            //alert(filter);

            // Gửi yêu cầu AJAX để tải dữ liệu mới
            loadData(filter);

            // Cập nhật thông tin hiển thị thời gian
            $('#time-range').text('| ' + filter);
        });

        // Hàm để gửi yêu cầu AJAX và cập nhật dữ liệu trong bảng
        // Khi chọn các fifter
        function loadData(filter) {
            var url = "{{ route('admin.product_tops') }}";
            var data = {
                _token: "{{ csrf_token() }}",
                data_value: filter
            };

            $.ajax({
                url: url,
                method: "POST",
                data: data,
                success: function (response) {
                    var tbody = $('#product-top-table-body');
                    tbody.empty(); // Clear existing rows

                    // Iterate through the response data and append rows to the table
                    $.each(response.product_tops, function (index, item) {
                        var formatter = new Intl.NumberFormat('vi-VN');
                        var formattedPrice = formatter.format(parseFloat(item.sanpham.sp_Gia));

                        var row = '<tr>' +
                            '<td>' + item.san_pham_id + '</td>' +
                            '<td>' + item.sanpham.sp_TenSanPham + '</td>' +
                            '<td><a href="/admin/products/show/' + item.san_pham_id + '"><img src="{{ url('/storage/images/products/') }}/' + item.sanpham.sp_AnhDaiDien + '" height="50px" width="50px"></a></td>' +
                            '<td><p style="color: red;"><b>' + formattedPrice + ' đ</b></p></td>' +
                            '<td>' + item.totalQuantity + '</td>' +
                            '</tr>';
                        tbody.append(row);
                    });

                },


            });
        }

    });

</script>


{{--  Lựa chọn sản phẩm khi nhập kho  --}}
<script type="text/javascript">
    $('#productSelect').select2({
        templateResult: function(data) {
            if (!data.id) {
                return data.text;
            }
            var $template = $('<div class="product-option"></div>');
            $template.append(data.text);
            return $template;
        }
    });


    // Khi người dùng mở custom select box
    $('#productSelect').on('select2:opening', function (e) {
        $.ajax({
            url: "{{ url('/admin/warehouses/getProducts') }}",
            method: "GET",
            success:function (data) {
                // Xóa tất cả các tùy chọn hiện có trong Select2
                $('#productSelect').empty();

                // Thêm tùy chọn mới vào Select2
                $('#productSelect').append(data);

            }
        });
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

        var selectedProductPrice; // Khai báo biến để lưu giá sản phẩm đã chọn

        $('#productSelect').on('select2:select', function (e) {
            var selectedProduct = e.params.data;
            // Lấy giá sản phẩm
            selectedProductPrice = parseFloat(selectedProduct.element.getAttribute('data-price').replace(/[,\.]/g, ''));
            var productName = selectedProduct.text.split(' - ')[1].trim();
            var productImage = selectedProduct.element.getAttribute('data-image');

            var productSize = selectedProduct.element.getAttribute('data-size');
            var sizeOptions = '<option value="">Chọn kích thước</option>'; // Thêm một tùy chọn mặc định
            var availableSizes = productSize.split(', ');
            availableSizes.forEach(function (size) {
                sizeOptions += '<option value="' + size + '">' + size + '</option>';
            });

            // Kiểm tra xem sản phẩm đã có trong bảng chưa
            var $existingRow = $('#product-table tbody').find('[data-product-id="' + selectedProduct.id + '"]');
            var selectedSize = $('[name="product_size[' + selectedProduct.id + '][]"]').val();
            if ($existingRow.length > 0 && !selectedSize) {
                // Sản phẩm đã có trong bảng, tăng số lượng
                var $quantityInput = $existingRow.find('.quantity-input');
                var currentQuantity = parseInt($quantityInput.val());
                $quantityInput.val(currentQuantity + 1);
            } else {
                // Sản phẩm chưa có trong bảng, thêm dòng mới
                var newRow = '<tr data-product-id="' + selectedProduct.id + '">' +
                    '<td style="text-align: center;">#' + selectedProduct.id + '</td>' +
                    '<td style="text-align: center;width: 160px" >' + productName + '</td>' +
                    '<td style="text-align: center;">' +
                    '<a><img src="' + productImage + '" height="40px"></a>' +
                    '<td style="text-align: center;"><select name="product_size[' + selectedProduct.id + '][]" required>' + sizeOptions + '</select>' +
                    '</td>' +
                    '<td style="text-align: center;"><input type="text" autocomplete="off" required class="price-input" style="width: 80px" name="product_price[' + selectedProduct.id + '][]" value=""></td>' +
                    '<td style="text-align: center;"><input type="number" style="width: 40px" class="quantity-input" name="product_quantity[' + selectedProduct.id + '][]" value="1" min="1"></td>' +
                    '<td style="text-align: center;width: 180px" >' +
                    '<button type="button" class="btn btn-primary btn-update-product" data-product-id="' + selectedProduct.id + '">Cập nhật</button>' +
                    '<span style="margin: 0 5px;"></span>' + // Khoảng cách giữa nút
                    '<button class="btn btn-danger btn-remove-product" data-product-id="' + selectedProduct.id + '">Xóa</button>' +
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

        $(document).on('input', '.price-input', function() {
            // Lấy giá trị nhập liệu từ trường nhập liệu
            var inputValue = $(this).val();

            // Loại bỏ tất cả các dấu phẩy và dấu chấm
            var numericValue = inputValue.replace(/[,\.]/g, '');

            // Chuyển đổi giá trị thành số
            var numericPrice = parseFloat(numericValue);
            //alert(numericPrice);

            // Lấy số lượng của sản phẩm
            var $quantityInput = $(this).closest('tr').find('.quantity-input');
            var quantity = parseInt($quantityInput.val());

            // Kiểm tra xem số lượng và giá có hợp lệ hay không
            if (!isNaN(numericPrice) && numericPrice >= 0 && !isNaN(quantity) && quantity >= 1) {
                // Tính toán tổng tiền cho sản phẩm
                var totalProductPrice = numericPrice * quantity;

                // Cập nhật giá trị đã định dạng vào trường giá nhập
                $(this).val(new Intl.NumberFormat('vi-VN').format(numericPrice));

                // Cập nhật tổng tiền cho sản phẩm
                var $totalProductPrice = $(this).closest('tr').find('.total-product-price');
                $totalProductPrice.text(new Intl.NumberFormat('vi-VN').format(totalProductPrice));

                // Kiểm tra giá nhập
                if (numericPrice > selectedProductPrice) {
                    alert('Giá nhập phải nhỏ hơn giá bán.');
                }

                // Cập nhật tổng tiền toàn bộ
                updateTotal();
            } else if (numericPrice < 0) {
                alert('Giá sản phẩm phải lớn hơn 0.');
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
                alert('Đã cập nhật số lượng sản phẩm thành công');
            } else {
                alert('Số lượng không hợp lệ.');
            }

        });
    });

</script>


  @yield('footer')
