@extends('back-end.main2')

@section('head')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
@endsection

@section('content')
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
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="pagetitle text-center">
                            <h1 class="card-title"
                                style="border-bottom: 3px solid blue; display: inline-block; padding-bottom: 5px; "; >
                                THÔNG TIN PHIẾU NHẬP
                            </h1>
                        </div>

                        <section class="content">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="inputNanme4" class="form-label"><strong>Người lập phiếu <span class="text-danger">(*)</span></strong></label>
                                                                <input type="text" class="form-control" id="" name="" value="{{ $nhanvien->nv_Ten }}" disabled>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="inputNanme4" class="form-label"><strong>Nhà cung cấp <span class="text-danger">(*)</span></strong></label>
                                                                <input type="text" class="form-control" id="" name="" value="{{ $warehouse->nhacungcap->ncc_TenNhaCungCap }}" disabled>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label for="inputNanme4" class="form-label"><strong>Ghi chú </strong></label>
                                                                <textarea class="form-control" id="" name="" style="height: 100px;" disabled>{{ $warehouse->pnh_GhiChu }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card">
                                                <table class="table table-bordered">
                                                    <thead style="text-align: center;">
                                                    <tr role="row" style="background-color: #1E90FF; color: white">
                                                        <th>Mã sản phẩm</th>
                                                        <th>Hình ảnh</th>
                                                        <th>Tên sản phẩm</th>
                                                        <th>Giá nhập</th>
                                                        <th>Số lượng</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody style="text-align: center;">
                                                    @if (count ($detail_warehouses) != 0)
                                                    @php
                                                        $sln = 0;
                                                        foreach ($detail_warehouses as $detail_warehouse) {
                                                            $sln += $detail_warehouse->ctpnh_SoLuongNhap;
                                                        }
                                                    @endphp
                                                    @endif

                                                    @foreach ($detail_warehouses as $detail_warehouse)
                                                        <tr>
                                                            <td>#{{ $detail_warehouse->sanpham->id }}</td>
                                                            <td>
                                                                <img src="{{asset('/storage/images/products/'.$detail_warehouse->sanpham->sp_AnhDaiDien) }}" height="50px" width="50px">
                                                            </td>
                                                            <td><b>{{ $detail_warehouse->sanpham->sp_TenSanPham }}</b></td>
                                                            <td><p style="color: red">{{ number_format($detail_warehouse->ctpnh_GiaNhap, 0, '', '.') }} đ</p></td>
                                                            <td>{{ $detail_warehouse->ctpnh_SoLuongNhap }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="3" style="text-align: right;"><b>Tổng tiền: </b></td>
                                                        <td colspan="1"><b style="color:red;;">{{ number_format($warehouse->pnh_TongTien, 0, '', '.') }} đ</b></td>
                                                        <td colspan="1"><b>Tổng SL : {{ $sln }}</b></td>
                                                    </tr>

                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection




