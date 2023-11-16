@extends('back-end.main2')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Khách hàng</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/customers">Khách hàng</a></li>
                <li class="breadcrumb-item active"><a href="">Xem chi tiết</a></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <div class="image-container" style=" position: relative;display: inline-block;">
                            <img src="{{ url('/storage/images/avatar/customers/'.$customer->avatar) }}" alt="Profile" class="rounded-circle">
                            @if($customer->vip == 1)
                            <span class="label" style="position: absolute;top: 0;right: 0;
                                                       background-color: red;color: white;
                                                       padding: 5px;border-radius: 10px;">
                                Vip
                            </span>
                            @endif
                        </div>

                        <h2 style="text-align: center">{{ $customer->kh_Ten }}</h2>
                        <div class="social-links mt-2">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Tổng quan</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-order">Các đơn hàng</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-wish-list">Các sản phẩm yêu thích</button>
                            </li>

                        </ul>


                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="inputNanme4" class="form-label"><strong>Email</strong></label>
                                            <input type="text" class="form-control" disabled value="{{ $customer->email }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputNanme4" class="form-label"><strong>Tổng tiền đã mua</strong></label>
                                            <input type="text" class="form-control" style="color: red;font-weight: bold;" disabled  value="{{ number_format($customer->kh_TongTienDaMua, 0, '', '.') }} đ">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="inputNanme4" class="form-label"><strong>Họ và tên</strong></label>
                                            <input type="text" class="form-control" disabled  value="{{ $customer->kh_Ten }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputNanme4" class="form-label"><strong>Số điện thoại</strong></label>
                                            <input type="text" class="form-control" disabled value="{{ $customer->kh_SoDienThoai }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        @php ($stt = 1)
                                        @foreach ($address as $ad)
                                            <div class="col-md-12">
                                                <label for="inputNanme4" class="form-label">
                                                    <strong>
                                                        Địa chỉ {{ $stt++ }}
                                                    </strong>
                                                </label>
                                                <input type="text" class="form-control" disabled  value="{{ $ad->dc_DiaChi }}">
                                            </div>
                                        @endforeach
                                    </div>


                            </div>

                            <div class="tab-pane fade profile-order pt-3" id="profile-order">
                                <table class="table datatable">
                                    <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Tổng tiền</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Phương thức</th>
                                        <th scope="col">Ngày đặt</th>
                                        <th scope="col">Tùy biến</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
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
                                            <span class="badge bg-success" style="width: 90%">
                                                {{ $item->phuongthucthanhtoan->pttt_TenPhuongThucThanhToan }}
                                            </span>
                                                </p>
                                            </td>
                                            <td><p style="width: 100px"> {{ date("d-m-Y", strtotime($item->pdh_NgayDat)) }}</p></td>
                                            <td style="display: flex">
                                                <a href="{{ url('/admin/order_detail/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Xem chi tiết"><i class="bi bi-eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade pt-3" id="profile-wish-list">

                                <table class="table datatable">
                                    <thead>
                                    <tr>
                                        <th scope="col"><p style="text-align: center;">ID</th>
                                        <th scope="col"><p style="text-align: center;">Tên sản phẩm</p></th>
                                        <th scope="col"><p style="text-align: center;">Hình</p></th>
                                        <th scope="col"><p style="text-align: center;">Giá</p></th>
                                        <th scope="col"><p style="text-align: center;">Tùy biến</p></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($wish as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td><p style="width: 100px">{{ $item->sanpham->sp_TenSanPham }}</p></td>
                                            <td><img src="{{ url('/storage/images/products/'.$item->sanpham->sp_AnhDaiDien) }}" height="100px" width="100px"></td>
                                            <td><p style="text-align: center;color: red;width: 90px"><b>{{ number_format($item->sanpham->sp_Gia, 0, '', '.') }} đ</b></p></td>
                                            <td>
                                                <p style="width: 70px;text-align: center">
                                                    <a href="{{ url('/admin/products/show/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Xem sản phẩm"><i class="bi bi-eye"></i></a>
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection


