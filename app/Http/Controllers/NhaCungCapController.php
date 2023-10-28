<?php

namespace App\Http\Controllers;

use App\Models\NhaCungCap;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class NhaCungCapController extends Controller
{
    public function index()
    {
        $suppliers = NhaCungCap::all()->sortByDesc("id");
        return view('back-end.supplier.index',[
            'suppliers' => $suppliers,
        ]);
    }

    public function create()
    {
        return view('back-end.supplier.create');
    }

    public function store(Request $request)
    {
        //dd($request);
        $this -> validate($request, [
            'ncc_TenNhaCungCap' => 'required',
            'ncc_Email' => 'required',
            'ncc_SoDienThoai' => 'required',
            'ncc_DiaChi' => 'required',
            'ncc_TrangThai' => 'required',
        ],
            [
                'ncc_TenNhaCungCap.required' => 'Vui lòng nhập tên nhà cung cấp',
                'ncc_Email.required' => 'Vui lòng nhập email',
                'ncc_SoDienThoai.required' => 'Vui lòng nhập số điện thoại',
                'ncc_DiaChi.required' => 'Vui lòng nhập địa chỉ',
                'ncc_TrangThai.required' => 'Vui lòng chọn trạng thái',
            ]);

        $ncc = new NhaCungCap();
        $ncc->ncc_TenNhaCungCap = $request->ncc_TenNhaCungCap;
        $ncc->ncc_Email = $request->ncc_Email;
        $ncc->ncc_SoDienThoai = $request->ncc_SoDienThoai;
        $ncc->ncc_DiaChi = $request->ncc_DiaChi;
        $ncc->ncc_TrangThai = $request->ncc_TrangThai;
        $ncc->save();

        Session::flash('flash_message', 'Thêm nhà cung cấp thành công!');
        return redirect('/admin/suppliers');
    }

    public function edit($id)
    {
        $supplier = NhaCungCap::find($id);
        return view('back-end.supplier.edit',[
            'supplier' => $supplier,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this -> validate($request, [
            'ncc_TenNhaCungCap' => 'required',
            'ncc_Email' => 'required',
            'ncc_SoDienThoai' => 'required',
            'ncc_DiaChi' => 'required',
            'ncc_TrangThai' => 'required',
        ],
            [
                'ncc_TenNhaCungCap.required' => 'Vui lòng nhập tên nhà cung cấp',
                'ncc_Email.required' => 'Vui lòng nhập email',
                'ncc_SoDienThoai.required' => 'Vui lòng nhập số điện thoại',
                'ncc_DiaChi.required' => 'Vui lòng nhập địa chỉ',
                'ncc_TrangThai.required' => 'Vui lòng chọn trạng thái',
            ]);

        $supplier = NhaCungCap::find($id);

        $supplier->ncc_TenNhaCungCap = $request->ncc_TenNhaCungCap;
        $supplier->ncc_Email = $request->ncc_Email;
        $supplier->ncc_SoDienThoai = $request->ncc_SoDienThoai;
        $supplier->ncc_DiaChi = $request->ncc_DiaChi;
        $supplier->ncc_TrangThai = $request->ncc_TrangThai;
        $supplier->save();

        Session::flash('flash_message', 'Cập nhật nhà cung cấp thành công !');
        return redirect('/admin/suppliers');
    }


}
