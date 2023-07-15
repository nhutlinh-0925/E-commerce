<!DOCTYPE html>
<html lang="zxx">

<head>
    @include('front-end.pages.head')
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
                    <h4>Đơn hàng của bạn</h4>
                    <div class="breadcrumb__links">
                        <a href="/">Home</a>
                        <span>Đơn hàng của bạn</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
<br><br>

<div class="container">
    {{--    <h1 class="mb-5 mt-5">Laravel Datatables Tutorial | ScratchCode.io</h1>--}}
    <table class="table table-bordered data-table">
        <thead>
        <tr style="background-color: red;color: white">
            <th>ID</th>
            <th>Trạng thái đơn hàng</th>
            <th>Tổng tiền</th>
            <th>Phương thức thanh toán</th>
            <th>Thời gian đặt hàng</th>
            <th style="width: 100px">Tùy biến</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@include('front-end.pages.footer')
</body>
</html>
