{{-- them san pham --}}
@extends('back-end.main2')

{{--  @section('head')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@endsection  --}}


@section('content')
<div class="container">
    {{--  <header>Signup Form</header>  --}}
    <div class="progress-bar" style="flex-direction: row;">
       <div class="step">
          <p>
             Thông tin sản phẩm
          </p>
          <div class="bullet">
             <span>1</span>
          </div>
          <div class="check fas fa-check"></div>
       </div>
       <div class="step">
          <p>
             Chi tiết sản phẩm
          </p>
          <div class="bullet">
             <span>2</span>
          </div>
          <div class="check fas fa-check"></div>
       </div>
       <div class="step">
          <p>
             Hình ảnh sản phẩm
          </p>
          <div class="bullet">
             <span>3</span>
          </div>
          <div class="check fas fa-check"></div>
       </div>
       <div class="step">
          <p>
             Xác nhận
          </p>
          <div class="bullet">
             <span>4</span>
          </div>
          <div class="check fas fa-check"></div>
       </div>
    </div>



    <div class="form-outer">
        <form class="row g-3" method="POST" enctype="multipart/form-data">

            <div class="page slide-page">
                <div class="pagetitle text-center">
                    <h1 class="card-title"
                        style="border-bottom: 3px solid blue; display: inline-block; padding-bottom: 5px; "; >
                        THÔNG TIN SẢN PHẨM
                    </h1>
                    <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi thêm</p>
                </div>


                <div class="row">
                    <div class="col-md-9">
                        <label for="inputNanme4" class="form-label"><strong>Tên sản phẩm <span class="text-danger">(*)</span></strong></label>
                        <input type="text" class="form-control" id="sp_TenSanPham" name="sp_TenSanPham" placeholder="Nhập tên sản phẩm" value="{{ old('sp_TenSanPham', $product->sp_TenSanPham ?? '') }}">
                        @error ('sp_TenSanPham')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                        <b class="form-text text-danger" id="nameError"></b>
                    </div>
                    <div class="col-md-3">
                        <label for="inputNanme4" class="form-label"><strong>Giá sản phẩm <span class="text-danger">(*)</span></strong></label>
                        <input type="number" class="form-control" id="sp_Gia" name="sp_Gia" placeholder="Nhập giá" value="{{ old('sp_Gia', $product->sp_Gia ?? '') }}">
                        @error ('sp_Gia')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                        <b class="form-text text-danger" id="priceError"></b>
                    </div>
                </div>



                <div class="row">
                <div class="col-md-6">
                    <label for="inputNanme4" class="form-label"><strong>Số lượng sản phẩm <span class="text-danger">(*)</span></strong></label>
                    <input type="text" class="form-control" id="" name="" placeholder="Số lượng sản phẩm tăng khi nhập kho" value="{{ old('sp_SoLuongHang', $request->sp_SoLuongHang ?? '') }}" disabled>
                    @error ('sp_SoLuongHang')
                        <span style="color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="inputNanme4" class="form-label"><strong>Danh mục sản phẩm <span class="text-danger">(*)</span></strong></label>
                    <select class="form-control" name="danh_muc_san_pham_id" id="danh_muc_san_pham_id">
                        <option value="">--- Chọn Danh Mục ---</option>
                        @foreach ($category_products as $category_product)
                            <option value="{{ $category_product->id }}" {{ isset($product->danh_muc_san_pham_id) && $product->danh_muc_san_pham_id == $category_product->id ? 'selected' : '' }} >{{ $category_product->dmsp_TenDanhMuc }}</option>
                        @endforeach

                    </select>
                    @error ('danh_muc_san_pham_id')
                        <span style="color: red;">{{ $message }}</span>
                     @enderror
                     <b class="form-text text-danger" id="categoryError"></b>

                </div>

                <div class="col-md-3">
                    <label for="inputNanme4" class="form-label"><strong>Thương hiệu <span class="text-danger">(*)</span></strong></label>
                    <select class="form-control" name="thuong_hieu_id" id="thuong_hieu_id">
                        <option value="">--- Chọn Thương Hiệu ---</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ isset($product->thuong_hieu_id) && $product->thuong_hieu_id == $brand->id ? 'selected' : '' }} >{{ $brand->thsp_TenThuongHieu }}</option>
                        @endforeach

                    </select>
                    @error ('thuong_hieu_id')
                        <span style="color: red;">{{ $message }}</span>
                     @enderror
                     <b class="form-text text-danger" id="brandError"></b>
                </div>
                </div>



                <div class="col-12">
                    <label for="inputAddress" class="form-label"><strong>Mô tả tóm tắt sản phẩm <span class="text-danger">(*)</span></strong></label>
                    <textarea class="form-control" placeholder="Nhập mô tả" id="sp_MoTa" name="sp_MoTa" style="height: 100px;">{{ old('sp_MoTa', $product->sp_MoTa ?? '') }}</textarea>
                    @error ('sp_MoTa')
                        <span style="color: red;">{{ $message }}</span>
                    @enderror
                    <b class="form-text text-danger" id="descError"></b>
                </div>

                <div class="col-12">
                    <label for="inputAddress" class="form-label"><strong>Nội dung <span class="text-danger">(*)</span></strong></label>
                    <textarea class="form-control" placeholder="Nhập nội dung" id="sp_NoiDung" name="sp_NoiDung" style="height: 100px;">{{ old('sp_NoiDung', $product->sp_NoiDung ?? '') }}</textarea>
                    @error ('sp_NoiDung')
                        <span style="color: red;">{{ $message }}</span>
                    @enderror
                    <b class="form-text text-danger" id="contentError"></b>
                </div>


                <div class="field">
                    <button class="firstNext" id="next-1">TIẾP TỤC</button>
                </div>
            </div>

          <div class="page">
             <div class="pagetitle text-center">
                <h1 class="card-title"
                    style="border-bottom: 3px solid blue; display: inline-block; padding-bottom: 5px; "; >
                    CHI TIẾT SẢN PHẨM
                </h1>
                <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi thêm</p>
            </div>

            <div class="col-12">
                <label for="inputAddress" class="form-label"><strong>Chất liệu <span class="text-danger">(*)</span></strong></label>
                <textarea class="form-control" placeholder="Nhập nội dung chất liệu" id="sp_ChatLieu" name="sp_ChatLieu" style="height: 100px;">{{ old('sp_ChatLieu', $product->sp_ChatLieu ?? '') }}</textarea>
                <b class="form-text text-danger" id="materialError"></b>
            </div>

