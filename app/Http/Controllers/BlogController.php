<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
use App\Models\BaiViet;
use App\Models\DanhMucBaiViet;
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
            $id_kh = Auth('web')->user()->id;
            $category_post = DanhMucBaiViet::all()->where('dmbv_TrangThai',1)->sortByDesc("id");

            $tags = BaiViet::pluck('bv_Tag')->all();
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
            // Giới hạn mảng chỉ còn tối đa 8 phần tử
            $limitedArray = array_slice($mergedArray, 0, 8);

            $posts = BaiViet::orderBy('id', 'desc')->where('bv_TrangThai',1)->paginate(9);

            $carts = $this->cartService->getProduct();

            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();

            return view('front-end.blog',[
                'category_post' => $category_post,
                'posts' => $posts,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'limitedArray' => $limitedArray,
                'wish_count' => $wish_count
            ]);
        }else{
            $category_post = DanhMucBaiViet::all()->where('dmbv_TrangThai',1)->sortByDesc("id");
            $posts = BaiViet::orderBy('id', 'desc')->where('bv_TrangThai',1)->paginate(9);

            $tags = BaiViet::pluck('bv_Tag')->all();
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
            // Giới hạn mảng chỉ còn tối đa 8 phần tử
            $limitedArray = array_slice($mergedArray, 0, 8);

            $carts = $this->cartService->getProduct();
        }
        return view('front-end.blog',[
            'category_post' => $category_post,
            'posts' => $posts,
            'carts' => $carts,
            'gh' => session()->get('carts'),
            'limitedArray' => $limitedArray,
        ]);
    }

    public function tag(Request $request, $blog_tag){
        if(Auth::check()){
            $id_kh = Auth('web')->user()->id;
            $category_post = DanhMucBaiViet::all()->where('dmbv_TrangThai',1)->sortByDesc("id");
            $tags = BaiViet::pluck('bv_Tag')->all();
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
            // Giới hạn mảng chỉ còn tối đa 8 phần tử
            $limitedArray = array_slice($mergedArray, 0, 8);

            $tag = str_replace("-"," ",$blog_tag);
            $blog_tag = DB::table('bai_viets')->where('bv_TieuDeBaiViet','like','%'.$tag.'%')
                ->orWhere('bv_Tag','like','%'.$tag.'%')
                ->where('bv_TrangThai',1)
                ->orderBy('id', 'desc')
                ->paginate(9);

            $carts = $this->cartService->getProduct();
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();
            return view('front-end.blog_tag',[
                'category_post' => $category_post,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'blog_tag' => $blog_tag,
                'tag' => $tag,
                'limitedArray' => $limitedArray,
                'wish_count' => $wish_count
            ]);
        }else{
            $category_post = DanhMucBaiViet::all()->where('dmbv_TrangThai',1)->sortByDesc("id");
            $tags = BaiViet::pluck('bv_Tag')->all();
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
            // Giới hạn mảng chỉ còn tối đa 8 phần tử
            $limitedArray = array_slice($mergedArray, 0, 8);

            $tag = str_replace("-"," ",$blog_tag);
            $blog_tag = DB::table('bai_viets')->where('bv_TieuDeBaiViet','like','%'.$tag.'%')
                ->orWhere('bv_Tag','like','%'.$tag.'%')
                ->where('bv_TrangThai',1)
                ->orderBy('id', 'desc')
                ->paginate(9);
            $carts = $this->cartService->getProduct();
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
            $id_kh = Auth('web')->user()->id;
            $cate_po = DanhMucBaiViet::find($id);
            $category_post = DanhMucBaiViet::all()->where('dmbv_TrangThai',1)->sortByDesc("id");

            $tags = BaiViet::pluck('bv_Tag')->all();
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
            // Giới hạn mảng chỉ còn tối đa 8 phần tử
            $limitedArray = array_slice($mergedArray, 0, 8);

            $id_bv = $id;
            $bv = BaiViet::where('danh_muc_bai_viet_id',$id_bv)
                ->where('bv_TrangThai',1)
                ->orderBy('id', 'desc')
                ->paginate(9);

            $carts = $this->cartService->getProduct();
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();
            //dd($wish_count);
            return view('front-end.danhmuc_baiviet',[
                'cate_po' => $cate_po,
                'category_post' => $category_post,
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
            // Giới hạn mảng chỉ còn tối đa 8 phần tử
            $limitedArray = array_slice($mergedArray, 0, 8);

            $id_bv = $id;
            $bv = BaiViet::where('danh_muc_bai_viet_id',$id_bv)
                ->where('bv_TrangThai',1)
                ->orderBy('id', 'desc')
                ->paginate(9);

            $carts = $this->cartService->getProduct();

        }
        return view('front-end.danhmuc_baiviet',[
            'cate_po' => $cate_po,
            'category_post' => $category_post,
            'carts' => $carts,
            'gh' => session()->get('carts'),
            'bv' => $bv,
            'limitedArray' => $limitedArray,
        ]);
    }

    public function blog_detail($id) {
        if(Auth::check()){
            $id_kh = Auth('web')->user()->id;
            $post = BaiViet::find($id);
            $post->bv_LuotXem = $post->bv_LuotXem + 1;
            $post->save();

            $id_bv = $post->id;
            $comment = BinhLuan::where('bai_viet_id',$id_bv)->where('bl_TrangThai',1)->get();

            $post_related = BaiViet::where('danh_muc_bai_viet_id',$post->danh_muc_bai_viet_id)->inRandomOrder()->limit(4)->get();
            $carts = $this->cartService->getProduct();

            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();

            return view('front-end.blog_detail', [
                'post' => $post,
                'comment' => $comment,
                'post_related' => $post_related,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'wish_count' => $wish_count
            ]);
        }else{
            $post = BaiViet::find($id);
            $post->bv_LuotXem = $post->bv_LuotXem + 1;
            $post->save();

            $id_bv = $post->id;
            $comment = BinhLuan::where('bai_viet_id',$id_bv)->where('bl_TrangThai',1)->get();

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
            'bl_NoiDung' => 'required|min:3|max:255',
        ],
            [
                'bl_NoiDung.required' => 'Vui lòng nhập nội dung bình luận',
                'bl_NoiDung.min' => 'Bình luận phải lớn hơn 3 kí tự',
                'bl_NoiDung.max' => 'Bình luận phải nhỏ hơn 255 kí tự',
            ]);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        if(Auth::check()){
            $id_kh = Auth('web')->user()->id;

            $bl = new BinhLuan();
            $bl->bai_viet_id = $request->id_bv;
            $bl->khach_hang_id = $id_kh;
            $bl->bl_NoiDung = $request->bl_NoiDung;
            $bl->bl_TrangThai = 1 ;
            $bl->save();

            Session::flash('success_message', 'Thêm bình luận thành công!');
            return redirect()->back();
        }else{
            Session::flash('flash_message_error', 'Vui lòng đăng nhập để bình luận!');
            return redirect()->back();
        }
    }
}
