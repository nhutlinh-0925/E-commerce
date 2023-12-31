@extends('back-end.main2')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Mã giảm giá</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/admin/coupons">Mã giảm giá</a></li>
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
                                MÃ GIẢM GIÁ
                            </h1>

                        </div>
                        <section>
                            <a href="{{ url('/admin/coupons/add') }}" class="btn btn-primary btn-sm"> <i class="bi bi-plus-lg"></i>Thêm mã giảm giá</a>
                        </section>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Mã giảm giá</th>
                                <th scope="col">Số lượng mã</th>
                                <th scope="col">Loại giảm giá</th>
                                <th scope="col">Giá trị</th>
                                <th scope="col">Đơn tối thiểu</th>
                                <th scope="col">Giảm tối đa</th>
                                <th scope="col">Tình trạng</th>
                                <th scope="col">Tùy biến</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($coupons as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
{{--                                    <td><p style="width: 80px">{{ $item->mgg_TenGiamGia }}</p></td>--}}
                                    <td><b><p style="width: 120px">{{ $item->mgg_MaGiamGia }}</p></b></td>
                                    <td>{{ $item->mgg_SoLuongMa }}</td>
                                    <td>@if ($item->mgg_LoaiGiamGia == 1)
                                            <p>Giảm theo tiền</p>
                                        @elseif ($item->mgg_LoaiGiamGia == 2)
                                            <p style="width: 80px">Giảm theo phần trăm</p>
                                        @endif
                                    </td>
                                    <td>@if ($item->mgg_LoaiGiamGia == 1)
                                            <p style="color: red;width: 80px"><b>{{ number_format($item->mgg_GiaTri, 0, '', '.') }} đ</b></p>
                                        @elseif ($item->mgg_LoaiGiamGia == 2)
                                            <p style="color: red;"><b>{{ $item->mgg_GiaTri }} %</b></p>
                                        @endif
                                    </td>
                                    <td>
                                        <p style="width: 90px"><b>{{ number_format($item->mgg_DonToiThieu, 0, '', '.') }} đ</b></p>
                                    </td>
                                    <td>
                                        <p style="width: 80px"><b>{{ number_format($item->mgg_GiamToiDa, 0, '', '.') }} đ</b></p>
                                    </td>
                                    <td>
                                        @if($item->mgg_SoLuongMa <= 0)
                                            <p style="color: red;width: 70px"><b>Hết mã</b></p>
                                        @elseif($item->mgg_SoLuongMa > 0)
                                            @if (\Carbon\Carbon::parse($item->mgg_NgayBatDau) > \Carbon\Carbon::now())
                                                <p style="color: green;width: 80px"><b>Sắp diễn ra</b></p>
                                            @elseif (\Carbon\Carbon::parse($item->mgg_NgayBatDau) < \Carbon\Carbon::now() && \Carbon\Carbon::parse($item->mgg_NgayKetThuc) > \Carbon\Carbon::now())
                                                 <p style="color: green;width: 80px"><b>Khả dụng</b></p>
                                            @elseif (\Carbon\Carbon::parse($item->mgg_NgayKetThuc) < \Carbon\Carbon::now())
                                                <p style="color: red;width: 70px"><b>Hết hạn</b></p>
                                            @endif
                                        @endif
                                    </td>
                                    <td style="display: flex">
                                        @if($item->mgg_SoLuongMa <= 0)
                                            <form method="post" action="{{ url('/admin/coupons/destroy/' .$item->id  ) }}" style="text-align: center; margin: 0 auto;">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm" title = 'Xóa mã giảm giá'
                                                        data-toggle = 'tooltip'
                                                        onclick ='return confirm("Bạn chắc chắn muốn xóa?")'>
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        @elseif($item->mgg_SoLuongMa > 0)
                                            @if (\Carbon\Carbon::parse($item->mgg_NgayKetThuc) > \Carbon\Carbon::now())
                                            <form method="post" action="{{ url('/admin/coupons/destroy/' .$item->id  ) }}" style="width: 120px; text-align: center; margin: 0 auto;">
                                                <a href="{{ url('/admin/coupons/edit/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Cập nhật mã giảm giá"><i class="bi bi-pencil-square"></i></a>
                                                <a href="{{ url('/admin/coupons/show/' . $item->id ) }}" class="btn btn-warning btn-sm" title="Gửi mã giảm giá"><i class="bi bi-ticket-perforated-fill"></i></a>
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm" title = 'Xóa mã giảm giá'
                                                        data-toggle = 'tooltip'
                                                        onclick ='return confirm("Bạn chắc chắn muốn xóa?")'>
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                            @else
                                                <form method="post" action="{{ url('/admin/coupons/destroy/' .$item->id  ) }}" style="text-align: center; margin: 0 auto;">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm" title = 'Xóa mã giảm giá'
                                                            data-toggle = 'tooltip'
                                                            onclick ='return confirm("Bạn chắc chắn muốn xóa?")'>
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>
                                            @endif
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
