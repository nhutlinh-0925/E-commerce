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
use \App\Http\Controllers\NguoiGiaoHangController;
use \App\Http\Controllers\DanhMucBaiVietController;
use \App\Http\Controllers\BaiVietController;
use \App\Http\Controllers\BinhLuanController;
use \App\Http\Controllers\NhaCungCapController;
use \App\Http\Controllers\NhapKhoController;
use \App\Http\Controllers\ĐanhGiaController;
use \App\Http\Controllers\PhanHoiController;
use \App\Http\Controllers\ThanhTruotController;

use \App\Http\Controllers\LoginController;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\ShopController;
use \App\Http\Controllers\ShopDetailController;
use \App\Http\Controllers\CartController;
use \App\Http\Controllers\SettingController;
use \App\Http\Controllers\BlogController;

use \App\Http\Controllers\Shipper\ShipperController;
use \App\Http\Controllers\Shipper\DonHangShipperController;
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
//PayPal
//      trannhutlinh@business.example.com
//      linh_paypal

//VNPAY
//Ngân hàng: NCB
//Số thẻ:           9704198526191432198
//Tên chủ thẻ:      NGUYEN VAN A
//Ngày phát hành:   07/15
//Mật khẩu OTP:     123456


//Trạng thái        pdh_TrangThai
//1 - Chờ duyệt
//2 - Đã duyệt
//3 - Đang vận chuyển
//4 - Giao hàng thành công
//5 - Đã hủy đơn
//6 - Giao hàng thất bại

//Trạng thái        pdh_TrangThaiGiaoHang
//0 - Từ chối nhận đơn
//1 - Đã nhận đơn - Đang giao hàng
//2 - Đã nhận đơn - Giao hàng thành công
//3 - Đã nhận đơn - Giao hàng thất bại

//Trang admin
//pdh_TrangThai = 1 => Chọn shipper
//pdh_TrangThai = 2 và pdh_TrangThaiGiaoHang = 0 => Chọn shipper

//Trang shipper
//pdh_TrangThai = 2
//              + pdh_TrangThaiGiaoHang = 0 : Từ chối
//              + pdh_TrangThaiGiaoHang = 1 : Nhận đơn
//pdh_TrangThai = 3
//              + pdh_TrangThaiGiaoHang = 2 : Giao thành công
//              + pdh_TrangThaiGiaoHang = 3 : Giao thất bại



//Doanh số:            số lượng * giá bán
//Doanh thu:           số lượng * giá bán - mgg + pvc = pdh_TongTien
//Chi phí nhập kho:    số lượng * (giá bán - giá nhập)
//Lợi nhuận:           Doanh thu - Chi phí nhập kho


// Front-end - Trang người dùng

    //Trang chủ
    Route::get('/',[HomeController::class, 'home']);

    //Trang shop
    Route::get('/shop',[ShopController::class, 'shop'])->name('shop');
    Route::get('/product/{id}',[ShopDetailController::class, 'product_detail']);
    Route::get('/danhmuc-sanpham/{id}',[ShopController::class, 'danhmuc_sanpham']);
    Route::get('/thuonghieu-sanpham/{id}',[ShopController::class, 'thuonghieu_sanpham']);

    //Xem nhanh
    Route::post('add-cart-quick_view',[CartController::class, 'add_cart_quick_view']);
    Route::post('/quick_view',[ShopDetailController::class, 'quick_view']);

    //Tag sản phẩm
    Route::get('tag/{product_tag}', [ShopController::class, 'tag']);

    //Trang cart
    Route::post('add-cart',[CartController::class, 'index']);

    //Đăng nhập facebook
//    Route::get('auth/facebook', [LoginController::class, 'login_facebook']);
//    Route::get('auth/facebook/callback', [LoginController::class, 'callback_facebook']);

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

    //Về Chúng Tôi
    Route::get('about',[HomeController::class,'about']);

    //Liên hệ
    Route::get('contact',[HomeController::class,'contact']);

    //Chính sách bảo hành
    Route::get('warranty',[HomeController::class,'warranty']);


    //Thanh toán ONEPAY
    //Route::post('onepay_payment', [PayPalController::class, 'onepay_payment']);

    //Tìm kiếm giọng nói
    Route::get('/search_microphone', [HomeController::class, 'search_Microphone']);


