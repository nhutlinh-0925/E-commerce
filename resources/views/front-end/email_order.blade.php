<div style="width: 600px; margin: 0 auto">
    <div style="text-align: center;">
        <h2>Xin chào {{ $mailData['kh_Ten'] }}</h2>
        <p>Chúng tôi xin thông báo rằng đơn hàng có mã <b>#{{ $mailData['id_pdh'] }}</b> đã được duyệt thành công.</p>
    </div>

    <h3>Thông tin khách hàng</h3>
    <table border="1" cellspacing="0" cellpadding="10" style="width: 100%">
        <tr>
            <th><p style="float: left;">Tên :</p></th>
            <td>{{ $mailData['kh_Ten'] }}</td>
        </tr>

        <tr>
            <th><p style="float: left;">Số điện thoại :</p></th>
            <td>{{ $mailData['kh_SoDienThoai'] }}</td>
        </tr>

        <tr>
            <th><p style="float: left;">Địa chỉ :</p></th>
            <td>{{ $mailData['pdh_DiaChiGiao'] }}</td>
        </tr>

        <tr>
            <th><p style="float: left;">Phương thức thanh toán :</p></th>
            <td>
                @if ($mailData['pdh_pttt'] == 1)
                    <p style="color: green"><b>Nhận hàng trả tiền</b></p>
                @elseif($mailData['pdh_pttt'] == 2)
                    <p style="color: green"><b>Thanh toán qua Paypal</b></p>
                @elseif($mailData['pdh_pttt'] == 3)
                    <p style="color: green"><b>Thanh toán qua VNPay</b></p>
                @elseif($mailData['pdh_pttt'] == 4)
                    <p style="color: green"><b>Thanh toán qua Momo</b></p>
                @endif
            </td>
        </tr>

        <tr>
            <th><p style="float: left;">Tổng giá trị đơn hàng :</p></th>
            <td><p style="color: red"><b>{{ number_format($mailData['pdh_TongTien'], 0, '', '.') }} đ</b></p> </td>
        </tr>

        <tr>
            <th><p style="float: left;">Thời gian đặt hàng :</p></th>
            <td>{{ \Carbon\Carbon::parse($mailData['pdh_created_at'])->format('d-m-Y H:i:s') }}</td>
        </tr>
    </table>

    <h3>Thông tin sản phẩm</h3>
    <table border="1" cellspacing="0" cellpadding="10" style="width: 100%">
        <thead>
        <tr>
            <th>STT</th>
{{--            <th>Ảnh</th>--}}
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Thành tiền</th>
        </tr>
        </thead>

        <tbody>
        @php $total = 0; @endphp
        @foreach($mailData['cart_id'] as $key => $detail_cart)
            @php
                $price = $detail_cart->ctpdh_Gia;
                $priceEnd = $price * $detail_cart->ctpdh_SoLuong;
                $total += $priceEnd;
            @endphp
        <tr>
            <td>{{ $key+1 }}</td>
{{--            <td>--}}
{{--                <a>--}}
{{--                    <img src="{{ url('/storage/images/products/'.$detail_cart->sp_AnhDaiDien) }}" height="40px">--}}
{{--                </a>--}}
{{--            </td>--}}
            <td>{{ $detail_cart->sp_TenSanPham }}</td>
            <td>{{ $detail_cart->ctpdh_SoLuong }}</td>
            <td>{{ number_format($detail_cart->ctpdh_Gia, 0, '', '.') }} đ</td>
            <td>{{ number_format($detail_cart->ctpdh_SoLuong * $detail_cart->ctpdh_Gia, 0, '', '.') }} đ</td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <h3>Trạng thái đơn hàng</h3>
    <label><p style="color: green"><b>Đã xác nhận</b></p></label>
{{--    <p>Bạn có thể xem chi tiết <a href="/user/purchase_order/order_detail/{{ $mailData['id_pdh']}}">tại đây</a></p>--}}
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi !!!</p>

</div>


