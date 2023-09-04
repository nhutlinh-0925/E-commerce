{{-- them san pham --}}
@extends('back-end.main2')

@section('head')
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}
    <link rel="stylesheet" href="/template/back-end2/css/bootstrap-tagsinput.css">
@endsection

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Bài viết</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/posts">Bài viết</a></li>
                <li class="breadcrumb-item active"><a href="">Cập nhật bài viết</a></li>
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
                    CẬP NHẬT BÀI VIẾT
                </h1>
                <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi cập nhật</p>
            </div>
            <!-- Vertical Form -->
            <form class="row g-3" method="POST" enctype="multipart/form-data">
                <div class="col-12">
                    <label for="inputNanme4" class="form-label"><strong>Tiêu đề bài viết <span class="text-danger">(*)</span></strong></label>
                    <input type="text" class="form-control" id="inputNanme4" name="bv_TieuDeBaiViet" placeholder="Nhập tiêu đề" value="{{ old('bv_TieuDeBaiViet', $post->bv_TieuDeBaiViet ?? '') }}">
                    @error ('bv_TieuDeBaiViet')
                    <span style="color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="inputAddress" class="form-label"><strong>Mô tả ngắn bài viết <span class="text-danger">(*)</span></strong></label>
                    <textarea class="form-control" placeholder="Nhập mô tả ngắn" id="" name="bv_NoiDungNgan" style="height: 100px;">{{ old('bv_NoiDungNgan', $post->bv_NoiDungNgan ?? '') }}</textarea>
                    @error ('bv_NoiDungNgan')
                    <span style="color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="inputAddress" class="form-label"><strong>Mô tả chi tiết bài viết <span class="text-danger">(*)</span></strong></label>
                    <textarea class="form-control" placeholder="Nhập mô tả chi tiết" id="" name="bv_NoiDungChiTiet" style="height: 100px;">{{ old('bv_NoiDungChiTiet', $post->bv_NoiDungChiTiet ?? '') }}</textarea>
                    @error ('bv_NoiDungChiTiet')
                    <span style="color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-9">
                        <label for="inputNanme4" class="form-label"><strong>Danh mục bài viết <span class="text-danger">(*)</span></strong></label>
                        <select class="form-control" name="danh_muc_bai_viet_id" id="">
                            <option value="">--- Chọn Danh Mục ---</option>
                            @foreach ($category_posts as $category_post)
                                <option value="{{ $category_post->id }}" {{ isset($post->danh_muc_bai_viet_id) && $post->danh_muc_bai_viet_id == $category_post->id ? 'selected' : '' }}>{{ $category_post->dmbv_TenDanhMuc }}</option>
                            @endforeach

                        </select>
                        @error ('danh_muc_bai_viet_id')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="validationDefault04" class="form-label"><strong>Hiển thị <span class="text-danger">(*)</span></strong></label>
                        <select class="form-select" name="bv_TrangThai" id="validationDefault04" >
                            <option selected disabled value="">Lựa chọn</option>
                            <option value="1" {{ $post->bv_TrangThai == '1' ? 'selected' : '' }}>
                                Hiển thị
                            </option>
                            <option value="0" {{ $post->bv_TrangThai == '0' ? 'selected' : '' }}>
                                Ẩn
                            </option>
                        </select>
                        @error ('bv_TrangThai')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <br><br>

                    <div class="col-12">
                        <label for="inputAddress" class="form-label"><strong>Tags <span class="text-danger">(*)</span></strong></label>
                        <input type="text" class="form-control" data-role="tagsinput" id="" name="bv_Tag" value="{{ old('bv_Tag', $post->bv_Tag ?? '') }}">

                    </div>
                    @error ('bv_Tag')
                    <span style="color: red;">{{ $message }}</span>
                    @enderror

                <div class="row">
                    <div class="col-6">
                        <label for="" class="form-label"><strong>Ảnh đại diện <span class="text-danger">(*)</span></strong></label>
                        <input type="file" class="form-control" id="" name="bv_AnhDaiDien" onchange="loadFile(event)">
                        @error ('bv_AnhDaiDien')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="" class="form-label"><strong>Xem trước hình ảnh</strong></label>
                        <br>
                        <img id="output" src="{{ url('/storage/images/posts/'.$post->bv_AnhDaiDien) }}" width="220px" height="170px">
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary" style="width: 11%;">Cập nhật</button>
                    <a href="/admin/posts" class="btn btn-danger">Quay lại</a>
                </div>
                @csrf
            </form><!-- Vertical Form -->

        </div>
    </div>

@endsection

@section('footer')
    <script>
        var loadFile = function(event){
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/template/back-end2/js/bootstrap-tagsinput.min.js"></script>
@endsection
