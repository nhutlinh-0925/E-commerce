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
                <li class="breadcrumb-item active"><a href="">Thêm phí vận chuyển</a></li>
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
                    THÊM PHÍ VẬN CHUYỂN
                </h1>
                <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi thêm</p>
            </div>
            <!-- Vertical Form -->
            <form class="row g-3" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <label for="inputNanme4" class="form-label"><strong>Thành phố áp dụng <span class="text-danger">(*)</span></strong></label>
                        <select class="form-control" name="thanh_pho_id" id="thanh_pho_id">
                            <option value="">--- Chọn Thành phố ---</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" >{{ $city->tp_Ten }}</option>
                            @endforeach
                        </select>
                        @error ('thanh_pho_id')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                    <input type="hidden" name="pvc_ThanhPho">
                    <div class="col-md-6">
                        <label for="inputNanme4" class="form-label"><strong>Phí vận chuyển <span class="text-danger">(*)</span></strong></label>
                        <input type="number" class="form-control" id="pvc_PhiVanChuyen" name="pvc_PhiVanChuyen" placeholder="Nhập phí vận chuyển" value="{{ old('pvc_PhiVanChuyen', $request->pvc_PhiVanChuyen ?? '') }}" min="0" max="100000">
                        @error ('pvc_PhiVanChuyen')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary" style="width: 10%;">Thêm</button>
                    <a href="/admin/deliveries" class="btn btn-danger">Quay lại</a>
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
