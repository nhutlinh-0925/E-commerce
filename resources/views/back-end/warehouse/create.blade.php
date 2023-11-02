@extends('back-end.main2')

@section('head')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
@endsection

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Phiếu nhập kho</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/warehouses">Phiếu nhập kho</a></li>
                <li class="breadcrumb-item active"><a href="">Thêm phiếu nhập kho</a></li>
            </ol>
        </nav>
    </div>
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
                                THÊM PHIẾU NHẬP MỚI
                            </h1>
                            <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi thêm</p>
                        </div>

                        <section class="content">
                            <div class="box">
                                <div class="box-header with-border">
                                    <div class="row">
                                        <form class="row g-3" method="POST">
                                            <div class="col-md-12">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4 class="card-title" style="font-size: 25px; color: blue">Thông tin phiếu nhập</h4>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="inputNanme4" class="form-label"><strong>Người lập phiếu <span class="text-danger">(*)</span></strong></label>
                                                                    <input type="text" class="form-control" id="" name="" value="{{ Auth('admin')->user()->nv_Ten }}" disabled>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label for="inputNanme4" class="form-label"><strong>Nhà cung cấp <span class="text-danger">(*)</span></strong></label>
                                                                    <select class="form-control" name="nha_cung_cap_id" id="">
                                                                        <option value="">--- Chọn Nhà Cung Cấp ---</option>
                                                                        @foreach ($suppliers as $supplier)
                                                                            <option value="{{ $supplier->id }}" >{{ $supplier->ncc_TenNhaCungCap }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error ('nha_cung_cap_id')
                                                                    <span style="color: red;">{{ $message }}</span>
                                                                    @enderror

                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label for="inputNanme4" class="form-label"><strong>Ghi chú </strong></label>
                                                                    <textarea class="form-control" placeholder="Nhập ghi chú (nếu có)" id="" name="pnh_GhiChu" style="height: 100px;">{{ old('pnh_GhiChu', $request->pnh_GhiChu ?? '') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div style="display: flex; justify-content: flex-start; align-items: center;">
                                                                <div style="display: flex; align-items: center;">
                                                                    {{--                                                                    <button class="text-success" type="button"><b>Sản phẩm</b></button>--}}
                                                                    <select id="productSelect" style="width: 500px;">
                                                                        <option value="" >Sản phẩm</option>
                                                                    </select>

                                                                    {{--                                                                    <input autocomplete="off" type="text" style="width: 290px" placeholder="Tìm kiếm sản phẩm" id="keywords">--}}
                                                                    {{--                                                                    <button type="button" id="clear-input"><i class="fa fa-times"></i></button>--}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--                                                    <div style="display: flex; align-items: center;">--}}
                                                    {{--                                                        <div id="search-ajax"></div>--}}
                                                    {{--                                                        <div id="select-ajax"></div>--}}
                                                    {{--                                                    </div>--}}
                                                </div>

                                                <div class="card">
                                                    <table class="table table-bordered" id="product-table">
                                                        <thead style="text-align: center;">
                                                        <tr role="row" style="background-color: #1E90FF; color: white">
                                                            <th>Mã sản phẩm</th>
                                                            <th>Tên sản phẩm</th>
                                                            <th>Hình ảnh</th>
                                                            <th>Size</th>
                                                            <th>Giá nhập</th>
                                                            <th>Số lượng</th>
                                                            <th>Tùy biến</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                    <!-- Tổng số lượng -->
                                                    <div style="text-align: right; font-weight: bold;">
                                                        Tổng số lượng:
                                                        <span id="total-quantity">0</span>
                                                        <input type="hidden" name="ctpnh_SoLuongNhap" id="ctpnh_SoLuongNhap">
                                                    </div>

                                                    <!-- Tổng tiền -->
                                                    <div style="text-align: right; font-weight: bold;">
                                                        Tổng tiền:
                                                        <span id="total-price">0</span>
                                                        <input type="hidden" name="pnh_TongTien" id="pnh_TongTien">
                                                    </div>
                                                </div>

                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary" style="width: 10%;">Lưu</button>
                                                    <a href="/admin/warehouses" class="btn btn-danger">Quay lại</a>
                                                </div>

                                            </div>
                                            @csrf
                                        </form>
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



