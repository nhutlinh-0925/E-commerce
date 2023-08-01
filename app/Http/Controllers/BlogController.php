<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
use App\Models\BaiViet;
use App\Models\DanhMucBaiViet;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function blog() {
        if(Auth::check()){
            $id_kh = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id_kh)->first();
            // dd($khachhang);
            $category_post = DanhMucBaiViet::all()->where('dmbv_TrangThai',1)->sortByDesc("id");
            //$product_all = SanPham::all();

            $tags = BaiViet::pluck('bv_Tag')->all();
            //dd($tags);
            // Khởi tạo mảng trống để chứa kết quả
            $mergedArray = [];
            // Lặp qua mảng ban đầu và gộp các chuỗi vào mảng kết quả
            foreach ($tags as $item) {
                if (!is_null($item)) {
                    $tags = explode(',', $item);
                    $mergedArray = array_merge($mergedArray, $tags);
                }
            }
            // Xóa các phần tử trùng lặp trong mảng kết quả (nếu muốn)
            $mergedArray = array_unique($mergedArray);
            //dd($mergedArray);
            // Giới hạn mảng chỉ còn tối đa 8 phần tử
            $limitedArray = array_slice($mergedArray, 0, 8);
            //dd($limitedArray);

            $posts = BaiViet::orderBy('id', 'desc')->where('bv_TrangThai',1)->paginate(9);

            $carts = $this->cartService->getProduct();
            return view('front-end.blog',[
                'category_post' => $category_post,
                'posts' => $posts,
                //'product_all' => $product_all,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'limitedArray' => $limitedArray
            ]);
        }else{
            $category_post = DanhMucBaiViet::all()->where('dmbv_TrangThai',1)->sortByDesc("id");
            //$product_all = SanPham::all();
            $posts = BaiViet::orderBy('id', 'desc')->where('bv_TrangThai',1)->paginate(9);

            $tags = BaiViet::pluck('bv_Tag')->all();
            //dd($tags);
            // Khởi tạo mảng trống để chứa kết quả
            $mergedArray = [];
            // Lặp qua mảng ban đầu và gộp các chuỗi vào mảng kết quả
            foreach ($tags as $item) {
                if (!is_null($item)) {
                    $tags = explode(',', $item);
                    $mergedArray = array_merge($mergedArray, $tags);
                }
            }
            // Xóa các phần tử trùng lặp trong mảng kết quả (nếu muốn)
            $mergedArray = array_unique($mergedArray);
            //dd($mergedArray);
            // Giới hạn mảng chỉ còn tối đa 8 phần tử
            $limitedArray = array_slice($mergedArray, 0, 8);
            //dd($limitedArray);

            $carts = $this->cartService->getProduct();
            // dd($carts);
        }
        return view('front-end.blog',[
            'category_post' => $category_post,
            'posts' => $posts,
            //'product_all' => $product_all,
            'carts' => $carts,
            'gh' => session()->get('carts'),
            'limitedArray' => $limitedArray
        ]);
    }

    public function tag(Request $request, $blog_tag){
        if(Auth::check()){
            $id = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id)->first();
            // dd($khachhang);

            $category_post = DanhMucBaiViet::all()->where('dmbv_TrangThai',1)->sortByDesc("id");

            $tags = BaiViet::pluck('bv_Tag')->all();
            //dd($tags);
            // Khởi tạo mảng trống để chứa kết quả
            $mergedArray = [];
            // Lặp qua mảng ban đầu và gộp các chuỗi vào mảng kết quả
            foreach ($tags as $item) {
                if (!is_null($item)) {
                    $tags = explode(',', $item);
                    $mergedArray = array_merge($mergedArray, $tags);
                }
            }
            // Xóa các phần tử trùng lặp trong mảng kết quả (nếu muốn)
            $mergedArray = array_unique($mergedArray);
            //dd($mergedArray);
            // Giới hạn mảng chỉ còn tối đa 8 phần tử
            $limitedArray = array_slice($mergedArray, 0, 8);
            //dd($limitedArray);

            $tag = str_replace("-"," ",$blog_tag);
            $blog_tag = DB::table('bai_viets')->where('bv_TieuDeBaiViet','like','%'.$tag.'%')
                ->orWhere('bv_Tag','like','%'.$tag.'%')
                ->where('bv_TrangThai',1)
                ->orderBy('id', 'desc')
                ->paginate(9);
            //dd($blog_tag);
            $carts = $this->cartService->getProduct();
            return view('front-end.blog_tag',[
                'category_post' => $category_post,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'blog_tag' => $blog_tag,
                'tag' => $tag,
                'limitedArray' => $limitedArray
            ]);
        }else{
            $category_post = DanhMucBaiViet::all()->where('dmbv_TrangThai',1)->sortByDesc("id");
            $tags = BaiViet::pluck('bv_Tag')->all();
            //dd($tags);
            // Khởi tạo mảng trống để chứa kết quả
            $mergedArray = [];
            // Lặp qua mảng ban đầu và gộp các chuỗi vào mảng kết quả
            foreach ($tags as $item) {
                if (!is_null($item)) {
                    $tags = explode(',', $item);
                    $mergedArray = array_merge($mergedArray, $tags);
                }
            }
            // Xóa các phần tử trùng lặp trong mảng kết quả (nếu muốn)
            $mergedArray = array_unique($mergedArray);
            //dd($mergedArray);
            // Giới hạn mảng chỉ còn tối đa 8 phần tử
            $limitedArray = array_slice($mergedArray, 0, 8);
            //dd($limitedArray);

            $tag = str_replace("-"," ",$blog_tag);
            //dd($tag);
            $blog_tag = DB::table('bai_viets')->where('bv_TieuDeBaiViet','like','%'.$tag.'%')
                ->orWhere('bv_Tag','like','%'.$tag.'%')
                ->where('bv_TrangThai',1)
                ->orderBy('id', 'desc')
                ->paginate(9);
            //dd($blog_tag);
            $carts = $this->cartService->getProduct();
            // dd($carts);
        }
        return view('front-end.blog_tag',[
            'category_post' => $category_post,
            'carts' => $carts,
            'gh' => session()->get('carts'),
            'blog_tag' => $blog_tag,
            'tag' => $tag,
            'limitedArray' => $limitedArray
        ]);
    }

    public function danhmuc_baiviet($id) {
        if(Auth::check()){
            $id_kh = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id_kh)->first();
            // dd($khachhang);
            $cate_po = DanhMucBaiViet::find($id);
            $category_post = DanhMucBaiViet::all()->where('dmbv_TrangThai',1)->sortByDesc("id");
            //$product_all = SanPham::all();

            $tags = BaiViet::pluck('bv_Tag')->all();
            //dd($tags);
            // Khởi tạo mảng trống để chứa kết quả
            $mergedArray = [];
            // Lặp qua mảng ban đầu và gộp các chuỗi vào mảng kết quả
            foreach ($tags as $item) {
                if (!is_null($item)) {
                    $tags = explode(',', $item);
                    $mergedArray = array_merge($mergedArray, $tags);
                }
            }
            // Xóa các phần tử trùng lặp trong mảng kết quả (nếu muốn)
            $mergedArray = array_unique($mergedArray);
            //dd($mergedArray);
            // Giới hạn mảng chỉ còn tối đa 8 phần tử
            $limitedArray = array_slice($mergedArray, 0, 8);
            //dd($limitedArray);

            $id_bv = $id;
            $bv = BaiViet::where('danh_muc_bai_viet_id',$id_bv)
                ->where('bv_TrangThai',1)
                ->orderBy('id', 'desc')
                ->paginate(9);
            //dd($bv);

            $carts = $this->cartService->getProduct();
            return view('front-end.danhmuc_baiviet',[
                'cate_po' => $cate_po,
                'category_post' => $category_post,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'bv' =>$bv,
                'limitedArray' => $limitedArray
            ]);
        }else{
            $cate_po = DanhMucBaiViet::find($id);
            $category_post = DanhMucBaiViet::all()->where('dmbv_TrangThai',1)->sortByDesc("id");

            $tags = BaiViet::pluck('bv_Tag')->all();
            //dd($tags);
            // Khởi tạo mảng trống để chứa kết quả
            $mergedArray = [];
            // Lặp qua mảng ban đầu và gộp các chuỗi vào mảng kết quả
            foreach ($tags as $item) {
                if (!is_null($item)) {
                    $tags = explode(',', $item);
                    $mergedArray = array_merge($mergedArray, $tags);
                }
            }
            // Xóa các phần tử trùng lặp trong mảng kết quả (nếu muốn)
            $mergedArray = array_unique($mergedArray);
            //dd($mergedArray);
            // Giới hạn mảng chỉ còn tối đa 8 phần tử
            $limitedArray = array_slice($mergedArray, 0, 8);
            //dd($limitedArray);

            $id_bv = $id;
            $bv = BaiViet::where('danh_muc_bai_viet_id',$id_bv)
                ->where('bv_TrangThai',1)
                ->orderBy('id', 'desc')
                ->paginate(9);
            //dd($sp);

            $carts = $this->cartService->getProduct();
            // dd($carts);
        }
        return view('front-end.danhmuc_baiviet',[
            'cate_po' => $cate_po,
            'category_post' => $category_post,
            //'posts' => $posts,
            //'product_all' => $product_all,
            'carts' => $carts,
            'gh' => session()->get('carts'),
            'bv' => $bv,
            'limitedArray' => $limitedArray
        ]);
    }

    public function blog_detail($id) {
        if(Auth::check()){
            $id_kh = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id_kh)->first();

            $post = BaiViet::find($id);
            $post_related = BaiViet::where('danh_muc_bai_viet_id',$post->danh_muc_bai_viet_id)->inRandomOrder()->limit(4)->get();
            $carts = $this->cartService->getProduct();
            // dd($carts);
            return view('front-end.blog_detail', [
                'post' => $post,
                'post_related' => $post_related,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
            ]);
        }else{
            $post = BaiViet::find($id);
            //dd($post);

            $post_related = BaiViet::where('danh_muc_bai_viet_id',$post->danh_muc_bai_viet_id)->inRandomOrder()->limit(4)->get();
            $carts = $this->cartService->getProduct();

            return view('front-end.blog_detail', [
                'post' => $post,
                'post_related' => $post_related,
                'carts' => $carts,
                'gh' => session()->get('carts'),
            ]);
        }
    }
}
