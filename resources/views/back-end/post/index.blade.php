@extends('back-end.main2')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Bài viết</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/admin/posts">Bài viết</a></li>
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
                                BÀI VIẾT
                            </h1>

                        </div>
                        <section>
                            <a href="{{ url('/admin/posts/add') }}" class="btn btn-primary btn-sm"> <i class="bi bi-plus-lg"></i>Thêm bài viết</a>
                        </section>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Hình</th>
                                <th scope="col">Lượt xem</th>
{{--                                <th scope="col">Nội dung ngắn</th>--}}
                                <th scope="col">Tình trạng</th>
                                <th scope="col">Người đăng</th>
                                <th scope="col">Ngày đăng</th>
                                <th scope="col">Tùy biến</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->bv_TieuDeBaiViet }}</td>
                                    <td><img src="{{asset('/storage/images/posts/'.$item->bv_AnhDaiDien) }}" height="100px" width="100px"></td>
                                    <td>{{ $item->bv_LuotXem }}</td>
{{--                                    <td><p>{{ $item->bv_NoiDungNgan }}</p>--}}
                                    </td>
                                    <td>
                                        @if ($item->bv_TrangThai == 0)
                                            <p style="color: red"><b>Ẩn</b></p>
                                        @elseif($item->bv_TrangThai == 1)
                                            <p style="color: green"><b>Hiển thị</b></p>
                                        @endif
                                    </td>
                                    <td>{{ $item->nguoidang->nv_Ten }}</td>
                                    <td><p style="width: 100px">{{ date("d-m-Y", strtotime($item->bv_NgayTao)) }}</p></td>

                                    <td style="display: flex">
                                          <form method="post" action="{{ url('/admin/posts/destroy/' .$item->id  ) }}" style="width: 80px">
                                          <a href="{{ url('/admin/posts/edit/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Cập nhật bài viết"><i class="bi bi-pencil-square"></i></a>
                                        @method('delete')
                                        @csrf
                                          <button type="submit" class="btn btn-danger btn-sm" title = 'Xóa bài viết'
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
