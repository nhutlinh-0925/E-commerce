{{-- them san pham --}}
@extends('back-end.main2')

{{--  @section('head')
    <link rel="stylesheet" type="text/css" href="/template/back-end/vendors/flag-icon/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="/template/back-end/vendors/quill/katex.min.css">
    <link rel="stylesheet" type="text/css" href="/template/back-end/vendors/quill/monokai-sublime.min.css">
    <link rel="stylesheet" type="text/css" href="/template/back-end/vendors/quill/quill.snow.css">
    <link rel="stylesheet" type="text/css" href="/template/back-end/vendors/quill/quill.bubble.css">
@endsection  --}}

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="pagetitle text-center">
                <h1 class="card-title"
                    style="border-bottom: 3px solid blue; display: inline-block; padding-bottom: 5px; "; >
                    CẬP NHẬT DANH MỤC BÀI VIẾT
                </h1>
                <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi cập nhật</p>
            </div>
            <!-- Vertical Form -->
            <form class="row g-3" method="POST">
                <div class="col-12">
                    <label for="inputNanme4" class="form-label"><strong>Tên danh mục <span class="text-danger">(*)</span></strong></label>
                    <input type="text" class="form-control" id="inputNanme4" name="dmbv_TenDanhMuc" placeholder="Nhập tên" value="{{ old('dmbv_TenDanhMuc', $categoty_post->dmbv_TenDanhMuc ?? '') }}">
                    @error ('dmbv_TenDanhMuc')
                    <span style="color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="inputAddress" class="form-label"><strong>Mô tả danh mục <span class="text-danger">(*)</span></strong></label>
                    <textarea class="form-control" placeholder="Nhập mô tả" id="floatingTextarea" name="dmbv_MoTa" style="height: 100px;">{{ old('dmbv_MoTa', $categoty_post->dmbv_MoTa ?? '') }}</textarea>
                    @error ('dmbv_MoTa')
                    <span style="color: red;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="validationDefault04" class="form-label"><strong>Hiển thị <span class="text-danger">(*)</span></strong></label>
                    <select class="form-select" name="dmbv_TrangThai" id="validationDefault04" >

                        <option selected disabled value="">Lựa chọn</option>
                        <option value="1" {{ $categoty_post->dmbv_TrangThai == '1' ? 'selected' : '' }}>
                            Hiển thị
                        </option>
                        <option value="0" {{ $categoty_post->dmbv_TrangThai == '0' ? 'selected' : '' }}>
                            Ẩn
                        </option>
                    </select>
                    @error ('dmbv_TrangThai')
                    <span style="color: red;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" style="width: 11%;">Cập nhật</button>
                    <a href="/admin/category-posts" class="btn btn-danger">Quay lại</a>
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
