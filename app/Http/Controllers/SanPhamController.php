<?php

namespace App\Http\Controllers;

//use App\Models\KichThuoc;
use App\Models\SanPhamKichThuoc;
use App\Models\ĐanhGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\DanhMucSanPham;
use App\Models\ThuongHieu;
use App\Models\SanPham;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Auth;
//use App\Models\NhanVien;
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
//        $products = SanPham::all()->sortByDesc("id");
        $products = SanPham::withSum('sanphamkichthuoc', 'spkt_SoLuongHang')->get()->sortByDesc('id');
        return view('back-end.product.index',[
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category_products = DanhMucSanPham::where('dmsp_TrangThai',1)->get();
        $brands = ThuongHieu::where('thsp_TrangThai',1)->get();
//        $sizes = KichThuoc::all();
        $data = [
            'category_products' => $category_products,
            'brands' => $brands,
//            'sizes' => $sizes
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
//         dd($request);
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

//        $selectedSizes = $request->input('kich_thuoc_id', []);
//        foreach ($selectedSizes as $sizeId) {
//            $size = KichThuoc::find($sizeId);
//            if ($size) {
//                DB::table('san_pham_kich_thuocs')->insert([
//                    'san_pham_id' => $id_sp,
//                    'kich_thuoc_id' => $size->id,
//                ]);
//            }
//        }

        for ($kichthuocId = 1; $kichthuocId <= 4; $kichthuocId++) {
            SanPhamKichThuoc::create([
                'san_pham_id' => $id_sp,
                'kich_thuoc_id' => $kichthuocId,
                //'spkt_soLuongHang' => 0,
            ]);
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
        $product = SanPham::find($id);
        $images = $product->hinhanh;
        $sizes = SanPhamKichThuoc::where('san_pham_id',$id)->where('spkt_soLuongHang','>', 0)->get();
        $total_size = $sizes->sum('spkt_soLuongHang');
        $review = ĐanhGia::where('san_pham_id',$id)->where('dg_TrangThai',1)->orderBy('id', 'desc')->get();
        $rating = ĐanhGia::where('san_pham_id',$id)->avg('dg_SoSao');
        $roundedRating = round($rating, 1);
        $rating_products = ĐanhGia::where('san_pham_id', $id)->get();

        return view('back-end.product.show',[
            'product' => $product,
            'images' => $images,
            'sizes' => $sizes,
            'total_size' => $total_size,
            'review' => $review,
            'rating' => $rating,
            'roundedRating' => $roundedRating,
            'rating_products' => $rating_products,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = SanPham::find($id);
        $category_products = DanhMucSanPham::where('dmsp_TrangThai',1)->get();
        $brands = ThuongHieu::where('thsp_TrangThai',1)->get();
        $images = $product->hinhanh; // Lấy các hình ảnh liên quan đến sản phẩm

        //$selectedSizes = $product->kichthuoc->pluck('id')->toArray();
        //$sizes = KichThuoc::all();

        return view('back-end.product.edit',[
            'product' => $product,
            'category_products' => $category_products,
            'brands' => $brands,
            'images' => $images,
            //'selectedSizes' => $selectedSizes,
            //'sizes' => $sizes
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

        // Cập nhật kích thước của sản phẩm
        // Nếu đã bán sp có size đó r thì phải làm sao.
        //$selectedSizes = $request->input('kich_thuoc_id', []);
        //$product->kichthuoc()->sync($selectedSizes);

        Session::flash('flash_message', 'Cập nhật sản phẩm thành công!');
        return redirect('/admin/products');
    }

    public function active($id)
    {
        $product = SanPham::find($id)
            ->update(
                ['sp_TrangThai' => 1],
            );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/products');
    }

    public function unactive($id)
    {
        $product = SanPham::find($id)
            ->update(
                ['sp_TrangThai' => 0],
            );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function destroy($id)
//    {
//        try {
//            DB::beginTransaction();
//            SanPham::destroy($id);
//            DB::commit();
//            Session::flash('flash_message', 'Xoá sản phẩm thành công!');
//            return redirect('/admin/products');
//        } catch (Exception $e) {
//            DB::rollback();
//            Session::flash('flash_message_error', 'Xóa sản phẩm thất bại!');
//            return redirect()->back();
//        }
//    }
}
