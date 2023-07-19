<?php

namespace App\Http\Controllers;
use App\Http\Services\CartService;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
// use App\Models\PhieuDatHang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\KhachHang;

use DataTables;

use App\Models\MaGiamGia;

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



    public function showcheckout()
    {
        if(Auth::check()){
            $id = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id)->first();
            $products = $this->cartService->getProduct();
            return view('front-end.checkout', [
                // 'title' => 'Giỏ Hàng',
                'products' => $products,
                'carts' => session()->get('carts'),
                'khachhang' => $khachhang,
                'coupons' => session()->get('coupon')
            ]);
        }else{
            Session::flash('flash_message_error', 'Vui lòng đăng nhập để thanh toán!');
            Session::put('flash_message_error_link', '/user/login');
            return redirect('/carts');
        }
    }

    public function getCart(Request $request)
    {
//        dd($request->input());
        $this->cartService->getCart($request);
        return redirect()->back();
    }

    public function check_coupon(Request $request){
    //dd($request);
        $data = $request->all();
        $coupon = MaGiamGia::where('mgg_MaGiamGia',$data['coupon'])->first();
//        dd($coupon);
        if($coupon){
            $count_coupon = $coupon->count();
//            dd($count_coupon);
            if($count_coupon>0){
                $coupon_session = Session::get('coupon');
//                dd($coupon_session);
                if($coupon_session == true){
                    $is_avaiable = 0;
                    if($is_avaiable==0){
                        $cou[] = array(
                            'id' => $coupon->id,
                            'mgg_MaGiamGia' => $coupon->mgg_MaGiamGia,
                            'mgg_LoaiGiamGia' => $coupon->mgg_LoaiGiamGia,
                            'mgg_GiaTri' => $coupon->mgg_GiaTri,
                        );
//                        dd($cou);
                        session()->put('coupon',$cou);
                    }
                }else{
                    $cou[] = array(
                        'id' => $coupon->id,
                        'mgg_MaGiamGia' => $coupon->mgg_MaGiamGia,
                        'mgg_LoaiGiamGia' => $coupon->mgg_LoaiGiamGia,
                        'mgg_GiaTri' => $coupon->mgg_GiaTri,
                    );
//                    dd($cou);
//                    Session::put('coupon',$cou);
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
