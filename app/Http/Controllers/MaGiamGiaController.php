<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\MaGiamGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MaGiamGiaController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }
        $coupons = MaGiamGia::all()->sortByDesc("id");
        return view('back-end.coupon.index',[
            'coupons' => $coupons,
            'nhanvien' => $nhanvien
        ]);
    }

    public function create()
    {
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }
        return view('back-end.coupon.create',[
            'nhanvien' => $nhanvien
        ]);
    }

    public function store(Request $request)
    {
//         dd($request);
        $this -> validate($request, [
            'mgg_TenGiamGia' => 'required',
            'mgg_MaGiamGia' => 'required',
            'mgg_SoLuongMa' => 'required',
            'mgg_LoaiGiamGia' => 'required',
            'mgg_NgayBatDau' => 'required',
            'mgg_NgayKetThuc' => 'required',
            'mgg_GiaTri' => 'required',
        ],
            [
                'mgg_TenGiamGia.required' => 'Vui lòng nhập tên mã giảm giá',
                'mgg_MaGiamGia.required' => 'Vui lòng nhập mã giảm giá',
                'mgg_SoLuongMa.required' => 'Vui lòng nhập số lượng mã',
                'mgg_LoaiGiamGia.required' => 'Vui lòng chọn loại giảm giá',
                'mgg_NgayBatDau.required' => 'Vui lòng chọn ngày bắt đầu',
                'mgg_NgayKetThuc.required' => 'Vui lòng chọn ngày hết hạn',
                'mgg_GiaTri.required' => 'Vui lòng nhập giá trị giảm',
            ]);

        $mgg = new MaGiamGia();
        $mgg->mgg_TenGiamGia = $request->mgg_TenGiamGia;
        $mgg->mgg_MaGiamGia = $request->mgg_MaGiamGia;
        $mgg->mgg_SoLuongMa = $request->mgg_SoLuongMa;
        $mgg->mgg_LoaiGiamGia = $request->mgg_LoaiGiamGia;
        $mgg->mgg_NgayBatDau = $request->mgg_NgayBatDau;
        $mgg->mgg_NgayKetThuc = $request->mgg_NgayKetThuc;
        $mgg->mgg_GiaTri = $request->mgg_GiaTri;
        $mgg->save();

        Session::flash('flash_message', 'Thêm mã giảm giá thành công!');
        return redirect('/admin/coupons');
    }

//    public function edit($id)
//    {
//        if(Auth::check()){
//            $id = Auth::user()->id;
//            $nhanvien = NhanVien::where('tai_khoan_id', $id)->first();
//            // dd($nhanvien);
//        }
//        $brand = ThuongHieu::find($id);
//        // dd($brand);
//        return view('back-end.coupon.edit',[
//            'brand' => $brand,
//            'nhanvien' => $nhanvien
//        ]);
//    }
//
//    public function update(Request $request, $id)
//    {
//        $requestData = $request->all();
//        //dd($requestData);
//        $brand = ThuongHieu::find($id);
//        $brand->update($requestData);
//        Session::flash('flash_message', 'Cập nhật thương hiệu thành công!');
//        return redirect('/admin/coupons');
//    }
//
//    public function destroy($id)
//    {
//        $brand = ThuongHieu::find($id);
//        // dd($categoty_product);
//        try {
//            DB::beginTransaction();
//
//            if (count($brand->products) > 0) {
//                Session::flash('flash_message_error', 'Xóa thương hiệu thất bại! Thương hiệu '.$brand->thsp_TenThuongHieu.' đang có sản phẩm.');
//                return redirect()->back();
//            }
//
//            $brand->destroy($brand->id);
//
//            DB::commit();
//            Session::flash('flash_message', 'Xóa thương hiệu thành công!');
//            return redirect('/admin/brands');
//        } catch (Exception $e) {
//            DB::rollback();
//            Session::flash('flash_message_error', 'Xóa thương hiệu thất bại !');
//            return redirect()->back();
//        }
//    }
//

}
