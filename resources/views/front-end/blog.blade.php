<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- head -->
    @include('front-end.pages.head')
</head>

<body>
@include('front-end.pages.header')

@include('front-end.header_cart')

{{--  @include('front-end.pages.banner')  --}}

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Tin tức</h4>
                    <div class="breadcrumb__links">
                        <a href="/">Trang chủ</a>
                        <span>Tin tức</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shop Section Begin -->
<section class="shop spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="shop__sidebar">
                    <div class="shop__sidebar__accordion">
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseOne">DANH MỤC BÀI VIẾT</a>
                                </div>
                                <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__categories">
                                            <ul class="nice-scroll">
                                                @foreach ($category_post as $item)
                                                     <li><a href="/danhmuc-baiviet/{{ $item->id }}">{{ $item->dmbv_TenDanhMuc }} <span class="count-check">({{ $item->posts->count() }})</span> </a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseTwo">Tags</a>
                                </div>
                                <div id="collapseTwo" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__tags">
                                            @foreach($limitedArray as $item)
                                                @php
                                                    $slug = Str::slug($item);
                                                @endphp
                                                <a href="/blog/tag/{{$slug}}">{{ $item }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseThree">Tin tức vừa xem</a>
                                </div>
                                <div id="collapseThree" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__tags">

                                            <div id="row_post_viewed" class="row"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="shop__product__option">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
{{--                            <div class="shop__product__option__left">--}}
{{--                                <p>Hiển thị 1-12 của  kết quả</p>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="blog__item" data-post-id="{{ $post->id }}">
                                <div class="blog__item__pic set-bg">
                                    <a href="/blog/{{ $post->id }}">
                                        <img src="{{asset('/storage/images/posts/'.$post->bv_AnhDaiDien) }}" width="340px" height="260px"></a>
                                </div>

                                <input type="hidden" id="post_viewed_id" value="{{ $post->id }}">
                                <input type="hidden" id="viewed_post_title{{ $post->id }}" value="{{ $post->bv_TieuDeBaiViet }}">
                                <input type="hidden" id="viewed_post_image{{ $post->id }}" value="{{asset('/storage/images/posts/'.$post->bv_AnhDaiDien) }}">
                                <input type="hidden" id="viewed_post_date{{ $post->id }}" value="{{ date("d-m-Y", strtotime($post->bv_NgayTao)) }}">

                                <div class="blog__item__text">
                                    <span><img src="/template/front-end/img/icon/calendar.png" alt=""> {{ date("d-m-Y", strtotime($post->bv_NgayTao)) }}</span>
                                    <h6>{{ $post->bv_TieuDeBaiViet }}</h6>
                                    <a href="/blog/{{ $post->id }}">Đọc thêm</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center">
                    {!! $posts->links() !!}
                </div>

            </div>
        </div>
    </div>
</section>
<!-- Shop Section End -->

@include('front-end.pages.footer')

</body>

</html>
