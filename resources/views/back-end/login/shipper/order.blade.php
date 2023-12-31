@extends('back-end.main_shipper')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Đơn hàng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/shipper">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/shipper/orders">Đơn hàng</a></li>
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

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên khách hàng</th>
                                <th scope="col">Tiền thu</th>
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
                                    <td>
                                        @if($item->phuong_thuc_thanh_toan_id == 1)
                                        <p style="width: 90px;text-align: center"><b style="color: red;">{{ number_format($item->pdh_TongTien, 0, '', '.') }} đ</b></p>
                                        @else
                                        <p style="width: 90px;text-align: center"><b style="color: red;">{{ number_format(0, 0, '', '.') }} đ</b></p>
                                        @endif
                                    </td>
                                    <td>
                                        <p style="width: 110px">
                                            @if ($item->pdh_TrangThai == 2)
                                                <a href="#" class="btn btn-primary" style=" font-size: 10px;">
                                                    Chờ nhận đơn <i class="bi bi-check-circle-fill"></i>
                                                </a>
                                            @elseif ($item->pdh_TrangThai == 3)
                                                <a href="#" class="btn btn-warning" style=" font-size: 10px;">
                                                    Đang vận chuyển <i class="bi bi-bus-front-fill"></i>
                                                </a>
                                            @elseif ($item->pdh_TrangThai == 4)
                                                <a href="#" class="btn btn-success" style=" font-size: 10px;">
                                                    Giao thành công <i class=""></i>
                                                </a>
                                            @elseif ($item->pdh_TrangThai == 5)
                                                <a href="#" class="btn btn-danger" style=" font-size: 10px;">
                                                    Đơn bị hủy <i class="bi bi-x-circle-fill"></i>
                                                </a>
                                            @elseif ($item->pdh_TrangThai == 6)
                                                <a href="#" class="btn btn-danger" style=" font-size: 10px;">
                                                    Giao thất bại <i class="bi bi-x-circle-fill"></i>
                                                </a>
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-success" style="width: 70%; font-size: 10px;">
                                            {{ $item->phuongthucthanhtoan->pttt_TenPhuongThucThanhToan }}
                                        </a>
                                    </td>
                                    <td>
                                            <b>{{ $item->nhanvien->nv_Ten }}</b>
                                    </td>
                                    <td><p style="width: 100px"> {{ date("d-m-Y", strtotime($item->pdh_NgayDat)) }}</p></td>

                                    <td style="display: flex">
{{--                                        <form method="post" action="{{ url('/shipper/brands/destroy/' .$item->id  ) }}" style="width: 80px">--}}
                                            <a href="{{ url('/shipper/order_detail/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Xem chi tiết"><i class="bi bi-eye"></i></a>
{{--                                            @method('delete')--}}
{{--                                            @csrf--}}
{{--                                            <button type="submit" class="btn btn-danger btn-sm" title = 'Xóa thương hiệu'--}}
{{--                                                    data-toggle = 'tooltip'--}}
{{--                                                    onclick ='return confirm("Bạn chắc chắn muốn xóa?")'>--}}
{{--                                                <i class="bi bi-trash-fill"></i>--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
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

