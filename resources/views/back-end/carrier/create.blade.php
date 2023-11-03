@extends('back-end.main2')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Người giao hàng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/carriers">Người giao hàng</a></li>
                <li class="breadcrumb-item active"><a href="">Thêm người giao hàng</a></li>
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
                    THÊM NGƯỜI GIAO HÀNG
                </h1>
                <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi thêm</p>
            </div>
            <!-- Vertical Form -->
            <form class="row g-3" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <label for="inputName4" class="form-label"><strong>Họ tên nhân viên <span class="text-danger">(*)</span></strong></label>
                        <input type="text" class="form-control" id="" name="ngh_Ten" placeholder="Nhập tên người giao hàng" value="{{ old('ngh_Ten', $request->ngh_Ten ?? '') }}">
                        @error ('ngh_Ten')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="inputName4" class="form-label"><strong>Email <span class="text-danger">(*)</span></strong></label>
                        <input type="text" class="form-control" id="" name="email" placeholder="Nhập email" value="{{ old('email', $request->email ?? '') }}">
                        @error ('email')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="inputNanme4" class="form-label"><strong>Địa chỉ <span class="text-danger">(*)</span></strong></label>
                        <input type="text" class="form-control" id="" name="ngh_DiaChi" placeholder="Nhập địa chỉ cụ thể" value="{{ old('ngh_DiaChi', $request->ngh_DiaChi ?? '') }}">
                        @error ('ngh_DiaChi')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="inputNanme4" class="form-label"><strong>Mật khẩu <span class="text-danger">(*)</span></strong></label>
                        <input type="password" class="form-control" id="" name="password" placeholder="Nhập mật khẩu">
                        @error ('password')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="inputNanme4" class="form-label"><strong>Nhập lại mật khẩu <span class="text-danger">(*)</span></strong></label>
                        <input type="password" class="form-control" id="" name="password_again" placeholder="Nhập lại mật khẩu">
                        @error ('password_again')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="inputName4" class="form-label"><strong>Số điện thoại <span class="text-danger">(*)</span></strong></label>
                        <input type="text" class="form-control" id="" name="ngh_SoDienThoai" placeholder="Nhập số điện thoại" value="{{ old('ngh_SoDienThoai', $request->ngh_SoDienThoai ?? '') }}">
                        @error ('ngh_SoDienThoai')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="inputNanme4" class="form-label"><strong>Trạng thái <span class="text-danger">(*)</span></strong></label>
                        <select class="form-select" name="trangthai" id="" >
                            <option selected disabled value="">Lựa chọn</option>
                            <option value="1">Hoạt động</option>
                            <option value="0">Khóa</option>
                        </select>
                        @error ('trangthai')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <label for="" class="form-label"><strong>Ảnh đại diện <span class="text-danger">(*)</span></strong></label>
                        <input type="file" class="form-control" id="" name="avatar" onchange="loadFile(event)">
                        @error ('avatar')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="" class="form-label"><strong>Xem trước hình ảnh</strong></label>
                        <br>
                        <img id="output" width="220px" height="170px">
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary" style="width: 10%;">Thêm</button>
                    <a href="/admin/carriers" class="btn btn-danger">Quay lại</a>
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
@endsection


