<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Admin\AdminController;
use \App\Http\Controllers\DanhMucSanPhamController;
use \App\Http\Controllers\ThuongHieuController;
use \App\Http\Controllers\SanPhamController;
use \App\Http\Controllers\MaGiamGiaController;
use \App\Http\Controllers\VanChuyenController;
use \App\Http\Controllers\DonHangController;
use \App\Http\Controllers\KhachHangController;
use \App\Http\Controllers\NhanVienController;
use \App\Http\Controllers\DanhMucBaiVietController;
use \App\Http\Controllers\BaiVietController;
use \App\Http\Controllers\BinhLuanController;

use \App\Http\Controllers\LoginController;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\ShopController;
use \App\Http\Controllers\CartController;
use \App\Http\Controllers\SettingController;
use \App\Http\Controllers\BlogController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Front-end - Trang người dùng

    //Trang chủ
    Route::get('/',[HomeController::class, 'home']);

    //Trang shop
    Route::get('/shop',[ShopController::class, 'shop']);
    Route::get('/product/{id}',[ShopController::class, 'product_detail']);
    Route::get('/danhmuc-sanpham/{id}',[ShopController::class, 'danhmuc_sanpham']);
    Route::get('/thuonghieu-sanpham/{id}',[ShopController::class, 'thuonghieu_sanpham']);

    //Tag
    Route::get('tag/{product_tag}', [ShopController::class, 'tag']);

    //Trang cart
    Route::post('add-cart',[CartController::class, 'index']);
    Route::post('add-cart-shop',[CartController::class,'add_cart_shop']);
    Route::get('carts',[CartController::class, 'show']);
    Route::post('update-cart',[CartController::class, 'update']);
    Route::get('carts/delete/{id}',[CartController::class, 'remove']);
    Route::get('checkout',[CartController::class, 'showcheckout']);
    Route::post('/carts/checkout',[CartController::class, 'getCart']);

    //Mã giảm giá
    Route::post('/check_coupon',[CartController::class, 'check_coupon']);
    Route::get('/delete_coupon',[CartController::class, 'delete_coupon']);

    //Trang đơn hàng
    Route::get('/purchase_order/{id}',[CartController::class, 'show_DonHang'])->name('purchase_order');
    Route::get('/purchase_order/order_detail/{id}',[CartController::class, 'show_ChitietDonhang']);
    //Route::get('/purchase_order/{id}', [CartController::class, 'user'])->name('users.index');

    //Khi mua hàng gửi email
    Route::get('email',[CartController::class, 'email']);

    //Đăng nhập facebook
    //Route::get('user/login/facebook', [LoginController::class, 'login_facebook']);
    //Route::get('user/login/callback', [LoginController::class, 'callback_facebook']);

    //Đăng nhập google
    Route::get('auth/google', [LoginController::class, 'login_google']);
    Route::get('auth/google/callback', [LoginController::class, 'callback_google']);

    //Trang blog
    Route::get('/blog',[BlogController::class, 'blog']);
    Route::get('/blog/{id}',[BlogController::class, 'blog_detail']);
    Route::post('/blog/search', [BlogController::class, 'search']);
    Route::get('/blog/tag/{blog_tag}', [BlogController::class, 'tag']);
    Route::get('/danhmuc-baiviet/{id}',[BlogController::class, 'danhmuc_baiviet']);

    Route::post('blog/add-comment',[BlogController::class,'add_comment']);

    //Tìm kiếm
    Route::post('search', [HomeController::class, 'search']);
    Route::post('autocomplete-ajax', [HomeController::class, 'autocomplete_ajax']);

    Route::get('contact',[HomeController::class,'contact']);


    // Route::get('/login', function () {
    //     return view('front-end.login.login');
    // });

