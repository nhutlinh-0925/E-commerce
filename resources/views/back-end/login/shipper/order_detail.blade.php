@extends('back-end.main_shipper')

@section('head')
    <link rel="stylesheet" href="/template/back-end2/css/style3_admin_ctdh.css">
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
    <link rel="stylesheet" href="/template/back-end2/css/bootstrap-tagsinput.css">

    <link rel="stylesheet" href="/template/back-end2/css/sweetalert.css" type="text/css">
@endsection

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Đơn hàng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/shipper">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/shipper/orders">Đơn hàng</a></li>
                <li class="breadcrumb-item active"><a href="">Chi tiết đơn hàng</a></li>
            </ol>
        </nav>
    </div>
@endsection


@section('content')
    <div class="container">
        <div class="progress-bar" style="flex-direction: row;">
            <div class="step">
                <p>
                    Thông tin đơn hàng
                </p>
                <div class="bullet">
                    <span>1</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <p>
                    Danh sách sản phẩm của đơn hàng
                </p>
                <div class="bullet">
                    <span>2</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
            <div class="step">
                <p>
                    Xác nhận
                </p>
                <div class="bullet">
                    <span>3</span>
                </div>
                <div class="check fas fa-check"></div>
            </div>
        </div>

        <div class="form-outer">
            <form class="row g-3" method="POST" >

                <div class="page slide-page">
                    <div class="pagetitle text-center">
                        <h1 class="card-title"
                            style="border-bottom: 3px solid blue; display: inline-block; padding-bottom: 5px; "; >
                            KIỂM TRA THÔNG TIN ĐƠN HÀNG
                        </h1>
                        <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi chuyển sang bước tiếp theo</p>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputNanme4" class="form-label"><strong>Tên khách hàng: <span class="text-danger">(*)</span></strong></label>
                            <input  type="text" class="form-control" value="{{ $kh->kh_Ten }}" disabled >
                        </div>
                        <div class="col-md-6">
                            <label for="inputNanme4" class="form-label"><strong>Tiền thu: <span class="text-danger">(*)</span></strong></label>
                            @if($pdh->phuong_thuc_thanh_toan_id == 1)
                            <input type="text" class="form-control" style="color: red;font-weight: bold" value="{{ number_format($pdh->pdh_TongTien, 0, '', '.') }} đ" disabled>
                            @else
                            <input type="text" class="form-control" style="color: red;font-weight: bold" value="{{ number_format(0, 0, '', '.') }} đ" disabled>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputNanme4" class="form-label"><strong>Số điện thoại: <span class="text-danger">(*)</span></strong></label>
                            <input type="text" class="form-control" value="{{ $kh->kh_SoDienThoai }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="inputNanme4" class="form-label"><strong>Phương thức thanh toán: <span class="text-danger">(*)</span></strong></label>
                            <input type="text" class="form-control" value="{{ $pdh->phuongthucthanhtoan->pttt_MoTa }}" disabled>
                        </div>
                    </div>



                    <div class="col-12">
                        <label for="inputNanme4" class="form-label"><strong>Địa chỉ giao hàng: <span class="text-danger">(*)</span></strong></label>
                        <input type="text" class="form-control" value="{{ $pdh->pdh_DiaChiGiao }}" disabled>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputNanme4" class="form-label"><strong>Thời gian đặt hàng: <span class="text-danger">(*)</span></strong></label>
                            <input type="text" class="form-control" value="{{ $pdh->created_at->format('H:i:s d/m/Y') }}" disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="inputNanme4" class="form-label"><strong>Cập nhật gần nhất: <span class="text-danger">(*)</span></strong></label>
                            <input type="text" class="form-control" value="{{ $pdh->updated_at->format('H:i:s d/m/Y') }}" disabled>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="inputNanme4" class="form-label"><strong>Nhân viên giao hàng: <span class="text-danger">(*)</span></strong></label>
                        @if ($pdh->nguoi_giao_hang_id == '')
                            <input type="text" class="form-control" value="*Chưa xác định*" disabled>
                        @else
                            <input type="text" class="form-control" value="{{ $pdh->nguoigiaohang->ngh_Ten }}" disabled>
                        @endif
                    </div>


                    <div class="field">
                        <button class="firstNext" id="next-1">TIẾP TỤC</button>
                    </div>
                </div>

                <div class="page">
                    <div class="pagetitle text-center">
                        <h1 class="card-title"
                            style="border-bottom: 3px solid blue; display: inline-block; padding-bottom: 5px; "; >
                            DANH SÁCH SẢN PHẨM CỦA ĐƠN HÀNG
                        </h1>
                        <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi chuyển sang bước tiếp theo</p>
                    </div>

                    <div class="row">
                        <table class="table table-bordered" style="">
                            <thead style="text-align: center;">
                            <tr role="row" style="background-color: #1E90FF; color: white">
                                <th>STT</th>
                                <th>Tên sản phẩm</th>
                                <th>Hình ảnh</th>
                                <th>Size</th>
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
                                    <td style="text-align: center;">{{ $detail_cart->kt_TenKichThuoc }}</td>
                                    <td style="text-align: center;">{{ $detail_cart->ctpdh_SoLuong }}</td>
                                    <td style="text-align: center;">{{ number_format($detail_cart->ctpdh_Gia, 0, '', '.') }} đ</td>
                                    <td style="text-align: center;">{{ number_format($detail_cart->ctpdh_SoLuong * $detail_cart->ctpdh_Gia, 0, '', '.') }} đ</td>

                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5"><b></b></td>
                                <td colspan="5">
                                    <label style="float: right;">{{ number_format($total, 0, '', '.') }} đ</label>
                                    <label>Tổng giá trị đơn hàng : </label><br>

                                    <label style="float: right;">{{ number_format($phi, 0, '', '.') }} đ </label>
                                    <label>Phí ship : </label>

                                    @if($mgg)
                                        @if($mgg->mgg_LoaiGiamGia == 2)
                                            <br>
                                            <label style="float: right;">{{ $mgg->mgg_GiaTri }} %</label>
                                            <label>Mã giảm : </label>
                                            @php
                                                $total_coupon1 = ($total * $mgg->mgg_GiaTri)/100;
                                                $total_coupon2 = $mgg->mgg_GiamToiDa;//100
                                                if($total_coupon1 > $total_coupon2)
                                                    $total_coupon = $total_coupon2;
                                                elseif($total_coupon1 < $total_coupon2)
                                                    $total_coupon = $total_coupon1;
                                                elseif($total_coupon1 == $total_coupon2)
                                                    $total_coupon = $total_coupon2;
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
                    </div>

                    <div class="field btns">
                        <button class="prev-1 prev">QUAY LẠI</button>
                        <button class="next-1 next">TIẾP TỤC</button>
                    </div>
                </div>


                <div class="page">
                    <div class="pagetitle text-center">
                        <h1 class="card-title"
                            style="border-bottom: 3px solid blue; display: inline-block; padding-bottom: 5px; "; >
                            XÁC NHẬN
                        </h1>
                        <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi xác nhận</p>
                    </div>

                    <div class="col-12 text-center">
                        <label for="inputNanme4" class="form-label"><strong>Trạng thái đơn hàng: <span class="text-danger">(*)</span></strong></label>
                        @csrf
                        @if( $pdh->pdh_TrangThai == 2 )
                            <div class="form-group text-center">
                                <select name="pdh_TrangThaiGiaoHang" class="form-control mx-auto" style="width: 200px;">
                                    <option value="1">Nhận đơn</option>
                                    <option value="0">Từ chối giao hàng</option>
                                </select>
                            </div>
                        @elseif( $pdh->pdh_TrangThai == 3 )
                            <div class="form-group text-center">
                                <select name="pdh_TrangThaiGiaoHang" class="form-control mx-auto" style="width: 200px;">
                                    <option value="2">Giao hàng thành công</option>
                                    <option value="3">Giao hàng thất bại</option>
                                </select>
                            </div>
                        @elseif( $pdh->pdh_TrangThai == 4 )
                            <div class="form-group text-center">
                                <p style="color: green"><b>Giao hàng thành công</b></p>
                            </div>
                        @elseif( $pdh->pdh_TrangThai == 5 )
                            <div class="form-group text-center">
                                <p style="color: red"><b>Đơn đã hủy</b></p>
                            </div>
                        @elseif( $pdh->pdh_TrangThai == 6 )
                            <div class="form-group text-center">
                                <p style="color: red"><b>Giao hàng thất bại</b></p>
                            </div>
                        @endif
                    </div>
                    @if( $pdh->pdh_TrangThai == 4 || $pdh->pdh_TrangThai == 5 || $pdh->pdh_TrangThai == 6 )
                    <div class="fieldd btns">
                        <a href="/shipper/orders" class="prev-2 prev"
                           style="display: flex;justify-content: center;
                            align-items: center;margin: 1px 0;
                            position: relative;">
                            QUAY LẠI
                        </a>
                    </div>
                    @elseif( $pdh->pdh_TrangThai == 2 || $pdh->pdh_TrangThai == 3 )
                    <div class="fieldd btns">
                        <button class="prev-2 prev">QUAY LẠI</button>
                        <button type="submit" class="submit">XÁC NHẬN</button>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

@endsection

@section('footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/template/back-end2/js/script_admin_ctdh.js"></script>

@endsection


