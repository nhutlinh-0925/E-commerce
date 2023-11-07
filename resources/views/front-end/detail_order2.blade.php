<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- head -->
    @include('front-end.pages.head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" />
    <style>
        body {
            background-color:
                #eeeeee;
            font-family: 'Open Sans', serif
        }

        .container_order {
            margin-top: 50px;
            margin-bottom: 50px
        }

        .card {
            position:
                relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction:
                normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color:
                #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius:
                0.10rem
        }

        .card-header:first-child {
            border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0
        }

        .card-header {
            padding:
                0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1)
        }

        .track {
            position:
                relative;
            background-color: #ddd;
            height: 7px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            margin-bottom:
                60px;
            margin-top: 50px
        }

        .track .step {
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            width: 25%;
            margin-top:
                -18px;
            text-align: center;
            position: relative
        }

        .track .step.active:before {
            background: #FF5722
        }

        .track .step::before {
            height: 7px;
            position: absolute;
            content: "";
            width: 100%;
            left: 0;
            top: 18px
        }

        .track .step.active .icon {
            background: #ee5435;
            color: #fff
        }

        .track .icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height:
                40px;
            position: relative;
            border-radius: 100%;
            background: #ddd
        }

        .track .step.active .text {
            font-weight: 400;
            color:
                #000
        }

        .track .text {
            display: block;
            margin-top: 7px
        }

        .itemside {
            position: relative;
            display: -webkit-box;
            display:
                -ms-flexbox;display: flex;
            width: 100%
        }

        .itemside .aside {
            position: relative;
            -ms-flex-negative: 0;
            flex-shrink:
                0
        }

        .img-sm {
            width: 80px;
            height: 80px;
            padding: 7px
        }

        ul.row,
        ul.row-sm {
            list-style: none;
            padding: 0
        }

        .itemside .info {
            padding-left: 15px;
            padding-right: 7px
        }

        .itemside .title {
            display: block;
            margin-bottom: 5px;
            color:
                #212529
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem
        }

        .btn-warning {
            color: #ffffff;
            background-color: #ee5435;
            border-color:
                #ee5435;
            border-radius: 1px
        }

        .btn-warning:hover {
            color: #ffffff;
            background-color: #ff2b00;
            border-color:
                #ff2b00;
            border-radius: 1px
        }
    </style>
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
                    <div class="breadcrumb__links">
                        <a href="/">Trang chủ</a>
                        <a href="/user/purchase_order/{{ Auth('web')->user()->id }}">Đơn hàng</a>
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

