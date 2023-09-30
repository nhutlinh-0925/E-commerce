<?php

namespace App\Http\Controllers;
use App\Http\Services\CartService;
use App\Models\PhieuDatHang;
use App\Models\PhiVanChuyen;
use App\Models\PhuongThucThanhToan;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
// use App\Models\PhieuDatHang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\KhachHang;

use DataTables;

use App\Models\MaGiamGia;

use App\Models\DiaChi;
use App\Models\YeuThich;
use Carbon\Carbon;

use App\Models\ThongKe;

class CartController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $result = $this->cartService->create($request);
        // dd($result);
        // dd(session()->get('carts'));
        if ($result === false){
            return redirect()->back();
        }
        return redirect('/carts');
    }

    public function add_cart_shop(Request $request)
    {
        $result = $this->cartService->create($request);
        // dd($result);
        // dd(session()->get('carts'));
        if ($result === false){
            return redirect()->back();
        }
        // Lưu thông báo vào Session
        Session::flash('success_message', 'Thêm giỏ hàng thành công!');
        return redirect()->back();
    }



    public function show()
    {
        if(Auth::check()){
            $id_tk = Auth::user()->id;
            //dd($id_kh);8
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            //dd($khachhang);
            $id_kh = $khachhang->id;
            //dd($id_kh);
            $products = $this->cartService->getProduct();
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();
            //dd($wish_count);
            return view('front-end.cart', [
                // 'title' => 'Giỏ Hàng',
                'products' => $products,
                'carts' => session()->get('carts'),
                'khachhang' => $khachhang,
                'coupons' => session()->get('coupon'),
                'wish_count' => $wish_count
            ]);
        }else{
            $products = $this->cartService->getProduct();
            return view('front-end.cart', [
                // 'title' => 'Giỏ Hàng',
                'products' => $products,
                'carts' => session()->get('carts'),
                'coupons' => session()->get('coupon'),
            ]);
        }
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $this->cartService->update($request);
        return redirect('/carts');
    }

    public function remove($id = 0)
    {
        $this->cartService->remove($id);

        $products = $this->cartService->getProduct();
        if (count ($products) == 0){
            $coupon = Session::get('coupon');
            if($coupon == true){
                Session::forget('coupon');
                return redirect()->back();
            }
        }

        return redirect('/carts');
    }


    //Hàm get checkout
    public function showcheckout()
    {
//        dd($request);
        if(Auth::check()){
            $id = Auth::user()->id;
            //dd($id);
            $khachhang = KhachHang::where('tai_khoan_id', $id)->first();
            $id_kh = $khachhang->id;

            $products = $this->cartService->getProduct();

            $address = DiaChi::where('khach_hang_id', $id_kh)->get();
            //dd($address);
            //$dc_md = DiaChi::where('khach_hang_id', $id)->where('dc_TrangThai', 1)->get();
            //dd($dc_md);
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();
            //dd($wish_count);

            $payments = PhuongThucThanhToan::all();

            return view('front-end.checkout', [
                // 'title' => 'Giỏ Hàng',
                'products' => $products,
                'carts' => session()->get('carts'),
                'khachhang' => $khachhang,
                'coupons' => session()->get('coupon'),
                'address' => $address,
//                'dc_md' => $dc_md,
//                'pvc' => session()->get('pvc'),
                'wish_count' => $wish_count,
                'payments' => $payments
            ]);
        }else{
            Session::flash('flash_message_error', 'Vui lòng đăng nhập để thanh toán!');
            Session::put('flash_message_error_link', '/user/login');
            return redirect('/carts');
        }
    }

    public function get_ship(Request $request)
    {
        // Lấy id địa chỉ từ yêu cầu AJAX
        $addressId = $request->input('address_id');
        //dd($addressId);
        $address = DiaChi::find($addressId);

        if ($address) {
            // Lấy id của tỉnh/thành phố từ địa chỉ
            $thanhPhoId = $address->tinh_thanh_pho_id;

            // Tìm thông tin phí vận chuyển từ bảng `phi_van_chuyens`
            $shippingFee = PhiVanChuyen::where('thanh_pho_id', $thanhPhoId)->value('pvc_PhiVanChuyen');
        } else {
            // Nếu không tìm thấy địa chỉ, mặc định phí vận chuyển là 0 (hoặc giá trị tùy ý)
            $shippingFee = 25000;
        }

        // Trả về kết quả dưới dạng JSON
        return response()->json(['pvc_PhiVanChuyen' => $shippingFee]);
    }

    public function getCart(Request $request)
    {
//        dd($request->input());
        $this -> validate($request, [
            'kh_Ten' => 'required',
            'kh_SoDienThoai' => 'required',
            'dc_DiaChi' => 'required',
            'phuong_thuc_thanh_toan_id' => 'required',
        ],
            [
                'kh_Ten.required' => 'Vui lòng nhập tên ',
                'kh_SoDienThoai.required' => 'Vui lòng nhập số điện thoại',
                'dc_DiaChi.required' => 'Vui lòng chọn địa chỉ',
                'phuong_thuc_thanh_toan_id.required' => 'Vui lòng chọn phương thức thanh toán',
            ]);
        $this->cartService->getCart($request);
        Session::flash('flash_message_checkout', 'Đặt hàng thành công!');
        return redirect('/shop');
        //return redirect()->back();
    }

    public function check_coupon(Request $request){
    //dd($request);
        $now = \Carbon\Carbon::now('Asia/Ho_Chi_Minh');
        $data = $request->all();
        $coupon = MaGiamGia::where('mgg_MaGiamGia',$data['coupon'])
                            ->where(\DB::raw('DATE(mgg_NgayKetThuc)'), '>=', $now->toDateString())
                           ->first();
        //dd($coupon);
        if($coupon){
            $count_coupon = $coupon->count();
            //dd($count_coupon);
            if($count_coupon>0){
                $coupon_session = Session::get('coupon');
                //dd($coupon_session);
                if($coupon_session == true){
                    $is_avaiable = 0;
                    if($is_avaiable==0){
                        $cou[] = array(
                            'id' => $coupon->id,
                            'mgg_MaGiamGia' => $coupon->mgg_MaGiamGia,
                            'mgg_SoLuongMa' => $coupon->mgg_SoLuongMa,
                            'mgg_LoaiGiamGia' => $coupon->mgg_LoaiGiamGia,
                            'mgg_GiaTri' => $coupon->mgg_GiaTri,
                        );
                        //dd($cou);
                        session()->put('coupon',$cou);
                    }
                }else{
                    $cou[] = array(
                        'id' => $coupon->id,
                        'mgg_MaGiamGia' => $coupon->mgg_MaGiamGia,
                        'mgg_SoLuongMa' => $coupon->mgg_SoLuongMa,
                        'mgg_LoaiGiamGia' => $coupon->mgg_LoaiGiamGia,
                        'mgg_GiaTri' => $coupon->mgg_GiaTri,
                    );
                    //dd($cou);
                      session()->put('coupon',$cou);

                }
                Session::save();
                Session::flash('flash_message', 'Thêm mã giảm giá thành công');
                return redirect()->back();
            }

        }else{
            Session::flash('flash_message_error', 'Mã giảm giá không đúng hoặc hết hạn');
            return redirect()->back();
        }
    }

    public function delete_coupon(){
        $coupon = Session::get('coupon');
        if($coupon == true){
            Session::forget('coupon');
            Session::flash('flash_message', 'Xóa mã giảm giá thành công');
            return redirect()->back();
        }
    }

     public function show_DonHang(Request $request, $id){
//        dd($request);
         if(Auth::check()){
             $id_kh = Auth::user()->id;
             $khachhang = KhachHang::where('tai_khoan_id', $id_kh)->first();
//              dd($khachhang);
             $id_kh = $khachhang->id;
             //dd($id_kh);
             $carts = $this->cartService->getProduct();
             $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();
             //dd($wish_count);

             if ($request->ajax())
             {
                 $khach_hang_id = $id;
//                 dd($khach_hang_id);
                 $data = DB::table('phieu_dat_hangs')
                     ->where('khach_hang_id','=',$khach_hang_id)
//                     ->orderby('id','asc')
                     ->get();
                 //dd($data);
                 return Datatables::of($data)
                     ->addIndexColumn()
                     ->make(true);
             }

             return view('front-end.purchase_order',[
                 'khachhang' => $khachhang,
                 'carts' => $carts,
                 'gh' => session()->get('carts'),
//                 'get_cart' => $get_cart,
                 'wish_count' => $wish_count
             ]);
         }
     }



    public function show_ChitietDonhang($id){
        if(Auth::check()) {
            $id_tk = Auth::user()->id;
            //dd($id_kh);8
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            //dd($khachhang);
            $id_kh = $khachhang->id;
            //dd($id_kh);
            $carts = $this->cartService->getProduct();
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();
            //dd($wish_count);

            $pdh = PhieuDatHang::find($id);

            $kh = KhachHang::find($id_kh);

            $id_mgg = $pdh->ma_giam_gia_id;
            //dd($id_mgg);
            $mgg = MaGiamGia::find($id_mgg);
            //dd($mgg);

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

            $cart_id = DB::table('chi_tiet_phieu_dat_hangs')
                ->join('san_phams', 'chi_tiet_phieu_dat_hangs.san_pham_id', '=', 'san_phams.id')
                ->select('chi_tiet_phieu_dat_hangs.*', 'san_phams.*')
                ->where('chi_tiet_phieu_dat_hangs.phieu_dat_hang_id', '=', $id)
                ->get();
        }

        return view('front-end.detail_order',[
            'khachhang' => $khachhang,
            'carts' => $carts,
            'gh' => session()->get('carts'),
            'wish_count' => $wish_count,

            'pdh' => $pdh,
            'kh' => $kh,
            'cart_id' => $cart_id,
            'mgg' => $mgg,
            'phi' => $phi,
            'id_kh' => $id_kh
        ]);
    }

    public function order_update(Request $request, $id){
        $data = $request->all();
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

            foreach ($order->chitietphieudathang as $detail){
                $product = $detail->sanpham;
                //dd($product);
                $quantity += $detail->ctpdh_SoLuong;
                //dd($quantity);
                $sales += $detail->ctpdh_Gia * $detail->ctpdh_SoLuong;
                //dd($sales);
                $profit = $sales - 100000;
            }
            $total_order += 1;

            if($thongke_dem > 0){
                $thongke_capnhat = ThongKe::where('tk_Ngay',$order_date)->first();
                $thongke_capnhat->tk_TongTien = $thongke_capnhat->tk_TogTien + $sales;
                $thongke_capnhat->tk_LoiNhuan = $thongke_capnhat->tk_LoiNhuan + $profit;
                $thongke_capnhat->tk_SoLuong = $thongke_capnhat->tk_SoLuong + $quantity;
                $thongke_capnhat->tk_TongDonHang = $thongke_capnhat->tk_TongDonHang + $total_order;
                $thongke_capnhat->save();
            }else{
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


        }else{

        }
        Session::flash('flash_message', 'Cập nhật trạng thái thành công!');
        return redirect()->back();
    }




}
