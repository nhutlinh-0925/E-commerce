<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- head -->
    @include('front-end.pages.head')
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">--}}
</head>

<body>
@include('front-end.pages.header')

@include('front-end.header_cart')

<!-- Blog Details Hero Begin -->
<section class="blog-hero spad">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-9 text-center">
                <div class="blog__hero__text">
                    <h2>{{ $post->bv_TieuDeBaiViet }}</h2>
                    <ul>
                        <li>Đăng bởi {{ $post->nguoidang->nv_Ten }} </li>
                        <li>{{ date("d-m-Y", strtotime($post->bv_NgayTao)) }}</li>
                        <li>8 Comments</li>
                        <li>{{ $post->bv_LuotXem }} lượt xem</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Details Hero End -->

<!-- Blog Details Section Begin -->
<section class="blog-details spad">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="blog__details__pic">
                    <img src="{{asset('/storage/images/posts/'.$post->bv_AnhDaiDien) }}" alt="" width="340px" height="560px">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="blog__details__content">
                    <div class="blog__details__share">
                        <span>share</span>
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#" class="twitter"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#" class="youtube"><i class="fa fa-youtube-play"></i></a></li>
                            <li><a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                    <div class="blog__details__text">
                        <p>{{ $post->bv_NoiDungNgan }}</p>
                    </div>
                    <div class="blog__details__quote">
                        <i class="fa fa-quote-left"></i>
                        <p>“Không chỉ đơn thuần là một sản phẩm, BALO TINH TẾ trở thành người bạn đồng hành đáng tin cậy, đem đến cho bạn sự thoải mái, sự tự tin và cảm giác an toàn, giúp bạn tập trung tối đa vào việc khám phá và trải nghiệm cuộc sống một cách đầy đam mê và ý nghĩa. ”</p>
                        <h6>BALO TINH TẾ - Một sự lựa chọn hàng đầu!</h6>
                    </div>
                    <div class="blog__details__text">
                        <p>{{ $post->bv_NoiDungChiTiet }}</p>
                    </div>
                    <div class="blog__details__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="blog__details__author">
                                    <div class="blog__details__author__pic">
                                        <img src="/template/front-end/img/blog/details/blog-author.jpg" alt="">
                                    </div>
                                    <div class="blog__details__author__text">
                                        <h5>Aiden Blair</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="blog__details__tags">
                                    <a href="#">#Fashion</a>
                                    <a href="#">#Trending</a>
                                    <a href="#">#2020</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="blog__details__comment">
                        <h4>Để lại bình luận của bạn</h4>
                        <form action="#">
                            <div class="row">
                                <div class="col-lg-12 text-center">
{{--                                    <label for="inputAddress" class="form-label"><strong>Mô tả tóm tắt sản phẩm <span class="text-danger">(*)</span></strong></label>--}}
                                    <textarea placeholder="Viết bình luận của bạn (Vui lòng gõ tiếng Việt có dấu)"></textarea>
                                    <button type="submit" class="site-btn">Gửi bình luận</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Details Section End -->

<!-- Related Section Begin -->
<section class="">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="related-title">Bài viết liên quan</h3>
            </div>
        </div>
        <div class="row">
            @foreach ($post_related as $post_relate)
                <div class="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg">
                            <a href="/blog/{{ $post_relate->id }}">
                                <img src="{{asset('/storage/images/posts/'.$post_relate->bv_AnhDaiDien) }}" width="340px" height="260px"></a>
                        </div>
                        <div class="blog__item__text">
                            <span><img src="/template/front-end/img/icon/calendar.png" alt=""> {{ date("d-m-Y", strtotime($post->bv_NgayTao)) }}</span>
                            <h6>{{ $post_relate->bv_TieuDeBaiViet }}</h6>
                            <a href="/blog/{{ $post_relate->id }}">Đọc thêm</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Related Section End -->

@include('front-end.pages.footer')
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>--}}

</body>

</html>
