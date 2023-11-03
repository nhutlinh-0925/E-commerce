@extends('back-end.main2')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Slider</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/sliders">Slider</a></li>
                <li class="breadcrumb-item active"><a href="">Thêm slider</a></li>
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
                    THÊM SLIDER
                </h1>
                <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi thêm</p>
            </div>
            <!-- Vertical Form -->
            <form class="row g-3" method="POST" enctype="multipart/form-data">
                <div class="col-12">
                    <label for="inputNanme4" class="form-label"><strong>Tiêu đề <span class="text-danger">(*)</span></strong></label>
                    <input type="text" class="form-control" id="inputNanme4" name="sl_TieuDe" placeholder="Nhập tiêu đề" value="{{ old('sl_TieuDe', $request->sl_TieuDe ?? '') }}">
                    @error ('sl_TieuDe')
                    <span style="color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="validationDefault04" class="form-label"><strong>Hiển thị <span class="text-danger">(*)</span></strong></label>
                    <select class="form-select" name="sl_TrangThai" id="validationDefault04" >
                        <option selected disabled value="">Lựa chọn</option>
                        <option value="1">Hiện thị</option>
                        <option value="0">Ẩn</option>
                    </select>
                    @error ('sl_TrangThai')
                    <span style="color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-6">
                        <label for="" class="form-label"><strong>Hình ảnh <span class="text-danger">(*)</span></strong></label>
                        <input type="file" class="form-control" id="" name="sl_HinhAnh" onchange="loadFile(event)">
                        @error ('sl_HinhAnh')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="" class="form-label"><strong>Xem trước hình ảnh</strong></label>
                        <br>
                        <img id="output" width="350px" height="170px">
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary" style="width: 10%;">Thêm</button>
                    <a href="/admin/sliders" class="btn btn-danger">Quay lại</a>
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
@endsection
