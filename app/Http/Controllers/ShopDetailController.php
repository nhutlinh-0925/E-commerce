<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
use App\Models\DanhMucSanPham;
use App\Models\PhanHoi;
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

            $id_sp = $product->id;

            $category_product = DanhMucSanPham::all();
            $product_related = SanPham::where('danh_muc_san_pham_id',$product->danh_muc_san_pham_id)->where('id', '!=', $id_sp)->inRandomOrder()->limit(4)->get();

            $carts = $this->cartService->getProduct();
            $favoritedProducts = YeuThich::where('khach_hang_id', $id_kh)->pluck('san_pham_id')->toArray();
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();

            $images = $product->hinhanh;

            $rating = ĐanhGia::where('san_pham_id',$id)->avg('dg_SoSao');
            $rating_round = round($rating);
            $review = ĐanhGia::where('san_pham_id',$id)->where('dg_TrangThai',1)->orderBy('id', 'desc')->get();
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

            $id_sp = $product->id;

            $category_product = DanhMucSanPham::all();
            $product_related = SanPham::where('danh_muc_san_pham_id',$product->danh_muc_san_pham_id)->where('id', '!=', $id_sp)->inRandomOrder()->limit(4)->get();

            $carts = $this->cartService->getProduct();
            $favoritedProducts = [];
            $images = $product->hinhanh;

            $rating = ĐanhGia::where('san_pham_id',$id)->avg('dg_SoSao');
            $rating_round = round($rating);
            $review = ĐanhGia::where('san_pham_id',$id)->where('dg_TrangThai',1)->orderBy('id', 'desc')->get();
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

    public function quick_view(Request $request){
        $product_id = $request->product_id;
        $product = SanPham::find($product_id);

        $rating = ĐanhGia::where('san_pham_id',$product_id)->avg('dg_SoSao');
        $review = ĐanhGia::where('san_pham_id',$product_id)->where('dg_TrangThai',1)->orderBy('id', 'desc')->get();

        $sizes = SanPhamKichThuoc::where('san_pham_id',$product_id)->where('spkt_soLuongHang','>', 0)->get();
        $total_size = $sizes->sum('spkt_soLuongHang');

        $output['product_id'] = $product->id;
        $output['product_name'] = $product->sp_TenSanPham;
        $output['product_price'] = number_format($product->sp_Gia,0,',','.'). ' VNĐ';
        $output['product_image'] = '<p><img width="100%" src="/storage/images/products/'.$product->sp_AnhDaiDien.'"></p>';

        $output['product_category'] = $product->danhmuc->dmsp_TenDanhMuc;
        $output['product_brand'] = $product->thuonghieu->thsp_TenThuongHieu;

        $output['product_rating_round'] = round($rating);
        $output['product_review_count'] = $review->count();

        $output['product_total_size'] = $total_size;
        $output['product_sizes'] = $sizes;

        $sizeNames = $sizes->pluck('kichthuoc.kt_TenKichThuoc')->toArray();
        $output['product_size_names'] = $sizeNames;

        echo json_encode($output);
    }

    public function add_review(Request $request, $id_dh, $id_pr){
        //dd($request);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
            $id_kh = Auth('web')->user()->id;
            $sao = $request->dg_SoSao;
            if($sao == ''){
                $dg = new ĐanhGia();
                $dg->khach_hang_id = $id_kh;
                $dg->san_pham_id = $request->san_pham_id;
                $dg->phieu_dat_hang_id = $request->phieu_dat_hang_id;
                $dg->dg_SoSao = 4;
                $dg->dg_MucDanhGia = $request->dg_MucDanhGia;
                $dg->kichthuoc = $request->kichthuoc;
                $dg->dg_TrangThai = 1;
                $dg->save();
            }elseif($sao != ''){
                $dg = new ĐanhGia();
                $dg->khach_hang_id = $id_kh;
                $dg->san_pham_id = $request->san_pham_id;
                $dg->phieu_dat_hang_id = $request->phieu_dat_hang_id;
                $dg->dg_SoSao = $sao;
                $dg->dg_MucDanhGia = $request->dg_MucDanhGia;
                $dg->kichthuoc = $request->kichthuoc;
                $dg->dg_TrangThai = 1;
                $dg->save();
            }

            Session::flash('success_message_review', 'Thêm đánh giá thành công!');
            return redirect()->back();
    }

    public function add_feedback(Request $request, $id){
        //dd($request);

        date_default_timezone_set('Asia/Ho_Chi_Minh');
            $id_kh = Auth('web')->user()->id;
            $sao = $request->ph_SoSao;
            if($sao == ''){
                $ph = new PhanHoi();
                $ph->khach_hang_id = $id_kh;
                $ph->phieu_dat_hang_id = $request->id_pdh;
                $ph->ph_SoSao = 4;
                $ph->ph_MucPhanHoi = $request->ph_MucPhanHoi;
                $ph->ph_TrangThai = 1;
                $ph->save();
            }elseif($sao != ''){
                $ph = new PhanHoi();
                $ph->khach_hang_id = $id_kh;
                $ph->phieu_dat_hang_id = $request->id_pdh;
                $ph->ph_SoSao = $sao;
                $ph->ph_MucPhanHoi = $request->ph_MucPhanHoi;
                $ph->ph_TrangThai = 1;
                $ph->save();
            }
            Session::flash('success_message_feedback', 'Thêm phản hồi thành công!');
            return redirect()->back();
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
}
