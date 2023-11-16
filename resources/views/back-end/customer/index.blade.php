@extends('back-end.main2')

{{--@section('head')--}}
{{--@endsection--}}
@section('breadcrumb')
    <div class="pagetitle">
        <h1>Khách hàng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/admin/customers">Khách hàng</a></li>
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
{{--                                <th scope="col">Trạng thái</th>--}}
                                <th scope="col">Tùy biến</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customers as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->kh_Ten }}</td>
                                    <td><img src="{{asset('/storage/images/avatar/customers/'.$item->avatar) }}" height="50px" width="50px" class="rounded-circle"></td>
                                    <td>{{ $item->kh_SoDienThoai }}</td>
                                    <td>
                                        <select style="width: 180px;">
                                            @php ($stt = 1)
                                            @foreach ($item->diachi as $diaChi)
                                                <option>Địa chỉ {{ $stt++ }}: {{ $diaChi->dc_DiaChi }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        {{ $item->email }}
                                    </td>

                                    <td>
                                        <p style="width: 65px">
                                        @if ($item->trangthai == 1)
                                            <a href="{{ url('/admin/customers/show/' . $item->id ) }}" title="Xem chi tiết khách hàng"><span class="bi bi-eye" style="font-size: 25px;color: blue; font-weight: bold"></span></a>
                                            <a href="/admin/customers/unactive/{{ $item->id }}" onclick ='return confirm("Bạn chắc chắn muốn khóa tài khoản?")' title="Khóa tài khoản"><span class="bi bi-unlock" style="font-size: 25px;color: blue; font-weight: bold"></span></a>
                                        @elseif ($item->trangthai == 0)
                                            <a href="{{ url('/admin/customers/show/' . $item->id ) }}" title="Xem chi tiết khách hàng"><span class="bi bi-eye" style="font-size: 25px;color: blue; font-weight: bold"></span></a>
                                            <a href="/admin/customers/active/{{ $item->id }}" onclick ='return confirm("Bạn chắc chắn muốn mở khóa tài khoản?")' title="Mở tài khoản"><span class="bi bi-lock" style="font-size: 25px;color: red; font-weight: bold"></span></a>
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
