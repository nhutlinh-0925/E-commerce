<?php

namespace App\Providers;

use App\Models\NhanVien;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

use App\Models\BaiViet;
use App\Models\KhachHang;
use App\Models\PhieuDatHang;
use App\Models\SanPham;

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

            $view->with([
                'product_tk' => $product_tk,
                'post_tk' => $post_tk,
                'order_tk' => $order_tk,
                'employess_tk' => $employess_tk,
                'customer_tk' => $customer_tk
            ]);
        });
    }
}
