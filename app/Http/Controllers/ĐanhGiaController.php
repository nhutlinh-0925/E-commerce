<?php

namespace App\Http\Controllers;

use App\Models\ĐanhGia;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ĐanhGiaController extends Controller
{
    public function index()
    {
        $reviews = ĐanhGia::all()->sortByDesc("id");
        return view('back-end.review.index',[
            'reviews' => $reviews,
        ]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            ĐanhGia::destroy($id);
            DB::commit();
            Session::flash('flash_message', 'Xoá đánh giá thành công!');
            return redirect('/admin/reviews');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('flash_message_error', 'Xóa đánh giá thất bại!');
            return redirect()->back();
        }
    }

    public function active($id)
    {
        $review = ĐanhGia::find($id)
            ->update(
                ['dg_TrangThai' => 0],
            );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/reviews');
    }

    public function unactive($id)
    {
        $review = ĐanhGia::find($id)
            ->update(
                ['dg_TrangThai' => 1],
            );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/reviews');
    }
}
