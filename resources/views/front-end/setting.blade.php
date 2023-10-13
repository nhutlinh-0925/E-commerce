<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- head -->
    @include('front-end.pages.head')

    <!-- Vendor CSS Files -->
    <link href="/template/back-end2/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/template/back-end2/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/template/back-end2/css/setting.css" rel="stylesheet">

</head>

{{--<div>--}}
@include('front-end.pages.header')

@include('front-end.header_cart')

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Cài đặt</h4>
                        <div class="breadcrumb__links">
                            <a href="/">Trang chủ</a>
                            <span>Cài đặt</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
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

<main id="main" class="main">
    <div class="container">
<section class="section profile">
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <img src="{{ url('/storage/images/avatar/customers/'.$account->avatar) }}" alt="Profile" class="rounded-circle">
                    <h2>{{ $khachhang->kh_Ten }}</h2>
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
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Sửa hồ sơ</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-address">Thêm địa chỉ</button>
                        </li>

{{--                        <li class="nav-item">--}}
{{--                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Thay đổi mật khẩu</button>--}}
{{--                        </li>--}}

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <h5 class="card-title">Thông tin chi tiết</h5><br>
                            <form class="row g-3" >
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="inputNanme4" class="form-label"><strong>Email</strong></label>
                                        <input type="text" class="form-control" disabled value="{{ $account->email }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputNanme4" class="form-label"><strong>Tổng số tiền bạn đã mua</strong></label>
                                        <input type="text" class="form-control" style="color: red;font-weight: bold;" disabled  value="{{ number_format($khachhang->kh_TongTienDaMua, 0, '', '.') }} đ">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="inputNanme4" class="form-label"><strong>Họ và tên</strong></label>
                                        <input type="text" class="form-control" disabled  value="{{ $khachhang->kh_Ten }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputNanme4" class="form-label"><strong>Số điện thoại</strong></label>
                                        <input type="text" class="form-control" disabled value="{{ $khachhang->kh_SoDienThoai }}">
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
                                            <a onclick="removeRow({{ $ad->id }},'/user/address/destroy')">
                                                <i class="fa fa-close" style='color: red'></i>
                                            </a>
{{--                                            <a style="color: red">--}}
{{--                                                @if($ad->dc_TrangThai == 1)--}}
{{--                                                    (Mặc định)--}}
{{--                                                @endif--}}
{{--                                            </a>--}}
                                        </label>
                                        <input type="text" class="form-control" disabled  value="{{ $ad->dc_DiaChi }}">
                                    </div>
                                    @endforeach
                                </div>
                            </form>

{{--                            <a href="{{ url('/user/address/add') }}" class="btn btn-primary btn-sm"> <i class="bi bi-plus-lg"></i>Thêm địa chỉ</a>--}}

                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                            <!-- Profile Edit Form -->
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <label for="profileImage" class="col-lg-4 col-form-label">Ảnh đại diện</label>
                                    <div class="col-lg-8">
                                        <img id="output" src="{{ url('/storage/images/avatar/customers/'.$account->avatar) }}">
                                        <br><br>
                                        <input type="file" class="form-control" id="avatar" name="avatar" onchange="loadFile(event)">
                                        <input type="hidden" name="avatar" value="{{ old('avatar', $account->avatar ?? '') }}">
                                        @error ('avatar')
                                        <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="" class="col-lg-4 col-form-label">Họ và tên : </label>
                                    <div class="col-lg-8">
                                        <input name="kh_Ten" type="text" class="form-control" id="" value="{{ old('kh_Ten', $khachhang->kh_Ten ?? '') }}">
                                        @error ('kh_Ten')
                                        <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Email" class="col-lg-4 col-form-label">Email : </label>
                                    <div class="col-lg-8">
                                        <input name="email" type="email" class="form-control" id="" value="{{ old('email', $account->email ?? '') }}">
                                        @error ('email')
                                        <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="" class="col-lg-4 col-form-label">Số điện thoại : </label>
                                    <div class="col-lg-8">
                                        <input name="kh_SoDienThoai" type="text" class="form-control" id="" value="{{ old('kh_SoDienThoai', $khachhang->kh_SoDienThoai ?? '') }}">
                                        @error ('kh_SoDienThoai')
                                        <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

