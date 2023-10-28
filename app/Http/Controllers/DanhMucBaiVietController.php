<?php

namespace App\Http\Controllers;

use App\Models\BaiViet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\DanhMucBaiViet;

use Illuminate\Support\Facades\Auth;
use App\Models\NhanVien;
class DanhMucBaiVietController extends Controller
{
    public function index()
    {
        $categoty_posts = DanhMucBaiViet::all()->sortByDesc("id");
        return view('back-end.category-post.index',[
            'categoty_posts' => $categoty_posts,
        ]);
    }

    public function create()
    {
        return view('back-end.category-post.create');
    }

    public function store(Request $request)
    {
        // dd($request);
        $this -> validate($request, [
            'dmbv_TenDanhMuc' => 'required',
            'dmbv_MoTa' => 'required',
            'dmbv_TrangThai' => 'required',
        ],
            [
                'dmbv_TenDanhMuc.required' => 'Vui lòng nhập tên danh mục',
                'dmbv_MoTa.required' => 'Vui lòng nhập mô tả',
                'dmbv_TrangThai.required' => 'Vui lòng chọn trạng thái',
            ]);

        $dmbv = new DanhMucBaiViet();
        $dmbv->dmbv_TenDanhMuc = $request->dmbv_TenDanhMuc;
        $dmbv->dmbv_MoTa = $request->dmbv_MoTa;
        $dmbv->dmbv_TrangThai = $request->dmbv_TrangThai;
        $dmbv->save();

        Session::flash('flash_message', 'Thêm danh mục thành công!');
        return redirect('/admin/category-posts');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $categoty_post = DanhMucBaiViet::find($id);
        return view('back-end.category-post.edit',[
            'categoty_post' => $categoty_post,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this -> validate($request, [
            'dmbv_TenDanhMuc' => 'required',
            'dmbv_MoTa' => 'required',
            'dmbv_TrangThai' => 'required',
        ],
            [
                'dmbv_TenDanhMuc.required' => 'Vui lòng nhập tên danh mục',
                'dmbv_MoTa.required' => 'Vui lòng nhập mô tả',
                'dmbv_TrangThai.required' => 'Vui lòng chọn trạng thái',
            ]);

        $categoty_post = DanhMucBaiViet::find($id);

        $categoty_post->dmbv_TenDanhMuc = $request->dmbv_TenDanhMuc;
        $categoty_post->dmbv_MoTa = $request->dmbv_MoTa;
        $categoty_post->dmbv_TrangThai = $request->dmbv_TrangThai;
        $categoty_post->save();

        Session::flash('flash_message', 'Cập nhật danh mục thành công !');
        return redirect('/admin/category-posts');
    }

    public function destroy($id)
    {
        $categoty_post = DanhMucBaiViet::find($id);

        try {
            DB::beginTransaction();

            if (count($categoty_post->posts) > 0) {
                Session::flash('flash_message_error', 'Xóa danh mục bài viết thất bại! Danh mục '.$categoty_post->dmbv_TenDanhMuc.' đang có bài viết.');
                return redirect()->back();
            }

            $categoty_post->destroy($categoty_post->id);

            DB::commit();
            Session::flash('flash_message', 'Xóa danh mục thành công!');
            return redirect('/admin/category-posts');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('flash_message_error', 'Xóa danh mục thất bại !');
            return redirect()->back();
        }
    }

    public function active($id)
    {
        $categoty_post = DanhMucBaiViet::find($id)
            ->update(
                ['dmbv_TrangThai' => 0],
            );

        $post_status = BaiViet::where('danh_muc_bai_viet_id', $id)->update(['bv_TrangThai' => 0]);
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/category-posts');
    }

    public function unactive($id)
    {
        $categoty_post = DanhMucBaiViet::find($id)
            ->update(
                ['dmbv_TrangThai' => 1],
            );
        $post_status = BaiViet::where('danh_muc_bai_viet_id', $id)->update(['bv_TrangThai' => 1]);
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/category-posts');
    }
}
