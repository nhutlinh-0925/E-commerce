@extends('back-end.main2')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Phân quyền</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/admin/employees/permissions">Phân quyền</a></li>
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
                                NHÂN VIÊN
                            </h1>
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Email </th>
                                <th scope="col">Quyền Đơn Hàng</th>
                                <th scope="col">Quyền Sản Phẩm</th>
                                <th scope="col">Quyền Nhân Sự</th>
                                <th scope="col">Quyền Bài Viết</th>
                                <th scope="col">Quyền Nhập Kho</th>
                                <th scope="col">Thay đổi quyền</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employees as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->taikhoan->email }}</td>
                                    <td>
                                        @php $donhangQuyen = false @endphp
                                        @foreach ($item->chitietquyen as $chitietquyen)
                                            @if ($chitietquyen->quyen_id == 1)
                                                @php $donhangQuyen = true @endphp
                                                @if ($chitietquyen->ctq_CoQuyen == 1)
                                                    <a href="">
                                                        <span class="bi bi-check2" style="font-size: 28px; color: blue; font-weight: bold"></span>
                                                    </a>
                                                @elseif ($chitietquyen->ctq_CoQuyen == 0)
                                                    <a href="">
                                                        <span class="bi bi-dash-circle" class="bi bi-lock" style="font-size: 25px; color: red; font-weight: bold"></span>
                                                    </a>
                                                @endif
                                            @endif
                                        @endforeach
                                        @if (!$donhangQuyen)
                                            <!-- Handle the case when 'quyen_id' = 1 is not found -->
                                            <!-- You can show a default value or a message -->
                                            <!-- For example: -->
                                            Không xác định
                                        @endif
                                    </td>
                                    <td>
                                        @php $sanphamQuyen = false @endphp
                                        @foreach ($item->chitietquyen as $chitietquyen)
                                            @if ($chitietquyen->quyen_id == 2)
                                                @php $sanphamQuyen = true @endphp
                                                @if ($chitietquyen->ctq_CoQuyen == 1)
                                                    <a href="">
                                                        <span class="bi bi-check2" style="font-size: 28px; color: blue; font-weight: bold"></span>
                                                    </a>
                                                @elseif ($chitietquyen->ctq_CoQuyen == 0)
                                                    <a href="">
                                                        <span class="bi bi-dash-circle" class="bi bi-lock" style="font-size: 25px; color: red; font-weight: bold"></span>
                                                    </a>
                                                @endif
                                            @endif
                                        @endforeach
                                        @if (!$sanphamQuyen)
                                            <!-- Handle the case when 'quyen_id' = 1 is not found -->
                                            <!-- You can show a default value or a message -->
                                            <!-- For example: -->
                                            Không xác định
                                        @endif
                                    </td>
                                    <td>
                                        @php $nhansuQuyen = false @endphp
                                        @foreach ($item->chitietquyen as $chitietquyen)
                                            @if ($chitietquyen->quyen_id == 3)
                                                @php $nhansuQuyen = true @endphp
                                                @if ($chitietquyen->ctq_CoQuyen == 1)
                                                    <a href="">
                                                        <span class="bi bi-check2" style="font-size: 28px; color: blue; font-weight: bold"></span>
                                                    </a>
                                                @elseif ($chitietquyen->ctq_CoQuyen == 0)
                                                    <a href="">
                                                        <span class="bi bi-dash-circle" class="bi bi-lock" style="font-size: 25px; color: red; font-weight: bold"></span>
                                                    </a>
                                                @endif
                                            @endif
                                        @endforeach
                                        @if (!$nhansuQuyen)
                                            <!-- Handle the case when 'quyen_id' = 1 is not found -->
                                            <!-- You can show a default value or a message -->
                                            <!-- For example: -->
                                            Không xác định
                                        @endif
                                    </td>
                                    <td>
                                        @php $baivietQuyen = false @endphp
                                        @foreach ($item->chitietquyen as $chitietquyen)
                                            @if ($chitietquyen->quyen_id == 4)
                                                @php $baivietQuyen = true @endphp
                                                @if ($chitietquyen->ctq_CoQuyen == 1)
                                                    <a href="">
                                                        <span class="bi bi-check2" style="font-size: 28px; color: blue; font-weight: bold"></span>
                                                    </a>
                                                @elseif ($chitietquyen->ctq_CoQuyen == 0)
                                                    <a href="">
                                                        <span class="bi bi-dash-circle" class="bi bi-lock" style="font-size: 25px; color: red; font-weight: bold"></span>
                                                    </a>
                                                @endif
                                            @endif
                                        @endforeach
                                        @if (!$baivietQuyen)
                                            <!-- Handle the case when 'quyen_id' = 1 is not found -->
                                            <!-- You can show a default value or a message -->
                                            <!-- For example: -->
                                            Không xác định
                                        @endif
                                    </td>
                                    <td>
                                        @php $nhapkhoQuyen = false @endphp
                                        @foreach ($item->chitietquyen as $chitietquyen)
                                            @if ($chitietquyen->quyen_id == 5)
                                                @php $nhapkhoQuyen = true @endphp
                                                @if ($chitietquyen->ctq_CoQuyen == 1)
                                                    <a href="">
                                                        <span class="bi bi-check2" style="font-size: 28px; color: blue; font-weight: bold"></span>
                                                    </a>
                                                @elseif ($chitietquyen->ctq_CoQuyen == 0)
                                                    <a href="">
                                                        <span class="bi bi-dash-circle" class="bi bi-lock" style="font-size: 25px; color: red; font-weight: bold"></span>
                                                    </a>
                                                @endif
                                            @endif
                                        @endforeach
                                        @if (!$nhapkhoQuyen)
                                            <!-- Handle the case when 'quyen_id' = 1 is not found -->
                                            <!-- You can show a default value or a message -->
                                            <!-- For example: -->
                                            Không xác định
                                        @endif
                                    </td>

                                    <td>
                                        <p style="width: 100px;text-align: center">
                                        @if ($item->taikhoan->loai == 0 && $item->taikhoan->vip == 1)
                                            <a href="#" class="btn btn-danger" style="font-size: 10px">
                                                Senior Manager
                                            </a>
                                        @elseif ($item->taikhoan->loai == 0 && $item->taikhoan->vip == 0)
                                            <a href="{{ url('/admin/employees/permissions/edit/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Thay đổi quyền"><i class="bi bi-pencil-square"></i></a>
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
