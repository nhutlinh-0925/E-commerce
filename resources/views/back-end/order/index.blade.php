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
                                TẤT CẢ ĐƠN HÀNG
                            </h1>

                        </div>
{{--                        <section>--}}
{{--                            <a href="{{ url('/admin/brands/add') }}" class="btn btn-primary btn-sm"> <i class="bi bi-plus-lg"></i>Thêm thương hiệu</a>--}}
{{--                        </section>--}}

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên khách hàng</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Hình thức thanh toán</th>
                                <th scope="col">Nhân viên duyệt</th>
                                <th scope="col">Ngày đặt</th>
                                <th scope="col">Tùy biến</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td><b>{{ $item->khachhang->kh_Ten }}</b></td>
                                    <td><b style="color: red">{{ number_format($item->pdh_TongTien, 0, '', '.') }} đ</b></td>
                                    <td>
                                        @if ($item->pdh_TrangThai == 1)
                                            <a href="">
                                                <button class="btn btn-info" style="width: 100%">Đang chờ duyệt <i class="bi bi-clock-fill"></i></button>
                                            </a>
                                        @elseif ($item->pdh_TrangThai == 2)
                                            <a href="">
                                                <button class="btn btn-primary" style="width: 100%">Đơn đã duyệt <i class="bi bi-check-circle-fill"></i></button>
                                            </a>
                                        @elseif ($item->pdh_TrangThai == 3)
                                            <a href="">
                                                <button class="btn btn-warning" style="width: 100%">Đang vận chuyển <i class="bi bi-bus-front-fill"></i></button>
                                            </a>
                                        @elseif ($item->pdh_TrangThai == 4)
                                            <a href="">
                                                <button class="btn btn-success" style="width: 100%">Giao hàng thành công</button>
                                            </a>
                                        @elseif ($item->pdh_TrangThai == 5)
                                            <a href="">
                                                <button class="btn btn-danger" style="width: 100%">Đơn bị hủy <i class="bi bi-x-circle-fill"></i></button>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="">
                                            <button class="btn btn-success" style="width: 70%;">{{ $item->phuongthucthanhtoan->pttt_TenPhuongThucThanhToan }}</button>
                                        </a>
                                    </td>
                                    <td>
                                        @if ($item->nhan_vien_id == '')
                                            <i>*Chưa duyệt*</i>
                                        @else
                                            <b>{{ $item->nhanvien->nv_Ten }}</b>
                                        @endif
                                    </td>
                                    <td>{{ date("d-m-Y", strtotime($item->pdh_NgayDat)) }}</td>

                                    <td style="display: flex">
                                        <form method="post" action="{{ url('/admin/brands/destroy/' .$item->id  ) }}">
                                            <a href="{{ url('/admin/order_detail/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Xem chi tiết"><i class="bi bi-eye"></i></a>
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
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
