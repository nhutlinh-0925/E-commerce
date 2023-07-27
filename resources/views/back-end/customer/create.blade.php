<!DOCTYPE html>
<html lang="en">

@include('back-end.pages2.head')

<body>

@include('back-end.pages2.header')

@include('back-end.pages2.sidebar')

{{--  @include('back-end.pages2.main')  --}}
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <div class="pagetitle text-center">
                    <h1 class="card-title"
                        style="border-bottom: 3px solid blue; display: inline-block; padding-bottom: 5px; "; >
                        THÊM KHÁCH HÀNG
                    </h1>
                    <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi thêm</p>
                </div>
                <!-- Vertical Form -->
                <form class="row g-3" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputName4" class="form-label"><strong>Họ tên khách hàng <span class="text-danger">(*)</span></strong></label>
                            <input type="text" class="form-control" id="" name="kh_Ten" placeholder="Nhập tên khách hàng" value="{{ old('kh_Ten', $request->kh_Ten ?? '') }}">
                            @error ('kh_Ten')
                            <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inputName4" class="form-label"><strong>Email <span class="text-danger">(*)</span></strong></label>
                            <input type="text" class="form-control" id="" name="email" placeholder="Nhập email" value="{{ old('email', $request->email ?? '') }}">
                            @error ('email')
                            <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputNanme4" class="form-label"><strong>Thành phố <span class="text-danger">(*)</span></strong></label>
                            <select class="form-control choose city" name="city" id="city" >
                                <option value="">--- Chọn Thành phố ---</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" >{{ $city->tp_Ten }}</option>
                                @endforeach
                            </select>
                            @error ('city')
                            <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="inputNanme4" class="form-label"><strong>Quận, huyện <span class="text-danger">(*)</span></strong></label>
                            <select class="form-control province choose" name="province" id="province">
                                <option value="">--- Chọn Quận Huyện ---</option>
                            </select>
                            @error ('province')
                            <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="inputNanme4" class="form-label"><strong>Xã, phường, thị trấn <span class="text-danger">(*)</span></strong></label>
                            <select class="form-control wards" name="wards" id="wards">
                                <option value="">---Xã Phường Thị trấn---</option>
                            </select>
                            @error ('wards')
                            <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="inputNanme4" class="form-label"><strong>Địa chỉ cụ thể <span class="text-danger">(*)</span></strong></label>
                            <input type="text" class="form-control" id="" name="dc_DiaChi" placeholder="Nhập địa chỉ cụ thể" value="{{ old('dc_DiaChi', $request->dc_DiaChi ?? '') }}">
                            @error ('dc_DiaChi')
                            <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputNanme4" class="form-label"><strong>Mật khẩu <span class="text-danger">(*)</span></strong></label>
                            <input type="password" class="form-control" id="" name="password" placeholder="Nhập mật khẩu">
                            @error ('password')
                            <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inputNanme4" class="form-label"><strong>Nhập lại mật khẩu <span class="text-danger">(*)</span></strong></label>
                            <input type="password" class="form-control" id="" name="password_again" placeholder="Nhập lại mật khẩu">
                            @error ('password_again')
                            <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputName4" class="form-label"><strong>Số điện thoại <span class="text-danger">(*)</span></strong></label>
                            <input type="text" class="form-control" id="" name="kh_SoDienThoai" placeholder="Nhập số điện thoại" value="{{ old('kh_SoDienThoai', $request->kh_SoDienThoai ?? '') }}">
                            @error ('kh_SoDienThoai')
                            <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="inputNanme4" class="form-label"><strong>Trạng thái <span class="text-danger">(*)</span></strong></label>
                            <select class="form-select" name="trangthai" id="" >
                                <option selected disabled value="">Lựa chọn</option>
                                <option value="1">Hoạt động</option>
                                <option value="0">Khóa</option>
                            </select>
                            @error ('trangthai')
                            <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <label for="" class="form-label"><strong>Ảnh đại diện <span class="text-danger">(*)</span></strong></label>
                            <input type="file" class="form-control" id="" name="avatar" onchange="loadFile(event)">
                            @error ('avatar')
                            <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-6">
                            <label for="" class="form-label"><strong>Xem trước hình ảnh</strong></label>
                            <br>
                            <img id="output" width="220px" height="170px">
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" style="width: 10%;">Thêm</button>
                        <button type="reset" class="btn btn-danger" style="width: 10%;">Hủy</button>
                    </div>
                    @csrf
                </form><!-- Vertical Form -->

            </div>
        </div>

    </section>

</main>

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="credits">
    </div>
</footer><!-- End Footer -->


<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="/template/back-end2/vendor/apexcharts/apexcharts.min.js"></script>
<script src="/template/back-end2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/back-end2/vendor/chart.js/chart.umd.js"></script>
<script src="/template/back-end2/vendor/echarts/echarts.min.js"></script>
<script src="/template/back-end2/vendor/quill/quill.min.js"></script>
<script src="/template/back-end2/vendor/simple-datatables/simple-datatables.js"></script>
<script src="/template/back-end2/vendor/tinymce/tinymce.min.js"></script>
<script src="/template/back-end2/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="/template/back-end2/js/main.js"></script>

<!-- jQuery should be loaded before other plugins -->
<script src="/template/front-end/js/jquery-3.3.1.min.js"></script>

<!-- Js Plugins (Front-end) -->
<script src="/template/front-end/js/jquery-3.3.1.min.js"></script>
<script src="/template/front-end/js/bootstrap.min.js"></script>
<script src="/template/front-end/js/jquery.nice-select.min.js"></script>
<script src="/template/front-end/js/jquery.nicescroll.min.js"></script>
<script src="/template/front-end/js/jquery.magnific-popup.min.js"></script>
<script src="/template/front-end/js/jquery.countdown.min.js"></script>
<script src="/template/front-end/js/jquery.slicknav.js"></script>
<script src="/template/front-end/js/mixitup.min.js"></script>
{{--<script src="/template/front-end/js/owl.carousel.min.js"></script>--}}
<script src="/template/front-end/js/main.js"></script>

<script>
    var loadFile = function(event){
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
    };
</script>

<script type="text/javascript">
    $(document).ready(function (){
        // $('.add_address').click(function (){
        //     // alert('ok');
        //
        //     var city = $('.city').val();
        //     var province = $('.province').val();
        //     var wards = $('.wards').val();
        // });

        $('.choose').on('change',function (){
            var action = $(this).attr('id');
            var ma_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';
            // alert(action);
            // alert(ma_id);
            // alert(_token);

            if(action == 'city'){
                result = 'province';
            }else{
                result = 'wards';
            }
            $.ajax({
                url : '{{ url('/admin/customers/select_city')}}',
                method: 'POST',
                data:{action:action,ma_id:ma_id,_token:_token},
                success:function (data){
                    $('#'+result).html(data)
                }
            });
        });
    });

</script>
</body>

</html>


