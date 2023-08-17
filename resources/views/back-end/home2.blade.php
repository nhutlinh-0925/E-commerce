@extends('back-end.main2')

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
                <a href="/admin/patients" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                <a href="/admin/all-patients" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                <a href="/admin/all-patients" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                <p>Lọc theo:
                    <select class="dashboard-filter">
                        <option>--Chọn--</option>
                        <option value="7ngay">7 ngày qua</option>
                        <option value="thangtruoc">Tháng trước</option>
                        <option value="thangnay">Tháng này</option>
{{--                        <option value="365ngayqua">365 ngày qua</option>--}}
                    </select>
                </p>
            </div>

            <div class="col-3">
                <input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Lọc kết quả">
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

<div class="row">
    <div class="col-md-4 col-xs-12">
        <h5 class="text-center" style="font-weight: bold">Thống kê số lượng</h5>
        <div id="donut" class="morris-donut-inverse"></div>
    </div>

    <div class="col-md-4 col-xs-12">
        <style type="text/css">
            ol.list_views {
                margin: 10px 0;
                color: #fff;
            }
            ol.list_views a {
                color: orange;
                font-weight: 400;
            }
        </style>
        <h5 class="text-center" style="font-weight: bold">Sản phẩm xem nhiều</h5>
        <ol class="list_views">
            @foreach($product_views as $key => $pro)
                <li>
                    <a href="#">{{ $pro->sp_TenSanPham }} | <span style="color: black">{{ $pro->sp_LuotXem }}</span> </a>
                </li>
            @endforeach
        </ol>
    </div>

    <div class="col-md-4 col-xs-12">
        <style type="text/css">
            ol.list_views {
                margin: 10px 0;
                color: #61a1ce;
            }
            ol.list_views a {
                color: orange;
                font-weight: 400;
            }
        </style>
        <h5 class="text-center" style="font-weight: bold">Bài viết xem nhiều</h5>
        <ol class="list_views">
            @foreach($post_views as $key => $pos)
                <li>
                    <a href="#">{{ $pos->bv_TieuDeBaiViet }} | <span style="color: black">{{ $pos->bv_LuotXem }}</span> </a>
                </li>
            @endforeach
        </ol>
    </div>

</div>





{{--    </div>--}}
{{--    </div>--}}
@endsection
