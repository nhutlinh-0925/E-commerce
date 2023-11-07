<?php

namespace App\Http\Controllers;

use App\Models\DiaChi;
use App\Models\KhachHang;
use App\Models\MaGiamGia;
use App\Models\SanPhamKichThuoc;
use App\Models\ThongKe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\PhieuDatHang;
use Illuminate\Support\Facades\Auth;
use App\Models\NhanVien;

use App\Models\PhiVanChuyen;
use Mail;
use App\Models\NguoiGiaoHang;

class DonHangController extends Controller
{
    public function index()
    {
        $orders = PhieuDatHang::all()->sortByDesc("id");
        return view('back-end.order.index',[
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

        $dc_giao = $pdh->pdh_DiaChiGiao;
        $dc = DiaChi::where('dc_DiaChi',$dc_giao)->get();
        //dd($dc);
        $id_tp = $dc[0]->tinh_thanh_pho_id;

        $phiVanChuyen = PhiVanChuyen::where('thanh_pho_id', $id_tp)->get();
        //dd($phiVanChuyen);
        if($phiVanChuyen->isNotEmpty()){
            $phi = $phiVanChuyen[0]['pvc_PhiVanChuyen'];
        }else{
            $phi = 25000;
        }
        //$phi = $phiVanChuyen[0]->pvc_PhiVanChuyen;
        //dd($phi);

        $cart_id = DB::table('chi_tiet_phieu_dat_hangs')
            ->join('san_phams', 'chi_tiet_phieu_dat_hangs.san_pham_id', '=', 'san_phams.id')
            ->join('kich_thuocs', 'chi_tiet_phieu_dat_hangs.kich_thuoc_id', '=', 'kich_thuocs.id')
            ->select('chi_tiet_phieu_dat_hangs.*', 'san_phams.*','kich_thuocs.*')
            ->where('chi_tiet_phieu_dat_hangs.phieu_dat_hang_id', '=', $id)
            ->get();

        $shippers = NguoiGiaoHang::where('trangthai', 1)->get();

        return view('back-end.order.order_detail2',[
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
        $order = PhieuDatHang::find($id);
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
                if ($product) {
                    $product->sp_SoLuongBan -= $detail->ctpdh_SoLuong;
                    $product->save();

                    // Truy vấn dữ liệu trong bảng san_pham_kich_thuocs
                    $spkt = SanPhamKichThuoc::where('san_pham_id', $product->id)
                        ->where('kich_thuoc_id', $detail->kichthuoc->id) // Thay kichthuoc bằng tên quan hệ trong model PhieuDatHang
                        ->first();

                    if ($spkt) {
                        // Cập nhật spkt_SoLuongHang bằng cách trừ đi ctpdh_SoLuong
                        $spkt->spkt_soLuongHang += $detail->ctpdh_SoLuong;
                        $spkt->save();
                        //dd($spkt);
                    }
                }
            }
            $order->pdh_TrangThai = $newStatus;
            $order->save();
        }elseif($newStatus == 2){
            $id_nv = Auth('admin')->user()->id;
            if($order->nhan_vien_id == '' && $order->nguoi_giao_hang == ''){
                $order->nguoi_giao_hang_id = $request->nguoi_giao_hang_id;
                $order->nhan_vien_id = $id_nv;
                $order->pdh_TrangThai = $newStatus;
                $order->pdh_TrangThaiGiaoHang = 1;
                $order->save();
                //dd($order);

                $pdh = PhieuDatHang::find($id);
                $id_kh = $pdh->khach_hang_id;
                $kh = KhachHang::find($id_kh);

                $cart_id = DB::table('chi_tiet_phieu_dat_hangs')
                    ->join('san_phams', 'chi_tiet_phieu_dat_hangs.san_pham_id', '=', 'san_phams.id')
                    ->join('kich_thuocs', 'chi_tiet_phieu_dat_hangs.kich_thuoc_id', '=', 'kich_thuocs.id')
                    ->select('chi_tiet_phieu_dat_hangs.*', 'san_phams.*','kich_thuocs.*')
                    ->where('chi_tiet_phieu_dat_hangs.phieu_dat_hang_id', '=', $id)
                    ->get();

                $title_mail = "Đơn hàng của bạn";
                $email = $kh->email;

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
            }elseif($order->nhan_vien_id != '' && $order->nguoi_giao_hang == ''){
                $order->nguoi_giao_hang_id = $request->nguoi_giao_hang_id;
                $order->pdh_TrangThai = $newStatus;
                $order->pdh_TrangThaiGiaoHang = 1;
                $order->save();
                //dd($order);
            }

        }

        Session::flash('success_message', 'Cập nhật trạng thái thành công!');
        return redirect('/admin/orders');
    }
}