{{--            <div class="row">--}}
{{--                <div class="col-sm">--}}
{{--                    <label for="inputNanme4" class="form-label"><strong>Màu sắc <span class="text-danger">(*)</span></strong></label>--}}
{{--                    <input type="text" class="form-control" id="inputNanme4" name="sp_MauSac" placeholder="Nhập màu" value="{{ old('sp_MauSac', $request->sp_MauSac ?? '') }}">--}}
{{--                      @error ('sp_MauSac')--}}
{{--                          <span style="color: red;">{{ $message }}</span>--}}
{{--                      @enderror--}}
{{--                </div>--}}
{{--                <div class="col-sm">--}}
{{--                    <label for="inputNanme4" class="form-label"><strong>Kích cở <span class="text-danger">(*)</span></strong></label>--}}
{{--                    <input type="text" class="form-control" id="inputNanme4" name="sp_KichCo" placeholder="Nhập kích cở" value="{{ old('sp_KichCo', $request->sp_KichCo ?? '') }}">--}}
{{--                      @error ('sp_KichCo')--}}
{{--                          <span style="color: red;">{{ $message }}</span>--}}
{{--                      @enderror--}}
{{--                </div>--}}
{{--                <div class="col-sm">--}}
{{--                    <label for="inputNanme4" class="form-label"><strong>Tag <span class="text-danger">(*)</span></strong></label>--}}
{{--                    <input type="text" class="form-control" id="inputNanme4" name="sp_Tag" placeholder="Nhập tên" value="{{ old('sp_Tag', $request->sp_Tag ?? '') }}">--}}
{{--                      @error ('sp_Tag')--}}
{{--                          <span style="color: red;">{{ $message }}</span>--}}
{{--                      @enderror--}}
{{--                </div>--}}
{{--            </div>--}}

                <div class="row">
                    <div class="col-6">
                        <label for="" class="form-label"><strong>Ảnh đại diện <span class="text-danger">(*)</span></strong></label>
                        <input type="file" class="form-control" name="sp_AnhDaiDien" onchange="loadFile1(event)">
                        <b class="form-text text-danger" id="pictureError"></b>
                    </div>

                    <div class="col-6">
                        <label for="" class="form-label"><strong>Xem trước hình ảnh</strong></label>
                        <br>
                        <img id="output" src="{{ url('/storage/images/products/'.$product->sp_AnhDaiDien) }}" width="220px" height="170px">
                    </div>
                </div>

              <div class="col-sm">
                  <label for="inputNanme4" class="form-label"><strong>Video <span class="text-danger">(*)</span></strong></label>
                  <input type="text" class="form-control" id="sp_Video" name="sp_Video" placeholder="Copy đường link video vào đây" value="{{ old('sp_Video', $product->sp_Video ?? '') }}">
                  <b class="form-text text-danger" id="videoError"></b>
              </div>

             <div class="field btns">
                <button class="prev-1 prev">QUAY LẠI</button>
                <button class="next-1 next">TIẾP TỤC</button>
             </div>
          </div>




          <div class="page">
             <div class="pagetitle text-center">
                <h1 class="card-title"
                    style="border-bottom: 3px solid blue; display: inline-block; padding-bottom: 5px; "; >
                    HÌNH ẢNH SẢN PHẨM
                </h1>
                <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi thêm</p>
            </div>
              <div class="row">
                  @for ($i = 1; $i <= 2; $i++)
                      <div class="col-6">
                          <label for="" class="form-label">
                              <strong>Ảnh chi tiết {!! $i !!} <span class="text-danger">(*)</span></strong>
                          </label>
                          <input type="file" class="form-control" name="ha_AnhChiTiet[]" onchange="loadFile(event, {!! $i !!})">
                          <b class="form-text text-danger" ></b>
                          @if(isset($images[$i-1]))
                              <input type="hidden" name="ha_AnhChiTiet[{{ $i-1 }}]" value="{{ $images[$i-1]->ha_Ten }}">
                          @endif
                      </div>

                      <div class="col-6">
                          <label for="" class="form-label"><strong>Xem trước hình ảnh</strong></label>
                          <br>
                          @if(isset($images[$i-1]))
                              <img id="output{!! $i !!}" src="{{ asset('storage/images/product/detail/' . $images[$i-1]->ha_Ten) }}" width="220px" height="170px">
                          @else
                              <img id="output{!! $i !!}" width="220px" height="170px">
                          @endif
                      </div>
                  @endfor
              </div>

             <div class="field btns">
                <button class="prev-2 prev">QUAY LẠI</button>
                <button class="next-2 next">TIẾP TỤC</button>
             </div>
          </div>




          <div class="page">
             <div class="pagetitle text-center">
                <h1 class="card-title"
                    style="border-bottom: 3px solid blue; display: inline-block; padding-bottom: 5px; "; >
                    XÁC NHẬN
                </h1>
                <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi thêm</p>
            </div>
            <div class="col-12">

            </div>
             <div class="col-12">

              </div>
             <div class="field btns">
                <button class="prev-3 prev">QUAY LẠI</button>
                <button type="submit" class="submit">XÁC NHẬN</button>
             </div>
          </div>
          @csrf
       </form>
    </div>
 </div>

@endsection

@section('footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/template/back-end2/js/script.js"></script>
    <script>
        var loadFile1 = function(event){
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
    <script>
        var loadFile = function(event, i) {
            var output = document.getElementById('output' + i);
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>

@endsection
