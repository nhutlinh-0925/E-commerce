<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
use App\Models\DanhMucSanPham;
use App\Models\SanPham;
use App\Models\SanPhamKichThuoc;
use App\Models\ThuongHieu;
use App\Models\YeuThich;
use App\Models\ĐanhGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ShopDetailController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function product_detail($id) {
        if(Auth::check()){
            $id_kh = Auth('web')->user()->id;

            $product = SanPham::find($id);
            $product->sp_LuotXem = $product->sp_LuotXem + 1;
            $product->save();

            $category_product = DanhMucSanPham::all();
            $product_related = SanPham::where('danh_muc_san_pham_id',$product->danh_muc_san_pham_id)->inRandomOrder()->limit(4)->get();

            $carts = $this->cartService->getProduct();
            $favoritedProducts = YeuThich::where('khach_hang_id', $id_kh)->pluck('san_pham_id')->toArray();
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();

            $images = $product->hinhanh;

            $rating = ĐanhGia::where('san_pham_id',$id)->avg('dg_SoSao');
            $rating_round = round($rating);
            $review = ĐanhGia::where('san_pham_id',$id)->where('dg_TrangThai',1)->get();
            $roundedRating = round($rating, 1);
            $rating_products = ĐanhGia::where('san_pham_id', $id)->get();

            $sizes = SanPhamKichThuoc::where('san_pham_id',$id)->where('spkt_soLuongHang','>', 0)->get();
            $total_size = $sizes->sum('spkt_soLuongHang');

            return view('front-end.product_detail', [
                'product' => $product,
                'category_product' => $category_product,
                'product_related' => $product_related,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'favoritedProducts' => $favoritedProducts,
                'wish_count' => $wish_count,
                'images' => $images,
                'rating' => $rating,
                'rating_round' => $rating_round,
                'review' => $review,
                'roundedRating' => $roundedRating,
                'rating_products' => $rating_products,
                'product_id' => $id,
                'sizes' => $sizes,
                'total_size' => $total_size
            ]);
        }else{
            $product = SanPham::find($id);
            $product->sp_LuotXem = $product->sp_LuotXem + 1;
            $product->save();

            $category_product = DanhMucSanPham::all();
            $product_related = SanPham::where('danh_muc_san_pham_id',$product->danh_muc_san_pham_id)->inRandomOrder()->limit(4)->get();

            $carts = $this->cartService->getProduct();
            $favoritedProducts = [];
            $images = $product->hinhanh;

            $rating = ĐanhGia::where('san_pham_id',$id)->avg('dg_SoSao');
            $rating_round = round($rating);
            $review = ĐanhGia::where('san_pham_id',$id)->where('dg_TrangThai',1)->get();
            $roundedRating = round($rating, 1);
            $rating_products = ĐanhGia::where('san_pham_id', $id)->get();

            $sizes = SanPhamKichThuoc::where('san_pham_id',$id)->where('spkt_soLuongHang','>', 0)->get();
//            dd($sizes);
            $total_size = $sizes->sum('spkt_soLuongHang');
            return view('front-end.product_detail', [
                'product' => $product,
                'category_product' => $category_product,
                'product_related' => $product_related,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'favoritedProducts' => $favoritedProducts,
                'images' => $images,
                'rating' => $rating,
                'rating_round' => $rating_round,
                'review' => $review,
                'roundedRating' => $roundedRating,
                'rating_products' => $rating_products,
                'product_id' => $id,
                'sizes' => $sizes,
                'total_size' => $total_size
            ]);
        }
    }

    public function add_review(Request $request){
        //dd($request);

        $this -> validate($request, [
            'dg_SoSao' => 'required',
            'dg_MucDanhGia' => 'required|max:255',
        ],
            [
                'dg_MucDanhGia.required' => 'Vui lòng nhập nội dung đánh giá',
//                'dg_MucDanhGia.min' => 'Đánh giá phải lớn hơn 1 kí tự',
                'dg_MucDanhGia.max' => 'Đánh giá phải nhỏ hơn 255 kí tự',
            ]);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        if(Auth::check()){
            $id_kh = Auth('web')->user()->id;
//            $userHasPurchasedProduct = $this->checkIfUserHasPurchasedProduct($id_kh, $request->id_sp);
//            if ($userHasPurchasedProduct) {
            $dg = new ĐanhGia();
            $dg->khach_hang_id = $id_kh;
            $dg->san_pham_id = $request->id_sp;
            $dg->dg_SoSao = $request->dg_SoSao;
            $dg->dg_MucDanhGia = $request->dg_MucDanhGia;
            $dg->dg_TrangThai = 1;
            $dg->save();

            Session::flash('success_message_review', 'Thêm đánh giá thành công!');
            return redirect()->back();
//            }else {
//                Session::flash('flash_message_error_review1', 'Bạn phải mua sản phẩm trước khi đánh giá!');
//                return redirect()->back();
//            }
//            }
        }else{
            Session::flash('flash_message_error_review2', 'Vui lòng đăng nhập để đánh giá!');
            return redirect()->back();
        }
    }

    public function wish_lish_show($product_id)
    {
        //nếu đã đăng nhập
        if (Auth::check()) {
            $id_kh = Auth('web')->user()->id;
            $wish = YeuThich::where('san_pham_id', $product_id)->where('khach_hang_id', $id_kh)->first();

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

    public function wish_list_count($id) {
        if(Auth::check()){
            $id_kh = Auth('web')->user()->id;

            $category_product = DanhMucSanPham::all()->where('dmsp_TrangThai',1)->sortByDesc("id");
            $brand = ThuongHieu::all()->where('thsp_TrangThai',1)->sortByDesc("id");
            $carts = $this->cartService->getProduct();

            $tags = SanPham::pluck('sp_Tag')->all();
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

            $yt = YeuThich::where('khach_hang_id',$id_kh)
                ->with('sanpham')
                ->orderBy('id', 'desc')
                ->paginate(9);
            $favoritedProducts = YeuThich::where('khach_hang_id', $id_kh)->pluck('san_pham_id')->toArray();
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();

            return view('front-end.wish_count', [
                'category_product' => $category_product,
                'brand' => $brand,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'limitedArray' => $limitedArray,
                'favoritedProducts' => $favoritedProducts,
                'wish_count' => $wish_count,
                'yt' => $yt,
            ]);
        }
    }

//    private function checkIfUserHasPurchasedProduct($customerId, $productId) {
//        // Implement your logic to check if the user (customerId) has purchased the product (productId)
//        // Return true if the user has purchased the product, otherwise return false.
//    }
}