//Khách hàng chưa đăng nhập
Route::prefix('user')->name('user.')->group(function () {
    // Route::middleware(['guest:web'])->group(function () {
        Route::view('/login','front-end.login.login')->name('login');
        Route::post('/doLogin',[LoginController::class, 'doLogin'])->name('doLogin');
        Route::view('/register', 'front-end.login.register')->name('register');
        Route::post ('/register', [LoginController::class, 'doRegister'])->name('doRegister');
    // });

    // Đã đăng nhập thành công

    // Route::middleware(['auth:web'])->group(function () {
    Route::middleware(['auth','isCus'])->group(function () {
        Route::get('/',[HomeController::class, 'home'])->name('home');

        //Trang cài đặt
        Route::get('/setting/{id}',[SettingController::class, 'setting']);
        Route::post('/setting/{id}',[SettingController::class, 'account'])->name('setting');

        //Phần địa chỉ trong cài đặt
        Route::post('address/add', [SettingController::class, 'add_address'])->name('add_address');
        Route::post('/select_city', [SettingController::class, 'select_city']);
        Route::DELETE('/address/destroy', [SettingController::class, 'destroy_address']);
        //Chọn địa chỉ ra phí ship
        Route::post('/get_ship', [CartController::class, 'get_ship']);

        Route::get('/logout',[LoginController::class, 'logout'])->name('logout');


    });

});

