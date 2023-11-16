@extends('back-end.main2')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Sản phẩm</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/products">Sản phẩm</a></li>
                <li class="breadcrumb-item active"><a href="">Xem chi tiết</a></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <section class="section profile">
        <div class="row">

            <div class="col-xl-12">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Tổng quan</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-detail">Chi tiết</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-image">Hình ảnh</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-review">Đánh giá ({{ $review->count() }})</button>
                            </li>

                        </ul>


                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>
                                            @if($total_size > 0)
                                                Tình trạng: Còn hàng <b id="total-quantity2">{{ $total_size }}</b> trong kho
                                            @elseif($total_size == 0)
                                                Tình trạng: <b style="color: red">Hết hàng</b>
                                            @endif
                                        </p>

                                        @if($total_size > 0)
                                            <span><b>Xem số lượng size trong kho:</b></span>
                                            <div>
                                                @foreach($sizes as $item)
                                                    <input type="radio" class="size-input2" name="product_size" data-quantity2="{{ $item->spkt_soLuongHang }}" value="{{$item->kich_thuoc_id}}" required>
                                                    <label>Size {{ $item->kichthuoc->kt_TenKichThuoc }}</label><br>
                                                @endforeach
                                            </div>
                                        @elseif($total_size == 0)
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="inputNanme4" class="form-label"><strong>Tên sản phẩm:</strong></label>
                                        <input type="text" class="form-control" disabled value="{{ $product->sp_TenSanPham }}">
                                    </div>

                                    <div class="col-md-2">
                                        <label for="inputNanme4" class="form-label"><strong>Giá:</strong></label>
                                        <input type="text" class="form-control" style="color: red;font-weight: bold;" disabled  value="{{ number_format($product->sp_Gia, 0, '', '.') }} đ">
                                    </div>

                                    <div class="col-md-2">
                                        <label for="inputNanme4" class="form-label"><strong>Lượt bán:</strong></label>
                                        <input type="text" class="form-control" style="font-weight: bold;" disabled  value="{{ $product->sp_SoLuongBan }}">
                                    </div>

                                    <div class="col-md-2">
                                        <label for="inputNanme4" class="form-label"><strong>Lượt xem:</strong></label>
                                        <input type="text" class="form-control" style="font-weight: bold;" disabled  value="{{ $product->sp_LuotXem }}">
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="inputNanme4" class="form-label"><strong>Danh mục</strong></label>
                                        <input type="text" class="form-control" disabled  value="{{ $product->danhmuc->dmsp_TenDanhMuc }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputNanme4" class="form-label"><strong>Thương hiệu</strong></label>
                                        <input type="text" class="form-control" disabled value="{{ $product->thuonghieu->thsp_TenThuongHieu }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="inputNanme4" class="form-label"><strong>Tags</strong></label>
                                        <input type="text" class="form-control" disabled value="{{ $product->sp_Tag }}">
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade profile-detail pt-3" id="profile-detail">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="inputNanme4" class="form-label"><strong>Mô tả:</strong></label>
                                        <textarea class="form-control" style="height: 100px;" disabled>{{ $product->sp_MoTa }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="inputNanme4" class="form-label"><strong>Nội dung:</strong></label>
                                        <textarea class="form-control" style="height: 100px;" disabled>{{ $product->sp_NoiDung }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="inputNanme4" class="form-label"><strong>Chất liệu:</strong></label>
                                        <textarea class="form-control" style="height: 100px;" disabled>{{ $product->sp_ChatLieu }}</textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade pt-3" id="profile-image">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="" class="form-label"><strong>Ảnh đại diện:</strong></label>
                                        <br>
                                        <div style="text-align: center;">
                                            <img src="{{ asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}" width="220px" height="170px">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <label for="" class="form-label"><strong>Video:</strong></label>
                                        <br>
                                        <div style="text-align: center;">
                                            <div style="position: relative; display: inline-block;">
                                                <img src="{{ asset('/storage/images/products/'.$product->sp_AnhDaiDien) }}" width="220px" height="170px">
                                                <a href="{{ $product->sp_Video }}" class="video-popup" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                    <i class="fa fa-play"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div><br><br>

                                <div class="row">
                                    <div class="col-6">
                                        <label for="" class="form-label"><strong>Ảnh chi tiết 1:</strong></label>
                                        <br>
                                        <div style="text-align: center;">
                                            <img src="{{ asset('storage/images/product/detail/' . $images[0]->ha_Ten) }}" width="220px" height="170px">
                                        </div>
                                    </div>


                                    <div class="col-6">
                                        <label for="" class="form-label"><strong>Ảnh chi tiết 2:</strong></label>
                                        <br>
                                        <div style="text-align: center;">
                                            <img src="{{ asset('storage/images/product/detail/' . $images[1]->ha_Ten) }}" width="220px" height="170px">
                                        </div>
                                    </div>
                                </div>



                            </div>

                            <div class="tab-pane fade pt-3" id="profile-review">
                                <p><b>Phần trăm đánh giá: </b></p>
                                <div class="component_rating_content" style="display: flex;align-items: center;border-radius: 5px;border: 1px solid #dedede">
                                    <div class="rating_item" style="width: 15%; position: relative; display: grid; text-align: center;">
                                        <span class="fa fa-star" style="font-size: 70px; color: #ff9705;"></span>
                                        <b style="color: red; font-size: 20px;">{{ $roundedRating }}</b>
                                    </div>

                                    <?php
                                    $ratingCounts = [0, 0, 0, 0, 0]; // Mảng đếm số lượng đánh giá cho mỗi số sao (1-5)
                                    foreach ($rating_products as $rating_product) {
                                        $ratingCounts[$rating_product->dg_SoSao - 1]++;
                                    }
                                    $totalRatings = count($rating_products);
                                    $percentageRatings = [];
                                    for ($i = 0; $i < 5; $i++) {
                                        $percentage = ($totalRatings > 0) ? ($ratingCounts[$i] / $totalRatings) * 100 : 0;
                                        $percentageRatings[] = $percentage;
                                    }
                                    ?>

                                    <div class="list_rating" style="width: 100%;padding: 5px">
                                        @for($i = 5; $i >= 1; $i--)
                                            <div class="item_rating" style="display: flex;align-items: center">
                                                <div style="width: 6%;font-size: 14px">
                                                    {{ $i }} <span class="fa fa-star" style="color: #ff9705;"></span>
                                                </div>
                                                <div style="width: 100%;margin: 0 10px">
                                                            <span style="width: 100%;height: 8px;display: block;border: 1px solid #dedede;border-radius: 5px;background-color: #dedede">
                                                                <b style="width: {{ $percentageRatings[$i-1] }}%;background-color: #f25800;
                                                                              display: block;border-radius: 5px;
                                                                              height: 100%">
                                                                </b>
                                                            </span>
                                                </div>
                                                <div style="width: 6%">
                                                    <p>{{ round($percentageRatings[$i-1]) }} %</p>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div><br>

                                <p><b>Đánh giá của khách hàng: </b></p>

                                <div class="review-scroll" style="border:3px solid white;
                                                           width:870px;height:300px;
                                                           overflow-x:hidden;overflow-y:auto;">
                                    <div class="review-list">
                                        @foreach($review as $rv)
                                            <div class="row" style="background-color: #F0FFFF;padding: 10px;border-radius: 5px;margin-bottom: 5px;">
                                                <div class="col-1">
                                                    <div style="width: 70px;height: 70px;display: inline-block;margin-right: 5px;margin-top: 2px;vertical-align: top;">
                                                        <img src="{{ asset('/storage/images/avatar/customers/'.$rv->khachhang->avatar) }}" class="rounded-circle" width="50px" height="50px">
                                                    </div>
                                                </div>
                                                <div class="col-11">
                                                    <div>
                                                        <h6>{{ $rv->khachhang->kh_Ten }}</h6>
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $rv->dg_SoSao)
                                                                <span class="fa fa-star " style="color: #ff9705;"></span>
                                                            @else
                                                                <span class="fa fa-star " style="color: #ccc;"></span>
                                                            @endif
                                                        @endfor
                                                        <br>
                                                        <i style="font-size: 12px;">Phân loại : Size {{ $rv->kichthuoc }}</i><br>
                                                        <span>{{ $rv->dg_MucDanhGia }}</span><br>
                                                        <span>Lúc {{ $rv->created_at->format('H:i:s d/m/Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>



                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/template/back-end2/js/script.js"></script>

    <script>
        var sizeInputs = document.querySelectorAll('.size-input2');
        var totalQuantityDisplay = document.getElementById('total-quantity2');

        sizeInputs.forEach(function(input) {
            input.addEventListener('change', function() {
                var quantity = this.getAttribute('data-quantity2');
                // Cập nhật giá trị `$total_size`
                totalQuantityDisplay.textContent = quantity;
            });
        });
    </script>


@endsection



