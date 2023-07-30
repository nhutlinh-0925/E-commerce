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

use App\Models\HinhAnh;

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
        $category_products = DanhMucSanPham::where('dmsp_TrangThai',1)->get();
//         dd($category_products);
        $brands = ThuongHieu::where('thsp_TrangThai',1)->get();
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

        $sanpham = SanPham::create($input);

        $id_sp = $sanpham->id;
        $files = $request->ha_AnhChiTiet;
        if (count($files) > 0) {
            foreach ($files as $file){
                if(isset($file)) {
                    $ha_ct = new HinhAnh();
                    $ha_ct->san_pham_id = $id_sp;
                    // Sử dụng tên gốc của tệp tin làm tên hình ảnh trong cơ sở dữ liệu
                    $ha_ct->ha_Ten = $file->getClientOriginalName();
                    // Di chuyển và lưu hình ảnh vào thư mục lưu trữ
                    $file->storeAs('public/images/product/detail', $file->getClientOriginalName());
                    // Lưu thông tin vào cơ sở dữ liệu
                    $ha_ct->save();
                }
            }
        }

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
        $category_products = DanhMucSanPham::where('dmsp_TrangThai',1)->get();
//         dd($category_products);
        $brands = ThuongHieu::where('thsp_TrangThai',1)->get();
        $images = $product->hinhanh; // Lấy các hình ảnh liên quan đến sản phẩm
        return view('back-end.product.edit',[
            'product' => $product,
            'category_products' => $category_products,
            'brands' => $brands,
            'nhanvien' => $nhanvien,
            'images' => $images
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
//         dd($request);
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

        // Cập nhật hình ảnh chi tiết (nếu có)
        $files = $request->ha_AnhChiTiet;
        if (is_array($files) && count($files) > 0) {
            // Lưu giá trị cũ của hình ảnh chi tiết
            $old_images = $product->hinhanh->pluck('ha_Ten')->toArray();

            // Xóa các hình ảnh chi tiết cũ không còn trong danh sách hình ảnh mới
            $deleted_images = array_diff($old_images, $files);
            foreach ($deleted_images as $image_name) {
                $image_path = 'public/images/product/detail/' . $image_name;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }

                // Xóa bản ghi trong cơ sở dữ liệu có cùng ha_Ten
                HinhAnh::where('ha_Ten', $image_name)->delete();
            }

            // Thêm hình ảnh chi tiết mới vào bảng HinhAnh
            foreach ($files as $file) {
                if (is_object($file)) {
                    // Sử dụng tên gốc của tệp tin làm tên hình ảnh trong cơ sở dữ liệu
                    $image_name = $file->getClientOriginalName();

                    // Nếu hình ảnh chi tiết đã tồn tại thì cập nhật, nếu không thì tạo mới
                    HinhAnh::updateOrCreate(
                        ['san_pham_id' => $product->id, 'ha_Ten' => $image_name],
                        ['san_pham_id' => $product->id, 'ha_Ten' => $image_name]
                    );

                    // Di chuyển và lưu hình ảnh vào thư mục lưu trữ
                    $file->storeAs('public/images/product/detail', $image_name);
                }
            }
        }


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
