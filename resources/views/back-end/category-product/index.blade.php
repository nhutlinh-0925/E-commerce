@extends('back-end.main2')

@section('head')
<style>
    .toggle-button-cover {
      display: table-cell;
      position: relative;
      width: 10px;
      height: 30px;
      box-sizing: border-box;
    }

    .button-cover {
      height: 100px;
      margin: 20px;
      background-color: #fff;
      box-shadow: 0 10px 20px -8px #c5d6d6;
      border-radius: 4px;
    }

    .button-cover:before {
      counter-increment: button-counter;
      content: counter(button-counter);
      position: absolute;
      right: 0;
      bottom: 0;
      color: #d7e3e3;
      font-size: 12px;
      line-height: 1;
      padding: 5px;
    }

    .button-cover,
    .knobs,
    .layer {
      position: absolute;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
    }

    .button {
      position: relative;
      top: 50%;
      width: 74px;
      height: 36px;
      margin: -20px auto 0 auto;
      overflow: hidden;
    }

    .checkbox {
      position: relative;
      width: 100%;
      height: 100%;
      padding: 0;
      margin: 0;
      opacity: 0;
      cursor: pointer;
      z-index: 3;
    }

    .knobs {
      z-index: 2;
    }

    .layer {
      width: 100%;
      background-color: #ebf7fc;
      transition: 0.3s ease all;
      z-index: 1;
    }

    .button.r,
    .button.r .layer {
      border-radius: 100px;
    }

    #button-3 .knobs:before {
      content: "YES";
      position: absolute;
      top: 4px;
      left: 4px;
      width: 30px;
      height: 30px;
      color: #fff;
      font-size: 10px;
      font-weight: bold;
      text-align: center;
      line-height: 1;
      padding: 9px 4px;
      background-color: #03a9f4;
      border-radius: 50%;
      transition: 0.3s ease all, left 0.3s cubic-bezier(0.18, 0.89, 0.35, 1.15);
    }

    #button-3 .checkbox:active + .knobs:before {
      width: 46px;
      border-radius: 100px;
    }

    #button-3 .checkbox:checked:active + .knobs:before {
      margin-left: -26px;
    }

    #button-3 .checkbox:checked + .knobs:before {
      content: "NO";
      left: 42px;
      background-color: #f44336;
    }

    #button-3 .checkbox:checked ~ .layer {
      background-color: #fcebeb;
    }
  </style>
@endsection

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Danh mục sản phẩm</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/home">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="/admin/category-products">Danh mục sản phẩm</a></li>
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
                     DANH MỤC SẢN PHẨM
                </h1>

            </div>
            <section>
                <a href="{{ url('/admin/category-products/add') }}" class="btn btn-primary btn-sm"> <i class="bi bi-plus-lg"></i>Thêm danh mục</a>
              </section>

            <!-- Table with stripped rows -->
            <table class="table datatable">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Tên danh mục</th>
                  <th scope="col">Mô tả danh mục</th>
                  <th scope="col">Hiển thị</th>
                  <th scope="col">Tùy biến</th>
                </tr>
              </thead>
              <tbody>
                {{--  @php ($stt = 1)  --}}
                @foreach($categoty_products as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->dmsp_TenDanhMuc }}</td>
                    <td>{{ $item->dmsp_MoTa }}</td>
                    <td>
                    @if ($item->dmsp_TrangThai == 0)
                    <form method="post" action="{{ url('/admin/category-products/unactive/' . $item->id ) }}">
                        @method('post')
                        @csrf
                        <div class="toggle-button-cover">
                            <div id="button-3" class="button r">
                            <button type="submit" class="btn btn-light btn-sm"
                                data-toggle = 'tooltip'
                                onclick ='return confirm("Bạn chắc chắn muốn hiện danh mục không?")'>
                                    <input class="checkbox" type="checkbox" checked>
                                    <div class="knobs"></div>
                                    <div class="layer"></div>
                                </button>
                            </div>
                        </div>
                    </form>
                    @else
                    <form method="post" action="{{ url('/admin/category-products/active/' . $item->id ) }}">
                        @method('post')
                        @csrf
                        <div class="toggle-button-cover">
                          <div id="button-3" class="button r">
                            <button type="submit" class="btn btn-light btn-sm"
                              data-toggle = 'tooltip'
                              onclick ='return confirm("Bạn chắc chắn muốn ẩn danh mục không?")'>
                              <input class="checkbox" type="checkbox">
                              <div class="knobs"></div>
                              <div class="layer"></div>
                            </button>
                          </div>
                        </div>
                      </form>
                    @endif
                  </td>
                  <td style="display: flex">
                    <form method="post" action="{{ url('/admin/category-products/destroy/' .$item->id  ) }}">
                      <a href="{{ url('/admin/category-products/edit/' . $item->id ) }}" class="btn btn-primary btn-sm" title="Cập nhật danh mục"><i class="bi bi-pencil-square"></i></a>
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm" title = 'Xóa danh mục'
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
