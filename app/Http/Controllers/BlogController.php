<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
use App\Models\BaiViet;
use App\Models\DanhMucBaiViet;
use App\Models\KhachHang;
use App\Models\BinhLuan;
use App\Models\YeuThich;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function blog() {
        if(Auth::check()){
            $id_tk = Auth::user()->id;
            //dd($id_kh);8
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            //dd($khachhang);
            $id_kh = $khachhang->id;
            //dd($id_kh);

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

            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();
            //dd($wish_count);
            return view('front-end.blog',[
                'category_post' => $category_post,
                'posts' => $posts,
                //'product_all' => $product_all,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'limitedArray' => $limitedArray,
                'wish_count' => $wish_count
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
            'limitedArray' => $limitedArray,
        ]);
    }

    public function tag(Request $request, $blog_tag){
        if(Auth::check()){
            $id_tk = Auth::user()->id;
            //dd($id_kh);8
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            //dd($khachhang);
            $id_kh = $khachhang->id;
            //dd($id_kh);

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
                'limitedArray' => $limitedArray,
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
            'limitedArray' => $limitedArray,
        ]);
    }

    public function danhmuc_baiviet($id) {
        if(Auth::check()){
            $id_tk = Auth::user()->id;
            //dd($id_kh);8
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            //dd($khachhang);
            $id_kh = $khachhang->id;
            //dd($id_kh);
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
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();
            //dd($wish_count);
            return view('front-end.danhmuc_baiviet',[
                'cate_po' => $cate_po,
                'category_post' => $category_post,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'bv' =>$bv,
                'limitedArray' => $limitedArray,
                'wish_count' => $wish_count
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
            'limitedArray' => $limitedArray,
        ]);
    }

    public function blog_detail($id) {
        if(Auth::check()){
            $id_tk = Auth::user()->id;
            //dd($id_kh);8
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            //dd($khachhang);
            $id_kh = $khachhang->id;
            //dd($id_kh);

            $post = BaiViet::find($id);
            $post->bv_LuotXem = $post->bv_LuotXem + 1;
            $post->save();

            $id_bv = $post->id;
            $comment = BinhLuan::where('bai_viet_id',$id_bv)->where('bl_TrangThai',1)->get();
            //dd($comment);

            $post_related = BaiViet::where('danh_muc_bai_viet_id',$post->danh_muc_bai_viet_id)->inRandomOrder()->limit(4)->get();
            $carts = $this->cartService->getProduct();
            // dd($carts);
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();
            //dd($wish_count);
            return view('front-end.blog_detail', [
                'post' => $post,
                'comment' => $comment,
                'post_related' => $post_related,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'wish_count' => $wish_count
            ]);
        }else{
            $post = BaiViet::find($id);
            //dd($post);
            $post->bv_LuotXem = $post->bv_LuotXem + 1;
            $post->save();

            $id_bv = $post->id;
            $comment = BinhLuan::where('bai_viet_id',$id_bv)->where('bl_TrangThai',1)->get();
            //dd($comment);

            $post_related = BaiViet::where('danh_muc_bai_viet_id',$post->danh_muc_bai_viet_id)->inRandomOrder()->limit(4)->get();
            $carts = $this->cartService->getProduct();
            return view('front-end.blog_detail', [
                'post' => $post,
                'comment' => $comment,
                'post_related' => $post_related,
                'carts' => $carts,
                'gh' => session()->get('carts'),
            ]);
        }
    }

    public function add_comment(Request $request){
        $this -> validate($request, [
            'bl_NoiDung' => 'required',
        ],
            [
                'bl_NoiDung.required' => 'Vui lòng nhập nội dung bình luận',
            ]);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        if(Auth::check()){
            $id = Auth::user()->id;
            //dd($id);
            $khachhang = KhachHang::where('tai_khoan_id', $id)->first();
            $id_kh = $khachhang->id;

            $bl = new BinhLuan();
            $bl->bai_viet_id = $request->id_bv;
            $bl->khach_hang_id = $id_kh;
            $bl->bl_NoiDung = $request->bl_NoiDung;
            $bl->bl_TrangThai = 0 ;
            //dd($bl);
            $bl->save();

            Session::flash('success_message', 'Thêm bình luận thành công!');
            return redirect()->back();
        }else{
            Session::flash('flash_message_error', 'Vui lòng đăng nhập để bình luận!');
            return redirect()->back();
        }
    }
}
