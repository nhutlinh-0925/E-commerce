<?php

namespace App\Http\Controllers;

use App\Models\NhaCungCap;
//use App\Models\NhanVien;
use App\Models\PhieuNhapHang;
use App\Models\ChiTietPhieuNhapHang;
use App\Models\SanPham;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\KichThuoc;
use App\Models\SanPhamKichThuoc;
class NhapKhoController extends Controller
{
    public function index()
    {
        $warehouses = PhieuNhapHang::all()->sortByDesc("id");
        return view('back-end.warehouse.index',[
            'warehouses' => $warehouses,
        ]);
    }

    public function create()
    {
        $suppliers = NhaCungCap::where('ncc_TrangThai', 1)->get();
        $products = SanPham::where('SP_TrangThai', 1)->get();
        return view('back-end.warehouse.create',[
            'suppliers' => $suppliers,
            'products' => $products
        ]);
    }

//    public function autocomplete_ajax(Request $request){
//        //dd($request);
//        $data = $request->all();
//
//        if($data['query']) {
//            $product = SanPham::where('sp_TrangThai', 1)
//                ->where('sp_TenSanPham', 'LIKE', '%'. $data['query'].'%')->get();
//            $output = '<ul class="dropdown-menu search-results" style="display:block; width: 50%;">';
//            foreach ($product as $key => $val) {
//                $imagePath = asset('/storage/images/products/' . $val->sp_AnhDaiDien);
//                $formattedPrice = number_format($val->sp_Gia, 0, '', '.');
//
//                $output .= '
//                    <li style="display: flex; align-items: center; justify-content: space-between;">
//                    <div style="display: flex; align-items: center;">
//                        <img src="' . $imagePath . '" width="50px" height="50px" style="margin-right: 10px;">
//                        <div>
//                            <span style="font-weight: bold;color: black">' . $val->sp_TenSanPham . '</span><br>
//                            <span style="color: red;font-weight: bold;">' . $formattedPrice . ' đ</span>
//                        </div>
//                        </div>
//                        <button type="button" class="btn btn-primary btn-add-product"
//                                data-product-id="' . $val->id . '"
//                                data-product-name="' . $val->sp_TenSanPham . '"
//                                data-product-image="' . $val->sp_AnhDaiDien . '"
//                        >
//                            Thêm
//                        </button>
//                    </li>
//                ';
//
//            }
//            $output .= '</ul>';
//            echo $output;
//        }
//    }

    public function getProducts()
    {
        $products = SanPham::where('sp_TrangThai', 1)->get();

        $output = '<option value="">Sản phẩm</option>';

        foreach ($products as $key => $val) {
            $imagePath = asset('/storage/images/products/' . $val->sp_AnhDaiDien);
            $formattedPrice = number_format($val->sp_Gia, 0, '', '.');
            // Lấy danh sách kích thước của sản phẩm
            $sizes = $val->kichthuoc->pluck('kt_TenKichThuoc')->implode(', ');
            $output .= '
            <option value="' . $val->id . '" data-image="' . $imagePath . '" data-price="' . $formattedPrice . '" data-size="' . $sizes .'">
                ' . '#' . $val->id . ' - ' . $val->sp_TenSanPham . ' - ' . $formattedPrice . ' đ
            </option>';

        }

        return $output;
    }

    public function store(Request $request)
    {
        // Đảm bảo người dùng đã đăng nhập
        if (Auth::check()) {
            date_default_timezone_set('Asia/Ho_Chi_Minh');

            $this->validate($request, [
                'nha_cung_cap_id' => 'required',
            ], [
                'nha_cung_cap_id.required' => 'Vui lòng chọn nhà cung cấp',
            ]);

            $now = Carbon::now();
            $id_nv = Auth('admin')->user()->id;

            // Tạo phiếu nhập hàng
            $pnh = new PhieuNhapHang();
            $pnh->nhan_vien_id = $id_nv;
            $pnh->nha_cung_cap_id = $request->nha_cung_cap_id;
            $pnh->pnh_NgayLapPhieu = $now;
            $pnh->pnh_TongTien = $request->pnh_TongTien;
            $pnh->pnh_GhiChu = $request->pnh_GhiChu;
            $pnh->pnh_TrangThai = 0;
            $pnh->save();

            // Lấy id của phiếu nhập hàng mới tạo
            $phieuNhapHangId = $pnh->id;

            // Lấy danh sách sản phẩm từ request
            $productPrices = $request->product_price;
            $productQuantities = $request->product_quantity;
            $productSizes = $request->product_size;

            // Lặp qua các sản phẩm
            foreach ($productPrices as $productId => $prices) {
                $quantity = $productQuantities[$productId];

                // Lặp qua các giá và kích thước
                foreach ($prices as $key => $price) {
                    $size = $productSizes[$productId][$key];
                    $priceWithoutComma = str_replace('.', '', $price);

                    // Lấy kích thước tương ứng với sản phẩm và kích thước được chọn
                    $kichThuoc = KichThuoc::where('kt_TenKichThuoc', trim($size))->first();

                    if ($kichThuoc) {
                        // Tạo chi tiết phiếu nhập hàng và lưu vào cơ sở dữ liệu
                        $chiTietPhieuNhap = new ChiTietPhieuNhapHang();
                        $chiTietPhieuNhap->phieu_nhap_hang_id = $phieuNhapHangId;
                        $chiTietPhieuNhap->san_pham_id = $productId;
                        $chiTietPhieuNhap->kich_thuoc_id = $kichThuoc->id;
                        $chiTietPhieuNhap->ctpnh_SoLuongNhap = $quantity[$key];
                        $chiTietPhieuNhap->ctpnh_GiaNhap = $priceWithoutComma;
                        $chiTietPhieuNhap->save();
                    }
                }
            }

            Session::flash('flash_message', 'Thêm phiếu nhập thành công!');
            return redirect('/admin/warehouses');
        }
    }

    public function show($id){
        $warehouse = PhieuNhapHang::find($id);
        $detail_warehouses = ChiTietPhieuNhapHang::with('sanpham')
                           ->where('phieu_nhap_hang_id', $id)
                           ->get();

        return view('back-end.warehouse.show',[
            'warehouse' => $warehouse,
            'detail_warehouses' => $detail_warehouses
        ]);
    }

    public function active($id)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $now = Carbon::now();
        $warehouse = PhieuNhapHang::find($id)
            ->update([
                'pnh_TrangThai' => 1,
                'pnh_NgayXacNhan' => $now,
            ]);
        $warehouses = PhieuNhapHang::find($id);
        foreach ($warehouses->chitietphieunhaphang as $detail) {
            $product = $detail->sanpham;
            if ($product) {
                // Truy vấn dữ liệu trong bảng san_pham_kich_thuocs
                $spkt = SanPhamKichThuoc::where('san_pham_id', $product->id)
                    ->where('kich_thuoc_id', $detail->kichthuoc->id) // Thay kichthuoc bằng tên quan hệ trong model PhieuDatHang
                    ->first();

                if ($spkt) {
                    // Cập nhật spkt_SoLuongHang bằng cách trừ đi ctpdh_SoLuong
                    $spkt->spkt_soLuongHang += $detail->ctpnh_SoLuongNhap;
                    $spkt->save();
                }
            }
        }

        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/warehouses');
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            PhieuNhapHang::destroy($id);
            DB::commit();
            Session::flash('flash_message', 'Xoá phiếu nhập hàng thành công!');
            return redirect('/admin/warehouses');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('flash_message_error', 'Xóa phiếu nhập hàng thất bại!');
            return redirect()->back();
        }
    }
}
