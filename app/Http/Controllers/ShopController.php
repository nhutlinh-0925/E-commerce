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
use Illuminate\Support\Facades\DB;
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
            return view('front-end.shop',[
                'category_product' => $category_product,
                'brand' => $brand,
                'products' => $products,
//                'product_all' => $product_all,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'limitedArray' => $limitedArray
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
            }
            return view('front-end.shop',[
                'category_product' => $category_product,
                'brand' => $brand,
                'products' => $products,
//                'product_all' => $product_all,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'limitedArray' => $limitedArray
            ]);
    }

    public function product_detail($id) {
        if(Auth::check()){
            $id_kh = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id_kh)->first();

            $product = SanPham::find($id);
            $category_product = DanhMucSanPham::all();
            $product_related = SanPham::where('danh_muc_san_pham_id',$product->danh_muc_san_pham_id)->inRandomOrder()->limit(4)->get();
            // dd($product_related);
            $carts = $this->cartService->getProduct();
            // dd($carts);
            $images = $product->hinhanh;
//            dd($images);
            return view('front-end.product_detail', [
                'product' => $product,
                'category_product' => $category_product,
                'product_related' => $product_related,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'images' => $images
            ]);
        }else{
            $product = SanPham::find($id);
            $category_product = DanhMucSanPham::all();
            $product_related = SanPham::where('danh_muc_san_pham_id',$product->danh_muc_san_pham_id)->inRandomOrder()->limit(4)->get();
            //dd($product_related);
            $carts = $this->cartService->getProduct();
            $images = $product->hinhanh;
//            dd($images);
            return view('front-end.product_detail', [
                'product' => $product,
                'category_product' => $category_product,
                'product_related' => $product_related,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'images' => $images
            ]);
        }
    }

    public function danhmuc_sanpham($id) {
        if(Auth::check()){
            $id_kh = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id_kh)->first();

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

            return view('front-end.danhmuc_sanpham', [
                'cate_pro' => $cate_pro,
                'category_product' => $category_product,
                'brand' => $brand,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'sp' => $sp,
                'limitedArray' => $limitedArray
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
            return view('front-end.danhmuc_sanpham', [
                'cate_pro' => $cate_pro,
                'category_product' => $category_product,
                'brand' => $brand,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'sp' => $sp,
                'limitedArray' => $limitedArray
            ]);
        }
    }

    public function thuonghieu_sanpham($id) {
        if(Auth::check()){
            $id_kh = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id_kh)->first();

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

            return view('front-end.thuonghieu_sanpham', [
                'bra' => $bra,
                'category_product' => $category_product,
                'brand' => $brand,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'sp' => $sp,
                'limitedArray' => $limitedArray
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
            return view('front-end.thuonghieu_sanpham', [
                'bra' => $bra,
                'category_product' => $category_product,
                'brand' => $brand,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'sp' => $sp,
                'limitedArray' => $limitedArray
            ]);
        }
    }

    public function search(Request $request)
    {
        if(Auth::check()){
            $id = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id)->first();
            // dd($khachhang);

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

            $keywords = $request->keywords_submit;
            $search_product = DB::table('san_phams')->where('sp_TenSanPham','like','%'.$keywords.'%')
                                                         ->where('sp_TrangThai',1)
                                                         ->orderBy('id', 'desc')
                                                         ->paginate(9);
            $carts = $this->cartService->getProduct();
            return view('front-end.search',[
                'category_product' => $category_product,
                'brand' => $brand,
                //'product_all' => $product_all,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'search_product' => $search_product,
                'keywords' => $keywords,
                'limitedArray' => $limitedArray
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

            $keywords = $request->keywords_submit;
            $search_product = DB::table('san_phams')->where('sp_TenSanPham','like','%'.$keywords.'%')
                                ->where('sp_TrangThai',1)
                                ->orderBy('id', 'desc')
                                ->paginate(9);
            //dd($search_product);
            $carts = $this->cartService->getProduct();
            // dd($carts);
        }
        return view('front-end.search',[
            'category_product' => $category_product,
            'brand' => $brand,
            //'product_all' => $product_all,
            'carts' => $carts,
            'gh' => session()->get('carts'),
            'search_product' => $search_product,
            'keywords' => $keywords,
            'limitedArray' => $limitedArray
        ]);
    }

    public function autocomplete_ajax(Request $request){
        $data = $request->all();

        if($data['query']) {
            $product = SanPham::where('sp_TrangThai', 1)
                ->where('sp_TenSanPham', 'LIKE', '%'. $data['query'].'%')->get();
            $output = '<ul class="dropdown-menu search-results" style="display:block; position:absolute; z-index: 9999; width: 100%;">';
            $output .= '<p style="text-align: center; font-weight: bold;">Sản phẩm gợi ý</p>';
            foreach ($product as $key => $val) {
                $imagePath = asset('/storage/images/products/' . $val->sp_AnhDaiDien);
                $formattedPrice = number_format($val->sp_Gia, 0, '', '.');
                $output .= '
                    <li style="display: flex; align-items: center;">

                        <img src="' . $imagePath . '" width="50px" height="50px" style="margin-right: 10px;">
                        <div>
                            <a href="/product/' . $val->id . '"><span style="font-weight: bold;color: black">' . $val->sp_TenSanPham . '</span></a><br>
                            <span style="color: red;font-weight: bold;">' . $formattedPrice . ' đ</span>
                        </div>
                    </li>

                ';
            }
            $output .= '</ul>';
            echo $output;
        }
    }

    public function tag(Request $request, $product_tag){
        if(Auth::check()){
            $id = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id)->first();
            // dd($khachhang);

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
            return view('front-end.product_tag',[
                'category_product' => $category_product,
                'brand' => $brand,
                //'product_all' => $product_all,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'product_tag' => $product_tag,
                'tag' => $tag,
                'limitedArray' => $limitedArray
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
        }
        return view('front-end.product_tag',[
            'category_product' => $category_product,
            'brand' => $brand,
            //'product_all' => $product_all,
            'carts' => $carts,
            'gh' => session()->get('carts'),
            'product_tag' => $product_tag,
            'tag' => $tag,
            'limitedArray' => $limitedArray
        ]);
    }


    // public function store($id,$sp_TenSanPham,$sp_Gia)
    // {
    //     dd($id);
    //     Cart::add($id,$sp_TenSanPham,1,$sp_Gia)->associate('App\Models\SanPham');
    //     session()->flash('success_message','da them');
    //     return redirect()->route('cart');
    // }


}