<!-- content description -->
<section class="bg-light border-top py-4">
    <div class="container">
        <div class="row gx-4">
            <div class="col-lg-12 mb-4 row">
                <div class="col-lg-12 ">
                    <div class="pd-20 card-box mb-30">
                        <div class="container_order">
                            <article class="card">
                                <div class="row mt-2">
                                    <div class="col-lg-9">
                                        <h4>Thông tin chi tiết của đơn hàng ID:# {{ $pdh->id }}</h4>
                                    </div>
                                    <div class="col-lg-3 text-end">
                                        @if($pdh->pdh_TrangThai == 1)
                                        <a href="{{ url('user/purchase_order/order_detail/status_confirmed_cancel/' . $pdh->id) }}" class="btn btn-warning" data-abc="true">
                                            <i class="fa fa-times"></i> HỦY ĐƠN HÀNG
                                        </a>
                                        @elseif($pdh->pdh_TrangThai == 3)
                                        <a href="{{ url('/user/purchase_order/order_detail/status_confirmed_success/' . $pdh->id) }}" class="btn btn-warning" data-abc="true">
                                            <i class="fa fa-check"></i> ĐÃ NHẬN HÀNG
                                        </a>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-body">
                                    <article class="card">
                                        <div class="card-body row">
                                            <div class="col-3"> <strong>Ngày đặt hàng: </strong> <br>
                                                {{ $pdh->created_at->format('H:i:s d/m/Y') }}
                                            </div>
                                            <div class="col-3"> <strong>Vận chuyển bởi:</strong> <br>
                                                @if ($pdh->nguoi_giao_hang_id == '')
                                                    <p>Giao bởi : <i>*Chưa cập nhật*</i></p>
                                                @elseif ($pdh->nguoi_giao_hang_id != '')
                                                    <p>Giao bởi :<b>{{ $pdh->nguoigiaohang->ngh_Ten }}</b></p>
                                                    <i class="fa fa-phone"></i> {{ $pdh->nguoigiaohang->ngh_SoDienThoai }}
                                                @endif
                                            </div>
                                            <div class="col-3">
                                                <strong>Tình trạng đơn hàng:</strong>
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
                                                    @elseif($pdh->pdh_TrangThai == 6)
                                                        <p style="color:red;"><b>Giao hàng thất bại</b></p>
                                                    @endif
                                            </div>
                                            <div class="col-3"> <strong>Theo dõi #:</strong> <br>
                                                {{ $pdh->id }}
                                            </div>
                                        </div>
                                    </article>
                                    <article class="card mt-2">
                                        <div class="card-body row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <label><b>Tên khách hàng : </b></label>
                                                    </div>
                                                    <div class="col-4">
                                                        <p>{{ $kh->kh_Ten }}</p>
                                                    </div>
                                                    <div class="col-2">
                                                        <label><b>Số điện thoại :</b></label>
                                                    </div>
                                                    <div class="col-4">
                                                        <p>(+84) {{ $kh->kh_SoDienThoai }}</p>
                                                    </div>

                                                    <div class="col-2">
                                                        <label><b>Thanh toán: </b></label>
                                                    </div>
                                                    <div class="col-4">
                                                        <p class="text-success"><b>{{ $pdh->phuongthucthanhtoan->pttt_MoTa }}</b></p>
                                                    </div>

                                                    <div class="col-2">
                                                        <label><b>Ghi chú: </b></label>
                                                    </div>
                                                    <div class="col-4">
                                                        @if ($pdh->pdh_GhiChu == '')
                                                        <p><i>*Không*</i></p>
                                                        @elseif ($pdh->pdh_GhiChu != '')
                                                        <p><b>{{ $pdh->pdh_GhiChu }}</b></p>
                                                        @endif
                                                    </div>

                                                    <div class="col-2">
                                                        <label><b>Địa chỉ giao hàng: </b></label>
                                                    </div>
                                                    <div class="col-10">
                                                        <p>{{ $pdh->pdh_DiaChiGiao }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                    <div class="track">
                                        @php
                                            $status_confirmed = '';
                                            $status_picked = '';
                                            $status_way = '';
                                            $status_ready = '';
                                            if ($pdh->pdh_TrangThai == 4) {
                                                $status_confirmed = 'active';
                                                $status_picked = 'active';
                                                $status_way = 'active';
                                                $status_ready = 'active';
                                            } elseif ($pdh->pdh_TrangThai == 3) {
                                                $status_confirmed = 'active';
                                                $status_picked = 'active';
                                                $status_way = 'active';
                                            } elseif ($pdh->pdh_TrangThai == 6) {
                                                $status_confirmed = 'active';
                                                $status_picked = 'active';
                                                $status_way = 'active';
                                            } elseif ($pdh->pdh_TrangThai == 2) {
                                                $status_confirmed = 'active';
                                                $status_picked = 'active';
                                            } else {
                                                $status_confirmed = 'active';
                                            }
                                        @endphp
                                        <div class="step {{ $status_confirmed }} ">
                                            <span class="icon"> <i class="fa fa-check"></i>
                                            </span> <span class="text">Chờ xác nhận</span>
                                        </div>
                                        <div class="step {{ $status_picked }}">
                                            <span class="icon"> <i class="fa fa-user"></i>
                                            </span> <span class="text">Duyệt đơn hàng</span> </div>
                                        <div class="step {{ $status_way }}">
                                            <span class="icon"> <i class="fa fa-truck"></i>
                                            </span> <span class="text"> Đang vận chuyển </span> </div>
                                        <div class="step {{ $status_ready }}">
                                            <span class="icon"> <i class="fa fa-box"></i> </span>
                                            <span class="text">Giao hàng thành công</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <table class="table table-bordered" style="">
                                            <thead style="text-align: center;">
                                            <tr role="row" style="background-color: #ee5435; color: white">
                                                <th>STT</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Hình ảnh</th>
                                                <th>Size</th>
                                                <th>Số lượng</th>
                                                <th>Giá tiền</th>
                                                <th>Thành tiền</th>
                                                @if($pdh->pdh_TrangThai == 4)
                                                    <th>Đánh giá</th>
                                                @endif
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
                                                    @php
                                                        $dg_hoan_thanh = false; // Mặc định đơn hàng chưa hoàn thành
                                                        // Kiểm tra xem đã có phản hồi cho đơn hàng này hay chưa
                                                        $dg_hoan_thanh = \App\Models\ĐanhGia::where('phieu_dat_hang_id', $pdh->id)
                                                                        ->where('san_pham_id', $detail_cart->san_pham_id)
                                                                        ->where('dg_TrangThai',1)->exists();
                                                    @endphp
                                                    <td style="text-align: center;">
                                                        @if($pdh->pdh_TrangThai == 4 && !$dg_hoan_thanh)
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#exampleModal-{{ $key }}" title ='Đánh giá sản phẩm'>
                                                            <i class="fa fa-star"></i>
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="exampleModal-{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Đánh giá sản phẩm: <p style="color: #ee5435;">{{ $detail_cart->sp_TenSanPham }}</p></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <form action="{{ route('user.add_review', ['id_dh' => $pdh->id, 'id_pr' => $detail_cart->san_pham_id]) }}" method="POST">
                                                                            @csrf
                                                                            <ul class="list-inline rating" title="Average Rating" style="float: left">
                                                                                @for($count = 1; $count <= 5; $count++)
                                                                                    <li id="{{ $detail_cart->san_pham_id }}-{{ $count }}"
                                                                                        data-index="{{ $count }}"
                                                                                        data-product_id="{{ $detail_cart->san_pham_id }}"
                                                                                        data-dg-value="{{ $count }}"
                                                                                        class="rating"
                                                                                        style="cursor: pointer;font-size: 30px; display: inline-block; margin-right: 5px;">
                                                                                        &#9733;
                                                                                    </li>
                                                                                @endfor
                                                                            </ul>
                                                                            <input type="hidden" name="san_pham_id" value="{{ $detail_cart->san_pham_id }}">
                                                                            <input type="hidden" name="phieu_dat_hang_id" value="{{$pdh->id}}">
                                                                            <input type="hidden" name="dg_SoSao" id="dg_SoSao">
                                                                            <textarea name="dg_MucDanhGia" placeholder="Viết đánh giá của bạn" style="width: 480px;height: 100px" required></textarea>
                                                                            <button type="submit" class="btn btn-sm btn-success justify-content-end" style="color: white;font-size: 18px;float: right;"><i class="fa fa-paper-plane"></i>Gửi đánh giá</button>
                                                                        </form>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        @elseif($pdh->pdh_TrangThai == 4 && $dg_hoan_thanh)
                                                            <a class="btn btn-primary btn-sm" href="/product/{{ $detail_cart->san_pham_id }}" title ='Xem đánh giá sản phẩm'><i class="fa fa-eye"></i></a>
                                                        @endif
                                                    </td>
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
                                    </div>
                                    @php
                                        $ph_hoan_thanh = false; // Mặc định đơn hàng chưa hoàn thành
                                        // Kiểm tra xem đã có phản hồi cho đơn hàng này hay chưa
                                        $ph_hoan_thanh = \App\Models\PhanHoi::where('phieu_dat_hang_id', $pdh->id)
                                                        ->where('ph_TrangThai',1)->exists();
                                    @endphp

                                    @if($pdh->pdh_TrangThai == 4 && !$ph_hoan_thanh)
                                        <form action="/user/purchase_order/order_detail/add_feedback/{{ $pdh->id}}" method="POST">
                                            <div class="text-start">
                                                <div class="row">
                                                    <label><strong>Phản hồi đơn hàng của bạn :</strong></label>
                                                    <ul class="list-inline rating" title="Average Rating">
                                                        @for($count = 1; $count <= 5; $count++)
                                                            <li title="Đánh giá sao"
                                                                id="{{ $order_id }}-{{ $count }}"
                                                                data-index="{{ $count }}"
                                                                data-order_id="{{ $order_id }}"
{{--                                                                data-rating="{{ $rating }}"--}}
                                                                data-dg-value="{{ $count }}"
                                                                class="rating_feedback"
                                                                style="cursor: pointer;font-size: 30px; display: inline-block; margin-right: 5px;">
                                                                &#9733;
                                                            </li>
                                                        @endfor
                                                    </ul>
                                                    <input type="hidden" name="id_pdh" value="{{$order_id}}">
                                                    <input type="hidden" name="ph_SoSao" id="ph_SoSao">
                                                    <textarea name="ph_MucPhanHoi" placeholder="Viết phản hồi của bạn" style="color: black;width: 1050px;height: 100px" required></textarea>
                                                    @error ('ph_MucPhanHoi')
                                                    <span style="color: red;">{{ $message }}</span>
                                                    @enderror

                                                </div>

                                                <br>
                                                <button type="submit" class="btn btn-sm btn-success justify-content-end" style="color: white;font-size: 18px;float: right;">
                                                    <i class="fa fa-paper-plane"></i> Gửi phản hồi</button>
                                            </div>
                                        @csrf
                                        </form>
                                    @elseif($pdh->pdh_TrangThai == 4 && $ph_hoan_thanh)
                                        <div class="text-start">
                                            <div class="row">
                                                <label><strong>Phản hồi đơn hàng của bạn :</strong></label>
                                                <ul class="list-inline rating" title="Average Rating">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $pdh->phanhoi->ph_SoSao)
                                                            <span class="fa fa-star " style="color: #ff9705;"></span>
                                                        @else
                                                            <span class="fa fa-star " style="color: #ccc;"></span>
                                                        @endif
                                                    @endfor
                                                </ul>
                                                <textarea placeholder="Viết phản hồi của bạn" style="color: black;width: 1050px;height: 100px" disabled>{{ $feedback->ph_MucPhanHoi }}</textarea>
                                            </div>
                                            <br>
                                        </div>
                                    @endif

                                    <div class="text-start">
                                        <a href="/user/purchase_order/{{ Auth('web')->user()->id }}" class="btn btn-sm btn-warning justify-content-end " style="color: white;font-size: 18px">
                                            <i class="fa fa-chevron-left"></i> QUAY VỀ
                                        </a>
                                    </div>

                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('front-end.pages.footer')
