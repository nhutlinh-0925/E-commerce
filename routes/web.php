<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\LoginController;
use \App\Http\Controllers\Admin\AdminController;
use \App\Http\Controllers\DanhMucSanPhamController;
use \App\Http\Controllers\ThuongHieuController;
use \App\Http\Controllers\SanPhamController;

use \App\Http\Controllers\KhachHangController;


use \App\Http\Controllers\ShopController;
use \App\Http\Controllers\CartController;

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

// Route::get('/', function () {
//     return view('front-end.home');
// });
Route::get('/',[LoginController::class, 'home']);

Route::get('/shop',[ShopController::class, 'shop']);
Route::get('/product/{id}',[ShopController::class, 'product_detail']);

Route::post('add-cart',[CartController::class, 'index']);
Route::get('carts',[CartController::class, 'show']);
Route::post('update-cart',[CartController::class, 'update']);
Route::get('carts/delete/{id}',[CartController::class, 'remove']);
Route::get('checkout',[CartController::class, 'showcheckout']);
Route::post('/carts/checkout',[CartController::class, 'getCart']);

Route::get('/purchase_order/{id}',[CartController::class, 'show_DonHang'])->name('purchase_order');
Route::get('/purchase_order/orderdetail/{id}',[CartController::class, 'show_ChitietDonhang']);
//Route::get('/purchase_order/{id}', [CartController::class, 'user'])->name('users.index');

// Route::get('/login', function () {
//     return view('front-end.login.login');
// });


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
            Route::get('edit/{id}', [SanPhamController::class, 'edit']);
            Route::post('edit/{id}', [SanPhamController::class, 'update']);
            // Route::DELETE('destroy/{doctor}', [AdminController::class, 'destroy']);
        });

        // Route::get('/users/ajax',[KhachHangController::class,'getUsers'])->name('get-users');

        Route::get('/users',[KhachHangController::class,'index']);
        Route::get('/user1',[KhachHangController::class,'index2']);





        Route::get('/logout',[AdminController::class, 'logout'])->name('logout');

    });

});
