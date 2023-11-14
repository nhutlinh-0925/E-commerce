@extends('back-end.main2')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="/admin/home">Dashboard</a></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card info-card sales-card" style="background-color: #7ac5cd">

{{--                            <div class="filter">--}}
{{--                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>--}}
{{--                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">--}}
{{--                                    <li class="dropdown-header text-start">--}}
{{--                                        <h6>Filter</h6>--}}
{{--                                    </li>--}}

{{--                                    <li><a class="dropdown-item" href="#">Today</a></li>--}}
{{--                                    <li><a class="dropdown-item" href="#">This Month</a></li>--}}
{{--                                    <li><a class="dropdown-item" href="#">This Year</a></li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}

                            <div class="card-body">
                                <h5 class="card-title">Đơn hàng mới</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-bag-check"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $tongdonhang }}</h6>
                                        <span class="text-success small pt-1 fw-bold"><a href="/admin/orders" style="color: white">Xem chi tiết</a></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card info-card revenue-card" style="background-color: #458b00">

{{--                            <div class="filter">--}}
{{--                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>--}}
{{--                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">--}}
{{--                                    <li class="dropdown-header text-start">--}}
{{--                                        <h6>Filter</h6>--}}
{{--                                    </li>--}}

{{--                                    <li><a class="dropdown-item" href="#">Today</a></li>--}}
{{--                                    <li><a class="dropdown-item" href="#">This Month</a></li>--}}
{{--                                    <li><a class="dropdown-item" href="#">This Year</a></li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}

                            <div class="card-body">
                                <h5 class="card-title" style="font-size: 14px">Doanh thu trong tháng</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-bar-chart-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <p style="color: #012970;font-size: 14px"><b>{{ number_format($tongdoanhthu) }} đ</b></p>
                                        <span class="text-success small pt-1 fw-bold"><a href="/admin/orders" style="color: white">Xem chi tiết</a></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Revenue Card -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card info-card revenue-card" style="background-color: #ffb90f">

{{--                            <div class="filter">--}}
{{--                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>--}}
{{--                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">--}}
{{--                                    <li class="dropdown-header text-start">--}}
{{--                                        <h6>Filter</h6>--}}
{{--                                    </li>--}}

{{--                                    <li><a class="dropdown-item" href="#">Today</a></li>--}}
{{--                                    <li><a class="dropdown-item" href="#">This Month</a></li>--}}
{{--                                    <li><a class="dropdown-item" href="#">This Year</a></li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}

                            <div class="card-body">
                                <h5 class="card-title">Khách hàng</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-fill-add" style="color: #9e9d24;"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $customer_tk }}</h6>
                                        <span class="text-success small pt-1 fw-bold"><a href="/admin/customers" style="color: white">Xem chi tiết</a></span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Revenue Card -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card info-card revenue-card" style="background-color:#b22222">

{{--                            <div class="filter">--}}
{{--                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>--}}
{{--                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">--}}
{{--                                    <li class="dropdown-header text-start">--}}
{{--                                        <h6>Filter</h6>--}}
{{--                                    </li>--}}

{{--                                    <li><a class="dropdown-item" href="#">Today</a></li>--}}
{{--                                    <li><a class="dropdown-item" href="#">This Month</a></li>--}}
{{--                                    <li><a class="dropdown-item" href="#">This Year</a></li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}

                            <div class="card-body">
                                <h5 class="card-title">Nhân viên</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people-fill" style="color: red;"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $employess_tk }}</h6>
                                        <span class="text-success small pt-1 fw-bold"><a href="/admin/employees" style="color: white">Xem chi tiết</a></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                </div>
            </div><!-- End Left side columns -->

        </div>
    </section>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Thống kê doanh thu</h5>

                <div class="row">
                    <form autocomplete="off" style="display: flex;">
                        @csrf
                        <div class="col-2">
                            <p>Từ ngày: <input type="text" id="datepicker" style="width: 140px"> </p>
                        </div>

                        <div class="col-2">
                            <p>Đến ngày: <input type="text" id="datepicker2" style="width: 140px"> </p>
                        </div>

                        <div class="col-2 d-flex align-items-center justify-content-center">
                            <input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Lọc kết quả">
                        </div>

                        <div class="col-2 d-flex align-items-center justify-content-center">
                            <p>Lọc theo:
                                <select class="dashboard-filter">
                                    <option>--Chọn--</option>
                                    <option value="7ngay">7 ngày qua</option>
                                    <option value="thangtruoc">Tháng trước</option>
                                    <option value="thangnay">Tháng này
                                    <option value="quy1">Quý 1</option>
                                    <option value="quy2">Quý 2</option>
                                    <option value="quy3">Quý 3</option>
                                    <option value="quy4">Quý 4</option>
                                    {{--                        <option value="365ngayqua">365 ngày qua</option>--}}
                                </select>
                            </p>
                        </div>

                        <div class="col-4" id="total">
                            <p>Tổng doanh số: </p>
                            <p>Tổng lợi nhuận: </p>
                        </div>
                    </form>
                </div>

                <div class="col-12">
                    <div id="chart" style="height: 250px;"></div>
                </div>

            </div>
        </div>
    </div>

{{--<div class="row">--}}
{{--    <style type="text/css">--}}
{{--        table.table-bordered.table-dark {--}}
{{--            background: #32883e;--}}
{{--        }--}}

{{--        table.table-bordered.table-dark tr th {--}}
{{--            color: #fff;--}}
{{--        }--}}
{{--    </style>--}}

{{--    <p>Thống kê truy cập</p>--}}
{{--    <table class="table table-bordered table-dark">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th>Đang online</th>--}}
{{--            <th>Tổng tháng trước</th>--}}
{{--            <th>Tổng tháng này</th>--}}
{{--            <th>Tổng một năm</th>--}}
{{--            <th>Tổng truy cập</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        <tr>--}}
{{--            <td>1</td>--}}
{{--            <td>2</td>--}}
{{--            <td>3</td>--}}
{{--            <td>4</td>--}}
{{--            <td>5</td>--}}
{{--        </tr>--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--</div>--}}


    <div class="col-lg-12">
        <div class="card" style="background-color: #11cdef">
            <div class="card-body">
                <h5 class="card-title">Thống kê</h5>
                <div class="row" >
                    <div class="col-md-4 col-xs-12">
                        <h5 class="text-center" style="font-weight: bold;color: white">Thống kê số lượng</h5>
                        <div id="donut" class="morris-donut-inverse"></div>
                    </div>

                    <div class="col-md-4 col-xs-12">
                        <style type="text/css">
                            ol.list_views {
                                margin: 10px 0;
                                color: black;
                            }
                            ol.list_views a {
                                color: black;
                                font-weight: 400;
                            }
                        </style>
                        <h5 class="text-center" style="font-weight: bold;color: white">Sản phẩm xem nhiều</h5>
                        <ol class="list_views">
                            @foreach($product_views as $key => $pro)
                                <li>
                                    <a href="#"><b>{{ $pro->sp_TenSanPham }} </b></a>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <div class="col-md-4 col-xs-12">
                        <style type="text/css">
                            ol.list_views {
                                margin: 10px 0;
                                color: black;
                            }
                            ol.list_views a {
                                color: black;
                                font-weight: 400;
                            }
                        </style>
                        <h5 class="text-center" style="font-weight: bold;color: white">Bài viết xem nhiều</h5>
                        <ol class="list_views">
                            @foreach($post_views as $key => $pos)
                                <li>
                                    <a href="#"><b>{{ $pos->bv_TieuDeBaiViet }} </b></a>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <section class="section">
        <div class="row">

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Trạng thái đơn hàng</h5>

                        <!-- Pie Chart -->
                        <div id="pieChart"></div>

                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new ApexCharts(document.querySelector("#pieChart"), {
                                    series: [pdh_tt_1, pdh_tt_2, pdh_tt_3, pdh_tt_4, pdh_tt_5, pdh_tt_6],
                                    chart: {
                                        height: 350,
                                        type: 'pie',
                                        toolbar: {
                                            show: true
                                        }
                                    },
                                    labels: ['Chưa duyệt', 'Đã duyệt', 'Giao hàng', 'Thành công', 'Thất bại', 'Đã hủy']
                                }).render();
                            });
                        </script>
                        <!-- End Pie Chart -->

                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Phương thức thanh toán</h5><br>

                        <!-- Donut Chart -->
                        <div id="donutChart"></div>

                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new ApexCharts(document.querySelector("#donutChart"), {
                                    series: [pdh_pttt_1, pdh_pttt_2, pdh_pttt_3],
                                    chart: {
                                        height: 350,
                                        type: 'donut',
                                        toolbar: {
                                            show: true
                                        }
                                    },
                                    labels: ['Nhận hàng trả tiền', 'Thanh toán qua PayPal', 'Thanh toán qua VNPay'],
                                }).render();
                            });
                        </script>
                        <!-- End Donut Chart -->
                        <br><br>

                    </div>
                </div>
            </div>

        </div>
    </section>



@endsection

<script>
    var pdh_tt_1 = <?php echo $pdh_tt_1; ?>;
    var pdh_tt_2 = <?php echo $pdh_tt_2; ?>;
    var pdh_tt_3 = <?php echo $pdh_tt_3; ?>;
    var pdh_tt_4 = <?php echo $pdh_tt_4; ?>;
    var pdh_tt_5 = <?php echo $pdh_tt_5; ?>;
    var pdh_tt_6 = <?php echo $pdh_tt_6; ?>;

    var pdh_pttt_1 = <?php echo $pdh_pttt_1; ?>;
    var pdh_pttt_2 = <?php echo $pdh_pttt_2; ?>;
    var pdh_pttt_3 = <?php echo $pdh_pttt_3; ?>;
</script>
