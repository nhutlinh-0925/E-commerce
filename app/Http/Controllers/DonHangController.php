<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhieuDatHang;
use App\Models\KhachHang;
use App\Models\MaGiamGia;
use App\Models\SanPham;
use App\Models\TaiKhoan;
use App\Models\ThongKe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\PhieuDatHang;
use Illuminate\Support\Facades\Auth;
use App\Models\NhanVien;

use App\Models\DiaChi;
use App\Models\PhiVanChuyen;
use Mail;

class DonHangController extends Controller
{
    public function index()
    {
        // return 123;
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }
        $orders = PhieuDatHang::all()->sortByDesc("id");
        return view('back-end.order.index',[
            'orders' => $orders,
            'nhanvien' => $nhanvien
        ]);
    }

    public function order_detail($id)
    {
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }
        //dd($id);
        $pdh = PhieuDatHang::find($id);
        //dd($pdh);
        $id_pdh = $pdh->id;

        $pdh_DiaChiGiao = $pdh->pdh_DiaChiGiao;

        $id_mgg = $pdh->ma_giam_gia_id;
        //dd($id_mgg);
        $mgg = MaGiamGia::find($id_mgg);
        //dd($mgg);

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
        //dd($dc);

        $id_tp = $dc[0]['tinh_thanh_pho_id'];
        //dd($id_tp);
        $phiVanChuyen = PhiVanChuyen::where('thanh_pho_id', $id_tp)->first();
        $phi = $phiVanChuyen->pvc_PhiVanChuyen;
        // In giá trị pvc_PhiVanChuyen
        //dd($phi);

        $cart_id = DB::table('chi_tiet_phieu_dat_hangs')
            ->join('san_phams', 'chi_tiet_phieu_dat_hangs.san_pham_id', '=', 'san_phams.id')
            ->select('chi_tiet_phieu_dat_hangs.*', 'san_phams.*')
            ->where('chi_tiet_phieu_dat_hangs.phieu_dat_hang_id', '=', $id)
            ->get();
        //dd($cart_id);

        return view('back-end.order.order_detail2',[
            'nhanvien' => $nhanvien,
            'pdh' => $pdh,
            'kh' => $kh,
             'nv' => $nv,
             'cart_id' => $cart_id,
            'mgg' => $mgg,
            'phi' => $phi
        ]);
    }

    public function order_update(Request $request, $id){
//        $data = $request->all();
//        dd($data);
        $order = PhieuDatHang::find($id);
        //dd($order);

        $order_date = $order->pdh_NgayDat;
        $thongke = ThongKe::where('tk_Ngay',$order_date)->get();

        if($thongke){
            $thongke_dem = $thongke->count();
        }else{
            $thongke_dem = 0;
        }

        $newStatus = $request->input('pdh_TrangThai');

        if($newStatus == 5){
            foreach ($order->chitietphieudathang as $detail) {
                $product = $detail->sanpham;
                //dd($product);
                if ($product) {
                    $product->sp_SoLuongHang += $detail->ctpdh_SoLuong;
                    $product->sp_SoLuongBan -= $detail->ctpdh_SoLuong;
                    $product->save();
                }
            }
            //$order->save();
            $order->pdh_TrangThai = $newStatus;
            $order->save();
        }elseif($newStatus == 4) {
            $total_order = 0; //tong so luong don
            $sales = 0; //doanh thu
            $profit = 0; //loi nhuan
            $quantity = 0; //so luong

            foreach ($order->chitietphieudathang as $detail) {
                $product = $detail->sanpham;
                //dd($product);
                $quantity += $detail->ctpdh_SoLuong;
                //dd($quantity);
                $sales += $detail->ctpdh_Gia * $detail->ctpdh_SoLuong;
                //dd($sales);
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

            $order->pdh_TrangThai = $newStatus;
            $order->save();

            $id_kh = $order->khach_hang_id;
            $tien_hang = $order->pdh_TongTien;
            $customer = KhachHang::find($id_kh);
            $tien = $customer->kh_TongTienDaMua;
            $customer->kh_TongTienDaMua = $tien + $tien_hang;
            $customer->save();

            $pdh = PhieuDatHang::find($id);
            $id_kh = $pdh->khach_hang_id;
            $kh = KhachHang::find($id_kh);
            $id_tk = $kh->tai_khoan_id;
            $tk = TaiKhoan::find($id_tk);
            $email = $tk->email;
            $title_mail = "Thông báo giao hàng thành công";

            $mailData = [
                'id_pdh' => $pdh->id,
                'kh_Ten' => $kh->kh_Ten,
            ];

            Mail::send('front-end.email_delivery', [$email,'mailData' => $mailData], function ($message) use ($email,$title_mail) {
                $message->to($email)->subject($title_mail);
                $message->from($email, $title_mail);
            });

        }elseif($newStatus == 2){
            if(Auth::check()){
                $id_tk = Auth::user()->id;
                $nhanvien = NhanVien::where('tai_khoan_id', $id_tk)->first();
                //dd($nhanvien);
                $id_nv = $nhanvien->id;
            }
            $order->nhan_vien_id = $id_nv;
            $order->pdh_TrangThai = $newStatus;
            $order->save();
            //dd($order);

            $pdh = PhieuDatHang::find($id);
            $id_kh = $pdh->khach_hang_id;
            $kh = KhachHang::find($id_kh);

            $id_tk = $kh->tai_khoan_id;
            $tk = TaiKhoan::find($id_tk);

            $cart_id = DB::table('chi_tiet_phieu_dat_hangs')
                ->join('san_phams', 'chi_tiet_phieu_dat_hangs.san_pham_id', '=', 'san_phams.id')
                ->select('chi_tiet_phieu_dat_hangs.*', 'san_phams.*')
                ->where('chi_tiet_phieu_dat_hangs.phieu_dat_hang_id', '=', $id)
                ->get();

            $title_mail = "Đơn hàng của bạn";
            $email = $tk->email;

            $mailData = [
                'id_pdh' => $pdh->id,
                'kh_Ten' => $kh->kh_Ten,
                'kh_SoDienThoai' => $kh->kh_SoDienThoai,
                'pdh_DiaChiGiao' => $pdh->pdh_DiaChiGiao,
                'pdh_created_at' => $pdh->created_at,
                'pdh_pttt' => $pdh->phuong_thuc_thanh_toan_id,
                'pdh_TongTien' => $pdh->pdh_TongTien,
                'cart_id' => $cart_id
            ];

            Mail::send('front-end.email_order', [$email,'mailData' => $mailData], function ($message) use ($email,$title_mail) {
                $message->to($email)->subject($title_mail);
                $message->from($email, $title_mail);
            });


        }
//        else{
//            if(Auth::check()){
//                $id_tk = Auth::user()->id;
//                $nhanvien = NhanVien::where('tai_khoan_id', $id_tk)->first();
//                //dd($nhanvien);
//                $id_nv = $nhanvien->id;
//            }
//            $order->nhan_vien_id = $id_nv;
//            $order->pdh_TrangThai = $newStatus;
//            $order->save();
//        }
        Session::flash('success_message', 'Cập nhật trạng thái thành công!');
//        Session::flash('flash_message', 'Cập nhật trạng thái thành công!');
        return redirect()->back();
    }
}
