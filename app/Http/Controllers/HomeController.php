<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
use App\Models\BaiViet;
use App\Models\DanhMucSanPham;
use App\Models\KhachHang;
use App\Models\SanPham;
use App\Models\ThuongHieu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function home(){
        if(Auth::check()){
            $id = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id)->first();
            // dd($khachhang);
            $carts = $this->cartService->getProduct();
            // dd($carts);

            $bestseller = SanPham::orderBy('sp_SoLuongBan', 'desc')->limit(8)->get();
            //dd($bestseller);
            $new_arrivals = SanPham::orderBy('id', 'desc')->limit(8)->get();
            $most_views = SanPham::orderBy('sp_LuotXem', 'desc')->limit(8)->get();

            $posts = BaiViet::orderBy('id', 'desc')->limit(3)->get();
            //dd($posts);
            return view('front-end.home',[
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'bestseller' => $bestseller,
                'new_arrivals' => $new_arrivals,
                'most_views' => $most_views,
                'posts' => $posts
            ]);
        }else{
            $carts = $this->cartService->getProduct();

            $bestseller = SanPham::orderBy('sp_SoLuongBan', 'desc')->limit(8)->get();
            //dd($bestseller);
            $new_arrivals = SanPham::orderBy('id', 'desc')->limit(8)->get();
            $most_views = SanPham::orderBy('sp_LuotXem', 'desc')->limit(8)->get();
            //dd($most_views);

            $posts = BaiViet::orderBy('id', 'desc')->limit(3)->get();
            //dd($posts);

            return view('front-end.home',[
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'bestseller' => $bestseller,
                'new_arrivals' => $new_arrivals,
                'most_views' => $most_views,
                'posts' => $posts
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

    public function contact(){
        if(Auth::check()){
            $id = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id)->first();
            // dd($khachhang);

            $carts = $this->cartService->getProduct();
            return view('front-end.contact',[
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
            ]);
        }else{
            $carts = $this->cartService->getProduct();
            // dd($carts);
        }
        return view('front-end.contact',[
            'carts' => $carts,
            'gh' => session()->get('carts'),
        ]);
    }


}
