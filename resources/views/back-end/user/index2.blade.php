@extends('back-end.main2')

@section('head')
<link rel="stylesheet" href="/template/back-end2/datatable/css/bootstrap.min.css">
<link rel="stylesheet" href="/template/back-end2/datatable/css/datatables.min.css">
<link rel="stylesheet" href="/template/back-end2/datatable/css/style.css">
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
                    KHÁCH HÀNG
                </h1>

            </div>
            {{--  <section>
                <a href="{{ url('/admin/brands/add') }}" class="btn btn-primary btn-sm"> <i class="bi bi-plus-lg"></i>Thêm thương hiệu</a>
              </section>  --}}

            <!-- Table with stripped rows -->
            {{--  <div class="container">  --}}
        <div class="row">
            <div class="col-12">
                <div class="data_table">
                    <table id="example" class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên thương hiệu</th>
                                <th scope="col">Mô tả thương hiệu</th>
                                <th scope="col">Hiển thị</th>
                                <th scope="col">Tùy biến</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($brands as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->thsp_TenThuongHieu }}</td>
                                <td>{{ $item->thsp_MoTa }}</td>
                                <td>
                                    @if ($item->thsp_TrangThai == 0)
                                    <form method="post" action="{{ url('/admin/brands/unactive/' . $item->id ) }}">
                                        @method('post')
                                        @csrf
                                        <div class="toggle-button-cover">
                                            <div id="button-3" class="button r">
                                            <button type="submit" class="btn btn-light btn-sm"
                                                data-toggle = 'tooltip'
                                                onclick ='return confirm("Bạn chắc chắn muốn hiện thương hiệu không?")'>
                                                    <input class="checkbox" type="checkbox" checked>
                                                    <div class="knobs"></div>
                                                    <div class="layer"></div>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    @else
                                    <form method="post" action="{{ url('/admin/brands/active/' . $item->id ) }}">
                                        @method('post')
                                        @csrf
                                        <div class="toggle-button-cover">
                                          <div id="button-3" class="button r">
                                            <button type="submit" class="btn btn-light btn-sm"
                                              data-toggle = 'tooltip'
                                              onclick ='return confirm("Bạn chắc chắn muốn ẩn thương hiệu không?")'>
                                              <input class="checkbox" type="checkbox">
                                              <div class="knobs"></div>
                                              <div class="layer"></div>
                                            </button>
                                          </div>
                                        </div>
                                      </form>
                                    @endif
                                  </td>
                                <td style="display: flex">
                                    <form method="post" action="{{ url('/admin/brands/destroy/' .$item->id  ) }}">
                                        <a href="{{ url('/admin/brands/edit/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Cập nhật thương hiệu"><i class="bi bi-pencil-square"></i></a>
                                          @method('delete')
                                          @csrf
                                          <button type="submit" class="btn btn-danger btn-sm" title = 'Xóa thương hiệu'
                                              data-toggle = 'tooltip'
                                              onclick ='return confirm("Bạn chắc chắn muốn xóa?")'>
                                               <i class="bi bi-trash-fill"></i>
                                          </button>
                                      </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    {{--  </div>  --}}
            <!-- End Table with stripped rows -->

          </div>
        </div>

      </div>
    </div>
  </section>


@endsection

@section('footer')

<script src="/template/back-end2/datatable/js/bootstrap.bundle.min.js"></script>
<script src="/template/back-end2/datatable/js/jquery-3.6.0.min.js"></script>
<script src="/template/back-end2/datatable/js/datatables.min.js"></script>
<script src="/template/back-end2/datatable/js/pdfmake.min.js"></script>
<script src="/template/back-end2/datatable/js/vfs_fonts.js"></script>
<script src="/template/back-end2/datatable/js/custom.js"></script>
@endsection