//Khách hàng chưa đăng nhập
Route::prefix('user')->name('user.')->group(function () {
    Route::middleware(['guest:web'])->group(function () {
        Route::view('/login', 'front-end.login.login')->name('login');
        Route::post('/doLogin', [LoginController::class, 'doLogin'])->name('doLogin');
        Route::view('/register', 'front-end.login.register')->name('register');
        Route::post('/register', [LoginController::class, 'doRegister'])->name('doRegister');

        Route::get('/forgot_password', [LoginController::class, 'forgot_password'])->name('forgot_password');
        Route::post('/forgot_password', [LoginController::class, 'post_forget_password'])->name('do_Forgot_password');
        Route::get('/reset_password/{token}', [LoginController::class, 'reset_password'])->name('reset_password');
        Route::post('/reset_password', [LoginController::class, 'post_reset_password'])->name('do_Reset_password');
         });

        // Đã đăng nhập thành công
        Route::middleware(['auth:web'])->group(function () {
            Route::get('/', [HomeController::class, 'home'])->name('home');

            //Trang cart
            Route::get('carts',[CartController::class, 'show']);
            Route::post('update-cart',[CartController::class, 'update']);
            Route::get('carts/delete/{id}/{size}',[CartController::class, 'remove'])->name('cart_remove');
            Route::get('checkout', [CartController::class, 'showcheckout'])->name('showcheckout');
            Route::post('/carts/checkout', [CartController::class, 'getCart'])->name('checkout');

            //Mã giảm giá
            Route::post('/check_coupon',[CartController::class, 'check_coupon']);
            Route::get('/delete_coupon',[CartController::class, 'delete_coupon']);

            Route::get('success-transaction', [CartController::class, 'successTransaction'])->name('successTransaction');
            Route::get('cancel-transaction', [CartController::class, 'cancelTransaction'])->name('cancelTransaction');

            Route::get('vnpay-callback', [CartController::class, 'handleVnPayCallback']);

            //Trang đơn hàng của toi
            Route::get('/purchase_order/{id}', [CartController::class, 'show_DonHang'])->name('purchase_order');
            Route::get('/purchase_order/order_detail/{id}', [CartController::class, 'show_ChitietDonhang']);

            Route::get('/purchase_order/order_detail/status_confirmed_cancel/{id}', [CartController::class, 'cancel']);
            Route::get('/purchase_order/order_detail/status_confirmed_success/{id}', [CartController::class, 'success']);

            Route::post('/purchase_order/order_detail/{id_dh}/add_review/{id_pr}',[ShopDetailController::class, 'add_review'])->name('add_review');
            Route::post('/purchase_order/order_detail/add_feedback/{id}', [ShopDetailController::class, 'add_feedback']);

            //Yêu thích
            Route::get('/wish-list/{id}', [ShopDetailController::class, 'wish_lish_show'])->name('wish_lish_show');
            Route::get('/wish-list-count/{id}', [ShopDetailController::class, 'wish_list_count']);

            //Trang cài đặt
            Route::get('/setting/{id}', [SettingController::class, 'setting']);
            Route::post('/setting/{id}', [SettingController::class, 'account'])->name('setting');

            //Phần địa chỉ trong cài đặt
            Route::post('address/add', [SettingController::class, 'add_address'])->name('add_address');
            Route::post('/select_city', [SettingController::class, 'select_city']);
            Route::DELETE('/address/destroy', [SettingController::class, 'destroy_address']);
            //Chọn địa chỉ ra phí ship
            Route::post('/get_ship', [CartController::class, 'get_ship']);

            //Tìm kiếm giọng nói
            Route::get('/search_microphone', [HomeController::class, 'search_Microphone']);

            //Chính sách bảo hành
            Route::get('warranty',[HomeController::class,'warranty']);

            //Đăng xuất
            Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

        });

    });

