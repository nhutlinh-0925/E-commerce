<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\ThuongHieu;

use Illuminate\Support\Facades\Auth;
use App\Models\NhanVien;

class ThuongHieuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            $id = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id)->first();
            // dd($nhanvien);
        }
        $brands = ThuongHieu::all()->sortByDesc("id");
        return view('back-end.brand.index',[
            'brands' => $brands,
            'nhanvien' => $nhanvien
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check()){
            $id = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id)->first();
            // dd($nhanvien);
        }
        return view('back-end.brand.create',[
        'nhanvien' => $nhanvien
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // dd($request);
        $this -> validate($request, [
            'thsp_TenThuongHieu' => 'required',
            'thsp_MoTa' => 'required',
            'thsp_TrangThai' => 'required',
        ],
        [
            'thsp_TenThuongHieu.required' => 'Vui lòng nhập tên thương hiệu',
            'thsp_MoTa.required' => 'Vui lòng nhập mô tả',
            'thsp_TrangThai.required' => 'Vui lòng chọn trạng thái',
        ]);

        $thsp = new ThuongHieu();
        $thsp->thsp_TenThuongHieu = $request->thsp_TenThuongHieu;
        $thsp->thsp_MoTa = $request->thsp_MoTa;
        $thsp->thsp_TrangThai = $request->thsp_TrangThai;
        $thsp->save();

        Session::flash('flash_message', 'Thêm thương hiệu thành công!');
        return redirect('/admin/brands');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::check()){
            $id = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id)->first();
            // dd($nhanvien);
        }
        $brand = ThuongHieu::find($id);
        // dd($brand);
        return view('back-end.brand.edit',[
            'brand' => $brand,
            'nhanvien' => $nhanvien
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();
        //dd($requestData);
        $brand = ThuongHieu::find($id);
        $brand->update($requestData);
        Session::flash('flash_message', 'Cập nhật thương hiệu thành công!');
        return redirect('/admin/brands');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = ThuongHieu::find($id);
        // dd($categoty_product);
        try {
            DB::beginTransaction();

            if (count($brand->products) > 0) {
                Session::flash('flash_message_error', 'Xóa thương hiệu thất bại! Thương hiệu '.$brand->thsp_TenThuongHieu.' đang có sản phẩm.');
                return redirect()->back();
            }

            $brand->destroy($brand->id);

            DB::commit();
            Session::flash('flash_message', 'Xóa thương hiệu thành công!');
            return redirect('/admin/brands');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('flash_message_error', 'Xóa thương hiệu thất bại !');
            return redirect()->back();
        }
    }

    public function active($id)
    {
        $brand = ThuongHieu::find($id)
            ->update(
                ['thsp_TrangThai' => 0],
        );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/brands');
    }

    public function unactive($id)
    {
        $brand = ThuongHieu::find($id)
            ->update(
                ['thsp_TrangThai' => 1],
        );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/brands');
    }

}
