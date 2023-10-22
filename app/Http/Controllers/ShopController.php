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
use App\Models\ĐanhGia;

class ShopController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function shop(Request $request) {
        if(Auth::check()){
            $id_tk = Auth::user()->id;
            //dd($id_kh);8
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            //dd($khachhang);
            $id_kh = $khachhang->id;
            $category_product = DanhMucSanPham::all()->where('dmsp_TrangThai',1)->sortByDesc("id");
            $brand = ThuongHieu::all()->where('thsp_TrangThai',1)->sortByDesc("id");

            if(isset($_GET['sort_by'])) {
                $sort_by = $_GET['sort_by'];
                if ($sort_by == 'giam_dan') {
                    $products = SanPham::orderBy('sp_Gia', 'desc')
                        ->where('sp_TrangThai', 1)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'tang_dan') {
                    $products = SanPham::orderBy('sp_Gia', 'asc')
                        ->where('sp_TrangThai', 1)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'kytu_za') {
                    $products = SanPham::orderBy('sp_TenSanPham', 'desc')
                        ->where('sp_TrangThai', 1)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'kytu_az') {
                    $products = SanPham::orderBy('sp_TenSanPham', 'asc')
                        ->where('sp_TrangThai', 1)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'none') {
                    $products = SanPham::orderBy('id', 'desc')
                        ->where('sp_TrangThai', 1)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'cu_nhat') {
                    $products = SanPham::orderBy('id', 'asc')
                        ->where('sp_TrangThai', 1)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'moi_nhat') {
                    $products = SanPham::orderBy('id', 'desc')
                        ->where('sp_TrangThai', 1)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'ban_chay') {
                    $products = SanPham::orderBy('sp_SoLuongBan', 'desc')
                        ->where('sp_TrangThai', 1)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'ton_kho') {
                    $products = SanPham::orderBy('sp_SoLuongHang', 'desc')
                        ->where('sp_TrangThai', 1)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '1000') {
                    $products = SanPham::orderBy('sp_Gia', 'asc')
                        ->where('sp_TrangThai', 1)
                        ->where('sp_Gia', '<=', 1000000)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '1000_2000') {
                    $products = SanPham::orderBy('sp_Gia', 'asc')
                        ->where('sp_TrangThai', 1)
                        ->where('sp_Gia', '>=', 1000000)
                        ->where('sp_Gia', '<=', 2000000)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '2000_3000') {
                    $products = SanPham::orderBy('sp_Gia', 'asc')
                        ->where('sp_TrangThai', 1)
                        ->where('sp_Gia', '>=', 2000000)
                        ->where('sp_Gia', '<=', 3000000)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3000') {
                    $products = SanPham::orderBy('sp_Gia', 'asc')
                        ->where('sp_TrangThai', 1)
                        ->where('sp_Gia', '>=', 3000000)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '5sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                    $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                        $subsubquery->select('san_pham_id')
                                            ->from('đanh_gias')
                                            ->where('dg_TrangThai', 1)
                                            ->groupBy('san_pham_id')
                                            ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 5');
                                    });
                                });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '4sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 4');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 3');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == '2sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 2');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                    //dd($products);
                }elseif ($sort_by == '1sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 1');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                }
            }else{
                $products = SanPham::orderBy('id', 'desc')->where('sp_TrangThai',1)->paginate(9);
            }
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

            $carts = $this->cartService->getProduct();
            $favoritedProducts = YeuThich::where('khach_hang_id', $id_kh)->pluck('san_pham_id')->toArray();
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();

            return view('front-end.shop',[
                'category_product' => $category_product,
                'brand' => $brand,
                'products' => $products,
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

            if(isset($_GET['sort_by'])) {
                $sort_by = $_GET['sort_by'];
                if ($sort_by == 'giam_dan') {
                    $products = SanPham::orderBy('sp_Gia', 'desc')
                        ->where('sp_TrangThai', 1)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'tang_dan') {
                    $products = SanPham::orderBy('sp_Gia', 'asc')
                        ->where('sp_TrangThai', 1)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'kytu_za') {
                    $products = SanPham::orderBy('sp_TenSanPham', 'desc')
                        ->where('sp_TrangThai', 1)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'kytu_az') {
                    $products = SanPham::orderBy('sp_TenSanPham', 'asc')
                        ->where('sp_TrangThai', 1)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'none') {
                    $products = SanPham::orderBy('id', 'desc')
                        ->where('sp_TrangThai', 1)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'cu_nhat') {
                    $products = SanPham::orderBy('id', 'asc')
                        ->where('sp_TrangThai', 1)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'moi_nhat') {
                    $products = SanPham::orderBy('id', 'desc')
                        ->where('sp_TrangThai', 1)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'ban_chay') {
                    $products = SanPham::orderBy('sp_SoLuongBan', 'desc')
                        ->where('sp_TrangThai', 1)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'ton_kho') {
                    $products = SanPham::orderBy('sp_SoLuongHang', 'desc')
                        ->where('sp_TrangThai', 1)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '1000') {
                    $products = SanPham::orderBy('sp_Gia', 'asc')
                        ->where('sp_TrangThai', 1)
                        ->where('sp_Gia', '<=', 1000000)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '1000_2000') {
                    $products = SanPham::orderBy('sp_Gia', 'asc')
                        ->where('sp_TrangThai', 1)
                        ->where('sp_Gia', '>=', 1000000)
                        ->where('sp_Gia', '<=', 2000000)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '2000_3000') {
                    $products = SanPham::orderBy('sp_Gia', 'asc')
                        ->where('sp_TrangThai', 1)
                        ->where('sp_Gia', '>=', 2000000)
                        ->where('sp_Gia', '<=', 3000000)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3000') {
                    $products = SanPham::orderBy('sp_Gia', 'asc')
                        ->where('sp_TrangThai', 1)
                        ->where('sp_Gia', '>=', 3000000)
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '5sao') {
                $products = SanPham::select('san_phams.*')
                    ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                    ->where('đanh_gias.dg_TrangThai', 1)
                    ->where(function ($query) {
                        $query->Where(function ($subquery) {
                            $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                $subsubquery->select('san_pham_id')
                                    ->from('đanh_gias')
                                    ->where('dg_TrangThai', 1)
                                    ->groupBy('san_pham_id')
                                    ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 5');
                            });
                        });
                    })
                    ->distinct()
                    ->paginate(9)->appends(request()->query());
            } elseif ($sort_by == '4sao') {
                $products = SanPham::select('san_phams.*')
                    ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                    ->where('đanh_gias.dg_TrangThai', 1)
                    ->where(function ($query) {
                        $query->Where(function ($subquery) {
                            $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                $subsubquery->select('san_pham_id')
                                    ->from('đanh_gias')
                                    ->where('dg_TrangThai', 1)
                                    ->groupBy('san_pham_id')
                                    ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 4');
                            });
                        });
                    })
                    ->distinct()
                    ->paginate(9)->appends(request()->query());
            } elseif ($sort_by == '3sao') {
                $products = SanPham::select('san_phams.*')
                    ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                    ->where('đanh_gias.dg_TrangThai', 1)
                    ->where(function ($query) {
                        $query->Where(function ($subquery) {
                            $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                $subsubquery->select('san_pham_id')
                                    ->from('đanh_gias')
                                    ->where('dg_TrangThai', 1)
                                    ->groupBy('san_pham_id')
                                    ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 3');
                            });
                        });
                    })
                    ->distinct()
                    ->paginate(9)->appends(request()->query());
            }elseif ($sort_by == '2sao') {
                $products = SanPham::select('san_phams.*')
                    ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                    ->where('đanh_gias.dg_TrangThai', 1)
                    ->where(function ($query) {
                        $query->Where(function ($subquery) {
                            $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                $subsubquery->select('san_pham_id')
                                    ->from('đanh_gias')
                                    ->where('dg_TrangThai', 1)
                                    ->groupBy('san_pham_id')
                                    ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 2');
                            });
                        });
                    })
                    ->distinct()
                    ->paginate(9)->appends(request()->query());
                //dd($products);
            }elseif ($sort_by == '1sao') {
                $products = SanPham::select('san_phams.*')
                    ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                    ->where('đanh_gias.dg_TrangThai', 1)
                    ->where(function ($query) {
                        $query->Where(function ($subquery) {
                            $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                $subsubquery->select('san_pham_id')
                                    ->from('đanh_gias')
                                    ->where('dg_TrangThai', 1)
                                    ->groupBy('san_pham_id')
                                    ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 1');
                            });
                        });
                    })
                    ->distinct()
                    ->paginate(9)->appends(request()->query());
            }
            }else{
                $products = SanPham::orderBy('id', 'desc')->where('sp_TrangThai',1)->paginate(9);
            }

            $carts = $this->cartService->getProduct();
            $favoritedProducts = [];
            }

            return view('front-end.shop',[
                'category_product' => $category_product,
                'brand' => $brand,
                'products' => $products,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'limitedArray' => $limitedArray,
                'favoritedProducts' => $favoritedProducts,
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

            return view('front-end.product_detail', [
                'product' => $product,
                'category_product' => $category_product,
                'product_related' => $product_related,
                'khachhang' => $khachhang,
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
                'product_id' => $id
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
                'product_id' => $id
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
            $id_dm = $id;

            if(isset($_GET['sort_by'])) {
                $sort_by = $_GET['sort_by'];
                if ($sort_by == '1000') {
                    $sp = SanPham::where('danh_muc_san_pham_id',$id_dm)
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '<=', 1000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());

                } elseif ($sort_by == '1000_2000') {
                    $sp = SanPham::where('danh_muc_san_pham_id',$id_dm)
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 1000000)
                        ->where('sp_Gia', '<=', 2000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '2000_3000') {
                    $sp = SanPham::where('danh_muc_san_pham_id',$id_dm)
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 2000000)
                        ->where('sp_Gia', '<=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3000') {
                    $sp = SanPham::where('danh_muc_san_pham_id',$id_dm)
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '5sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 5');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '4sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 4');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 3');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == '2sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 2');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                    //dd($products);
                }elseif ($sort_by == '1sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 1');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                }
            }else{
                $sp = SanPham::where('danh_muc_san_pham_id',$id_dm)
                    ->where('sp_TrangThai',1)
                    ->orderBy('id', 'desc')
                    ->paginate(9);
            }

            $favoritedProducts = YeuThich::where('khach_hang_id', $id_kh)->pluck('san_pham_id')->toArray();
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();

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
                'wish_count' => $wish_count,
            ]);
        }else{
            $cate_pro = DanhMucSanPham::find($id);
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

            $id_dm = $id;
            if(isset($_GET['sort_by'])) {
                $sort_by = $_GET['sort_by'];
                if ($sort_by == '1000') {
                    $sp = SanPham::where('danh_muc_san_pham_id',$id_dm)
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '<=', 1000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());

                } elseif ($sort_by == '1000_2000') {
                    $sp = SanPham::where('danh_muc_san_pham_id',$id_dm)
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 1000000)
                        ->where('sp_Gia', '<=', 2000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '2000_3000') {
                    $sp = SanPham::where('danh_muc_san_pham_id',$id_dm)
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 2000000)
                        ->where('sp_Gia', '<=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3000') {
                    $sp = SanPham::where('danh_muc_san_pham_id',$id_dm)
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '5sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 5');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '4sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 4');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 3');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == '2sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 2');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                    //dd($products);
                }elseif ($sort_by == '1sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 1');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                }
            }else{
                $sp = SanPham::where('danh_muc_san_pham_id',$id_dm)
                    ->where('sp_TrangThai',1)
                    ->orderBy('id', 'desc')
                    ->paginate(9);
            }

            $favoritedProducts = [];

            return view('front-end.danhmuc_sanpham', [
                'cate_pro' => $cate_pro,
                'category_product' => $category_product,
                'brand' => $brand,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'sp' => $sp,
                'limitedArray' => $limitedArray,
                'favoritedProducts' => $favoritedProducts,
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
            $id_th = $id;

            if(isset($_GET['sort_by'])) {
                $sort_by = $_GET['sort_by'];
                if ($sort_by == '1000') {
                    $sp = SanPham::where('thuong_hieu_id',$id_th)
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '<=', 1000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());

                } elseif ($sort_by == '1000_2000') {
                    $sp = SanPham::where('thuong_hieu_id',$id_th)
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 1000000)
                        ->where('sp_Gia', '<=', 2000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '2000_3000') {
                    $sp = SanPham::where('thuong_hieu_id',$id_th)
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 2000000)
                        ->where('sp_Gia', '<=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3000') {
                    $sp = SanPham::where('thuong_hieu_id',$id_th)
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '5sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 5');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '4sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 4');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 3');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == '2sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 2');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                    //dd($products);
                }elseif ($sort_by == '1sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 1');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                }
            }else{
                $sp = SanPham::where('thuong_hieu_id',$id_th)
                    ->where('sp_TrangThai',1)
                    ->orderBy('id', 'desc')
                    ->paginate(9);
            }

            $favoritedProducts = YeuThich::where('khach_hang_id', $id_kh)->pluck('san_pham_id')->toArray();
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();

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
                'wish_count' => $wish_count,
            ]);
        }else{
            $bra = ThuongHieu::find($id);
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
            $id_th = $id;

            if(isset($_GET['sort_by'])) {
                $sort_by = $_GET['sort_by'];
                if ($sort_by == '1000') {
                    $sp = SanPham::where('thuong_hieu_id',$id_th)
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '<=', 1000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());

                } elseif ($sort_by == '1000_2000') {
                    $sp = SanPham::where('thuong_hieu_id',$id_th)
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 1000000)
                        ->where('sp_Gia', '<=', 2000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '2000_3000') {
                    $sp = SanPham::where('thuong_hieu_id',$id_th)
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 2000000)
                        ->where('sp_Gia', '<=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3000') {
                    $sp = SanPham::where('thuong_hieu_id',$id_th)
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '5sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 5');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '4sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 4');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 3');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == '2sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 2');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                    //dd($products);
                }elseif ($sort_by == '1sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 1');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                }
            }else{
                $sp = SanPham::where('thuong_hieu_id',$id_th)
                    ->where('sp_TrangThai',1)
                    ->orderBy('id', 'desc')
                    ->paginate(9);
            }
            $favoritedProducts = [];

            return view('front-end.thuonghieu_sanpham', [
                'bra' => $bra,
                'category_product' => $category_product,
                'brand' => $brand,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'sp' => $sp,
                'limitedArray' => $limitedArray,
                'favoritedProducts' => $favoritedProducts,
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

            $tag = str_replace("-"," ",$product_tag);

            if(isset($_GET['sort_by'])) {
                $sort_by = $_GET['sort_by'];
                if ($sort_by == '1000') {
                    $product_tag = DB::table('san_phams')->where('sp_Tag','like','%'.$tag.'%')
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '<=', 1000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());

                } elseif ($sort_by == '1000_2000') {
                    $product_tag = DB::table('san_phams')->where('sp_Tag','like','%'.$tag.'%')
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 1000000)
                        ->where('sp_Gia', '<=', 2000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '2000_3000') {
                    $product_tag = DB::table('san_phams')->where('sp_Tag','like','%'.$tag.'%')
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 2000000)
                        ->where('sp_Gia', '<=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3000') {
                    $product_tag = DB::table('san_phams')->where('sp_Tag','like','%'.$tag.'%')
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '5sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 5');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '4sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 4');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 3');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == '2sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 2');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                    //dd($products);
                }elseif ($sort_by == '1sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 1');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                }
            }else{
                $product_tag = DB::table('san_phams')->where('sp_TenSanPham','like','%'.$tag.'%')
                    ->orWhere('sp_Tag','like','%'.$tag.'%')
                    ->where('sp_TrangThai',1)
                    ->orderBy('id', 'desc')
                    ->paginate(9);
            }

            $carts = $this->cartService->getProduct();
            $favoritedProducts = YeuThich::where('khach_hang_id', $id_kh)->pluck('san_pham_id')->toArray();
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();

            return view('front-end.product_tag',[
                'category_product' => $category_product,
                'brand' => $brand,
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'product_tag' => $product_tag,
                'tag' => $tag,
                'limitedArray' => $limitedArray,
                'favoritedProducts' => $favoritedProducts,
                'wish_count' => $wish_count,
            ]);
        }else{
            $category_product = DanhMucSanPham::all()->where('dmsp_TrangThai',1)->sortByDesc("id");
            $brand = ThuongHieu::all()->where('thsp_TrangThai',1)->sortByDesc("id");

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

            $tag = str_replace("-"," ",$product_tag);
            if(isset($_GET['sort_by'])) {
                $sort_by = $_GET['sort_by'];
                if ($sort_by == '1000') {
                    $product_tag = DB::table('san_phams')->where('sp_Tag','like','%'.$tag.'%')
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '<=', 1000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());

                } elseif ($sort_by == '1000_2000') {
                    $product_tag = DB::table('san_phams')->where('sp_Tag','like','%'.$tag.'%')
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 1000000)
                        ->where('sp_Gia', '<=', 2000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '2000_3000') {
                    $product_tag = DB::table('san_phams')->where('sp_Tag','like','%'.$tag.'%')
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 2000000)
                        ->where('sp_Gia', '<=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3000') {
                    $product_tag = DB::table('san_phams')->where('sp_Tag','like','%'.$tag.'%')
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '5sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 5');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '4sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 4');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 3');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == '2sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 2');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                    //dd($products);
                }elseif ($sort_by == '1sao') {
                    $products = SanPham::select('san_phams.*')
                        ->join('đanh_gias', 'san_phams.id', '=', 'đanh_gias.san_pham_id')
                        ->where('đanh_gias.dg_TrangThai', 1)
                        ->where(function ($query) {
                            $query->Where(function ($subquery) {
                                $subquery->whereIn('san_phams.id', function ($subsubquery) {
                                    $subsubquery->select('san_pham_id')
                                        ->from('đanh_gias')
                                        ->where('dg_TrangThai', 1)
                                        ->groupBy('san_pham_id')
                                        ->havingRaw('ROUND(AVG(dg_SoSao), 0) = 1');
                                });
                            });
                        })
                        ->distinct()
                        ->paginate(9)->appends(request()->query());
                }
            }else{
                $product_tag = DB::table('san_phams')->where('sp_TenSanPham','like','%'.$tag.'%')
                    ->orWhere('sp_Tag','like','%'.$tag.'%')
                    ->where('sp_TrangThai',1)
                    ->orderBy('id', 'desc')
                    ->paginate(9);
            }

            $carts = $this->cartService->getProduct();
            $favoritedProducts = [];
        }
        return view('front-end.product_tag',[
            'category_product' => $category_product,
            'brand' => $brand,
            'carts' => $carts,
            'gh' => session()->get('carts'),
            'product_tag' => $product_tag,
            'tag' => $tag,
            'limitedArray' => $limitedArray,
            'favoritedProducts' => $favoritedProducts,
        ]);
    }

    public function wish_lish_show($product_id)
    {
        //nếu đã đăng nhập
        if (Auth::check()) {
            $id_tk = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            $id_kh = $khachhang->id;

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
            $id_tk = Auth::user()->id;
            //dd($id_kh);8
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            //dd($khachhang);
            $id_kh = $khachhang->id;
            //dd($id_kh);

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
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'limitedArray' => $limitedArray,
                'favoritedProducts' => $favoritedProducts,
                'wish_count' => $wish_count,
                'yt' => $yt,
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
            $id = Auth::user()->id;
            //dd($id);
            $khachhang = KhachHang::where('tai_khoan_id', $id)->first();
            $id_kh = $khachhang->id;

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
        }else{
            Session::flash('flash_message_error_review2', 'Vui lòng đăng nhập để đánh giá!');
            return redirect()->back();
        }
    }

//    private function checkIfUserHasPurchasedProduct($customerId, $productId) {
//        // Implement your logic to check if the user (customerId) has purchased the product (productId)
//        // Return true if the user has purchased the product, otherwise return false.
//    }

}
