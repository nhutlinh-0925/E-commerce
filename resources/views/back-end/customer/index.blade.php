@extends('back-end.main2')

{{--@section('head')--}}
{{--@endsection--}}

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
                        <section>
                            <a href="{{ url('/admin/customers/add') }}" class="btn btn-primary btn-sm"> <i class="bi bi-plus-lg"></i>Thêm khách hàng</a>
                        </section>


                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Họ tên </th>
                                <th scope="col">Avatar</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Địa chỉ</th>
                                <th scope="col">Email</th>
                                <th scope="col">Trạng thái</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customers as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->kh_Ten }}</td>
                                    <td><img src="{{ url('/storage/images/avatar/customers/'.$item->taikhoan->avatar) }}" height="50px" width="50px" class="rounded-circle"></td>
                                    <td>{{ $item->kh_SoDienThoai }}</td>
                                    <td>
                                        <select style="width: 180px;">
                                            @php ($stt = 1)
                                            @foreach ($item->diachi as $diaChi)
                                                <option>Địa chỉ {{ $stt++ }}: {{ $diaChi->dc_DiaChi }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>{{ $item->taikhoan->email }}</td>
                                    <td>
                                        @if ($item->taikhoan->trangthai == 1)
                                            <a href="/admin/customers/unactive/{{ $item->taikhoan->id }}" onclick ='return confirm("Bạn chắc chắn muốn khóa tài khoản?")'><span class="bi bi-unlock" style="font-size: 25px;color: blue; font-weight: bold"></span></a>
                                        @elseif ($item->taikhoan->trangthai == 0)
                                            <a href="/admin/customers/active/{{ $item->taikhoan->id }}" onclick ='return confirm("Bạn chắc chắn muốn mở khóa tài khoản?")'><span class="bi bi-lock" style="font-size: 25px;color: red; font-weight: bold"></span></a>
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
