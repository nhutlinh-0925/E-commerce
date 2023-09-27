<?php

namespace App\Http\Controllers;

use App\Models\NhaCungCap;
use App\Models\NhanVien;
use App\Models\PhieuNhapHang;
use App\Models\ChiTietPhieuNhapHang;
use App\Models\SanPham;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class NhapKhoController extends Controller
{
    public function index()
    {
        // return 123;
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }
        $warehouses = PhieuNhapHang::all()->sortByDesc("id");
        return view('back-end.warehouse.index',[
            'warehouses' => $warehouses,
            'nhanvien' => $nhanvien
        ]);
    }

    public function create()
    {
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            //dd($nhanvien);
        }

        $suppliers = NhaCungCap::where('ncc_TrangThai', 1)->get();
        $products = SanPham::where('SP_TrangThai', 1)->get();
        return view('back-end.warehouse.create',[
            'nhanvien' => $nhanvien,
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

            $output .= '
            <option value="' . $val->id . '" data-image="' . $imagePath . '" data-price="' . $formattedPrice . '">
                ' . '#' . $val->id . ' - ' . $val->sp_TenSanPham . ' - ' . $formattedPrice . ' đ
            </option>';

        }

        return $output;
    }










    public function store(Request $request){
        //dd($request);
        if(Auth::check()){
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $this -> validate($request, [
                'nha_cung_cap_id' => 'required',
            ],
                [
                    'nha_cung_cap_id.required' => 'Vui lòng chọn nhà cung cấp',
                ]);

            $now = Carbon::now();
            $formattedDateTime = $now->format('Y-m-d H:i:s');

            $id_tk = $request->user()->id;
            //dd($id_tk);
            $nhanvien = NhanVien::where('tai_khoan_id', $id_tk)->first();
            //dd($nhanvien);
            $id_nv = $nhanvien->id;

            $pnh = new PhieuNhapHang();
            $pnh->nhan_vien_id = $id_nv;
            $pnh->nha_cung_cap_id = $request->nha_cung_cap_id;
            $pnh->pnh_NgayLapPhieu = $formattedDateTime;
            $pnh->pnh_TongTien = $request->pnh_TongTien;
            $pnh->pnh_GhiChu = $request->pnh_GhiChu;
            $pnh->pnh_TrangThai = 0;
            //dd($pnh);
            $pnh->save();

            // Lấy id của phiếu nhập hàng mới tạo
            $phieuNhapHangId = $pnh->id;

            // Lấy danh sách sản phẩm từ request
            $productPrices = $request->product_price;
            //dd($productPrices);
            $productQuantities = $request->product_quantity;

            // Duyệt qua danh sách sản phẩm và tạo chi tiết phiếu nhập hàng
            foreach ($productPrices as $productId => $price) {
                $quantity = $productQuantities[$productId];
                // Loại bỏ dấu phẩy và chuyển đổi thành số nguyên
                $price = $productPrices[$productId];
                //dd($price);
                $priceWithoutComma = str_replace('.', '', $price);

                // Tạo chi tiết phiếu nhập hàng và lưu vào cơ sở dữ liệu
                $chiTietPhieuNhap = new ChiTietPhieuNhapHang();
                $chiTietPhieuNhap->phieu_nhap_hang_id = $phieuNhapHangId;
                $chiTietPhieuNhap->san_pham_id = $productId;
                $chiTietPhieuNhap->ctpnh_SoLuongNhap = $quantity;
                //dd($chiTietPhieuNhap);
                $chiTietPhieuNhap->ctpnh_GiaNhap = $priceWithoutComma;
                //dd($chiTietPhieuNhap);
                $chiTietPhieuNhap->save();
            }

            Session::flash('flash_message', 'Thêm phiếu nhập thành công!');
            return redirect('/admin/warehouses');
        }
    }

    public function show($id){
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }

        $warehouse = PhieuNhapHang::find($id);
        $detail_warehouses = ChiTietPhieuNhapHang::with('sanpham')
                           ->where('phieu_nhap_hang_id', $id)
                           ->get();
        //dd($detail_warehouses);
        return view('back-end.warehouse.show',[
            'nhanvien' => $nhanvien,
            'warehouse' => $warehouse,
            'detail_warehouses' => $detail_warehouses
        ]);
    }

    public function active($id)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $now = Carbon::now();
        $formattedDateTime = $now->format('Y-m-d H:i:s');
        //dd($formattedDateTime);
        $warehouse = PhieuNhapHang::find($id)
            ->update([
                'pnh_TrangThai' => 1,
                'pnh_NgayXacNhan' => $formattedDateTime,
            ]);
        //dd($warehouse);

        $detail_warehouses = ChiTietPhieuNhapHang::with('sanpham')
            ->where('phieu_nhap_hang_id', $id)
            ->get();
        //dd($detail_warehouses);
        // Cập nhật số lượng hàng trong bảng san_phams
        foreach ($detail_warehouses as $detail_warehouse) {
            $sp = $detail_warehouse->sanpham;
            $sp->sp_SoLuongHang += $detail_warehouse->ctpnh_SoLuongNhap;
            $sp->save();
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
