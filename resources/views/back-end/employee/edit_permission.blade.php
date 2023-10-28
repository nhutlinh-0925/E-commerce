@extends('back-end.main2')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Phân quyền</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/employees/permissions">Phân quyền</a></li>
                <li class="breadcrumb-item active"><a href="">Thay đổi quyền</a></li>
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
                    THAY ĐỔI QUYỀN
                </h1>
                <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi thay đổi</p>
            </div>
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
            <section class="content">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-5"></div>
                                                <div class="col-7">
                                                    <form>
                                                        <div class="row mb-3">
                                                            <label for="" class="col-lg-3 col-form-label"><b>Email:</b></label>
                                                            <div class="col-lg-9">
                                                                <input name="" type="" class="form-control" id="" value="{{$id_nv = Auth('admin')->user()->email}}" disabled>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="" class="col-lg-3 col-form-label"><b>Họ và tên:</b></label>
                                                            <div class="col-lg-9">
                                                                <input name="" type="" class="form-control" id="" value="{{ $employee->nv_Ten }}" disabled>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <table class="table table-bordered" style="">
                                                    <thead style="text-align: center;">
                                                    <tr role="row" style="background-color: #1E90FF; color: white">
                                                        <th>Quyền Đơn Hàng</th>
                                                        <th>Quyền Sản Phẩm</th>
                                                        <th>Quyền Nhân Sự</th>
                                                        <th>Quyền Bài Viết</th>
                                                        <th>Quyền Nhập Kho</th>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td style="text-align: center;">
                                                            @php $donhangQuyen = $employee->chitietquyen->where('quyen_id', 1)->first() @endphp
                                                            @if ($donhangQuyen)
                                                                @if ($donhangQuyen->ctq_CoQuyen == 1)
                                                                    <a href="/admin/employees/auth/{{ $donhangQuyen->id }}" onclick='return confirm("Bạn chắc chắn muốn hủy trao quyền?")'>
                                                                        <span class="bi bi-check2" style="font-size: 28px; color: blue; font-weight: bold"></span>
                                                                    </a>
                                                                @else
                                                                    <a href="/admin/employees/unauth/{{ $donhangQuyen->id }}" onclick='return confirm("Bạn chắc chắn muốn trao quyền?")'>
                                                                        <span class="bi bi-dash-circle" class="bi bi-lock" style="font-size: 25px; color: red; font-weight: bold"></span>
                                                                    </a>
                                                                @endif
                                                            @else
                                                                Không xác định
                                                            @endif
                                                        </td>
                                                        <td style="text-align: center;">
                                                            @php $sanphamQuyen = $employee->chitietquyen->where('quyen_id', 2)->first() @endphp
                                                            @if ($sanphamQuyen)
                                                                @if ($sanphamQuyen->ctq_CoQuyen == 1)
                                                                    <a href="/admin/employees/auth/{{ $sanphamQuyen->id }}" onclick='return confirm("Bạn chắc chắn muốn hủy trao quyền?")'>
                                                                        <span class="bi bi-check2" style="font-size: 28px; color: blue; font-weight: bold"></span>
                                                                    </a>
                                                                @else
                                                                    <a href="/admin/employees/unauth/{{ $sanphamQuyen->id }}" onclick='return confirm("Bạn chắc chắn muốn trao quyền?")'>
                                                                        <span class="bi bi-dash-circle" class="bi bi-lock" style="font-size: 25px; color: red; font-weight: bold"></span>
                                                                    </a>
                                                                @endif
                                                            @else
                                                                Không xác định
                                                            @endif
                                                        </td>
                                                        <td style="text-align: center;">
                                                            @php $nhansuQuyen = $employee->chitietquyen->where('quyen_id', 3)->first() @endphp
                                                            @if ($nhansuQuyen)
                                                                @if ($nhansuQuyen->ctq_CoQuyen == 1)
                                                                    <a href="/admin/employees/auth/{{ $nhansuQuyen->id }}" onclick='return confirm("Bạn chắc chắn muốn hủy trao quyền?")'>
                                                                        <span class="bi bi-check2" style="font-size: 28px; color: blue; font-weight: bold"></span>
                                                                    </a>
                                                                @else
                                                                    <a href="/admin/employees/unauth/{{ $nhansuQuyen->id }}" onclick='return confirm("Bạn chắc chắn muốn trao quyền?")'>
                                                                        <span class="bi bi-dash-circle" class="bi bi-lock" style="font-size: 25px; color: red; font-weight: bold"></span>
                                                                    </a>
                                                                @endif
                                                            @else
                                                                Không xác định
                                                            @endif
                                                        </td>
                                                        <td style="text-align: center;">
                                                            @php $baivietQuyen = $employee->chitietquyen->where('quyen_id', 4)->first() @endphp
                                                            @if ($baivietQuyen)
                                                                @if ($baivietQuyen->ctq_CoQuyen == 1)
                                                                    <a href="/admin/employees/auth/{{ $baivietQuyen->id }}" onclick='return confirm("Bạn chắc chắn muốn hủy trao quyền?")'>
                                                                        <span class="bi bi-check2" style="font-size: 28px; color: blue; font-weight: bold"></span>
                                                                    </a>
                                                                @else
                                                                    <a href="/admin/employees/unauth/{{ $baivietQuyen->id }}" onclick='return confirm("Bạn chắc chắn muốn trao quyền?")'>
                                                                        <span class="bi bi-dash-circle" class="bi bi-lock" style="font-size: 25px; color: red; font-weight: bold"></span>
                                                                    </a>
                                                                @endif
                                                            @else
                                                                Không xác định
                                                            @endif
                                                        </td>

                                                        </td>
                                                        <td style="text-align: center;">
                                                            @php $nhapkhoQuyen = $employee->chitietquyen->where('quyen_id', 5)->first() @endphp
                                                            @if ($nhapkhoQuyen)
                                                                @if ($nhapkhoQuyen->ctq_CoQuyen == 1)
                                                                    <a href="/admin/employees/auth/{{ $nhapkhoQuyen->id }}" onclick='return confirm("Bạn chắc chắn muốn hủy trao quyền?")'>
                                                                        <span class="bi bi-check2" style="font-size: 28px; color: blue; font-weight: bold"></span>
                                                                    </a>
                                                                @else
                                                                    <a href="/admin/employees/unauth/{{ $nhapkhoQuyen->id }}" onclick='return confirm("Bạn chắc chắn muốn trao quyền?")'>
                                                                        <span class="bi bi-dash-circle" class="bi bi-lock" style="font-size: 25px; color: red; font-weight: bold"></span>
                                                                    </a>
                                                                @endif
                                                            @else
                                                                Không xác định
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <div class="text-center">
                                                    <a href="/admin/employees/permissions" class="btn btn-primary">Quay lại</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection

{{--  @section('footer')
  <script>
    CKEDITOR.replace('content');
  </script>
@endsection  --}}
