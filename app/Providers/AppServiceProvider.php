<?php

namespace App\Providers;

use App\Models\NhanVien;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

use App\Models\BaiViet;
use App\Models\KhachHang;
use App\Models\PhieuDatHang;
use App\Models\SanPham;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        view()->composer('*',function ($view){
            $product_tk = SanPham::all()->count();
            $post_tk = BaiViet::all()->count();
            $order_tk = PhieuDatHang::all()->count();
            $employess_tk = NhanVien::all()->count();
            $customer_tk = KhachHang::all()->count();

            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $tongdonhang = PhieuDatHang::whereBetween('pdh_NgayDat', [$startOfMonth, $endOfMonth])
                ->count();
            $tongdoanhthu = PhieuDatHang::whereBetween('pdh_NgayDat', [$startOfMonth, $endOfMonth])
                ->where('pdh_TrangThai', 4)
                ->sum('pdh_TongTien');

            $pdh_tt_1 = PhieuDatHang::where('pdh_TrangThai',1)->count();
            $pdh_tt_2 = PhieuDatHang::where('pdh_TrangThai',2)->count();
            $pdh_tt_3 = PhieuDatHang::where('pdh_TrangThai',3)->count();
            $pdh_tt_4 = PhieuDatHang::where('pdh_TrangThai',4)->count();
            $pdh_tt_5 = PhieuDatHang::where('pdh_TrangThai',5)->count();
            $pdh_tt_6 = PhieuDatHang::where('pdh_TrangThai',6)->count();

            $pdh_pttt_1 = PhieuDatHang::where('phuong_thuc_thanh_toan_id',1)->count();
            $pdh_pttt_2 = PhieuDatHang::where('phuong_thuc_thanh_toan_id',2)->count();
            $pdh_pttt_3 = PhieuDatHang::where('phuong_thuc_thanh_toan_id',3)->count();

            $view->with([
                'product_tk' => $product_tk,
                'post_tk' => $post_tk,
                'order_tk' => $order_tk,
                'employess_tk' => $employess_tk,
                'customer_tk' => $customer_tk,

                'tongdonhang' => $tongdonhang,
                'tongdoanhthu' => $tongdoanhthu,

                'pdh_tt_1' => $pdh_tt_1,
                'pdh_tt_2' => $pdh_tt_2,
                'pdh_tt_3' => $pdh_tt_3,
                'pdh_tt_4' => $pdh_tt_4,
                'pdh_tt_5' => $pdh_tt_5,
                'pdh_tt_6' => $pdh_tt_6,

                'pdh_pttt_1' => $pdh_pttt_1,
                'pdh_pttt_2' => $pdh_pttt_2,
                'pdh_pttt_3' => $pdh_pttt_3,
            ]);
        });
    }
}
