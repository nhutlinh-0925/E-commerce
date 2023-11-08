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
                    <h4>Về chúng tôi </h4>
                    <div class="breadcrumb__links">
                        <a href="/">Trang chủ</a>
                        <span>Về chúng tôi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- About Section Begin -->
<section class="about spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="about__pic">
                    <img src="/template/front-end/img/about/about.jpg" alt="" width="1500px" height="600px">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="about__item">
                    <h4>Giới thiệu ?</h4>
                    <p>
                        Nếu bạn đang băn khoăn không biết lựa chọn cho mình một chiếc balo du lịch loại nào cho bền, đẹp. Hay bạn muốn tìm mua một chiếc cặp đi học cho bé nhà mình.
                        Thậm chí bạn là một người yêu thích thể thao như golf, tennis thì chắc hẳn không thể thiếu một chiếc túi đựng phụ kiện golf hay bao vợt tennis phải không?
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about__item">
                    <h4>Tại sao lại chọn chúng tôi ?</h4>
                    <p>Đến với Balo Việt, bạn sẽ thỏa sức lựa chọn các sản phẩm đúng với nhu cầu sử dụng của mình chỉ cần một cú nhấp chuột. Nào, hãy cùng khám phá website Balo Việt
                        với hơn 10 năm kinh nghiệm là đơn vị uy tín, chuyên cung cấp các sản phẩm balo, cặp, túi, vali. Bạn chỉ cần ngồi tại nhà hay văn phòng là có thể
                        đặt hàng online tại website Baloviet.com, và chỉ trong vài giờ cho đến vài ngày tùy vào địa chỉ nhận hàng là bạn có thể nhận được ngay một chiếc Balo, Vali,... ưng ý.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section End -->

<!-- Testimonial Section Begin -->
<section class="testimonial">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 p-0">
                <div class="testimonial__text">
                    <span class="icon_quotations"></span>
                    <p>
                        “Balo Việt có bộ phận chăm sóc khách hàng tốt sẽ luôn sẵn sàng tiếp nhận những phản hồi, tư vấn nhiệt tình giúp khách hàng yên tâm khi mua hàng.
                        Ngoài ra, Balo Việt không ngừng đổi mới để mang đến cho khách hàng thời trang độc đáo và mới lạ.”
                    </p>
                </div>
            </div>
            <div class="col-lg-6 p-0">
                <div class="testimonial__pic set-bg" data-setbg="/template/front-end/img/about/author.jpg"></div>
            </div>
        </div>
    </div>
</section><br><br>
<!-- Testimonial Section End -->

<!-- Client Section End -->

@include('front-end.pages.footer')

</body>

</html>

