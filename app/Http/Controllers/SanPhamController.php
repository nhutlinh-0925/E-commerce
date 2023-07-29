<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\DanhMucSanPham;
use App\Models\ThuongHieu;
use App\Models\SanPham;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Auth;
use App\Models\NhanVien;


class SanPhamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }
        $products = SanPham::all()->sortByDesc("id");
        // $categoty_products = DanhMucSanPham::all()->sortByDesc("id");
        return view('back-end.product.index',[
            'products' => $products,
            'nhanvien' => $nhanvien
            // 'categoty_products' => $categoty_products
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
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }
        $category_products = DanhMucSanPham::all();
        // dd($category_products);
        $brands = ThuongHieu::all();
        $data = [
            'category_products' => $category_products,
            'brands' => $brands,
            'nhanvien' => $nhanvien
        ];

        return view('back-end.product.create2', $data);
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
        $input = $request->all();
        if($request->hasFile('sp_AnhDaiDien'))
            {
                $destination_path = 'public/images/products';
                $image = $request->file('sp_AnhDaiDien');
                $image_name = $image->getClientOriginalName();
                $path = $request->file('sp_AnhDaiDien')->storeAs($destination_path,$image_name);

                $input['sp_AnhDaiDien'] = $image_name;
            }

        SanPham::create($input);

        Session::flash('flash_message', 'Thêm sản phẩm thành công!');
        return redirect('/admin/products');
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
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }
        $product = SanPham::find($id);
        $category_products = DanhMucSanPham::all();
        $brands = ThuongHieu::all();
        return view('back-end.product.edit',[
            'product' => $product,
            'category_products' => $category_products,
            'brands' => $brands,
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
        // dd($request);
        $product = SanPham::find($id);
        $input = $request->all();
        if($request->hasFile('sp_AnhDaiDien'))
        {
            $destination = 'public/images/products'.$product->sp_AnhDaiDien;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $destination_path = 'public/images/products';
            $image = $request->file('sp_AnhDaiDien');
            $image_name = $image->getClientOriginalName();
            $path = $request->file('sp_AnhDaiDien')->storeAs($destination_path,$image_name);

            $input['sp_AnhDaiDien'] = $image_name;
        }

        SanPham::find($id)->update($input);

        Session::flash('flash_message', 'Cập nhật sản phẩm thành công!');
        return redirect('/admin/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
