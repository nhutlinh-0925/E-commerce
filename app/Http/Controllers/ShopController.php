<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhMucSanPham;
use App\Models\ThuongHieu;
use App\Models\SanPham;
use App\Models\YeuThich;

use Illuminate\Support\Facades\Auth;
use App\Models\KhachHang;

use App\Http\Services\CartService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function shop() {
        if(Auth::check()){
            $id_tk = Auth::user()->id;
            //dd($id_kh);8
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            //dd($khachhang);
            $id_kh = $khachhang->id;
            //dd($id_kh);
            $category_product = DanhMucSanPham::all()->where('dmsp_TrangThai',1)->sortByDesc("id");
            $brand = ThuongHieu::all()->where('thsp_TrangThai',1)->sortByDesc("id");
//            $product_all = SanPham::all();
            $products = SanPham::orderBy('id', 'desc')->where('sp_TrangThai',1)->paginate(9);


            $tags = SanPham::pluck('sp_Tag')->all();
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

            $favoritedProducts = YeuThich::where('khach_hang_id', $id_kh)->pluck('san_pham_id')->toArray();

            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();
            //dd($wish_count);
            return view('front-end.shop',[
                'category_product' => $category_product,
                'brand' => $brand,
                'products' => $products,
//                'product_all' => $product_all,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'limitedArray' => $limitedArray,
                'favoritedProducts' => $favoritedProducts,
                'wish_count' => $wish_count
            ]);
        }else{
            $category_product = DanhMucSanPham::all()->where('dmsp_TrangThai',1)->sortByDesc("id");
            $brand = ThuongHieu::all()->where('thsp_TrangThai',1)->sortByDesc("id");
//            $product_all = SanPham::all();

            $tags = SanPham::pluck('sp_Tag')->all();
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

            $products = SanPham::orderBy('id', 'desc')->where('sp_TrangThai',1)->paginate(9);

            $carts = $this->cartService->getProduct();
            // dd($carts);
            $favoritedProducts = [];
            }

            $wish_count = YeuThich::where('khach_hang_id', 0)->get();
            //dd($wish_count);

            return view('front-end.shop',[
                'category_product' => $category_product,
                'brand' => $brand,
                'products' => $products,
//                'product_all' => $product_all,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'limitedArray' => $limitedArray,
                'favoritedProducts' => $favoritedProducts,
                'wish_count' => $wish_count
            ]);
    }

    public function product_detail($id) {
        if(Auth::check()){
            $id_tk = Auth::user()->id;
            //dd($id_kh);8
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            //dd($khachhang);
            $id_kh = $khachhang->id;
            //dd($id_kh);

            $product = SanPham::find($id);
            $category_product = DanhMucSanPham::all();
            $product_related = SanPham::where('danh_muc_san_pham_id',$product->danh_muc_san_pham_id)->inRandomOrder()->limit(4)->get();
            // dd($product_related);
            $carts = $this->cartService->getProduct();
            //
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();
            //dd($wish_count);
            $images = $product->hinhanh;
//            dd($images);
            return view('front-end.product_detail', [
                'product' => $product,
                'category_product' => $category_product,
                'product_related' => $product_related,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'wish_count' => $wish_count,
                'images' => $images
            ]);
        }else{
            $product = SanPham::find($id);
            $category_product = DanhMucSanPham::all();
            $product_related = SanPham::where('danh_muc_san_pham_id',$product->danh_muc_san_pham_id)->inRandomOrder()->limit(4)->get();
            //dd($product_related);
            $carts = $this->cartService->getProduct();
            $wish_count = YeuThich::where('khach_hang_id', 0)->get();
            //dd($wish_count);
            $images = $product->hinhanh;
//            dd($images);
            return view('front-end.product_detail', [
                'product' => $product,
                'category_product' => $category_product,
                'product_related' => $product_related,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'wish_count' => $wish_count,
                'images' => $images
            ]);
        }
    }

    public function danhmuc_sanpham($id) {
        if(Auth::check()){
            $id_tk = Auth::user()->id;
            //dd($id_kh);8
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            //dd($khachhang);
            $id_kh = $khachhang->id;
            //dd($id_kh);

            $cate_pro = DanhMucSanPham::find($id);
            //dd($cate_pro);
            $category_product = DanhMucSanPham::all()->where('dmsp_TrangThai',1)->sortByDesc("id");
            $brand = ThuongHieu::all()->where('thsp_TrangThai',1)->sortByDesc("id");
            $carts = $this->cartService->getProduct();
            // dd($carts);

            $tags = SanPham::pluck('sp_Tag')->all();
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

            $id_dm = $id;
            $sp = SanPham::where('danh_muc_san_pham_id',$id_dm)
                ->where('sp_TrangThai',1)
                ->orderBy('id', 'desc')
                ->paginate(9);
            //dd($sp);

            $favoritedProducts = YeuThich::where('khach_hang_id', $id_kh)->pluck('san_pham_id')->toArray();
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();
            //dd($wish_count);
            return view('front-end.danhmuc_sanpham', [
                'cate_pro' => $cate_pro,
                'category_product' => $category_product,
                'brand' => $brand,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'sp' => $sp,
                'limitedArray' => $limitedArray,
                'favoritedProducts' => $favoritedProducts,
                'wish_count' => $wish_count
            ]);
        }else{
            $cate_pro = DanhMucSanPham::find($id);
            //dd($cate_pro);
            $category_product = DanhMucSanPham::all()->where('dmsp_TrangThai',1)->sortByDesc("id");
            //dd($category_product);
            $brand = ThuongHieu::all()->where('thsp_TrangThai',1)->sortByDesc("id");
            $carts = $this->cartService->getProduct();


            $tags = SanPham::pluck('sp_Tag')->all();
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

            $id_dm = $id;
            $sp = SanPham::where('danh_muc_san_pham_id',$id_dm)
                         ->where('sp_TrangThai',1)
                         ->orderBy('id', 'desc')
                         ->paginate(9);
            //dd($sp);
            $favoritedProducts = [];
            $wish_count = YeuThich::where('khach_hang_id', 0)->get();
            //dd($wish_count);
            return view('front-end.danhmuc_sanpham', [
                'cate_pro' => $cate_pro,
                'category_product' => $category_product,
                'brand' => $brand,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'sp' => $sp,
                'limitedArray' => $limitedArray,
                'favoritedProducts' => $favoritedProducts,
                'wish_count' => $wish_count
            ]);
        }
    }

    public function thuonghieu_sanpham($id) {
        if(Auth::check()){
            $id_tk = Auth::user()->id;
            //dd($id_kh);8
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            //dd($khachhang);
            $id_kh = $khachhang->id;
            //dd($id_kh);

            $bra = ThuongHieu::find($id);
            //dd($cate_pro);
            $category_product = DanhMucSanPham::all()->where('dmsp_TrangThai',1)->sortByDesc("id");
            $brand = ThuongHieu::all()->where('thsp_TrangThai',1)->sortByDesc("id");
            $carts = $this->cartService->getProduct();
            // dd($carts);

            $tags = SanPham::pluck('sp_Tag')->all();
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

            $id_th = $id;
            $sp = SanPham::where('thuong_hieu_id',$id_th)
                ->where('sp_TrangThai',1)
                ->orderBy('id', 'desc')
                ->paginate(9);
            //dd($sp);

            $favoritedProducts = YeuThich::where('khach_hang_id', $id_kh)->pluck('san_pham_id')->toArray();
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();
            //dd($wish_count);
            return view('front-end.thuonghieu_sanpham', [
                'bra' => $bra,
                'category_product' => $category_product,
                'brand' => $brand,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'sp' => $sp,
                'limitedArray' => $limitedArray,
                'favoritedProducts' => $favoritedProducts,
                'wish_count' => $wish_count
            ]);
        }else{
            $bra = ThuongHieu::find($id);
            //dd($cate_pro);
            $category_product = DanhMucSanPham::all()->where('dmsp_TrangThai',1)->sortByDesc("id");
            //dd($category_product);
            $brand = ThuongHieu::all()->where('thsp_TrangThai',1)->sortByDesc("id");
            $carts = $this->cartService->getProduct();

            $tags = SanPham::pluck('sp_Tag')->all();
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

            $id_th = $id;
            $sp = SanPham::where('thuong_hieu_id',$id_th)
                ->where('sp_TrangThai',1)
                ->orderBy('id', 'desc')
                ->paginate(9);
            //dd($sp);

            $favoritedProducts = [];
            $wish_count = YeuThich::where('khach_hang_id', 0)->get();
            //dd($wish_count);
            return view('front-end.thuonghieu_sanpham', [
                'bra' => $bra,
                'category_product' => $category_product,
                'brand' => $brand,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'sp' => $sp,
                'limitedArray' => $limitedArray,
                'favoritedProducts' => $favoritedProducts,
                'wish_count' => $wish_count
            ]);
        }
    }

    public function tag(Request $request, $product_tag){
        if(Auth::check()){
            $id_tk = Auth::user()->id;
            //dd($id_kh);8
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            //dd($khachhang);
            $id_kh = $khachhang->id;
            //dd($id_kh);

            $category_product = DanhMucSanPham::all()->where('dmsp_TrangThai',1)->sortByDesc("id");
            $brand = ThuongHieu::all()->where('thsp_TrangThai',1)->sortByDesc("id");
            //$product_all = SanPham::all();

            $tags = SanPham::pluck('sp_Tag')->all();
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

            $tag = str_replace("-"," ",$product_tag);
            $product_tag = DB::table('san_phams')->where('sp_TenSanPham','like','%'.$tag.'%')
                ->orWhere('sp_Tag','like','%'.$tag.'%')
                ->where('sp_TrangThai',1)
                ->orderBy('id', 'desc')
                ->paginate(9);
            //dd($product_tag);
            $carts = $this->cartService->getProduct();
            $favoritedProducts = YeuThich::where('khach_hang_id', $id_kh)->pluck('san_pham_id')->toArray();
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();
            //dd($wish_count);
            return view('front-end.product_tag',[
                'category_product' => $category_product,
                'brand' => $brand,
                //'product_all' => $product_all,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'product_tag' => $product_tag,
                'tag' => $tag,
                'limitedArray' => $limitedArray,
                'favoritedProducts' => $favoritedProducts,
                'wish_count' => $wish_count
            ]);
        }else{
            $category_product = DanhMucSanPham::all()->where('dmsp_TrangThai',1)->sortByDesc("id");
            $brand = ThuongHieu::all()->where('thsp_TrangThai',1)->sortByDesc("id");
            //$product_all = SanPham::all();

            $tags = SanPham::pluck('sp_Tag')->all();
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

            $tag = str_replace("-"," ",$product_tag);
            //dd($tag);
            $product_tag = DB::table('san_phams')->where('sp_TenSanPham','like','%'.$tag.'%')
                ->orWhere('sp_Tag','like','%'.$tag.'%')
                ->where('sp_TrangThai',1)
                ->orderBy('id', 'desc')
                ->paginate(9);
            //dd($product_tag);
            $carts = $this->cartService->getProduct();
            // dd($carts);
            $favoritedProducts = [];
            $wish_count = YeuThich::where('khach_hang_id', 0)->get();
            //dd($wish_count);
        }
        return view('front-end.product_tag',[
            'category_product' => $category_product,
            'brand' => $brand,
            //'product_all' => $product_all,
            'carts' => $carts,
            'gh' => session()->get('carts'),
            'product_tag' => $product_tag,
            'tag' => $tag,
            'limitedArray' => $limitedArray,
            'favoritedProducts' => $favoritedProducts,
            'wish_count' => $wish_count
        ]);
    }

    public function wish_lish_show($product_id)
    {
        //nếu đã đăng nhập
        if (Auth::check()) {
            $id_tk = Auth::user()->id;
            //dd($id_kh);
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            // dd($khachhang);
            $id_kh = $khachhang->id;

            $wish = YeuThich::where('san_pham_id', $product_id)->where('khach_hang_id', $id_kh)->first();
            //dd($wish);

            //nếu sản phẩm đã đc yêu thích
            if (isset($wish)) {
                $wish->delete();
            } else {
                $yt = YeuThich::insert([
                    'khach_hang_id' => $id_kh,
                    'san_pham_id' => $product_id
                ]);
            }
        }
    }

}
