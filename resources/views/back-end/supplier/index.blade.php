@extends('back-end.main2')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Nhà cung cấp</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/admin/suppliers">Nhà cung cấp</a></li>
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
                                NHÀ CUNG CẤP
                            </h1>

                        </div>
                        <section>
                            <a href="{{ url('/admin/suppliers/add') }}" class="btn btn-primary btn-sm"> <i class="bi bi-plus-lg"></i>Thêm nhà cung cấp</a>
                        </section>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên nhà cung cấp</th>
                                <th scope="col">Email</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Địa chỉ</th>
                                <th scope="col">Tình trạng</th>
                                <th scope="col">Tùy biến</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($suppliers as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td><b>{{ $item->ncc_TenNhaCungCap }}</b></td>
                                    <td>{{ $item->ncc_Email }}</td>
                                    <td>{{ $item->ncc_SoDienThoai }}</td>
                                    <td><p style="width: 200px">{{ $item->ncc_DiaChi }}</p></td>
                                    <td>
                                        @if($item->ncc_TrangThai == 0)
                                            <p class="text-danger" style="width: 120px"><b>Ngừng hợp tác</b></p>
                                        @elseif($item->ncc_TrangThai == 1)
                                            <p class="text-success" style="width: 120px"><b>Đang hợp tác</b></p>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ url('/admin/suppliers/edit/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Cập nhật nhà cung cấp"><i class="bi bi-pencil-square"></i></a>
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
