{{-- them san pham --}}
@extends('back-end.main2')

{{--  @section('head')
    <link rel="stylesheet" type="text/css" href="/template/back-end/vendors/flag-icon/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="/template/back-end/vendors/quill/katex.min.css">
    <link rel="stylesheet" type="text/css" href="/template/back-end/vendors/quill/monokai-sublime.min.css">
    <link rel="stylesheet" type="text/css" href="/template/back-end/vendors/quill/quill.snow.css">
    <link rel="stylesheet" type="text/css" href="/template/back-end/vendors/quill/quill.bubble.css">
@endsection  --}}

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Mã giảm giá</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/coupons">Mã giảm giá</a></li>
                <li class="breadcrumb-item active"><a href="">Cập nhật mã giảm giá</a></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="pagetitle text-center">
                <h1 class="card-title"
                    style="border-bottom: 3px solid blue; display: inline-block; padding-bottom: 5px; "; >
                    CẬP NHẬT MÃ GIẢM GIÁ
                </h1>
                <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi cập nhật</p>
            </div>
            <!-- Vertical Form -->
            <form class="row g-3" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <label for="inputNanme4" class="form-label"><strong>Tên mã giảm giá <span class="text-danger">(*)</span></strong></label>
                        <input type="text" class="form-control" id="mgg_TenGiamGia" name="mgg_TenGiamGia" placeholder="Nhập tên mã giảm giá" value="{{ old('mgg_TenGiamGia', $coupon->mgg_TenGiamGia ?? '') }}">
                        @error ('mgg_TenGiamGia')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="inputNanme4" class="form-label"><strong>Mã giảm giá <span class="text-danger">(*)</span></strong></label>
                        <input type="text" class="form-control" id="mgg_MaGiamGia" name="mgg_MaGiamGia" placeholder="Nhập mã giảm giá" value="{{ old('mgg_MaGiamGia', $coupon->mgg_MaGiamGia ?? '') }}">
                        @error ('mgg_MaGiamGia')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div><br><br><br><br>

                <div class="row">
                    <div class="col-md-6">
                        <label for="inputNanme4" class="form-label"><strong>Số lượng mã <span class="text-danger">(*)</span></strong></label>
                        <input type="number" class="form-control" id="mgg_SoLuongMa" name="mgg_SoLuongMa" placeholder="Nhập số lượng mã giảm giá" value="{{ old('mgg_SoLuongMa', $coupon->mgg_SoLuongMa ?? '') }}">
                        @error ('mgg_SoLuongMa')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="inputNanme4" class="form-label"><strong>Loại giảm giá <span class="text-danger">(*)</span></strong></label>
                        <select class="form-control" name="mgg_LoaiGiamGia" id="mgg_LoaiGiamGia">
                            <option selected disabled value="">Chọn Loại Giảm Giá </option>
                            <option value="1" {{ $coupon->mgg_LoaiGiamGia == '1' ? 'selected' : '' }}>
                                Giảm theo tiền
                            </option>
                            <option value="2" {{ $coupon->mgg_LoaiGiamGia == '2' ? 'selected' : '' }}>
                                Giảm theo phần trăm
                            </option>
                        </select>
                        @error ('mgg_LoaiGiamGia')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div><br><br><br><br>

                <div class="row">
                    <div class="col-md-6">
                        <label for="inputNanme4" class="form-label"><strong>Ngày bắt đầu <span class="text-danger">(*)</span></strong></label>
                        <input type="datetime-local" class="form-control" id="mgg_NgayBatDau" name="mgg_NgayBatDau" placeholder="Chọn ngày bắt đầu" value="{{ old('mgg_NgayBatDau', $coupon->mgg_NgayBatDau ?? '') }}">
                        @error ('mgg_NgayBatDau')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="inputNanme4" class="form-label"><strong>Ngày kết thúc <span class="text-danger">(*)</span></strong></label>
                        <input type="datetime-local" class="form-control" id="mgg_NgayKetThuc" name="mgg_NgayKetThuc" placeholder="Chọn ngày hết hạn" value="{{ old('mgg_NgayKetThuc', $coupon->mgg_NgayKetThuc ?? '') }}">
                        @error ('mgg_NgayKetThuc')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div><br><br><br><br>

                <div class="row">
                    <div class="col-md-4">
                        <label for="inputNanme4" class="form-label"><strong>Giá trị <span class="text-danger">(*)</span></strong></label>
                        <input type="number" class="form-control" id="mgg_GiaTri" name="mgg_GiaTri" placeholder="Nhập giá trị giảm" value="{{ old('mgg_GiaTri', $coupon->mgg_GiaTri ?? '') }}" max="500000" min="1">
                        @error ('mgg_GiaTri')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="inputNanme4" class="form-label"><strong>Đơn tối thiểu <span class="text-danger">(*)</span></strong></label>
                        <input type="number" class="form-control" id="mgg_DonToiThieu" name="mgg_DonToiThieu" placeholder="Nhập đơn tối thiểu" value="{{ old('mgg_DonToiThieu', $coupon->mgg_DonToiThieu ?? '') }}" max="5000000" min="1000000">
                        @error ('mgg_DonToiThieu')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="inputNanme4" class="form-label"><strong>Giảm tối đa <span class="text-danger">(*)</span></strong></label>
                        <input type="number" class="form-control" id="mgg_GiamToiDa" name="mgg_GiamToiDa" placeholder="Nhập giảm tối đa" value="{{ old('mgg_GiamToiDa', $coupon->mgg_GiamToiDa ?? '') }}" max="750000" min="50000">
                        @error ('mgg_GiamToiDa')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary" style="width: 12%;">Cập nhật</button>
                    <a href="/admin/coupons" class="btn btn-danger" style="width: 12%;">Quay lại</a>
                </div>
                @csrf
            </form><!-- Vertical Form -->

        </div>
    </div>

@endsection

{{--  @section('footer')
  <script>
    CKEDITOR.replace('content');
  </script>
@endsection  --}}
