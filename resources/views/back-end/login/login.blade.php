
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="/template/back-end-login/img/apple-icon.png">
  <link rel="icon" type="image/png" href="/template/back-end-login/img/favicon.png">
  <title>
    Đăng nhập
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="/template/back-end-login/css/nucleo-icons.css" rel="stylesheet" />
  <link href="/template/back-end-login/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="/template/back-end-login/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="/template/back-end-login/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="">

  <!-- End Navbar -->
  <main class="main-content  mt-0">
    <div class="page-header min-vh-100" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-cover.jpg'); background-position: top;">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class=" justify-content-center">
          <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
            <div class="card z-index-0">
                <div class="card-header text-center">
                    <h3>ĐĂNG NHẬP</h3>
                  </div>
              <div class="card-body">
                <form action="{{ route('admin.doLogin') }}" method="POST" >

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label>Vui lòng nhập email <span class="text-danger">(*)</span></label>
                        <input type="email" name="email" class="form-control" placeholder="Nhập email" value="{{ old('email', $request->email ?? '') }}">
                        @error ('email')
                         <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Vui lòng nhập mật khẩu <span class="text-danger">(*)</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu">
                        @error ('password')
                         <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>



                  <div class="form-check form-check-info text-start">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                    Lưu đăng nhập
                    </label>
{{--                    <a>Quên mật khẩu</a>--}}
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Đăng nhập</button>
                  </div>

                  @csrf
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </main>

</body>

</html>