// Back-end - Trang admin
Route::prefix('admin')->name('admin.')->group(function () {
    // Route::middleware(['guest:admin'])->group(function () {
        Route::view('/login','back-end.login.login')->name('login');
        // Route::view('/register','auth.login')->name('register');
        // Route::post('/add',[UsersController::class, 'store'])->name('add');
        Route::post('/doLogin',[AdminController::class, 'doLogin'])->name('doLogin');

        // Route::get('/get',[AdminController::class, 'getName']);

    // });

    // Đã đăng nhập thành công

    // Route::middleware(['auth:admin'])->group(function () {
    Route::middleware(['auth','isAdmin'])->group(function () {
        // Route::view('/home','back-end.home2')->name('home');
        Route::get('/home', [AdminController::class, 'getUser'])->name('home');

// Danh muc sản phẩm
        Route::prefix('/category-products')->group(function () {
            Route::get('/', [DanhMucSanPhamController::class, 'index']);
            Route::get('add', [DanhMucSanPhamController::class, 'create']);
            Route::post('add', [DanhMucSanPhamController::class, 'store']);
            Route::get('edit/{id}', [DanhMucSanPhamController::class, 'edit']);
            Route::post('edit/{id}', [DanhMucSanPhamController::class, 'update']);
            Route::DELETE('destroy/{id}', [DanhMucSanPhamController::class, 'destroy']);
            Route::post('active/{id}', [DanhMucSanPhamController::class, 'active']);
            Route::post('unactive/{id}', [DanhMucSanPhamController::class, 'unactive']);
        });

        // Thương hiệu
        Route::prefix('/brands')->group(function () {
            Route::get('/', [ThuongHieuController::class, 'index']);
            Route::get('add', [ThuongHieuController::class, 'create']);
            Route::post('add', [ThuongHieuController::class, 'store']);
            Route::get('edit/{id}', [ThuongHieuController::class, 'edit']);
            Route::post('edit/{id}', [ThuongHieuController::class, 'update']);
            Route::DELETE('destroy/{id}', [ThuongHieuController::class, 'destroy']);
            Route::post('active/{id}', [ThuongHieuController::class, 'active']);
            Route::post('unactive/{id}', [ThuongHieuController::class, 'unactive']);
        });
        //Sản phẩm
        Route::prefix('/products')->group(function () {
            Route::get('/', [SanPhamController::class, 'index']);
            Route::get('add', [SanPhamController::class, 'create']);
            Route::post('add', [SanPhamController::class, 'store']);
            Route::get('edit/{id}', [SanPhamController::class, 'edit']);
            Route::post('edit/{id}', [SanPhamController::class, 'update']);
            // Route::DELETE('destroy/{doctor}', [AdminController::class, 'destroy']);
        });
        //Mã giảm giá
        Route::prefix('/coupons')->group(function () {
            Route::get('/', [MaGiamGiaController::class, 'index']);
            Route::get('add', [MaGiamGiaController::class, 'create']);
            Route::post('add', [MaGiamGiaController::class, 'store']);
//            Route::get('edit/{id}', [MaGiamGiaController::class, 'edit']);
//            Route::post('edit/{id}', [MaGiamGiaController::class, 'update']);
//            Route::DELETE('destroy/{id}', [MaGiamGiaController::class, 'destroy']);
        });

        //Phí vận chuyển
        Route::prefix('/deliveries')->group(function () {
            Route::get('/', [VanChuyenController::class, 'index']);
            Route::get('add', [VanChuyenController::class, 'create']);
            Route::post('add', [VanChuyenController::class, 'store']);
            // Route::get('show/{doctor}', [ThuongHieuController::class, 'show']);
//            Route::get('edit/{id}', [MaGiamGiaController::class, 'edit']);
//            Route::post('edit/{id}', [MaGiamGiaController::class, 'update']);
//            Route::DELETE('destroy/{id}', [MaGiamGiaController::class, 'destroy']);
        });
        //Đơn hàng
        Route::get('/orders', [DonHangController::class, 'index']);

        Route::get('/order_detail/{id}', [DonHangController::class, 'order_detail']);
        Route::post('/order_detail/{id}', [DonHangController::class, 'order_update']);

        //Khách hàng
        Route::prefix('/customers')->group(function () {
            Route::get('/', [KhachHangController::class, 'index']);
            Route::get('add', [KhachHangController::class, 'create']);
            Route::post('add', [KhachHangController::class, 'store']);
//            Route::get('edit/{id}', [MaGiamGiaController::class, 'edit']);
//            Route::post('edit/{id}', [MaGiamGiaController::class, 'update']);
            Route::get('active/{id}', [KhachHangController::class, 'active']);
            Route::get('unactive/{id}', [KhachHangController::class, 'unactive']);
            Route::post('/select_city', [KhachHangController::class, 'select_city']);
        });

        //Nhân viên
        Route::prefix('/employees')->group(function () {
            Route::get('/', [NhanVienController::class, 'index']);
            Route::get('add', [NhanVienController::class, 'create']);
            Route::post('add', [NhanVienController::class, 'store']);
//            Route::get('edit/{id}', [MaGiamGiaController::class, 'edit']);
//            Route::post('edit/{id}', [MaGiamGiaController::class, 'update']);
            Route::get('active/{id}', [NhanVienController::class, 'active']);
            Route::get('unactive/{id}', [NhanVienController::class, 'unactive']);

            Route::get('/permissions', [NhanVienController::class, 'permissions']);
            Route::get('/permissions/edit/{id}', [NhanVienController::class, 'edit_permission'])->name('edit_permission');
            Route::get('auth/{id}', [NhanVienController::class, 'auth']);
            Route::get('unauth/{id}', [NhanVienController::class, 'unauth']);
        });
        //Danh mục bài viết
        Route::prefix('/category-posts')->group(function () {
            Route::get('/', [DanhMucBaiVietController::class, 'index']);
            Route::get('add', [DanhMucBaiVietController::class, 'create']);
            Route::post('add', [DanhMucBaiVietController::class, 'store']);
            Route::get('edit/{id}', [DanhMucBaiVietController::class, 'edit']);
            Route::post('edit/{id}', [DanhMucBaiVietController::class, 'update']);
            Route::DELETE('destroy/{id}', [DanhMucBaiVietController::class, 'destroy']);
            Route::post('active/{id}', [DanhMucBaiVietController::class, 'active']);
            Route::post('unactive/{id}', [DanhMucBaiVietController::class, 'unactive']);
        });

        //Bài viết
        Route::prefix('/posts')->group(function () {
            Route::get('/', [BaiVietController::class, 'index']);
            Route::get('add', [BaiVietController::class, 'create']);
            Route::post('add', [BaiVietController::class, 'store']);
            Route::get('edit/{id}', [BaiVietController::class, 'edit']);
            Route::post('edit/{id}', [BaiVietController::class, 'update']);
            Route::DELETE('destroy/{id}', [BaiVietController::class, 'destroy']);
        });

        //Bình luận
        Route::prefix('/comments')->group(function () {
            Route::get('/', [BinhLuanController::class, 'index']);
            Route::DELETE('destroy/{id}', [BinhLuanController::class, 'destroy']);
            Route::get('active/{id}', [BinhLuanController::class, 'active']);
            Route::get('unactive/{id}', [BinhLuanController::class, 'unactive']);
        });


        Route::get('/users2',[KhachHangController::class,'index1']);
        Route::get('/user1',[KhachHangController::class,'index2']);



        Route::get('/logout',[AdminController::class, 'logout'])->name('logout');

    });

});
