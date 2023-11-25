<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width-device-width, initial-scale-1">
    <style>
        body {
            font-family: Arial;
        }

        .coupon {
            border: 5px dotted #bbb;
            width: 80%;
            border-radius: 15px;
            margin: 0 auto;
            max-width: 600px;
        }

        .container {
            padding: 2px 16px;
            background-color: #f1f1f1;
        }

        .promo {
            background: #ccc;
            padding: 3px;
        }

        .expire {
            color: red;
        }

        p.code {
            text-align: center;
            font-size: 20px;
        }

        p.expire {
            text-align: center;
        }

        h2.note {
            text-align: center;
            font-size: large;
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="coupon">
    <div class="container">
        <h3>Mã khuyến mãi</h3>
    </div>
    <div class="container" style="background: white">
        <h2 class="note"><b><i>
            @if ($mailData['mgg_LoaiGiamGia'] == 2)
                        Giảm <span style="color: red"> {{ $mailData['mgg_GiaTri'] }}% </span>
            @else
                        Giảm <span style="color: red"> {{ number_format($mailData['mgg_GiaTri'], 0, '', '.') }}đ </span>
            @endif
                    cho đơn hàng tối thiểu <span style="color: red">{{ number_format($mailData['mgg_DonToiThieu'], 0, '', '.') }}đ</span>
                    giảm tối đa <span style="color: red">{{ number_format($mailData['mgg_GiamToiDa'], 0, '', '.') }}đ</span>
            </i></b>
        </h2>
        <p>Qúy khách mua hàng tại shop Balo Việt.
            Vào tài khoản để mua hàng và nhập mã code phía dưới để được giám giá mua hàng.
            Xin cảm ơn quý khách và chúc quý khách thật nhiều sức khỏe và may mắn trong cuộc sống.
        </p>
    </div>
    <div class="container">
        <p class="code" style="text-align: center;">Sử dụng Code sau: <span class="promo">{{ $mailData['mgg_MaGiamGia'] }}</span> <br>với {{ $mailData['mgg_SoLuongMa'] }} mã giảm giá đầu tiên </p>
        <p class="expire">Ngày bắt đầu : {{ \Carbon\Carbon::parse($mailData['mgg_NgayBatDau'])->format('d-m-Y H:i:s') }} / Ngày hết hạn mã code: {{ \Carbon\Carbon::parse($mailData['mgg_NgayKetThuc'])->format('d-m-Y H:i:s') }}</p>
    </div>
</div>
</body>
</html>
