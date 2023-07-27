@extends('back-end.main2')

@section('content')
        <div class="card">
            <div class="card-body">
                <div class="pagetitle text-center">
                    <h1 class="card-title"
                        style="border-bottom: 3px solid blue; display: inline-block; padding-bottom: 5px; "; >
                        THÊM NHÂN VIÊN
                    </h1>
                    <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi thêm</p>
                </div>
                <!-- Vertical Form -->
                <form class="row g-3" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputName4" class="form-label"><strong>Họ tên nhân viên <span class="text-danger">(*)</span></strong></label>
                            <input type="text" class="form-control" id="" name="nv_Ten" placeholder="Nhập tên nhân viên" value="{{ old('nv_Ten', $request->nv_Ten ?? '') }}">
                            @error ('nv_Ten')
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
                            <input type="text" class="form-control" id="" name="nv_DiaChi" placeholder="Nhập địa chỉ cụ thể" value="{{ old('nv_DiaChi', $request->nv_DiaChi ?? '') }}">
                            @error ('nv_DiaChi')
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
                            <input type="text" class="form-control" id="" name="nv_SoDienThoai" placeholder="Nhập số điện thoại" value="{{ old('nv_SoDienThoai', $request->nv_SoDienThoai ?? '') }}">
                            @error ('nv_SoDienThoai')
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
                        <button type="reset" class="btn btn-danger" style="width: 10%;">Hủy</button>
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


