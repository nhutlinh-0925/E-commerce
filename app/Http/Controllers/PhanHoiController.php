<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\PhanHoi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PhanHoiController extends Controller
{
    public function index()
    {
        $feedbacks = PhanHoi::all()->sortByDesc("id");
        return view('back-end.feedback.index',[
            'feedbacks' => $feedbacks,
        ]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            PhanHoi::destroy($id);
            DB::commit();
            Session::flash('flash_message', 'Xoá phản hồi thành công!');
            return redirect('/admin/feedbacks');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('flash_message_error', 'Xóa phản hồi thất bại!');
            return redirect()->back();
        }
    }

    public function active($id)
    {
        $feedback= PhanHoi::find($id)
            ->update(
                ['ph_TrangThai' => 0],
            );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/feedbacks');
    }

    public function unactive($id)
    {
        $feedback = PhanHoi::find($id)
            ->update(
                ['ph_TrangThai' => 1],
            );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/feedbacks');
    }
}
