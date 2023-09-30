@extends('back-end.main2')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Bình luận bài viết</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/admin/comments">Bình luận bài viết</a></li>
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
                                BÌNH LUẬN BÀI VIẾT
                            </h1>
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên khách hàng</th>
                                <th scope="col">Tên bài viết</th>
                                <th scope="col">Nội dung</th>
                                <th scope="col">Tình trạng</th>
                                <th scope="col">Tùy biến</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--  @php ($stt = 1)  --}}
                            @foreach($comments as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->khachhang->kh_Ten }}</td>
                                    <td>{{ $item->baiviet->bv_TieuDeBaiViet }}</td>
                                    <td>{{ $item->bl_NoiDung }}</td>
                                    <td>
                                        @if ($item->bl_TrangThai == 0)
                                            <p style="color: grey;width: 85px"><b>Chờ duyệt</b></p>
{{--                                            <button class="btn btn-warning" style="width: 80%">Chờ duyệt</button>--}}
                                        @elseif($item->bl_TrangThai == 1)
                                            <p style="color: green;width: 80px"><b>Đã duyệt</b></p>
{{--                                            <button class="btn btn-success" style="width: 80%">Đã duyệt</button>--}}
                                        @endif
                                    </td>
                                    <td style="display: flex">
                                        <form method="post" action="{{ url('/admin/comments/destroy/' .$item->id  ) }}" style="width: 80px">
                                            @if ($item->bl_TrangThai == 0)
                                                <a href="{{ url('/admin/comments/unactive/' . $item->id ) }}" class="btn btn-primary btn-sm" onclick ='return confirm("Bạn chắc chắn muốn duyệt bình luận?")' title="Duyệt"><i class="bi bi-check2-circle"></i></a>
                                            @elseif($item->bl_TrangThai == 1)
                                                <a href="{{ url('/admin/comments/active/' . $item->id ) }}" class="btn btn-secondary btn-sm" onclick ='return confirm("Bạn chắc chắn muốn hủy duyệt bình luận?")' title="Hủy duyệt"><i class="bi bi-x-octagon"></i></a>
                                            @endif
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" title = 'Xóa bình luận'
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
