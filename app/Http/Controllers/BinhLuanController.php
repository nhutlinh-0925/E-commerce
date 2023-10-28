<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\BinhLuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BinhLuanController extends Controller
{
    public function index()
    {
        $comments = BinhLuan::all()->sortByDesc("id");
        return view('back-end.comment.index',[
            'comments' => $comments,
        ]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            BinhLuan::destroy($id);
            DB::commit();
            Session::flash('flash_message', 'Xoá bình luận thành công!');
            return redirect('/admin/comments');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('flash_message_error', 'Xóa bình luận thất bại!');
            return redirect()->back();
        }
    }

    public function active($id)
    {
        $comment = BinhLuan::find($id)
            ->update(
                ['bl_TrangThai' => 0],
            );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/comments');
    }

    public function unactive($id)
    {
        $comment = BinhLuan::find($id)
            ->update(
                ['bl_TrangThai' => 1],
            );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/comments');
    }
}
