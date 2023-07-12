@extends('back-end.main2')

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
                  <th scope="col">ID</th>
                  <th scope="col">Tên sản phẩm</th>
                  <th scope="col">Hình</th>
                  <th scope="col">Giá</th>
                  <th scope="col">Danh mục sản phẩm</th>
                  <th scope="col">Số lượng hàng</th>
                  <th scope="col">Thương hiệu</th>
                  <th scope="col">Mô tả</th>
                  {{--  <th scope="col">Nội dung</th>  --}}
                  {{--  <th scope="col">Vật liệu</th>  --}}
                  <th scope="col">Tùy biến</th>
                </tr>
              </thead>
              <tbody>
                @foreach($products as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->sp_TenSanPham }}</td>
                    {{--  <td>a</td>  --}}

                    <td><img src="{{ url('/storage/images/products/'.$item->sp_AnhDaiDien) }}" height="100px" width="100px"></td>
                    <td>{{ $item->sp_Gia }}</td>
                    <td>{{ $item->danhmuc->dmsp_TenDanhMuc }}</td>
                    <td>{{ $item->sp_SoLuongHang }}</td>
                    <td>{{ $item->thuonghieu->thsp_TenThuongHieu }}</td>
                    <td>{{ $item->sp_MoTa }}</td>
                    {{--  <td>{{ $item->sp_NoiDung }}</td>  --}}
                    {{--  <td>{{ $item->sp_VatLieu }}</td>  --}}

                    <td style="display: flex">
                        {{--  <form method="post" action="">  --}}
                        {{--  <a href="" class="btn btn-primary btn-sm" title="Xem thông tin danh mục"><i class="bi bi-eye-fill"></i></a>  --}}
                        {{--  <a href="{{ url('/admin/category-products/edit/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Cập nhật danh mục"><i class="bi bi-pencil-square"></i></a>  --}}
                        <a href="{{ url('/admin/products/edit/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Cập nhật danh mục"><i class="bi bi-pencil-square"></i></a>

                        {{--  @method('delete')
                        @csrf  --}}
                        {{--  <button type="submit" class="btn btn-danger btn-sm" title = 'Xóa danh mục'
                                                data-toggle = 'tooltip'
                                                onclick ='return confirm("Bạn chắc chắn muốn xóa?")'>
                                                <i class="bi bi-trash-fill"></i>
                        </button>  --}}
                    {{--  </form>  --}}
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
