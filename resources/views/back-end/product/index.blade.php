@extends('back-end.main2')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Sản phẩm</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/admin/products">Sản phẩm</a></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    @if(Session::has('flash_message'))
        <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show text-center" role="alert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            {!! session('flash_message') !!}
        </div>

    @elseif(Session::has('flash_message_error'))
        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show text-center" role="alert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            {!! session('flash_message_error') !!}
        </div>

    @endif
<section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <div class="pagetitle text-center">
                <h1 class="card-title"
                    style="border-bottom: 3px solid blue; display: inline-block; padding-bottom: 5px; "; >
                    SẢN PHẨM
                </h1>

            </div>
            <section>
                <a href="{{ url('/admin/products/add') }}" class="btn btn-primary btn-sm"> <i class="bi bi-plus-lg"></i>Thêm sản phẩm</a>
              </section>

            <!-- Table with stripped rows -->
            <table class="table datatable">
              <thead>
                <tr>
                  <th scope="col"><p style="text-align: center;">ID</th>
                  <th scope="col"><p style="text-align: center;">Tên sản phẩm</p></th>
                  <th scope="col"><p style="text-align: center;">Hình</p></th>
                  <th scope="col"><p style="text-align: center;">Giá</p></th>
                  <th scope="col"><p style="text-align: center;">Danh mục<p></th>
                  <th scope="col"><p style="text-align: center;">Số lượng</p></th>
                  <th scope="col"><p style="text-align: center;">Thương hiệu</p></th>
                  <th scope="col"><p style="text-align: center;">Trạng thái</p></th>
                  <th scope="col"><p style="text-align: center;">Tùy biến</p></th>
                </tr>
              </thead>
              <tbody>
                @foreach($products as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td><p style="width: 100px">{{ $item->sp_TenSanPham }}</p></td>
                    {{--  <td>a</td>  --}}

                    <td><img src="{{ url('/storage/images/products/'.$item->sp_AnhDaiDien) }}" height="100px" width="100px"></td>
                    <td><p style="text-align: center;color: red;width: 90px"><b>{{ number_format($item->sp_Gia, 0, '', '.') }} đ</b></p></td>
                    <td><p style="text-align: center;">{{ $item->danhmuc->dmsp_TenDanhMuc }}</p></td>
                    <td><p style="text-align: center;">
                            {{ $item->sanphamkichthuoc->sum('spkt_soLuongHang') }}
                        </p></td>
                    <td><p style="text-align: center;">{{ $item->thuonghieu->thsp_TenThuongHieu }}</p></td>
{{--                    <td><p style="width: 100px">{{ $item->sp_MoTa }}</p></td>--}}
                    <td>
                        @if ($item->sp_TrangThai == 0)
                            <p style="color: red"><b>Ẩn</b></p>
                        @elseif($item->sp_TrangThai == 1)
                            <p style="color: green"><b>Hiện</b></p>
                        @endif
                    </td>
                    <td style="display: flex;">
                        <p style="width: 70px">
                        @if ($item->sp_TrangThai == 1)
                            <a href="{{ url('/admin/products/edit/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Cập nhật sản phẩm"><i class="bi bi-pencil-square"></i></a>
                            <a href="/admin/products/unactive/{{ $item->id }}" class="btn btn-primary btn-sm" title="Ẩn sản phẩm" onclick ='return confirm("Bạn chắc chắn muốn ẩn sản phẩm?")'><span class="bi bi-eye-slash"></span></a>
                        @elseif ($item->sp_TrangThai == 0)
                            <a href="{{ url('/admin/products/edit/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Cập nhật sản phẩm"><i class="bi bi-pencil-square"></i></a>
                            <a href="/admin/products/active/{{ $item->id }}" class="btn btn-danger btn-sm" title="Hiện sản phẩm" onclick ='return confirm("Bạn chắc chắn muốn hiện sản phẩm?")'><span class="bi bi-eye"></span></a>
                        @endif
                        </p>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <!-- End Table with stripped rows -->

          </div>
        </div>

      </div>
    </div>
  </section>
@endsection