@if(session()->has('success_message_feedback'))
    <style>
        .my-custom-icon {
            color: #ff0000; /* Màu đỏ */
            font-size: 5px; /* Kích thước nhỏ hơn (16px) */
        }
    </style>

    <script>
        Swal.fire({
            title: 'Cảm ơn bạn!!!', // Tiêu đề của thông báo
            text: 'Đã thêm phản hồi cho đơn hàng!', // Nội dung của thông báo
            icon: 'success', // Icon của thông báo (success, error, warning, info, question)
            showConfirmButton: false, // Không hiển thị nút xác nhận
            timer: 2500, // Thời gian hiển thị thông báo (tính theo milliseconds)
            showCloseButton: true, // Hiển thị nút X để tắt thông báo
            customClass: {
                icon: 'my-custom-icon' // Sử dụng lớp CSS tùy chỉnh cho icon
            },
            // background: '#ff0000', // Màu nền của thông báo
            padding: '3rem', // Khoảng cách lề bên trong thông báo
            borderRadius: '10px' // Độ cong của góc thông báo
        });
    </script>
@elseif(session()->has('success_message_review'))
    <style>
        .my-custom-icon {
            color: #ff0000; /* Màu đỏ */
            font-size: 5px; /* Kích thước nhỏ hơn (16px) */
        }
    </style>

    <script>
        Swal.fire({
            title: 'Cảm ơn bạn!!!', // Tiêu đề của thông báo
            text: 'Đã thêm đánh giá cho sản phẩm!', // Nội dung của thông báo
            icon: 'success', // Icon của thông báo (success, error, warning, info, question)
            showConfirmButton: false, // Không hiển thị nút xác nhận
            timer: 2500, // Thời gian hiển thị thông báo (tính theo milliseconds)
            showCloseButton: true, // Hiển thị nút X để tắt thông báo
            customClass: {
                icon: 'my-custom-icon' // Sử dụng lớp CSS tùy chỉnh cho icon
            },
            // background: '#ff0000', // Màu nền của thông báo
            padding: '3rem', // Khoảng cách lề bên trong thông báo
            borderRadius: '10px' // Độ cong của góc thông báo
        });
    </script>
@endif
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@section('footer')

    <script>
        document.getElementById('myButton').addEventListener('click', function() {
            $('#exampleModal-{{ $key }}').modal('show');
        });
    </script>
@endsection
</body>
</html>
