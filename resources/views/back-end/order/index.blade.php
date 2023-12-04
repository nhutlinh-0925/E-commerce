@extends('back-end.main2')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Đơn hàng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/admin/orders">Đơn hàng</a></li>
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
                                    <td><p style="width: 90px"><b style="color: red;">{{ number_format($item->pdh_TongTien, 0, '', '.') }} đ</b></p></td>
                                    <td>
                                        @if ($item->pdh_TrangThai == 1)
                                            <span class="badge bg-info" style="width: 100%">
                                                Chờ duyệt <i class="bi bi-clock-fill"></i>
                                            </span>
                                        @elseif ($item->pdh_TrangThai == 2 && $item->pdh_TrangThaiGiaoHang == '')
                                             <span class="badge bg-primary" style="width: 100%">
                                                Đã duyệt <i class="bi bi-check-circle-fill"></i>
                                             </span>
                                        @elseif ($item->pdh_TrangThai == 2 && $item->pdh_TrangThaiGiaoHang == 1)
                                            <span class="badge bg-secondary" style="width: 100%">
                                                Đã chọn shipper <i class="bi bi-person-check-fill"></i>
                                            </span>
                                        @elseif ($item->pdh_TrangThai == 2  && $item->pdh_TrangThaiGiaoHang == 0)
                                            <span class="badge bg-dark" style="width: 100%">
                                                Chọn shipper <i class="bi bi-person-fill-exclamation"></i>
                                            </span>
                                        @elseif ($item->pdh_TrangThai == 3)
                                            <span class="badge bg-warning" style="width: 100%">
                                                Đang vận chuyển <i class="bi bi-bus-front-fill" style="color: black"></i>
                                            </span>
                                        @elseif ($item->pdh_TrangThai == 4)
                                            <span class="badge bg-success" style="width: 100%">
                                                Giao thành công <i class="bi bi-calendar-check-fill"></i>
                                            </span>
                                        @elseif ($item->pdh_TrangThai == 5)
                                            <span class="badge bg-danger" style="width: 100%">
                                                Đơn bị hủy <i class="bi bi-x-circle-fill"></i>
                                            </span>
                                        @elseif ($item->pdh_TrangThai == 6)
                                            <span class="badge bg-danger" style="width: 100%">
                                                Giao thất bại <i class="bi bi-x-octagon-fill"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <p style="text-align: center">
                                            <span class="badge bg-success" style="width: 70%">
                                                {{ $item->phuongthucthanhtoan->pttt_TenPhuongThucThanhToan }}
                                            </span>
                                        </p>
                                    </td>
                                    <td>
                                        @if ($item->nhan_vien_id == '')
                                            <i>*Chưa duyệt*</i>
                                        @else
                                            <b>{{ $item->nhanvien->nv_Ten }}</b>
                                        @endif
                                    </td>
                                    <td><p style="width: 100px"> {{ date("d-m-Y", strtotime($item->pdh_NgayDat)) }}</p></td>

                                    <td style="display: flex">
                                        <p style="width: 110px;text-align: center">
                                        @if ($item->pdh_TrangThai == 4)
{{--                                        <form method="post" action="{{ url('/admin/brands/destroy/' .$item->id  ) }}" style="width: 80px">--}}
                                            <a href="{{ url('/admin/order_detail/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Xem chi tiết"><i class="bi bi-eye"></i></a>
{{--                                                <a href="{{ url('/admin/order_detail1/' . $item->id ) }}" class="btn btn-danger btn-sm" title="Xem chi tiết"><i class="bi bi-eye"></i></a>--}}
                                            <a target="_blank" href="{{ url('/admin/order_detail/view_pdf/' . $item->id ) }}" class="btn btn-info btn-sm" title="Xem trước hóa đơn"><i class="bi bi-file-pdf"></i></a>
                                            <a target="_blank" href="{{ url('/admin/order_detail/print_pdf/' . $item->id ) }}" class="btn btn-danger btn-sm" title="In pdf hóa đơn"><i class="bi bi-filetype-pdf"></i></a>
{{--                                            @method('delete')--}}
{{--                                            @csrf--}}
{{--                                            <button type="submit" class="btn btn-danger btn-sm" title = 'Xóa thương hiệu'--}}
{{--                                                    data-toggle = 'tooltip'--}}
{{--                                                    onclick ='return confirm("Bạn chắc chắn muốn xóa?")'>--}}
{{--                                                <i class="bi bi-trash-fill"></i>--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
                                        @else
                                            <a href="{{ url('/admin/order_detail/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Xem chi tiết"><i class="bi bi-eye"></i></a>
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

@section('footer')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/template/back-end2/js/script_admin_ctdh.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    @if(session()->has('success_message'))
        <style>
            .my-custom-icon {
                color: #ff0000; /* Màu đỏ */
                font-size: 5px; /* Kích thước nhỏ hơn (16px) */
            }
        </style>

        <script>
            Swal.fire({
                title: 'Đã xong !!!', // Tiêu đề của thông báo
                text: 'Đã thay đổi trạng thái đơn hàng thành công!', // Nội dung của thông báo
                icon: 'success', // Icon của thông báo (success, error, warning, info, question)
                showConfirmButton: false, // Không hiển thị nút xác nhận
                timer: 6500, // Thời gian hiển thị thông báo (tính theo milliseconds)
                showCloseButton: true, // Hiển thị nút X để tắt thông báo
                customClass: {
                    icon: 'my-custom-icon' // Sử dụng lớp CSS tùy chỉnh cho icon
                },
                // background: '#ff0000', // Màu nền của thông báo
                padding: '3rem', // Khoảng cách lề bên trong thông báo
                borderRadius: '10px' // Độ cong của góc thông báo
            });
        </script>
    @endif

@endsection
