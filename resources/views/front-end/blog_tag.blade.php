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
                    <h4>Tin tức</h4>
                    <div class="breadcrumb__links">
                        <a href="/">Home</a>
                        <span>Shop</span>
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
                                    <a data-toggle="collapse" data-target="#collapseSix">Tags</a>
                                </div>
                                <div id="collapseSix" class="collapse show" data-parent="#accordionExample">
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="shop__product__option">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 style="text-align: center">Tìm kiếm</h2>
                            <div style="text-align: center;">
                                <p style="border-bottom: 3px solid blue; display: inline-block; padding-bottom: 5px;">
                                    Có <b>{{ count($blog_tag) }} bài viết</b> cho tìm kiếm
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="shop__product__option">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="shop__product__option__left">
                                <h5>Kết quả tìm kiếm cho tag: <b>"{{ $tag }}"</b></h5>
                            </div>
                        </div>
                        <div class="col-lg-3">
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach($blog_tag as $post)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="blog__item">
                                <div class="blog__item__pic set-bg">
                                    <a href="/blog/{{ $post->id }}">
                                        <img src="{{asset('/storage/images/posts/'.$post->bv_AnhDaiDien) }}" width="340px" height="260px"></a>
                                </div>
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
                    {!! $blog_tag->links() !!}
                </div>

            </div>
        </div>
    </div>
</section>
<!-- Shop Section End -->

@include('front-end.pages.footer')

</body>

</html>
