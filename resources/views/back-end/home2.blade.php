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

    <div class="row">
        <div class="col-3">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
{{--                    @foreach($dem2 as $item)--}}
{{--                        <h3>{{$item->dem}}</h3>--}}
{{--                    @endforeach--}}


                    <p>Đơn hàng mới</p>
                </div>
                <div class="icon">
                    <i class="fas fa-briefcase-medical"></i>
                </div>
                <a href="/admin/patients" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-3">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
{{--                    @foreach($dem1 as $item)--}}
{{--                        <h3>{{$item->dem}}</h3>--}}
{{--                    @endforeach--}}


                    <p>Doanh thu trong tháng</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-nurse"></i>
                </div>
                <a href="" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-3">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
{{--                    @foreach($dem3 as $item)--}}
{{--                        <h3>{{$item->dem}}</h3>--}}
{{--                    @endforeach--}}


                    <p>Khách hàng</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-nurse"></i>
                </div>
                <a href="/admin/all-patients" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-3">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    {{--                    @foreach($dem3 as $item)--}}
                    {{--                        <h3>{{$item->dem}}</h3>--}}
                    {{--                    @endforeach--}}


                    <p>Lượt truy cập</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-nurse"></i>
                </div>
                <a href="/admin/all-patients" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <br>
    <div class="row">
        <form autocomplete="off" style="display: flex;">
        @csrf
            <div class="col-3">
                <p>Từ ngày: <input type="text" id="datepicker" style="width: 150px"> </p>

            </div>

            <div class="col-3">
                <p>Đến ngày: <input type="text" id="datepicker2" style="width: 140px"> </p>
            </div>

            <div class="col-3">
                <input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Lọc kết quả">
            </div>

            <div class="col-3">
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
        </form>
{{--        </div>--}}

    </div>

    <div class="col-12">
        <div id="chart" style="height: 250px;"></div>
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

<div class="row" style="background-color: #11cdef">
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





{{--    </div>--}}
{{--    </div>--}}
@endsection
