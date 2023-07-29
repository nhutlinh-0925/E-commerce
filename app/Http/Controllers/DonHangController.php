<?php

namespace App\Http\Controllers;

use App\Models\ChiTietPhieuDatHang;
use App\Models\KhachHang;
use App\Models\MaGiamGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\PhieuDatHang;
use Illuminate\Support\Facades\Auth;
use App\Models\NhanVien;

use App\Models\DiaChi;
use App\Models\PhiVanChuyen;

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


        return view('back-end.order.order_detail',[
            'nhanvien' => $nhanvien,
            'pdh' => $pdh,
            'kh' => $kh,
             'cart_id' => $cart_id,
            'mgg' => $mgg,
            'phi' => $phi
        ]);
    }

    public function order_update(Request $request, $id){
        $order = PhieuDatHang::find($id);
        //dd($order);
        $order->pdh_TrangThai = $request->input('pdh_TrangThai');
        $order->save();
        Session::flash('flash_message', 'Cập nhật trạng thái thành công!');
        return redirect()->back();
    }
}
