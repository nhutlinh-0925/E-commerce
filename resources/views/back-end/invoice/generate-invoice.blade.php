<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Invoice #{{ $pdh->id }}</title>

    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: DejaVu Sans;
        }
        h1,h2,h3,h4,h5,h6,p,span,label {
            font-family: DejaVu Sans;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px !important;
        }
        table thead th {
            height: 28px;
            text-align: left;
            font-size: 16px;
            font-family: DejaVu Sans;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 14px;
        }

        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: DejaVu Sans;
        }
        .small-heading {
            font-size: 18px;
            font-family: DejaVu Sans;
        }
        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: DejaVu Sans;
        }
        .order-details tbody tr td:nth-child(1) {
            width: 20%;
        }
        .order-details tbody tr td:nth-child(3) {
            width: 20%;
        }

        .text-start {
            text-align: left;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: DejaVu Sans;
            font-size: 14px;
            font-weight: 400;
        }
        .no-border {
            border: 1px solid #fff !important;
        }
        .bg-blue {
            background-color: #414ab1;
            color: #fff;
        }
    </style>
</head>
<body>

<table class="order-details">
    <thead>
    <tr>
        <th width="50%" colspan="2">
            <h1 class="text-center">Balo Việt</h1>
        </th>
        <th width="50%" colspan="2" class="text-end company-data">
            <span>Mã đơn hàng: #{{ $pdh->id }}</span> <br>
            <span>Vận chuyển: {{ $pdh->nguoigiaohang->ngh_Ten }}</span> <br>
            <span>{{ $pdh->nguoigiaohang->ngh_SoDienThoai }}</span> <br>
        </th>
    </tr>
    <tr class="bg-blue">
        <th width="50%" colspan="2">Thông tin đơn hàng</th>
        <th width="50%" colspan="2">Thông tin khách hàng</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Mã đơn hàng: </td>
        <td>#{{ $pdh->id }}</td>

        <td>Tên khách hàng:</td>
        <td>{{ $kh->kh_Ten }}</td>
    </tr>
    <tr>
        <td>Nhân viên duyệt :</td>
        <td>{{ $nv->nv_Ten }}</td>

        <td>Email: </td>
        <td>{{ $kh->email }}</td>
    </tr>
    <tr>
        <td>Ngày đặt:</td>
        <td>{{ $pdh->created_at->format('H:i:s d/m/Y') }}</td>

        <td>Số điện thoại: </td>
        <td>(+84) {{ $kh->kh_SoDienThoai }}</td>
    </tr>
    <tr>
        <td>Thanh toán: </td>
        <td><p class="text-success"><b>{{ $pdh->phuongthucthanhtoan->pttt_MoTa }}</b></p></td>

        <td>Địa chỉ giao: </td>
        <td>{{ $pdh->pdh_DiaChiGiao }}</td>
    </tr>
    <tr>
        <td>Tình trạng đơn hàng:</td>
        <td>Giao hàng thành công</td>

        <td>Ghi chú: </td>
        @if ($pdh->pdh_GhiChu == '')
            <td><p><i>*Không*</i></p></td>
        @elseif ($pdh->pdh_GhiChu != '')
            <td><p><b>{{ $pdh->pdh_GhiChu }}</b></p></td>
        @endif
    </tr>
    </tbody>
</table>

<table>
    <thead>
    <tr>
        <th class="no-border text-start heading" colspan="5">
            Thông tin sản phẩm
        </th>
    </tr>
    <tr class="bg-blue">
        <th>STT</th>
        <th>Tên sản phẩm</th>
        <th>Số lượng</th>
        <th>Giá tiền</th>
        <th>Thành tiền</th>
    </tr>
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
            <td style="text-align: center;">{{ $detail_cart->ctpdh_SoLuong }}</td>
            <td style="text-align: center;">{{ number_format($detail_cart->ctpdh_Gia, 0, '', '.') }} đ</td>
            <td style="text-align: center;">{{ number_format($detail_cart->ctpdh_SoLuong * $detail_cart->ctpdh_Gia, 0, '', '.') }} đ</td>

        </tr>
    @endforeach
    <tr>
        <td colspan="3"><b></b></td>
        <td colspan="3">
            <label style="float: right;">{{ number_format($total, 0, '', '.') }} đ</label>
            <label>Tổng tiền :</label><br>

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
                    <label>Tổng tiền giảm : </label>
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
                    <label>Tổng tiền giảm : </label>
                    <hr style="Border: solid 1px black;">

                    <label style="float: right;color: red"><b>{{ number_format($total_coupon + $phi, 0, '', '.') }} đ</b></label>
                    <label>Tiền thanh toán: </label>
                @endif
            @else
                <br>
                <label class="justify-content-end" style="float: right;">0 đ</label>
                <label>Mã giảm : </label>
                <br>
                <label class="justify-content-end" style="float: right;">0 đ</label>
                <label>Tổng tiền giảm : </label>
                <hr style="border: solid 1px black;">

                <label style="float: right;color: red"><b>{{ number_format($total + $phi, 0, '', '.') }} đ</b></label>
                <label>Tiền thanh toán : </label>
            @endif
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>
