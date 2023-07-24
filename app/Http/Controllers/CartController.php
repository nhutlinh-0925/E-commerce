<?php

namespace App\Http\Controllers;
use App\Http\Services\CartService;
use App\Models\PhiVanChuyen;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
// use App\Models\PhieuDatHang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\KhachHang;

use DataTables;

use App\Models\MaGiamGia;

use App\Models\DiaChi;

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

    public function show()
    {
        if(Auth::check()){
            $id = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id)->first();
            $products = $this->cartService->getProduct();
            return view('front-end.cart', [
                // 'title' => 'Giỏ Hàng',
                'products' => $products,
                'carts' => session()->get('carts'),
                'khachhang' => $khachhang,
                'coupons' => session()->get('coupon')
            ]);
        }else{
            $products = $this->cartService->getProduct();
            return view('front-end.cart', [
                // 'title' => 'Giỏ Hàng',
                'products' => $products,
                'carts' => session()->get('carts'),
                'coupons' => session()->get('coupon')
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

            return view('front-end.checkout', [
                // 'title' => 'Giỏ Hàng',
                'products' => $products,
                'carts' => session()->get('carts'),
                'khachhang' => $khachhang,
                'coupons' => session()->get('coupon'),
                'address' => $address,
//                'dc_md' => $dc_md,
//                'pvc' => session()->get('pvc'),
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
            'pdh_PhuongThucThanhToan' => 'required',
        ],
            [
                'kh_Ten.required' => 'Vui lòng nhập tên ',
                'kh_SoDienThoai.required' => 'Vui lòng nhập số điện thoại',
                'dc_DiaChi.required' => 'Vui lòng chọn địa chỉ',
                'pdh_PhuongThucThanhToan.required' => 'Vui lòng chọn phương thức thanh toán',
            ]);
        $this->cartService->getCart($request);
        return redirect()->back();
    }

    public function check_coupon(Request $request){
    //dd($request);
        $data = $request->all();
        $coupon = MaGiamGia::where('mgg_MaGiamGia',$data['coupon'])->first();
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
            Session::flash('flash_message_error', 'Mã giảm giá không đúng');
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
             $carts = $this->cartService->getProduct();

             if ($request->ajax())
             {
                 $khach_hang_id = $id;
//                 dd($khach_hang_id);
                 $data = DB::table('phieu_dat_hangs')
                     ->where('khach_hang_id','=',$khach_hang_id)
                     ->orderby('id','desc')
                     ->get();
//                 dd($data);
                 return Datatables::of($data)
                     ->addIndexColumn()
                     ->make(true);
             }

             return view('front-end.purchase_order',[
                 'khachhang' => $khachhang,
                 'carts' => $carts,
                 'gh' => session()->get('carts'),
//                 'get_cart' => $get_cart
             ]);
         }
     }



    public function show_ChitietDonhang($id){
        if(Auth::check()) {
            $id_kh = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id_kh)->first();
//              dd($khachhang);
            $carts = $this->cartService->getProduct();
        }
//        $customer = DB::table('carts')
//            ->select('carts.*')
//            ->where('carts.id', '=', $id)
//            ->first();

//        $cart = DB::table('detail_carts')
//            ->join('products', 'detail_carts.product_id', '=', 'products.id')
//            ->select('detail_carts.*', 'products.*')
//            ->where('detail_carts.cart_id', '=', $id)
//            ->get();

        return view('front-end.detail_order',[
            'khachhang' => $khachhang,
            'carts' => $carts,
            'gh' => session()->get('carts'),
        ]);
    }

//    public function update_DonHang(Request $request, $id){
//        $cart = Cart::find($id);
//        $cart->active = $request->input('active');
//        $cart->save();
//        Session::flash('message', "Successfully updated");
//        return redirect()->back();
//    }




}
