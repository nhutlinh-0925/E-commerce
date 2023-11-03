<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhMucSanPham;
use App\Models\ThuongHieu;
use App\Models\SanPham;
use App\Models\YeuThich;

use Illuminate\Support\Facades\Auth;

use App\Http\Services\CartService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\KichThuoc;

class ShopController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function shop(Request $request) {
        if(Auth::check()){
            $id_kh = Auth('web')->user()->id;
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
                }elseif ($sort_by == 'size_S') {
                    $products = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 1)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'size_M') {
                    $products = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 2)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == 'size_L') {
                    $products = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 3)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == 'size_XL') {
                    $products = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 4)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
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
            $sizes = KichThuoc::all();

            return view('front-end.shop',[
                'category_product' => $category_product,
                'brand' => $brand,
                'products' => $products,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'limitedArray' => $limitedArray,
                'favoritedProducts' => $favoritedProducts,
                'wish_count' => $wish_count,
                'sizes' => $sizes
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

            $sizes = KichThuoc::all();

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
            } elseif ($sort_by == 'size_S') {
                $products = SanPham::select('san_phams.*')
                    ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                    ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                    ->where('san_phams.sp_TrangThai', 1)
                    ->where('kich_thuocs.id', 1)
                    ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                    ->orderBy('san_phams.id', 'desc')
                    ->paginate(9)->appends(request()->query());
            } elseif ($sort_by == 'size_M') {
                    $products = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 2)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == 'size_L') {
                    $products = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 3)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == 'size_XL') {
                    $products = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 4)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
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
                'sizes' => $sizes
            ]);
    }

    public function danhmuc_sanpham($id) {
        if(Auth::check()){
            $id_kh = Auth('web')->user()->id;

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
            $sizes = KichThuoc::all();

            if(isset($_GET['sort_by'])) {
                $sort_by = $_GET['sort_by'];
                if ($sort_by == '1000') {
                    $sp = SanPham::where('sp_TrangThai',1)
                        ->where('sp_Gia', '<=', 1000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());

                } elseif ($sort_by == '1000_2000') {
                    $sp = SanPham::where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 1000000)
                        ->where('sp_Gia', '<=', 2000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '2000_3000') {
                    $sp = SanPham::where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 2000000)
                        ->where('sp_Gia', '<=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3000') {
                    $sp = SanPham::where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '5sao') {
                    $sp = SanPham::select('san_phams.*')
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
                    $sp = SanPham::select('san_phams.*')
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
                    $sp = SanPham::select('san_phams.*')
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
                    $sp = SanPham::select('san_phams.*')
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
                    $sp = SanPham::select('san_phams.*')
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
                }elseif ($sort_by == 'size_S') {
                    $sp = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 1)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'size_M') {
                    $sp = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 2)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == 'size_L') {
                    $sp = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 3)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == 'size_XL') {
                    $sp = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 4)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
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
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'sp' => $sp,
                'limitedArray' => $limitedArray,
                'favoritedProducts' => $favoritedProducts,
                'wish_count' => $wish_count,
                'sizes' => $sizes
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
            $sizes = KichThuoc::all();
            if(isset($_GET['sort_by'])) {
                $sort_by = $_GET['sort_by'];
                if ($sort_by == '1000') {
                    $sp = SanPham::where('sp_TrangThai',1)
                        ->where('sp_Gia', '<=', 1000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());

                } elseif ($sort_by == '1000_2000') {
                    $sp = SanPham::where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 1000000)
                        ->where('sp_Gia', '<=', 2000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '2000_3000') {
                    $sp = SanPham::where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 2000000)
                        ->where('sp_Gia', '<=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3000') {
                    $sp = SanPham::where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '5sao') {
                    $sp = SanPham::select('san_phams.*')
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
                    $sp = SanPham::select('san_phams.*')
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
                    $sp = SanPham::select('san_phams.*')
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
                    $sp = SanPham::select('san_phams.*')
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
                    $sp = SanPham::select('san_phams.*')
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
                }elseif ($sort_by == 'size_S') {
                    $sp = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 1)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'size_M') {
                    $sp = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 2)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == 'size_L') {
                    $sp = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 3)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == 'size_XL') {
                    $sp = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 4)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
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
                'sizes' => $sizes
            ]);
        }
    }

    public function thuonghieu_sanpham($id) {
        if(Auth::check()){
            $id_kh = Auth('web')->user()->id;

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
            $sizes = KichThuoc::all();

            if(isset($_GET['sort_by'])) {
                $sort_by = $_GET['sort_by'];
                if ($sort_by == '1000') {
                    $sp = SanPham::where('sp_TrangThai',1)
                        ->where('sp_Gia', '<=', 1000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());

                } elseif ($sort_by == '1000_2000') {
                    $sp = SanPham::where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 1000000)
                        ->where('sp_Gia', '<=', 2000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '2000_3000') {
                    $sp = SanPham::where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 2000000)
                        ->where('sp_Gia', '<=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3000') {
                    $sp = SanPham::where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '5sao') {
                    $sp = SanPham::select('san_phams.*')
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
                    $sp = SanPham::select('san_phams.*')
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
                    $sp = SanPham::select('san_phams.*')
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
                    $sp = SanPham::select('san_phams.*')
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
                    $sp = SanPham::select('san_phams.*')
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
                }elseif ($sort_by == 'size_S') {
                    $sp = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 1)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'size_M') {
                    $sp = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 2)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == 'size_L') {
                    $sp = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 3)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == 'size_XL') {
                    $sp = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 4)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
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
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'sp' => $sp,
                'limitedArray' => $limitedArray,
                'favoritedProducts' => $favoritedProducts,
                'wish_count' => $wish_count,
                'sizes' => $sizes
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
            $sizes = KichThuoc::all();

            if(isset($_GET['sort_by'])) {
                $sort_by = $_GET['sort_by'];
                if ($sort_by == '1000') {
                    $sp = SanPham::where('sp_TrangThai',1)
                        ->where('sp_Gia', '<=', 1000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());

                } elseif ($sort_by == '1000_2000') {
                    $sp = SanPham::where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 1000000)
                        ->where('sp_Gia', '<=', 2000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '2000_3000') {
                    $sp = SanPham::where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 2000000)
                        ->where('sp_Gia', '<=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3000') {
                    $sp = SanPham::where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '5sao') {
                    $sp = SanPham::select('san_phams.*')
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
                    $sp = SanPham::select('san_phams.*')
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
                    $sp = SanPham::select('san_phams.*')
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
                    $sp = SanPham::select('san_phams.*')
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
                    $sp = SanPham::select('san_phams.*')
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
                }elseif ($sort_by == 'size_S') {
                    $sp = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 1)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'size_M') {
                    $sp = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 2)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == 'size_L') {
                    $sp = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 3)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == 'size_XL') {
                    $sp = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 4)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
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
                'sizes' => $sizes
            ]);
        }
    }

    public function tag(Request $request, $product_tag){
        if(Auth::check()){
            $id_kh = Auth('web')->user()->id;

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
            $sizes = KichThuoc::all();

            if(isset($_GET['sort_by'])) {
                $sort_by = $_GET['sort_by'];
                if ($sort_by == '1000') {
                    $product_tag = DB::table('san_phams')
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '<=', 1000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());

                } elseif ($sort_by == '1000_2000') {
                    $product_tag = DB::table('san_phams')
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 1000000)
                        ->where('sp_Gia', '<=', 2000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '2000_3000') {
                    $product_tag = DB::table('san_phams')
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 2000000)
                        ->where('sp_Gia', '<=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3000') {
                    $product_tag = DB::table('san_phams')
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '5sao') {
                    $product_tag = SanPham::select('san_phams.*')
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
                    $product_tag = SanPham::select('san_phams.*')
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
                    $product_tag = SanPham::select('san_phams.*')
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
                    $product_tag = SanPham::select('san_phams.*')
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
                    $product_tag = SanPham::select('san_phams.*')
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
                }elseif ($sort_by == 'size_S') {
                    $product_tag = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 1)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'size_M') {
                    $product_tag = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 2)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == 'size_L') {
                    $product_tag = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 3)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == 'size_XL') {
                    $product_tag = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 4)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
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
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'product_tag' => $product_tag,
                'tag' => $tag,
                'limitedArray' => $limitedArray,
                'favoritedProducts' => $favoritedProducts,
                'wish_count' => $wish_count,
                'sizes' => $sizes
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
            $sizes = KichThuoc::all();
            if(isset($_GET['sort_by'])) {
                $sort_by = $_GET['sort_by'];
                if ($sort_by == '1000') {
                    $product_tag = DB::table('san_phams')
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '<=', 1000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());

                } elseif ($sort_by == '1000_2000') {
                    $product_tag = DB::table('san_phams')
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 1000000)
                        ->where('sp_Gia', '<=', 2000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '2000_3000') {
                    $product_tag = DB::table('san_phams')
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 2000000)
                        ->where('sp_Gia', '<=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '3000') {
                    $product_tag = DB::table('san_phams')
                        ->where('sp_TrangThai',1)
                        ->where('sp_Gia', '>=', 3000000)
                        ->orderBy('sp_Gia', 'asc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == '5sao') {
                    $product_tag = SanPham::select('san_phams.*')
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
                    $product_tag = SanPham::select('san_phams.*')
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
                    $product_tag = SanPham::select('san_phams.*')
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
                    $product_tag = SanPham::select('san_phams.*')
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
                    $product_tag = SanPham::select('san_phams.*')
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
                }elseif ($sort_by == 'size_S') {
                    $product_tag = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 1)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                } elseif ($sort_by == 'size_M') {
                    $product_tag = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 2)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == 'size_L') {
                    $product_tag = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 3)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
                        ->paginate(9)->appends(request()->query());
                }elseif ($sort_by == 'size_XL') {
                    $product_tag = SanPham::select('san_phams.*')
                        ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                        ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                        ->where('san_phams.sp_TrangThai', 1)
                        ->where('kich_thuocs.id', 4)
                        ->where('san_pham_kich_thuocs.spkt_soLuongHang', '>', 0)
                        ->orderBy('san_phams.id', 'desc')
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
            'sizes' => $sizes
        ]);
    }



}
