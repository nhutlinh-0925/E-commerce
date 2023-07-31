<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- head -->
    @include('front-end.pages.head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    @include('front-end.pages.header')

    @include('front-end.header_cart')

    <!-- Shop Details Section Begin -->
    <section class="shop-details">
        <div class="product__details__pic">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="/">Home</a>
                            <a href="/shop">Shop</a>
                            <span>Product Details</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
                                    <div class="product__thumb__pic set-bg">
                                        <img src="{{ asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}" width="100px" height="100px">
                                    </div>
                                </a>
                            </li>
                            @php
                                $tabIndex = 2;
                            @endphp
                            @foreach ($images as $index => $image)
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-{{ $tabIndex }}" role="tab">
                                        <div class="product__thumb__pic set-bg" data-setbg="{{ asset('/storage/images/product/detail/' . $image->ha_Ten) }}" width="100px" height="100px">
                                        </div>
                                    </a>
                                </li>
                                @php
                                    $tabIndex++;
                                @endphp
                            @endforeach

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-4" role="tab">
                                    <div class="product__thumb__pic set-bg" data-setbg="{{ asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}">
                                        <i class="fa fa-play"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__pic__item">
                                    <img src="{{ asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}" alt="" width="800px" height="550px">
                                </div>
                            </div>
                            @php
                                $tabIndex = 2;
                            @endphp
                            @foreach ($images as $index => $image)
                                <div class="tab-pane" id="tabs-{{ $tabIndex }}" role="tabpanel">
                                    <div class="product__details__pic__item">
                                        <img src="{{ asset('/storage/images/product/detail/' . $image->ha_Ten) }}" alt="" width="800px" height="550px">
                                    </div>
                                </div>
                                @php
                                    $tabIndex++;
                                @endphp
                            @endforeach
                            <div class="tab-pane" id="tabs-4" role="tabpanel">
                                <div class="product__details__pic__item">
                                    <img src="{{ asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}" width="800px" height="550px">
                                    <a href="{{ $product->sp_Video }}" class="video-popup"><i class="fa fa-play"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(Session::has('flash_message'))
            <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show text-center" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                {!! session('flash_message') !!}
            </div>

        @elseif(Session::has('flash_message_error'))
            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show text-center" role="alert">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                {!! session('flash_message_error') !!}
            </div>

        @endif
        <div class="product__details__content">
            <div class="container">
                <form action="/add-cart" method="post">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="product__details__text">
                            <h4>{{ $product->sp_TenSanPham }}</h4>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                                <span> - 5 Reviews</span>
                            </div>
                            @php
                                $price_reduced = 0;
                                $price = $product->sp_Gia;
                                $price_reduced = $price + $price*10/100;
                            @endphp
                            <h3>{{ number_format($product->sp_Gia) }}<sup><ins>đ</ins></sup>
                                <span>{{ number_format($price_reduced, 0, '', '.') }}<sup><ins>đ</ins></sup></span>
                                <br>
                                <p>Tình trạng :
                                    @if($product->sp_SoLuongHang > 0)
                                        <b>Còn hàng </b>({{ $product->sp_SoLuongHang }} sản phẩm trong kho)
                                    @elseif($product->sp_SoLuongHang == 0)
                                        <b style="color: red">Hết hàng</b>
                                    @endif
                                </p>
                            </h3>
                            <div class="product__details__option">
                                <div class="product__details__option__size">
                                    <span>Size:</span>
                                    <label for="xxl">xxl
                                        <input type="radio" id="xxl">
                                    </label>
                                    <label class="active" for="xl">xl
                                        <input type="radio" id="xl">
                                    </label>
                                    <label for="l">l
                                        <input type="radio" id="l">
                                    </label>
                                    <label for="sm">s
                                        <input type="radio" id="sm">
                                    </label>
                                </div>
                                <div class="product__details__option__color">
                                    <span>Color:</span>
                                    <label class="c-1" for="sp-1">
                                        <input type="radio" id="sp-1">
                                    </label>
                                    <label class="c-2" for="sp-2">
                                        <input type="radio" id="sp-2">
                                    </label>
                                    <label class="c-3" for="sp-3">
                                        <input type="radio" id="sp-3">
                                    </label>
                                    <label class="c-4" for="sp-4">
                                        <input type="radio" id="sp-4">
                                    </label>
                                    <label class="c-9" for="sp-9">
                                        <input type="radio" id="sp-9">
                                    </label>
                                </div>
                            </div>
                            <div class="product__details__cart__option">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input name="num_product" type="text" value="1">
                                    </div>
                                </div>
                                {{--  <a href="#"  class="primary-btn">add to cart</a>  --}}
                                <button type="submit"  class="primary-btn">add to cart</button>
                                <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                            </div>
                            <div class="product__details__btns__option">
                                <a href="#"><i class="fa fa-heart"></i> add to wishlist</a>
                                <a href="#"><i class="fa fa-exchange"></i> Add To Compare</a>
                            </div>
                            <div class="product__details__last__option">
                                <h5><span>Guaranteed Safe Checkout</span></h5>
                                <img src="/template/front-end/img/shop-details/details-payment.png" alt="">
                                <ul>
{{--                                    <li><span>SKU:</span> #000{{ $product->id }}</li>--}}
                                    <li><span>Danh mục:</span> {{$product->danhmuc->dmsp_TenDanhMuc}}</li>
                                    <li><span>Thương hiệu:</span> {{$product->thuonghieu->thsp_TenThuongHieu}}</li>
                                    <li><span>Tag:</span> Clothes, Skin, Body</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @csrf
                </form>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-5" role="tab">Mô tả</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-6" role="tab">Đánh giá(5)</a>
                                </li>
                                {{--  <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-7" role="tab">Thông tin thêm</a>
                                </li>  --}}
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-5" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <p class="note">{{ $product->sp_MoTa }}</p>
                                        <div class="product__details__tab__content__item">
                                            <h5>Thông tin sản phẩm</h5>
                                            <p>{{ $product->sp_NoiDung }}<p>
                                        </div>
                                        <div class="product__details__tab__content__item">
                                            <h5>Chất liệu</h5>
                                            <p>{{ $product->sp_ChatLieu }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-6" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <div class="product__details__tab__content__item">
                                            {{--  <h5>Products Infomation</h5>
                                            <p>
                                                A Pocket PC is a handheld computer, which features many of the same
                                                capabilities as a modern PC. These handy little devices allow
                                                individuals to retrieve and store e-mail messages, create a contact
                                                file, coordinate appointments, surf the internet, exchange text messages
                                                and more. Every product that is labeled as a Pocket PC must be
                                                accompanied with specific software to operate the unit and must feature
                                            a touchscreen and touchpad.
                                            </p>
                                            <p>As is the case with any new technology product, the cost of a Pocket PC
                                                was substantial during it’s early release. For approximately $700.00,
                                                consumers could purchase one of top-of-the-line Pocket PCs in 2003.
                                                These days, customers are finding that prices have become much more
                                                reasonable now that the newness is wearing off. For approximately
                                            $350.00, a new Pocket PC can now be purchased.</p>  --}}
                                        </div>
                                        <div class="product__details__tab__content__item">
                                            {{--  <h5>Material used</h5>
                                            <p>Polyester is deemed lower quality due to its none natural quality’s. Made
                                                from synthetic materials, not natural like wool. Polyester suits become
                                                creased easily and are known for not being breathable. Polyester suits
                                                tend to have a shine to them compared to wool and cotton suits, this can
                                                make the suit look cheap. The texture of velvet is luxurious and
                                                breathable. Velvet is a great choice for dinner party jacket and can be
                                            worn all year round.</p>  --}}
                                        </div>
                                    </div>
                                </div>
                                {{--  <div class="tab-pane" id="tabs-7" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <p class="note">Nam tempus turpis at metus scelerisque placerat nulla deumantos
                                            solicitud felis. Pellentesque diam dolor, elementum etos lobortis des mollis
                                            ut risus. Sedcus faucibus an sullamcorper mattis drostique des commodo
                                        pharetras loremos.</p>
                                        <div class="product__details__tab__content__item">
                                            <h5>Products Infomation</h5>
                                            <p>A Pocket PC is a handheld computer, which features many of the same
                                                capabilities as a modern PC. These handy little devices allow
                                                individuals to retrieve and store e-mail messages, create a contact
                                                file, coordinate appointments, surf the internet, exchange text messages
                                                and more. Every product that is labeled as a Pocket PC must be
                                                accompanied with specific software to operate the unit and must feature
                                            a touchscreen and touchpad.</p>
                                            <p>As is the case with any new technology product, the cost of a Pocket PC
                                                was substantial during it’s early release. For approximately $700.00,
                                                consumers could purchase one of top-of-the-line Pocket PCs in 2003.
                                                These days, customers are finding that prices have become much more
                                                reasonable now that the newness is wearing off. For approximately
                                            $350.00, a new Pocket PC can now be purchased.</p>
                                        </div>
                                        <div class="product__details__tab__content__item">
                                            <h5>Material used</h5>
                                            <p>Polyester is deemed lower quality due to its none natural quality’s. Made
                                                from synthetic materials, not natural like wool. Polyester suits become
                                                creased easily and are known for not being breathable. Polyester suits
                                                tend to have a shine to them compared to wool and cotton suits, this can
                                                make the suit look cheap. The texture of velvet is luxurious and
                                                breathable. Velvet is a great choice for dinner party jacket and can be
                                            worn all year round.</p>
                                        </div>
                                    </div>
                                </div>  --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Details Section End -->

    <!-- Related Section Begin -->
    <section class="related spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="related-title">Sản phẩm liên quan</h3>
                </div>
            </div>
            <div class="row">
                @foreach ($product_related as $product_relate)
                <div class="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg">
                            <a href="/product/{{ $product_relate->id }}">
                                <img src="{{asset('/storage/images/products/'.$product_relate->sp_AnhDaiDien) }}">
                            {{--  <span class="label">New</span>  --}}
                            <ul class="product__hover">
                                <li><a href="#"><img src="/template/front-end/img/icon/heart.png" alt=""></a></li>
                                <li><a href="#"><img src="/template/front-end/img/icon/compare.png" alt=""> <span>Compare</span></a></li>
                                <li><a href="#"><img src="/template/front-end/img/icon/search.png" alt=""></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6>{{ $product_relate->sp_TenSanPham }}</h6>
                            <a href="#" class="add-cart">+ Add To Cart</a>
                            <div class="rating">
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <h5>{{ number_format($product_relate->sp_Gia) }}<sup><ins>đ</ins></sup></h5>
                            <div class="product__color__select">
                                <label for="pc-1">
                                    <input type="radio" id="pc-1">
                                </label>
                                <label class="active black" for="pc-2">
                                    <input type="radio" id="pc-2">
                                </label>
                                <label class="grey" for="pc-3">
                                    <input type="radio" id="pc-3">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                {{--  <div class="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="/template/front-end/img/product/product-2.jpg">
                            <ul class="product__hover">
                                <li><a href="#"><img src="/template/front-end/img/icon/heart.png" alt=""></a></li>
                                <li><a href="#"><img src="/template/front-end/img/icon/compare.png" alt=""> <span>Compare</span></a></li>
                                <li><a href="#"><img src="/template/front-end/img/icon/search.png" alt=""></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6>Piqué Biker Jacket</h6>
                            <a href="#" class="add-cart">+ Add To Cart</a>
                            <div class="rating">
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <h5>$67.24</h5>
                            <div class="product__color__select">
                                <label for="pc-4">
                                    <input type="radio" id="pc-4">
                                </label>
                                <label class="active black" for="pc-5">
                                    <input type="radio" id="pc-5">
                                </label>
                                <label class="grey" for="pc-6">
                                    <input type="radio" id="pc-6">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                    <div class="product__item sale">
                        <div class="product__item__pic set-bg" data-setbg="/template/front-end/img/product/product-3.jpg">
                            <span class="label">Sale</span>
                            <ul class="product__hover">
                                <li><a href="#"><img src="/template/front-end/img/icon/heart.png" alt=""></a></li>
                                <li><a href="#"><img src="/template/front-end/img/icon/compare.png" alt=""> <span>Compare</span></a></li>
                                <li><a href="#"><img src="/template/front-end/img/icon/search.png" alt=""></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6>Multi-pocket Chest Bag</h6>
                            <a href="#" class="add-cart">+ Add To Cart</a>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <h5>$43.48</h5>
                            <div class="product__color__select">
                                <label for="pc-7">
                                    <input type="radio" id="pc-7">
                                </label>
                                <label class="active black" for="pc-8">
                                    <input type="radio" id="pc-8">
                                </label>
                                <label class="grey" for="pc-9">
                                    <input type="radio" id="pc-9">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="/template/front-end/img/product/product-4.jpg">
                            <ul class="product__hover">
                                <li><a href="#"><img src="/template/front-end/img/icon/heart.png" alt=""></a></li>
                                <li><a href="#"><img src="/template/front-end/img/icon/compare.png" alt=""> <span>Compare</span></a></li>
                                <li><a href="#"><img src="/template/front-end/img/icon/search.png" alt=""></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6>Diagonal Textured Cap</h6>
                            <a href="#" class="add-cart">+ Add To Cart</a>
                            <div class="rating">
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <h5>$60.9</h5>
                            <div class="product__color__select">
                                <label for="pc-10">
                                    <input type="radio" id="pc-10">
                                </label>
                                <label class="active black" for="pc-11">
                                    <input type="radio" id="pc-11">
                                </label>
                                <label class="grey" for="pc-12">
                                    <input type="radio" id="pc-12">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>  --}}
            </div>
        </div>
    </section>
    <!-- Related Section End -->

    @include('front-end.pages.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>