{{--                                <div class="row mb-3">--}}
{{--                                    <label for="" class="col-lg-4 col-form-label">Chọn địa chỉ mặc định : </label>--}}
{{--                                    <div class="col-lg-8">--}}
{{--                                        <select class="form-control" name="dc_DiaChi" id="" >--}}
{{--                                            <option disabled>--- Chọn Địa chỉ ---</option>--}}
{{--                                            @foreach ($address as $ad)--}}
{{--                                                <option value="{{ $ad->id }}" {{ $dc_md->contains('id', $ad->id) ? 'selected' : '' }}>--}}
{{--                                                    {{ $ad->dc_DiaChi }}--}}
{{--                                                </option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}



                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                </div>
                                @csrf
                            </form>
                        </div>

                        <div class="tab-pane fade pt-3" id="profile-address">
                            <!-- Change Password Form -->
                            <form action="{{ route('user.add_address') }}" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-4">
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

                                    <div class="col-md-4">
                                        <label for="inputNanme4" class="form-label"><strong>Quận, huyện <span class="text-danger">(*)</span></strong></label>
                                        <select class="form-control province choose" name="province" id="province">
                                            <option value="">--- Chọn Quận Huyện ---</option>
{{--                                            @foreach ($districts as $district)--}}
{{--                                                <option value="{{ $district->id }}" >{{ $district->qh_Ten }}</option>--}}
{{--                                            @endforeach--}}
                                        </select>
                                        @error ('province')
                                        <span style="color: red;">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    <div class="col-md-4">
                                        <label for="inputNanme4" class="form-label"><strong>Xã, phường, thị trấn <span class="text-danger">(*)</span></strong></label>
                                        <select class="form-control wards" name="wards" id="wards">
                                            <option value=""> Chọn Xã Phường Thị trấn </option>
{{--                                            @foreach ($wards as $ward)--}}
{{--                                                <option value="{{ $ward->id }}" >{{ $ward->xptt_Ten }}</option>--}}
{{--                                            @endforeach--}}
                                        </select>
                                        @error ('wards')
                                        <span style="color: red;">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <br><br><br><br>

                                    <div class="row mb-3">
                                        <label for="" class="col-md-4 col-lg-3 col-form-label"><strong>Địa chỉ cụ thể <span class="text-danger">(*)</span></strong></label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="dc_DiaChi" type="text" class="form-control" id="" >
                                            @error ('dc_DiaChi')
                                            <span style="color: red;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <div class="text-center">
{{--                                    <button type="submit" name="add_address" class="btn btn-primary add_address">Thêm địa chỉ </button>--}}
                                    <button type="submit" class="btn btn-primary add_address">Thêm địa chỉ </button>
                                </div>
                                @csrf
                            </form>

                        </div>

{{--                        <div class="tab-pane fade pt-3" id="profile-change-password">--}}
{{--                            <!-- Change Password Form -->--}}
{{--                            <form>--}}
{{--                                <div class="row mb-3">--}}
{{--                                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>--}}
{{--                                    <div class="col-md-8 col-lg-9">--}}
{{--                                        <input name="password" type="password" class="form-control" id="currentPassword">--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="row mb-3">--}}
{{--                                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>--}}
{{--                                    <div class="col-md-8 col-lg-9">--}}
{{--                                        <input name="newpassword" type="password" class="form-control" id="newPassword">--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="row mb-3">--}}
{{--                                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>--}}
{{--                                    <div class="col-md-8 col-lg-9">--}}
{{--                                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="text-center">--}}
{{--                                    <button type="submit" class="btn btn-primary">Change Password</button>--}}
{{--                                </div>--}}
{{--                            </form>--}}

{{--                        </div>--}}



                    </div><!-- End Bordered Tabs -->

                </div>
            </div>

        </div>
        </div>
</section>
    </div>
</main>
    <br>

{{--@include('front-end.pages.footer')--}}
<!-- Footer Section Begin -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__logo">
                        <a href="#"><img src="/template/front-end/img/footer-logo.png" alt=""></a>
                    </div>
                    <p>The customer is at the heart of our unique business model, which includes design.</p>
                    <a href="#"><img src="/template/front-end/img/payment.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-2 offset-lg-1 col-md-3 col-sm-6">
                <div class="footer__widget">
                    <h6>Shopping</h6>
                    <ul>
                        <li><a href="#">Clothing Store</a></li>
                        <li><a href="#">Trending Shoes</a></li>
                        <li><a href="#">Accessories</a></li>
                        <li><a href="#">Sale</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6">
                <div class="footer__widget">
                    <h6>Shopping</h6>
                    <ul>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Payment Methods</a></li>
                        <li><a href="#">Delivary</a></li>
                        <li><a href="#">Return & Exchanges</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 offset-lg-1 col-md-6 col-sm-6">
                <div class="footer__widget">
                    <h6>NewLetter</h6>
                    <div class="footer__newslatter">
                        <p>Be the first to know about new arrivals, look books, sales & promos!</p>
                        <form action="#">
                            <input type="text" placeholder="Your email">
                            <button type="submit"><span class="icon_mail_alt"></span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="footer__copyright__text">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    <p>Copyright ©
                        <script>
                            document.write(new Date().getFullYear());
                        </script>2020
                        All rights reserved | This template is made with <i class="fa fa-heart-o"
                                                                            aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                    </p>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->



<!-- Js Plugins -->
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

{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>--}}
{{--<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>--}}
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>--}}





<!-- Vendor JS Files -->
{{--<script src="/template/back-end2/vendor/apexcharts/apexcharts.min.js"></script>--}}
<script src="/template/back-end2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
{{--<script src="/template/back-end2/vendor/chart.js/chart.umd.js"></script>--}}
{{--<script src="/template/back-end2/vendor/echarts/echarts.min.js"></script>--}}
{{--<script src="/template/back-end2/vendor/quill/quill.min.js"></script>--}}
{{--<script src="/template/back-end2/vendor/simple-datatables/simple-datatables.js"></script>--}}
{{--<script src="/template/back-end2/vendor/tinymce/tinymce.min.js"></script>--}}
{{--<script src="/template/back-end2/vendor/php-email-form/validate.js"></script>--}}

<!-- Template Main JS File -->
<script src="/template/back-end2/js/setting.js"></script>
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
            // alert(matp);
            // alert(_token);

            if(action == 'city'){
                result = 'province';
            }else{
                result = 'wards';
            }
            $.ajax({
                url : '{{ url('/user/select_city')}}',
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
