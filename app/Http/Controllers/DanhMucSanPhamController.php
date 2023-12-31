<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\DanhMucSanPham;

use Illuminate\Support\Facades\Auth;

class DanhMucSanPhamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoty_products = DanhMucSanPham::all()->sortByDesc("id");
        return view('back-end.category-product.index',[
            'categoty_products' => $categoty_products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back-end.category-product.create2');
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
            'dmsp_TenDanhMuc' => 'required',
            'dmsp_MoTa' => 'required',
            'dmsp_TrangThai' => 'required',
        ],
        [
            'dmsp_TenDanhMuc.required' => 'Vui lòng nhập tên danh mục',
            'dmsp_MoTa.required' => 'Vui lòng nhập mô tả',
            'dmsp_TrangThai.required' => 'Vui lòng chọn trạng thái',
        ]);

        $dmsp = new DanhMucSanPham();
        $dmsp->dmsp_TenDanhMuc = $request->dmsp_TenDanhMuc;
        $dmsp->dmsp_MoTa = $request->dmsp_MoTa;
        $dmsp->dmsp_TrangThai = $request->dmsp_TrangThai;
        $dmsp->save();

        Session::flash('flash_message', 'Thêm danh mục thành công!');
        return redirect('/admin/category-products');
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
        $categoty_product = DanhMucSanPham::find($id);

        return view('back-end.category-product.edit',[
            'categoty_product' => $categoty_product,
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
        //dd($requestData);
        $this -> validate($request, [
            'dmsp_TenDanhMuc' => 'required',
            'dmsp_MoTa' => 'required',
            'dmsp_TrangThai' => 'required',
        ],
            [
                'dmsp_TenDanhMuc.required' => 'Vui lòng nhập tên danh mục',
                'dmsp_MoTa.required' => 'Vui lòng nhập mô tả',
                'dmsp_TrangThai.required' => 'Vui lòng chọn trạng thái',
            ]);
        $categoty_product = DanhMucSanPham::find($id);

        $categoty_product->dmsp_TenDanhMuc = $request->dmsp_TenDanhMuc;
        $categoty_product->dmsp_MoTa = $request->dmsp_MoTa;
        $categoty_product->dmsp_TrangThai = $request->dmsp_TrangThai;
        $categoty_product->save();

        Session::flash('flash_message', 'Cập nhật danh mục thành công !');
        return redirect('/admin/category-products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoty_product = DanhMucSanPham::find($id);

        try {
            DB::beginTransaction();

            if (count($categoty_product->products) > 0) {
                Session::flash('flash_message_error', 'Xóa danh mục sản phẩm thất bại! Danh mục '.$categoty_product->dmsp_TenDanhMuc.' đang có sản phẩm.');
                return redirect()->back();
            }

            $categoty_product->destroy($categoty_product->id);

            DB::commit();
            Session::flash('flash_message', 'Xóa danh mục thành công!');
            return redirect('/admin/category-products');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('flash_message_error', 'Xóa danh mục thất bại !');
            return redirect()->back();
        }
    }

    public function active($id)
    {
        $categoty_product = DanhMucSanPham::find($id)
            ->update(
                ['dmsp_TrangThai' => 0],
        );
        $product_status = SanPham::where('danh_muc_san_pham_id', $id)->update(['sp_TrangThai' => 0]);
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/category-products');
    }

    public function unactive($id)
    {
        $categoty_product = DanhMucSanPham::find($id)
            ->update(
                ['dmsp_TrangThai' => 1],
        );
        $product_status = SanPham::where('danh_muc_san_pham_id', $id)->update(['sp_TrangThai' => 1]);
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/category-products');
    }

}
