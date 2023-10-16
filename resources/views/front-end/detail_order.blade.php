<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- head -->
    @include('front-end.pages.head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
@include('front-end.pages.header')

@include('front-end.header_cart')

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Chi tiết đơn hàng</h4>
                    <div class="breadcrumb__links">
                        <a href="/">Trang chủ</a>
                        <a href="/purchase_order/{{ $khachhang->id }}">Đơn hàng</a>
                        <span>Chi tiết đơn hàng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

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

<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="card-body">
                <div class="pagetitle text-center">
                        <h1 class="card-title"
                            style="border-bottom: 3px solid blue; display: inline-block; padding-bottom: 5px; "; >
                            CHI TIẾT ĐƠN HÀNG
                        </h1>
                    </div>

                <section class="content">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" style="font-size: 25px; color: blue">Thông tin khách hàng</h4>
                                    <div class="row">
                                        <div class="col-3">
                                            <label><b>Tên khách hàng : </b></label>
                                        </div>
                                        <div class="col-3">
                                            <p>{{ $kh->kh_Ten }}</p>
                                        </div>
                                        <div class="col-3">
                                            <label><b>Tổng giá trị đơn hàng : </b></label>
                                        </div>
                                        <div class="col-3">
                                            <p>{{ number_format($pdh->pdh_TongTien, 0, '', '.') }} đ </p>
                                        </div>

                                        <div class="col-3">
                                            <label><b>Số điện thoại :</b></label>
                                        </div>
                                        <div class="col-3">
                                            <p>{{ $kh->kh_SoDienThoai }}</p>
                                        </div>
                                        <div class="col-3">
                                            <label><b>Hình thức thanh toán: </b></label>
                                        </div>
                                        <div class="col-3">
                                            <p class="text-success"><b>{{ $pdh->phuongthucthanhtoan->pttt_MoTa }}</b></p>
                                        </div>

                                        <div class="col-3">
                                            <label><b>Thời gian đặt hàng : </b></label>
                                        </div>
                                        <div class="col-3">
                                            <p>{{ $pdh->created_at->format('H:i:s d/m/Y') }}</p>
                                        </div>
                                        <div class="col-3">
                                            <label><b>Cập nhật gần nhất : </b></label>
                                        </div>
                                        <div class="col-3">
                                            <p>{{ $pdh->updated_at->format('H:i:s d/m/Y') }}</p>
                                        </div>

                                        <div class="col-3">
                                            <label><b>Địa chỉ giao hàng :</b></label>
                                        </div>
                                        <div class="col-3">
                                            <p>{{ $pdh->pdh_DiaChiGiao }}</p>
                                        </div>
                                        <div class="col-3">
                                            <label><b>Trạng thái :</b></label>
                                        </div>
                                        <div class="col-3">
                                            @if($pdh->pdh_TrangThai == 1)
                                                <p style="color:#4dd0e1;"><b>Đang chờ duyệt</b></p>
                                            @elseif($pdh->pdh_TrangThai == 2)
                                                <p style="color: blue"><b>Đơn đã duyệt</b></p>
                                            @elseif($pdh->pdh_TrangThai == 3)
                                                <p style="color: #0c5460"><b>Đang vận chuyển</b></p>
                                            @elseif($pdh->pdh_TrangThai == 4)
                                                <p style="color: green"><b>Giao hàng thành công</b></p>
                                            @elseif($pdh->pdh_TrangThai == 5)
                                                <p style="color:red;"><b>Đã hủy đơn</b></p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <h4 class="card-title" style="font-size: 25px; color: blue">Thông tin sản phẩm</h4>
                                    <div class="row">
                                        <table class="table table-bordered" style="">
                                            <thead style="text-align: center;">
                                            <tr role="row" style="background-color: #1E90FF; color: white">
                                                <th>STT</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Hình ảnh</th>
                                                <th>Số lượng</th>
                                                <th>Giá tiền</th>
                                                <th>Thành tiền</th>
                                            </thead>
                                            <tbody>
                                            @php $total = 0; @endphp
                                            @foreach($cart_id as $key => $detail_cart)
                                                @php
                                                    $price = $detail_cart->ctpdh_Gia;
                                                    $priceEnd = $price * $detail_cart->ctpdh_SoLuong;
                                                    $total += $priceEnd;
                                                @endphp
                                                <tr>
                                                    <td style="text-align: center;">{{ $key+1 }}</td>
                                                    <td style="text-align: center;">{{ $detail_cart->sp_TenSanPham }}</td>
                                                    <td style="text-align: center;">
                                                        <a>
                                                            <img src="{{ url('/storage/images/products/'.$detail_cart->sp_AnhDaiDien) }}" height="40px">
                                                        </a>
                                                    </td>
                                                    <td style="text-align: center;">{{ $detail_cart->ctpdh_SoLuong }}</td>
                                                    <td style="text-align: center;">{{ number_format($detail_cart->ctpdh_Gia, 0, '', '.') }} đ</td>
                                                    <td style="text-align: center;">{{ number_format($detail_cart->ctpdh_SoLuong * $detail_cart->ctpdh_Gia, 0, '', '.') }} đ</td>

                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="5"><b></b></td>
                                                <td colspan="5">
                                                    <label style="float: right;">{{ number_format($total, 0, '', '.') }} đ</label>
                                                    <label>Tổng giá trị đơn hàng : </label>
                                                    <br>
                                                    <label style="float: right;">{{ number_format($phi, 0, '', '.') }} đ </label>
                                                    <label>Phí ship : </label>

                                                    @if($mgg)
                                                        @if($mgg->mgg_LoaiGiamGia == 2)
                                                            <br>
                                                            <label style="float: right;">{{ $mgg->mgg_GiaTri }} %</label>
                                                            <label>Mã giảm : </label>
                                                            @php
                                                                $total_coupon = ($total * $mgg->mgg_GiaTri)/100;
                                                            @endphp

                                                            <br>
                                                            <label style="float: right;">{{ number_format($total_coupon, 0, '', '.') }} đ</label>
                                                            <label>Mã giảm được: </label>

                                                            <br>
                                                            <label style="float: right;">{{ number_format($total_coupon, 0, '', '.') }} đ</label>
                                                            <label>Tổng tiền được giảm : </label>
                                                            <hr style="Border: solid 1px black;">

                                                            <label style="float: right;color: red"><b>{{ number_format($total - $total_coupon + $phi, 0, '', '.') }} đ</b></label>
                                                            <label>Tiền thanh toán : </label>
                                                        @elseif($mgg->mgg_LoaiGiamGia == 1)
                                                            <br>
                                                            <label style="float: right;">{{ number_format($mgg->mgg_GiaTri, 0, '', '.') }} đ</label>
                                                            <label>Mã giảm : </label>
                                                            @php
                                                                $total_coupon = $total - $mgg->mgg_GiaTri;
                                                            @endphp

                                                            <br>
                                                            <label style="float: right;">{{ number_format($mgg->mgg_GiaTri, 0, '', '.') }} đ</label>
                                                            <label>Tổng tiền được giảm : </label>
                                                            <hr style="Border: solid 1px black;">

                                                            <label style="float: right;color: red"><b>{{ number_format($total_coupon + $phi, 0, '', '.') }} đ</b></label>
                                                            <label>Tiền thanh toán: </label>
                                                        @endif
                                                    @else
                                                        <br>
                                                        <label style="float: right;">0 đ</label>
                                                        <label>Mã giảm : </label>
                                                        <br>
                                                        <label style="float: right;">0 đ</label>
                                                        <label>Tổng tiền được giảm : </label>
                                                        <hr style="border: solid 1px black;">

                                                        <label style="float: right;color: red"><b>{{ number_format($total + $phi, 0, '', '.') }} đ</b></label>
                                                        <label>Tiền thanh toán : </label>
                                                    @endif
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        @if($pdh->pdh_TrangThai == 1)
                                        <div class="col-12 text-center">
                                            <h3>XÁC NHẬN</h3>
                                            <label for="inputNanme4" class="form-label"><strong>Trạng thái đơn hàng: <span class="text-danger">(*)</span></strong></label>
                                            <form method="POST" style="width: 200px"  class="mx-auto">
                                                @csrf
                                                <div class="form-group text-center">
                                                    <select name="pdh_TrangThai" class="form-control">
                                                        <option value="5">Hủy đơn</option>
                                                    </select>
                                                </div>
                                                <br><br>

                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                    <a href="{{ route('purchase_order', ['id' => $id_kh]) }}" class="btn btn-danger">Quay lại</a>
                                                </div>
                                            </form>
                                        </div>
                                        @elseif($pdh->pdh_TrangThai == 3)
                                        <div class="col-12 text-center">
                                            <h3>XÁC NHẬN</h3>
                                            <label for="inputNanme4" class="form-label"><strong>Trạng thái đơn hàng: <span class="text-danger">(*)</span></strong></label>
                                            <form method="POST" style="width: 200px"  class="mx-auto">
                                            @csrf
                                                <div class="form-group text-center">
                                                    <select name="pdh_TrangThai" class="form-control mx-auto" style="width: 150px;">
                                                        <option value="4">Giao hàng thành công</option>
                                                    </select>
                                                </div>
                                                <br><br>

                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                    <a href="{{ route('user.purchase_order', ['id' => $id_kh]) }}" class="btn btn-danger">Quay lại</a>
                                                </div>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>
</section>

@include('front-end.pages.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>
