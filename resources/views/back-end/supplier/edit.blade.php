@extends('back-end.main2')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Nhà cung cấp</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/suppliers">Nhà cung cấp</a></li>
                <li class="breadcrumb-item active"><a href="">Cập nhật nhà cung cấp</a></li>
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
                    CẬP NHẬT NHÀ CUNG CẤP
                </h1>
                <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi cập nhật</p>
            </div>
            <!-- Vertical Form -->
            <form class="row g-3" method="POST">
                <div class="row">
                    <div class="col-12">
                        <label for="inputNanme4" class="form-label"><strong>Tên nhà cung cấp <span class="text-danger">(*)</span></strong></label>
                        <input type="text" class="form-control" id="inputNanme4" name="ncc_TenNhaCungCap" placeholder="Nhập tên" value="{{ old('ncc_TenNhaCungCap', $supplier->ncc_TenNhaCungCap ?? '') }}">
                        @error ('ncc_TenNhaCungCap')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="inputNanme4" class="form-label"><strong>Email <span class="text-danger">(*)</span></strong></label>
                        <input type="text" class="form-control" id="" name="ncc_Email" placeholder="Nhập email" value="{{ old('ncc_Email', $supplier->ncc_Email ?? '') }}">
                        @error ('ncc_Email')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="inputNanme4" class="form-label"><strong>Số điện thoại <span class="text-danger">(*)</span></strong></label>
                        <input type="text" class="form-control" id="" name="ncc_SoDienThoai" placeholder="Nhập số điện thoại" value="{{ old('ncc_SoDienThoai', $supplier->ncc_SoDienThoai ?? '') }}">
                        @error ('ncc_SoDienThoai')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror

                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="inputAddress" class="form-label"><strong>Địa chỉ <span class="text-danger">(*)</span></strong></label>
                        <input type="text" class="form-control" id="" name="ncc_DiaChi" placeholder="Nhập địa chỉ" value="{{ old('ncc_DiaChi', $supplier->ncc_DiaChi ?? '') }}">
                        @error ('ncc_DiaChi')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="validationDefault04" class="form-label"><strong>Trạng thái <span class="text-danger">(*)</span></strong></label>
                        <select class="form-select" name="ncc_TrangThai" id="validationDefault04" >
                            <option selected disabled value="">Lựa chọn</option>
                            <option value="1" {{ $supplier->ncc_TrangThai == '1' ? 'selected' : '' }}>
                                Đang hợp tác
                            </option>
                            <option value="0" {{ $supplier->ncc_TrangThai == '0' ? 'selected' : '' }}>
                                Ngừng hợp tác
                            </option>
                        </select>
                        @error ('ncc_TrangThai')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary" style="width: 11%;">Cập nhật</button>
                    <a href="/admin/suppliers" class="btn btn-danger">Quay lại</a>
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
