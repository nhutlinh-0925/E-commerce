<!-- Latest Blog Section Begin -->
    <section class="latest spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Bài viết mới nhất</span>
                        <h2>Thời Trang Xu Hướng Mới</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($posts as $post)
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg">
                            <a href="/blog/{{ $post->id }}">
                                <img src="{{asset('/storage/images/posts/'.$post->bv_AnhDaiDien) }}" width="340px" height="260px"></a>
                        </div>
                        <div class="blog__item__text">
                            <span><img src="/template/front-end/img/icon/calendar.png" alt=""> {{ date("d-m-Y", strtotime($post->bv_NgayTao)) }}</span>
                            <h5>{{ $post->bv_TieuDeBaiViet }}</h5>
                            <a href="/blog/{{ $post->id }}">Đọc thêm</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Latest Blog Section End -->
