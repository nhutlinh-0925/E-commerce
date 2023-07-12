<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhMucSanPham;
use App\Models\ThuongHieu;
use App\Models\SanPham;
// use Cart;

use Illuminate\Support\Facades\Auth;
use App\Models\KhachHang;

use App\Http\Services\CartService;

class ShopController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function shop() {
        if(Auth::check()){
            $id = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id)->first();
            // dd($khachhang);
            $category_product = DanhMucSanPham::all()->where('dmsp_TrangThai',1)->sortByDesc("id");
            $brand = ThuongHieu::all()->where('thsp_TrangThai',1)->sortByDesc("id");
            $product_all = SanPham::all();
            $products = SanPham::paginate(7);

            $carts = $this->cartService->getProduct();
            return view('front-end.shop',[
                'category_product' => $category_product,
                'brand' => $brand,
                'products' => $products,
                'product_all' => $product_all,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
            ]);
        }else{
            $category_product = DanhMucSanPham::all()->where('dmsp_TrangThai',1)->sortByDesc("id");
            $brand = ThuongHieu::all()->where('thsp_TrangThai',1)->sortByDesc("id");
            $product_all = SanPham::all();
            $products = SanPham::paginate(7);

            $carts = $this->cartService->getProduct();
            // dd($carts);
            }
            return view('front-end.shop',[
                'category_product' => $category_product,
                'brand' => $brand,
                'products' => $products,
                'product_all' => $product_all,
                'carts' => $carts,
                'gh' => session()->get('carts'),
            ]);
    }

    public function product_detail($id) {
        if(Auth::check()){
            $id_kh = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id_kh)->first();

            $product = SanPham::find($id);
            $category_product = DanhMucSanPham::all();
            $product_related = SanPham::where('danh_muc_san_pham_id',$product->id)->inRandomOrder()->limit(4)->get();
            // dd($product_related);
            $carts = $this->cartService->getProduct();
            // dd($carts);
            return view('front-end.product_detail', [
                'product' => $product,
                'category_product' => $category_product,
                'product_related' => $product_related,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
            ]);
        }else{
            $product = SanPham::find($id);
            $category_product = DanhMucSanPham::all();
            $product_related = SanPham::where('danh_muc_san_pham_id',$product->id)->inRandomOrder()->limit(4)->get();
            // dd($product_related);
            $carts = $this->cartService->getProduct();
            return view('front-end.product_detail', [
                'product' => $product,
                'category_product' => $category_product,
                'product_related' => $product_related,
                'carts' => $carts,
                'gh' => session()->get('carts'),
            ]);
        }
    }

    // public function store($id,$sp_TenSanPham,$sp_Gia)
    // {
    //     dd($id);
    //     Cart::add($id,$sp_TenSanPham,1,$sp_Gia)->associate('App\Models\SanPham');
    //     session()->flash('success_message','da them');
    //     return redirect()->route('cart');
    // }


}
