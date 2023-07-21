<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Admin\AdminController;
use \App\Http\Controllers\DanhMucSanPhamController;
use \App\Http\Controllers\ThuongHieuController;
use \App\Http\Controllers\SanPhamController;
use \App\Http\Controllers\KhachHangController;
use \App\Http\Controllers\MaGiamGiaController;
use \App\Http\Controllers\VanChuyenController;

use \App\Http\Controllers\LoginController;
use \App\Http\Controllers\ShopController;
use \App\Http\Controllers\CartController;
use \App\Http\Controllers\SettingController;

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
Route::get('/',[LoginController::class, 'home']);
    //Trang shop
Route::get('/shop',[ShopController::class, 'shop']);
Route::get('/product/{id}',[ShopController::class, 'product_detail']);
    //Trang cart
Route::post('add-cart',[CartController::class, 'index']);
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
        Route::get('/',[LoginController::class, 'home'])->name('home');

    //Trang cài đặt
        Route::get('/setting/{id}',[SettingController::class, 'setting']);
        Route::post('/setting/{id}',[SettingController::class, 'account'])->name('setting');

    //Phần địa chỉ trong cài đặt
        Route::post('address/add', [SettingController::class, 'add_address'])->name('add_address');
        Route::post('/select_city', [SettingController::class, 'select_city']);
        Route::DELETE('/address/destroy', [SettingController::class, 'destroy_address']);

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
            // Route::get('show/{doctor}', [AdminController::class, 'show']);
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
            // Route::get('show/{doctor}', [ThuongHieuController::class, 'show']);
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
            // Route::get('show/{doctor}', [ThuongHieuController::class, 'show']);
//            Route::get('edit/{id}', [SanPhamController::class, 'edit']);
//            Route::post('edit/{id}', [SanPhamController::class, 'update']);
            // Route::DELETE('destroy/{doctor}', [AdminController::class, 'destroy']);
        });
//Mã giảm giá
        Route::prefix('/coupons')->group(function () {
            Route::get('/', [MaGiamGiaController::class, 'index']);
            Route::get('add', [MaGiamGiaController::class, 'create']);
            Route::post('add', [MaGiamGiaController::class, 'store']);
            // Route::get('show/{doctor}', [ThuongHieuController::class, 'show']);
//            Route::get('edit/{id}', [MaGiamGiaController::class, 'edit']);
//            Route::post('edit/{id}', [MaGiamGiaController::class, 'update']);
//            Route::DELETE('destroy/{id}', [MaGiamGiaController::class, 'destroy']);
//            Route::post('active/{id}', [MaGiamGiaController::class, 'active']);
//            Route::post('unactive/{id}', [MaGiamGiaController::class, 'unactive']);
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
//            Route::post('active/{id}', [MaGiamGiaController::class, 'active']);
//            Route::post('unactive/{id}', [MaGiamGiaController::class, 'unactive']);
        });



        Route::get('/users',[KhachHangController::class,'index']);
        Route::get('/user1',[KhachHangController::class,'index2']);





        Route::get('/logout',[AdminController::class, 'logout'])->name('logout');

    });

});
