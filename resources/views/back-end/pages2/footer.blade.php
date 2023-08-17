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





  @yield('footer')
