<?php

namespace App\Http\Controllers;
use App\Http\Services\CartService;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
// use App\Models\PhieuDatHang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\KhachHang;

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

    public function getCart(Request $request)
    {
        // dd($request->input());
        $this->cartService->getCart($request);
        return redirect()->back();
    }

    public function showcheckout()
    {
        // $products = $this->cartService->getProduct();
        // if (Auth::check()){
        //     return view('front-end.checkout', [
        //         // 'title' => 'Giỏ Hàng',
        //         'products' => $products,
        //         'carts' => session()->get('carts')
        //     ]);
        // }
        // else{
        //     return redirect('/admin/users/login');
        // }

        if(Auth::check()){
            $id = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id)->first();
            return view('front-end.checkout', [
                'khachhang' => $khachhang
            ]);
        }else{
            return view('front-end.checkout');
        }
    }

    // public function show_DonHang($id)
    // {
    //     $user_id= $id;
    //     $get_cart = DB::table('carts')
    //                 ->where('user_id','=',$user_id)
    //                 ->orderby('id','desc')
    //                 ->get();
    //     return view('carts.purchase_order', [
    //         'title' => 'Lịch sử đơn hàng'
    //     ])->with('get_cart',$get_cart);
    // }




}
