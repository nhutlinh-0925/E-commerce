<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
use App\Models\BaiViet;
use App\Models\DanhMucBaiViet;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function blog() {
        if(Auth::check()){
            $id = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id)->first();
            // dd($khachhang);
            $category_post = DanhMucBaiViet::all()->where('dmbv_TrangThai',1)->sortByDesc("id");
//            $product_all = SanPham::all();
            $posts = BaiViet::orderBy('id', 'desc')->where('bv_TrangThai',1)->paginate(9);

            $carts = $this->cartService->getProduct();
            return view('front-end.blog',[
                'category_post' => $category_post,
                'posts' => $posts,
//                'product_all' => $product_all,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
            ]);
        }else{
            $category_post = DanhMucBaiViet::all()->where('dmbv_TrangThai',1)->sortByDesc("id");
//            $product_all = SanPham::all();
            $posts = BaiViet::orderBy('id', 'desc')->where('bv_TrangThai',1)->paginate(9);

            $carts = $this->cartService->getProduct();
            // dd($carts);
        }
        return view('front-end.blog',[
            'category_post' => $category_post,
            'posts' => $posts,
//            'product_all' => $product_all,
            'carts' => $carts,
            'gh' => session()->get('carts'),
        ]);
    }

    public function blog_detail($id) {
        if(Auth::check()){
            $id_kh = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id_kh)->first();

            $post = BaiViet::find($id);
//            $category_product = DanhMucSanPham::all();
            $post_related = BaiViet::where('danh_muc_bai_viet_id',$post->danh_muc_bai_viet_id)->inRandomOrder()->limit(4)->get();
//             dd($post_related);
            $carts = $this->cartService->getProduct();
            // dd($carts);
            return view('front-end.blog_detail', [
                'post' => $post,
//                'category_product' => $category_product,
                'post_related' => $post_related,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
            ]);
        }else{
            $post = BaiViet::find($id);
//            dd($post);
//            $category_product = DanhMucSanPham::all();
//            $product_related = SanPham::where('danh_muc_san_pham_id',$product->id)->inRandomOrder()->limit(4)->get();
            $post_related = BaiViet::where('danh_muc_bai_viet_id',$post->danh_muc_bai_viet_id)->inRandomOrder()->limit(4)->get();
//             dd($post_related);
            $carts = $this->cartService->getProduct();
            return view('front-end.blog_detail', [
                'post' => $post,
//                'category_product' => $category_product,
                'post_related' => $post_related,
                'carts' => $carts,
                'gh' => session()->get('carts'),
            ]);
        }
    }
}
