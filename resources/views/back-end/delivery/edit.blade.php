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
        <h1>Phí vận chuyển</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/deliveries">Phí vận chuyển</a></li>
                <li class="breadcrumb-item active"><a href="">Cập nhật phí vận chuyển</a></li>
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
                    CẬP NHẬT PHÍ VẬN CHUYỂN
                </h1>
                <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi cập nhật</p>
            </div>
            <!-- Vertical Form -->
            <form class="row g-3" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <label for="inputNanme4" class="form-label"><strong>Thành phố áp dụng <span class="text-danger">(*)</span></strong></label>
                        <input type="text" class="form-control" id="" name="" value="{{ old('pvc_ThanhPho', $delivery->pvc_ThanhPho) }}" disabled>
                    </div>
                    <input type="hidden" name="pvc_ThanhPho">
                    <input type="hidden" name="thanh_pho_id">
                    <div class="col-md-6">
                        <label for="inputNanme4" class="form-label"><strong>Phí vận chuyển <span class="text-danger">(*)</span></strong></label>
                        <input type="number" class="form-control" id="pvc_PhiVanChuyen" name="pvc_PhiVanChuyen" placeholder="Nhập phí vận chuyển" value="{{ old('pvc_PhiVanChuyen', $delivery->pvc_PhiVanChuyen ?? '') }}" min="0" max="100000">
                        @error ('pvc_PhiVanChuyen')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary" style="width: 12%;">Cập nhật</button>
                    <a href="/admin/deliveries" class="btn btn-danger" style="width: 12%;">Quay lại</a>
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
