@extends('back-end.main2')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Phiếu nhập kho</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/admin/warehouses">Phiếu nhập kho</a></li>
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
                                PHIẾU NHẬP HÀNG
                            </h1>

                        </div>
                        <section>
                            <a href="{{ url('/admin/warehouses/add') }}" class="btn btn-primary btn-sm"> <i class="bi bi-plus-lg"></i>Thêm phiếu nhập hàng</a>
                        </section>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nhân viên lập phiếu</th>
                                <th scope="col">Ngày Nhập</th>
                                <th scope="col">Ngày Xác Nhận</th>
                                <th scope="col">Trạng Thái</th>
                                <th scope="col">Tùy biến</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($warehouses as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td><p class="text-center">{{ $item->nguoinhap->nv_Ten }}</p></td>
                                    <td>{{ $item->created_at->format('H:i:s d/m/Y') }}</td>
                                    <td>{{ $item->pnh_NgayXacNhan }}</td>
                                    <td>
                                        @if($item->pnh_TrangThai == 0)
                                            <p style="color: #9e9d24"><b>Chờ duyệt</b></p>
                                        @elseif($item->pnh_TrangThai == 1)
                                            <p style="color: green"><b>Đã nhập kho</b></p>
                                        @endif
                                    </td>
                                    <td style="display: flex">
                                        @if ($item->pnh_TrangThai == 0)
                                        <form method="post" action="{{ url('/admin/warehouses/destroy/' .$item->id  ) }}">
                                            <a href="{{ url('/admin/warehouses/show/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Xem phiếu nhập"><i class="bi bi-eye"></i></a>
                                            <a href="/admin/warehouses/active/{{ $item->id }}" class="btn btn-success btn-sm" onclick ='return confirm("Bạn chắc chắn muốn duyệt phiếu nhâp không?")' title = 'Duyệt phiếu nhập'><span class="bi bi-check2-circle" style="font-size: 15px;color: white; font-weight: bold"></span></a>
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" title = 'Xóa phiếu nhập'
                                                    data-toggle = 'tooltip'
                                                    onclick ='return confirm("Bạn chắc chắn muốn xóa?")'>
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                        @elseif($item->pnh_TrangThai == 1)
                                            <a href="{{ url('/admin/warehouses/show/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Xem phiếu nhập"><i class="bi bi-eye"></i></a>
                                        @endif

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

