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
                  <th scope="col"><p style="text-align: center;">ID</th>
                  <th scope="col"><p style="text-align: center;">Tên sản phẩm</p></th>
                  <th scope="col"><p style="text-align: center;">Hình</p></th>
                  <th scope="col"><p style="text-align: center;">Giá</p></th>
                  <th scope="col"><p style="text-align: center;">Danh mục sản phẩm<p></th>
                  <th scope="col"><p style="text-align: center;">Số lượng hàng</p></th>
                  <th scope="col"><p style="text-align: center;">Thương hiệu</p></th>
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
                    <td><p style="text-align: center;color: red;"><b>{{ number_format($item->sp_Gia, 0, '', '.') }} đ</b></p></td>
                    <td><p style="text-align: center;">{{ $item->danhmuc->dmsp_TenDanhMuc }}</p></td>
                    <td><p style="text-align: center;">{{ $item->sp_SoLuongHang }}</p></td>
                    <td><p style="text-align: center;">{{ $item->thuonghieu->thsp_TenThuongHieu }}</p></td>
{{--                    <td><p style="width: 100px">{{ $item->sp_MoTa }}</p></td>--}}

                    <td style="display: flex">
{{--                        <form method="post" action="{{ url('/admin/products/destroy/' .$item->id  ) }}">--}}
{{--                            <a href="" class="btn btn-primary btn-sm" title="Xem thông tin sản phẩm"><i class="bi bi-eye-fill"></i></a>--}}
                            <a href="{{ url('/admin/products/edit/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Cập nhật sản phẩm"><i class="bi bi-pencil-square"></i></a>
{{--                            @method('delete')--}}
{{--                            @csrf--}}
{{--                        <button type="submit" class="btn btn-danger btn-sm" title = 'Xóa sản phẩm'--}}
{{--                                 data-toggle = 'tooltip'--}}
{{--                                 onclick ='return confirm("Bạn chắc chắn muốn xóa?")'>--}}
{{--                                 <i class="bi bi-trash-fill"></i>--}}
{{--                        </button>--}}
{{--                      </form>--}}
{{--                        <form method="post" action="{{ url('/admin/products/destroy/' .$item->id  ) }}">--}}
{{--                            <a href="" class="btn btn-primary btn-sm" title="Xem thông tin sản phẩm"><i class="bi bi-eye-fill"></i></a>--}}
{{--                            <a href="{{ url('/admin/products/edit/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Cập nhật sản phẩm"><i class="bi bi-pencil-square"></i></a>--}}
{{--                            @method('delete')--}}
{{--                            @csrf--}}
{{--                            <button type="submit" class="btn btn-danger btn-sm" title = 'Xóa sản phẩm'--}}
{{--                                    data-toggle = 'tooltip'--}}
{{--                                    onclick ='return confirm("Bạn chắc chắn muốn xóa?")'>--}}
{{--                                <i class="bi bi-trash-fill"></i>--}}
{{--                            </button>--}}
{{--                        </form>--}}
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
