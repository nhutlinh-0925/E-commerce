<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- head -->
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
                    <h4>Liên hệ </h4>
                    <div class="breadcrumb__links">
                        <a href="/">Trang chủ</a>
                        <span>Liên hệ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Contact Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="contact__text">
                    <div class="section-title">
                        <span>Thông tin</span>
                        <h2>Liên hệ với chúng tôi</h2>
                        <p>Chất lượng: Cam kết các sản phẩm Balo Việt chính hãng 100% được nhập khẩu trực tiếp từ hãng, có đầy đủ giấy tờ và hợp đồng mua bán với hãng.</p>
                    </div>
                    <ul>
                        <li>
                            <h4>Cần Thơ</h4>
                            <p>BALO VIỆT<br>
                                118 Đ. Mậu Thân, An Phú, Ninh Kiều, Cần Thơ<br />0908 762 667</p>
                        </li>
                        <li>
                            <h4>TP. Hồ Chí Minh</h4>
                            <p>BALO VIỆT<br>
                                152/65 Đường D1, phường 25, quận Bình Thạnh, Tp. Hồ Chí Minh<br />0908 762 776</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="contact__form">
                    <form action="#">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" placeholder="Họ và tên" style="color: black">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Email" style="color: black">
                            </div>
                            <div class="col-lg-12">
                                <textarea placeholder="Lời nhắn" style="color: black"></textarea>
                                <button type="submit" class="site-btn">Gửi lời nhắn</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

<!-- Map Begin -->
<div class="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.8356146525416!2d105.77338257329887!3d10.030420472514061!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a089f417a9f3ab%3A0x1c62d169b632dbc6!2zQkFMTyBWSeG7hlQ!5e0!3m2!1svi!2s!4v1691112204727!5m2!1svi!2s" width="600" height="550" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>

@include('front-end.pages.footer')

</body>

</html>

