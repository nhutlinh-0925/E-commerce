<!DOCTYPE html>
<html>
<head>
    <title>Thông báo giao hàng thành công</title>
</head>
<body>
<h1>Giao hàng đã thành công</h1>
<p>Xin chào {{ $mailData['kh_Ten'] }},</p>
<p>Chúng tôi xin thông báo rằng đơn hàng có mã <b>#{{ $mailData['id_pdh'] }}</b> đã được giao hàng thành công.</p>
<p>Bạn có thể xem chi tiết đơn hàng <a href="https://baloviet.com/user/purchase_order/order_detail/{{ $mailData['id_pdh']}}">tại đây</a>.</p>
<p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
</body>
</html>
