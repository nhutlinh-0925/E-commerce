<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google.">
    <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template, eCommerce dashboard, analytic dashboard">
    <meta name="author" content="ThemeSelect">
    <title>Đăng nhập</title>
    {{--  <link rel="icon" type="image/png" href="/template/front-end-login/imgages/favicon/favicon-32x32.png">  --}}
    <link rel="apple-touch-icon" href="/template/front-end-login/images/favicon/apple-touch-icon-152x152.png">
    <link rel="shortcut icon" type="image/x-icon" href="/template/front-end-login/images/favicon/favicon-32x32.png">
    <link href="/template/front-end-login/css/icon.css?family=Material+Icons" rel="stylesheet">
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="/template/front-end-login/vendors/vendors.min.css">
    <!-- END: VENDOR CSS-->
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="/template/front-end-login/css/themes/vertical-dark-menu-template/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="/template/front-end-login/css/themes/vertical-dark-menu-template/style.min.css">
    <link rel="stylesheet" type="text/css" href="/template/front-end-login/css/pages/login.css">
    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="/template/front-end-login/css/custom/custom.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->
<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-dark-menu preload-transitions 1-column login-bg   blank-page blank-page" data-open="click" data-menu="vertical-dark-menu" data-col="1-column">
<div class="row" style="background-image: url('https://thumbs.dreamstime.com/z/online-shopping-concepts-basket-boxes-smartphone-yellow-background-ecommerce-market-transportation-logistic-business-193330425.jpg'); background-size: cover; background-size: 1300px 650px">
    <div class="col s12">
        <div class="container"><div id="login-page" class="row">
                <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
                    <form class="login-form" action="{{ route('user.do_Forgot_password') }}" method="POST">
                        <div class="row">
                            <div class="input-field col s12 ">
                                <h5 class="ml-4"><b>Quên mật khẩu</b></h5>
                                <p>Vui lòng nhập email mà bạn đã đăng kí trên hệ thống</p>
                                @if (session('success'))
                                    <div class="alert alert-success" role="alert" style="color: green">
                                         {{ session('success') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row margin">
                            <div class="input-field col s12">
                                <label class="center-align">Email</label>
                                <input id="email" type="text" name="email" value="{{ old('email', $request->email ?? '') }}" >
                                @error ('email')
                                <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                <button type="submit" class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">Đặt lại mật khẩu</button>
                            </div>

                        </div>
                        <div class="row">
                            <div class="input-field col s6 m6 l6">
                                <p class="margin medium-small"><a href="{{  route('user.login')}}">Đăng nhập</a></p>
                            </div>
                            <div class="input-field col s6 m6 l6">
                                <p class="margin right-align medium-small"><a href="{{  route('user.register')}}">Đăng kí</a></p>
                            </div>
                        </div>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>

<!-- BEGIN VENDOR JS-->
<script src="/template/front-end-login/js/vendors.min.js"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<!-- END PAGE VENDOR JS-->
<!-- BEGIN THEME  JS-->
<script src="/template/front-end-login/js/plugins.min.js"></script>
<script src="/template/front-end-login/js/search.min.js"></script>
<script src="/template/front-end-login/js/custom/custom-script.min.js"></script>
<!-- END THEME  JS-->
<!-- BEGIN PAGE LEVEL JS-->
<!-- END PAGE LEVEL JS-->
</body>
</html>
