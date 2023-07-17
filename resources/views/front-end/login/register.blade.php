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
    <title>Đăng ký</title>
    <link rel="apple-touch-icon" href="../../../app-assets/images/favicon/apple-touch-icon-152x152.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/favicon/favicon-32x32.png">
    <link href="/template/front-end-login/css/icon.css?family=Material+Icons" rel="stylesheet">
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="/template/front-end-login/vendors/vendors.min.css">
    <!-- END: VENDOR CSS-->
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="/template/front-end-login/css/themes/vertical-dark-menu-template/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="/template/front-end-login/css/themes/vertical-dark-menu-template/style.min.css">
    <link rel="stylesheet" type="text/css" href="/template/front-end-login/css/pages/register.min.css">
    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="/template/front-end-login/css/custom/custom.css">
    <!-- END: Custom CSS-->
  </head>
  <!-- END: Head-->
  <body class="vertical-layout page-header-light vertical-menu-collapsible vertical-dark-menu preload-transitions 1-column register-bg   blank-page blank-page" data-open="click" data-menu="vertical-dark-menu" data-col="1-column">
    <div class="row" style="background-image: url('https://thumbs.dreamstime.com/z/online-shopping-concepts-basket-boxes-smartphone-yellow-background-ecommerce-market-transportation-logistic-business-193330425.jpg'); background-size: cover; background-size: 1300px 700px">
      <div class="col s12">
        <div class="container"><div id="register-page" class="row">
  <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 register-card bg-opacity-8">
    <form class="login-form" action="{{ route('user.doRegister') }}" method="POST">
      <div class="row">
        <div class="input-field col s12">
          <h5 class="ml-4"><b>Đăng ký</b></h5>
            <p>Vui lòng đăng ký để quá trình thanh toán nhanh hơn</p>
        </div>
      </div>
      <div class="row margin">
        <div class="input-field col s12">
            <label class="center-align">Họ tên</label>
            <input id="kh_Ten" type="text" name="kh_Ten" value="{{ old('kh_Ten', $request->kh_Ten ?? '') }}" >
            @error ('kh_Ten')
              <span style="color: red;">{{ $message }}</span>
            @enderror
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
      <div class="row margin">
        <div class="input-field col s12">
            <label class="center-align">Mật khẩu</label>
            <input id="password" type="password" name="password" value="{{ old('password', $request->password ?? '') }}" >
            @error ('password')
              <span style="color: red;">{{ $message }}</span>
            @enderror
          </div>

      </div>
      <div class="row margin">
        <div class="input-field col s12">
            <label class="center-align">Nhập lại mật khẩu</label>
            <input id="re_password" type="password" name="re_password" >
            @error ('re_password')
              <span style="color: red;">{{ $message }}</span>
            @enderror
          </div>

      </div>
      <div class="row">
        <div class="input-field col s12">
            <button type="submit" class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">Đăng ký</button>
        </div>
      </div>
        <div class="row">
            <div class="input-field col s6 m6 l6">
                <p class="margin medium-small"><a href="{{  route('user.login')}}">Bạn đã có tài khoản? </a></p>
            </div>
            <div class="input-field col s6 m6 l6">
                <p class="margin right-align medium-small"><a href="/">Hủy bỏ !!!</a></p>
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
