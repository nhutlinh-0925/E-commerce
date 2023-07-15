<?php

namespace App\Http\Controllers;
use App\Http\Services\CartService;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
// use App\Models\PhieuDatHang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\KhachHang;

use App\Models\TaiKhoan;
use DataTables;

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
                'khachhang' => $khachhang
            ]);
        }else{
            $products = $this->cartService->getProduct();
            return view('front-end.cart', [
                // 'title' => 'Giỏ Hàng',
                'products' => $products,
                'carts' => session()->get('carts'),
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
                'khachhang' => $khachhang
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
//                 dd($get_cart);
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



//    public function show_ChitietDonhang($id){
//        $customer = DB::table('carts')
//            ->select('carts.*')
//            ->where('carts.id', '=', $id)
//            ->first();
//
//        $cart = DB::table('detail_carts')
//            ->join('products', 'detail_carts.product_id', '=', 'products.id')
//            ->select('detail_carts.*', 'products.*')
//            ->where('detail_carts.cart_id', '=', $id)
//            ->get();
//
//        return view('carts.detail_order',[
//            'title' => 'Chi tiết đơn hàng'
//        ])->with('customer',$customer)->with('cart',$cart);
//    }

//    public function update_DonHang(Request $request, $id){
//        $cart = Cart::find($id);
//        $cart->active = $request->input('active');
//        $cart->save();
//        Session::flash('message', "Successfully updated");
//        return redirect()->back();
//    }




}