// Back-end - Trang admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::middleware(['guest:admin'])->group(function () {
            Route::view('/login', 'back-end.login.login')->name('login');
            Route::post('/doLogin', [AdminController::class, 'doLogin'])->name('doLogin');

        });

        // Đã đăng nhập thành công
        Route::middleware(['auth:admin'])->group(function () {
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
                Route::get('show/{id}', [SanPhamController::class, 'show']);
                Route::get('active/{id}', [SanPhamController::class, 'active']);
                Route::get('unactive/{id}', [SanPhamController::class, 'unactive']);
            });

            //Mã giảm giá
            Route::prefix('/coupons')->group(function () {
                Route::get('/', [MaGiamGiaController::class, 'index']);
                Route::get('add', [MaGiamGiaController::class, 'create']);
                Route::post('add', [MaGiamGiaController::class, 'store']);
                Route::get('edit/{id}', [MaGiamGiaController::class, 'edit']);
                Route::post('edit/{id}', [MaGiamGiaController::class, 'update']);
                Route::get('show/{id}', [MaGiamGiaController::class, 'show']);
                Route::get('send_coupon_all/{id}', [MaGiamGiaController::class, 'send_coupon_all']);
                Route::get('send_coupon_vip/{id}', [MaGiamGiaController::class, 'send_coupon_vip']);
                Route::get('send_coupon/{id}', [MaGiamGiaController::class, 'send_coupon']);
                Route::DELETE('destroy/{id}', [MaGiamGiaController::class, 'destroy']);
            });

            //Phí vận chuyển
            Route::prefix('/deliveries')->group(function () {
                Route::get('/', [VanChuyenController::class, 'index']);
                Route::get('add', [VanChuyenController::class, 'create']);
                Route::post('add', [VanChuyenController::class, 'store']);
                Route::get('edit/{id}', [VanChuyenController::class, 'edit']);
                Route::post('edit/{id}', [VanChuyenController::class, 'update']);
                Route::DELETE('destroy/{id}', [VanChuyenController::class, 'destroy']);
            });

            //Đơn hàng
            Route::get('/orders', [DonHangController::class, 'index']);
            Route::get('/order_detail/{id}', [DonHangController::class, 'order_detail']);
            Route::post('/order_detail/{id}', [DonHangController::class, 'order_update']);
            //Route::DELETE('/orders/destroy/{id}', [DonHangController::class, 'destroy']);
            //Route::get('/order_detail1/{id}', [DonHangController::class, 'order_detail1']);
            Route::get('/order_detail/view_pdf/{id}', [DonHangController::class, 'view_pdf']);
            Route::get('/order_detail/print_pdf/{id}', [DonHangController::class, 'print_pdf']);

            //Khách hàng
            Route::prefix('/customers')->group(function () {
                Route::get('/', [KhachHangController::class, 'index']);
                Route::get('add', [KhachHangController::class, 'create']);
                Route::post('add', [KhachHangController::class, 'store']);
                Route::get('active/{id}', [KhachHangController::class, 'active']);
                Route::get('unactive/{id}', [KhachHangController::class, 'unactive']);
                Route::get('show/{id}', [KhachHangController::class, 'show']);
                Route::post('/select_city', [KhachHangController::class, 'select_city']);
            });

            //Nhân viên
            Route::prefix('/employees')->group(function () {
                Route::get('/', [NhanVienController::class, 'index']);
                Route::get('add', [NhanVienController::class, 'create']);
                Route::post('add', [NhanVienController::class, 'store']);
                Route::get('active/{id}', [NhanVienController::class, 'active']);
                Route::get('unactive/{id}', [NhanVienController::class, 'unactive']);
                Route::get('/permissions', [NhanVienController::class, 'permissions']);
                Route::get('/permissions/edit/{id}', [NhanVienController::class, 'edit_permission'])->name('edit_permission');
                Route::get('auth/{id}', [NhanVienController::class, 'auth']);
                Route::get('unauth/{id}', [NhanVienController::class, 'unauth']);
            });

            //Người giao hàng
            Route::prefix('/carriers')->group(function () {
                Route::get('/', [NguoiGiaoHangController::class, 'index']);
                Route::get('add', [NguoiGiaoHangController::class, 'create']);
                Route::post('add', [NguoiGiaoHangController::class, 'store']);
                Route::get('active/{id}', [NguoiGiaoHangController::class, 'active']);
                Route::get('unactive/{id}', [NguoiGiaoHangController::class, 'unactive']);
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

            //Nhà cung cấp
            Route::prefix('/suppliers')->group(function () {
                Route::get('/', [NhaCungCapController::class, 'index']);
                Route::get('add', [NhaCungCapController::class, 'create']);
                Route::post('add', [NhaCungCapController::class, 'store']);
                Route::get('edit/{id}', [NhaCungCapController::class, 'edit']);
                Route::post('edit/{id}', [NhaCungCapController::class, 'update']);
            });

            //Nhập kho
            Route::prefix('/warehouses')->group(function () {
                Route::get('/', [NhapKhoController::class, 'index']);
                Route::get('add', [NhapKhoController::class, 'create']);
                //Route::post('autocomplete-ajax', [NhapKhoController::class, 'autocomplete_ajax']);
                Route::get('getProducts', [NhapKhoController::class, 'getProducts']);
                Route::post('add', [NhapKhoController::class, 'store']);
                Route::get('show/{id}', [NhapKhoController::class, 'show']);
                Route::get('active/{id}', [NhapKhoController::class, 'active']);
                Route::DELETE('destroy/{id}', [NhapKhoController::class, 'destroy']);
            });

            //Đánh giá sản phẩm
            Route::prefix('/reviews')->group(function () {
                Route::get('/', [ĐanhGiaController::class, 'index']);
                Route::get('add', [ĐanhGiaController::class, 'create']);
                Route::post('add', [ĐanhGiaController::class, 'store']);
                Route::get('active/{id}', [ĐanhGiaController::class, 'active']);
                Route::get('unactive/{id}', [ĐanhGiaController::class, 'unactive']);
                Route::DELETE('destroy/{id}', [ĐanhGiaController::class, 'destroy']);
            });

            //Đánh giá giao hàng
            Route::prefix('/feedbacks')->group(function () {
                Route::get('/', [PhanHoiController::class, 'index']);
                Route::get('add', [PhanHoiController::class, 'create']);
                Route::post('add', [PhanHoiController::class, 'store']);
                Route::get('active/{id}', [PhanHoiController::class, 'active']);
                Route::get('unactive/{id}', [PhanHoiController::class, 'unactive']);
                Route::DELETE('destroy/{id}', [PhanHoiController::class, 'destroy']);
            });

            //Slider
            Route::prefix('/sliders')->group(function () {
                Route::get('/', [ThanhTruotController::class, 'index']);
                Route::get('add', [ThanhTruotController::class, 'create']);
                Route::post('add', [ThanhTruotController::class, 'store']);
                Route::get('edit/{id}', [ThanhTruotController::class, 'edit']);
                Route::post('edit/{id}', [ThanhTruotController::class, 'update']);
                Route::DELETE('destroy/{id}', [ThanhTruotController::class, 'destroy']);
                Route::get('active/{id}', [ThanhTruotController::class, 'active']);
                Route::get('unactive/{id}', [ThanhTruotController::class, 'unactive']);
            });

            //Route::get('/users2', [KhachHangController::class, 'index1']);
            //Route::get('/user1', [KhachHangController::class, 'index2']);

            //Thống kê doanh thu biểu đồ cột
            Route::post('/days-order', [AdminController::class, 'days_order']);
            Route::post('/dashboard-filter', [AdminController::class, 'dashboard_filter']);
            Route::post('/filter-by-date', [AdminController::class, 'filter_by_date']);

            //Thống kê doanh thu biểu đồ đường
            Route::get('/getChartData', [AdminController::class, 'getChartData'])->name('getChartData');
            Route::get('/getChartDataByYear', [AdminController::class, 'getChartDataByYear'])->name('getChartDataByYear');

            //Thống kê sản phẩm bán chạy bằng table
            Route::post('/product-tops', [AdminController::class, 'product_tops'])->name('product_tops');

            //Đăng xuất
            Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

        });
    });


// Back-end - Trang shipper
Route::prefix('shipper')->name('shipper.')->group(function () {
    Route::middleware(['guest:shipper'])->group(function () {
    Route::view('/login', 'back-end.login.shipper.login')->name('login');
    Route::post('/doLogin', [ShipperController::class, 'doLogin'])->name('doLogin');

});

    // Đã đăng nhập thành công
    Route::middleware(['auth:shipper'])->group(function () {
        Route::get('/', [ShipperController::class, 'getUser'])->name('home');

        //Đơn hàng
        Route::get('/orders', [DonHangShipperController::class, 'index']);

        Route::get('/order_detail/{id}', [DonHangShipperController::class, 'order_detail']);
        Route::post('/order_detail/{id}', [DonHangShipperController::class, 'order_update']);

        //Đăng xuất
        Route::get('/logout', [ShipperController::class, 'logout'])->name('logout');

    });

});
