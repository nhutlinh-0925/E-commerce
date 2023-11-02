<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use App\Models\KhachHang;
use App\Models\MaGiamGia;
use App\Models\NguoiGiaoHang;
use App\Models\NhanVien;
use App\Models\PhieuDatHang;
use App\Models\PhiVanChuyen;
use App\Models\ThongKe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mail;

class DonHangShipperController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $id_ngh = Auth('shipper')->user()->id;
        }
        $orders = PhieuDatHang::where('nguoi_giao_hang_id',$id_ngh)->get()->sortByDesc("id");
        return view('back-end.login.shipper.order',[
            'orders' => $orders,
        ]);
    }

    public function order_detail($id)
    {
        $pdh = PhieuDatHang::find($id);
        $id_mgg = $pdh->ma_giam_gia_id;
        $mgg = MaGiamGia::find($id_mgg);

        $id_kh = $pdh->khach_hang_id;
        $kh = KhachHang::find($id_kh);

        $id_nv = $pdh->nhan_vien_id;
        $nv = NhanVien::find($id_nv);

        $dc = PhieuDatHang::join('khach_hangs', 'khach_hangs.id', '=', 'phieu_dat_hangs.khach_hang_id')
            ->join('dia_chis','khach_hangs.id','=', 'dia_chis.khach_hang_id')
            ->select('dia_chis.*')
            ->where('phieu_dat_hangs.khach_hang_id', '=', $id_kh)
            ->whereColumn('phieu_dat_hangs.pdh_DiaChiGiao', '=', 'dia_chis.dc_DiaChi')
            ->get();

        $id_tp = $dc[0]['tinh_thanh_pho_id'];
        $phiVanChuyen = PhiVanChuyen::where('thanh_pho_id', $id_tp)->first();
        $phi = $phiVanChuyen->pvc_PhiVanChuyen;

        $cart_id = DB::table('chi_tiet_phieu_dat_hangs')
            ->join('san_phams', 'chi_tiet_phieu_dat_hangs.san_pham_id', '=', 'san_phams.id')
            ->join('kich_thuocs', 'chi_tiet_phieu_dat_hangs.kich_thuoc_id', '=', 'kich_thuocs.id')
            ->select('chi_tiet_phieu_dat_hangs.*', 'san_phams.*','kich_thuocs.*')
            ->where('chi_tiet_phieu_dat_hangs.phieu_dat_hang_id', '=', $id)
            ->get();

        $shippers = NguoiGiaoHang::where('trangthai', 1)->get();

        return view('back-end.login.shipper.order_detail',[
            'pdh' => $pdh,
            'kh' => $kh,
            'nv' => $nv,
            'cart_id' => $cart_id,
            'mgg' => $mgg,
            'phi' => $phi,
            'shippers' => $shippers
        ]);
    }

    public function order_update(Request $request, $id){
        //dd($request);
        $order = PhieuDatHang::find($id);
        $order_date = $order->pdh_NgayDat;
        $thongke = ThongKe::where('tk_Ngay',$order_date)->get();

        if($thongke){
            $thongke_dem = $thongke->count();
        }else{
            $thongke_dem = 0;
        }

        if($order->pdh_TrangThai == 3){
            $order->pdh_TrangThaiGiaoHang = $request->pdh_TrangThaiGiaoHang;
            if($order->pdh_TrangThaiGiaoHang == 2){
                //dd(123);
                $total_order = 0; //tong so luong don
                $sales = 0; //doanh thu
                $profit = 0; //loi nhuan
                $quantity = 0; //so luong

                foreach ($order->chitietphieudathang as $detail) {
                    $product = $detail->sanpham;
                    $quantity += $detail->ctpdh_SoLuong;
                    $sales += $detail->ctpdh_Gia * $detail->ctpdh_SoLuong;
                    $profit = $sales - 100000;
                }
                $total_order += 1;

                if ($thongke_dem > 0) {
                    $thongke_capnhat = ThongKe::where('tk_Ngay', $order_date)->first();
                    $thongke_capnhat->tk_TongTien = $thongke_capnhat->tk_TogTien + $sales;
                    $thongke_capnhat->tk_LoiNhuan = $thongke_capnhat->tk_LoiNhuan + $profit;
                    $thongke_capnhat->tk_SoLuong = $thongke_capnhat->tk_SoLuong + $quantity;
                    $thongke_capnhat->tk_TongDonHang = $thongke_capnhat->tk_TongDonHang + $total_order;
                    $thongke_capnhat->save();
                } else {
                    $thongke_moi = new ThongKe();
                    $thongke_moi->tk_Ngay = $order_date;
                    $thongke_moi->tk_SoLuong = $quantity;
                    $thongke_moi->tk_TongTien = $sales;
                    $thongke_moi->tk_LoiNhuan = $profit;
                    $thongke_moi->tk_TongDonHang = $total_order;
                    $thongke_moi->save();
                }

                $order->pdh_TrangThai = 4;
                $order->pdh_TrangThaiGiaoHang = 2;
                $order->save();

                $id_kh = $order->khach_hang_id;
                $tien_hang = $order->pdh_TongTien;
                $customer = KhachHang::find($id_kh);
                $tien = $customer->kh_TongTienDaMua;
                $customer->kh_TongTienDaMua = $tien + $tien_hang;
                if ($customer->kh_TongTienDaMua > 5000000){
                    $customer->vip = 1;
                }elseif($customer->kh_TongTienDaMua < 5000000){
                    $customer->vip = 1;
                }
                $customer->save();

                $pdh = PhieuDatHang::find($id);
                $email = $customer->email;
                $title_mail = "Thông báo giao hàng thành công";

                $mailData = [
                    'id_pdh' => $pdh->id,
                    'kh_Ten' => $customer->kh_Ten,
                ];

                Mail::send('front-end.email_delivery', [$email,'mailData' => $mailData], function ($message) use ($email,$title_mail) {
                    $message->to($email)->subject($title_mail);
                    $message->from($email, $title_mail);
                });
            }elseif($order->pdh_TrangThaiGiaoHang == 3){
                $order->pdh_TrangThai = 6;
                $order->pdh_TrangThaiGiaoHang = 3;
                $order->save();
            }

        }elseif($order->pdh_TrangThai == 2){
            $order->pdh_TrangThaiGiaoHang = $request->pdh_TrangThaiGiaoHang;
            if($order->pdh_TrangThaiGiaoHang == 0){
                $order->nguoi_giao_hang_id = null;
                $order->pdh_TrangThai = 2;
                $order->save();

            }elseif($order->pdh_TrangThaiGiaoHang == 1){
                $order->pdh_TrangThai = 3;
                $order->save();
            }
        }
        Session::flash('success_message', 'Cập nhật trạng thái thành công!');
        return redirect('/shipper/orders');
    }
}
