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
                                CHI TIẾT ĐƠN HÀNG
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
                                                                    <p class="text-success">{{ $pdh->phuongthucthanhtoan->pttt_MoTa }}</p>
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
                                                                <div class="col-9">
                                                                    <p>{{ $pdh->pdh_DiaChiGiao }}</p>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
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
                                                                    <td colspan="5"><b>Trạng thái đơn hàng</b></td>
                                                                    <td colspan="5">
                                                                        <form action="" method="post" class="form-inline">
                                                                            @csrf
                                                                            @if( $pdh->pdh_TrangThai == 1)
                                                                                <div class="form-group">
                                                                                    <select name="pdh_TrangThai" class="form-control" style="width: 150px; margin-right: 10px;">
                                                                                        <option value="1">Đang chờ duyệt</option>
                                                                                        <option value="2">Đã duyệt</option>
                                                                                        <option value="3">Đang vận chuyển</option>
                                                                                        <option value="4">Giao hàng thành công</option>
                                                                                        <option value="5">Hủy đơn</option>
                                                                                    </select>
                                                                                    <input type="submit" value="Xác nhận" class="btn btn-primary">
                                                                                </div>
                                                                            @elseif( $pdh->pdh_TrangThai == 2 )
                                                                                <div class="form-group">
                                                                                    <select name="pdh_TrangThai" class="form-control" style="width: 150px; margin-right: 10px;">
                                                                                        <option value="2">Đã duyệt</option>
                                                                                        <option value="3">Đang vận chuyển</option>
                                                                                        <option value="4">Giao hàng thành công</option>
                                                                                    </select>
                                                                                    <input type="submit" value="Xác nhận" class="btn btn-primary">
                                                                                </div>
                                                                            @elseif( $pdh->pdh_TrangThai == 3 )
                                                                                <div class="form-group">
                                                                                    <select name="pdh_TrangThai" class="form-control" style="width: 150px; margin-right: 10px;">
                                                                                        <option value="3">Đang vận chuyển</option>
                                                                                        <option value="4">Giao hàng thành công</option>
                                                                                    </select>
                                                                                    <input type="submit" value="Xác nhận" class="btn btn-primary">
                                                                                </div>
                                                                            @elseif( $pdh->pdh_TrangThai == 4 )
                                                                                <div class="form-group">
                                                                                    <select name="pdh_TrangThai" class="form-control" style="width: 150px; margin-right: 10px;">
                                                                                        <option value="4">Giao hàng thành công</option>
                                                                                    </select>
                                                                                    <input type="submit" value="Xác nhận" class="btn btn-primary">
                                                                                </div>
                                                                            @elseif( $pdh->pdh_TrangThai == 5 )
                                                                                <div class="form-group">
                                                                                    <select name="pdh_TrangThai" class="form-control" style="width: 150px; margin-right: 10px;">
                                                                                        <option value="">Đơn đã hủy</option>
                                                                                    </select>
                                                                                </div>
                                                                            @endif
                                                                        </form>
                                                                    </td>

                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                            <div class="row">
                                                                <div class="col-4"></div>
                                                                <div class="col-3"></div>

                                                                <div class="col-3">
                                                                    <label>Tổng giá trị đơn hàng : </label>
                                                                </div>
                                                                <div class="col-2">
                                                                    <p style="text-align: right;">{{ number_format($total, 0, '', '.') }} đ </p>
                                                                </div>

                                                                <div class="col-4"></div>
                                                                <div class="col-3"></div>

                                                                <div class="col-3">
                                                                    <label>Phí ship : </label>
                                                                </div>
                                                                <div class="col-2">
                                                                    <p style="text-align: right;">{{ number_format($phi, 0, '', '.') }} đ </p>
                                                                </div>
                                                            </div>
                                                            @if($mgg)
                                                                @if($mgg->mgg_LoaiGiamGia == 2)
                                                                    <div class="row">
                                                                        <div class="col-4"></div>
                                                                        <div class="col-3"></div>

                                                                        <div class="col-3">
                                                                            <label>Mã giảm: </label>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <p style="text-align: right;">{{ $mgg->mgg_GiaTri }} %</p>
                                                                        </div>
                                                                    @php
                                                                        $total_coupon = ($total * $mgg->mgg_GiaTri)/100;
                                                                    @endphp
                                                                        <div class="col-4"></div>
                                                                        <div class="col-3"></div>

                                                                        <div class="col-3">
                                                                            <label>Mã giảm được: </label>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <p style="text-align: right;">{{ number_format($total_coupon, 0, '', '.') }} đ</p>
                                                                        </div>

                                                                        <div class="col-4"></div>
                                                                        <div class="col-3"></div>

                                                                        <div class="col-3">
                                                                            <label>Tổng tiền được giảm: </label>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <p style="text-align: right;">{{ number_format($total_coupon, 0, '', '.') }} đ</p>
                                                                            <hr style="Border: solid 1px black;">
                                                                        </div>

                                                                        <div class="col-4"></div>
                                                                        <div class="col-3"></div>

                                                                        <div class="col-3">
                                                                            <label>Tiền thanh toán: </label>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <p class="font-weight-bold" style="text-align: right;color: red">{{ number_format($total - $total_coupon + $phi, 0, '', '.') }} đ</p>
                                                                        </div>
                                                                    </div>
                                                                @elseif($mgg->mgg_LoaiGiamGia == 1)
                                                                    <div class="row">
                                                                        <div class="col-4"></div>
                                                                        <div class="col-3"></div>

                                                                        <div class="col-3">
                                                                            <label>Mã giảm: </label>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <p style="text-align: right;">{{ number_format($mgg->mgg_GiaTri, 0, '', '.') }} đ</p>
                                                                        </div>

                                                                    @php
                                                                        $total_coupon = $total - $mgg->mgg_GiaTri;
                                                                    @endphp
                                                                        <div class="col-4"></div>
                                                                        <div class="col-3"></div>

                                                                        <div class="col-3">
                                                                            <label>Tổng tiền được giảm: </label>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <p style="text-align: right;">{{ number_format($mgg->mgg_GiaTri, 0, '', '.') }} đ</p>
                                                                            <hr style="Border: solid 1px black;">
                                                                        </div>

                                                                        <div class="col-4"></div>
                                                                        <div class="col-3"></div>

                                                                        <div class="col-3">
                                                                            <label>Tiền thanh toán: </label>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <p class="font-weight-bold" style="text-align: right;color: red">{{ number_format($total_coupon + $phi, 0, '', '.') }} đ</p>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @else
                                                                <div class="row">
                                                                    <div class="col-4"></div>
                                                                    <div class="col-3"></div>

                                                                    <div class="col-3">
                                                                        <label>Mã giảm : </label>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <p style="text-align: right;">0 đ</p>
                                                                    </div>

                                                                    <div class="col-4"></div>
                                                                    <div class="col-3"></div>
                                                                        <div class="col-3">
                                                                            <label>Tổng tiền được giảm:</label>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <p style="text-align: right;">0 đ</p>
                                                                            <hr style="border: solid 1px black;">
                                                                        </div>

                                                                    <div class="col-4"></div>
                                                                    <div class="col-3"></div>

                                                                    <div class="col-3">
                                                                        <label>Tiền thanh toán: </label>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <p class="font-weight-bold" style="text-align: right;color: red">{{ number_format($total + $phi, 0, '', '.') }} đ</p>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
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
