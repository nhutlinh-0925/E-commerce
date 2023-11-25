<?php

namespace App\Http\Controllers;

use App\Models\ChiTietQuyen;
use App\Models\NguoiGiaoHang;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NguoiGiaoHangController extends Controller
{
    public function index(){
        $carriers = NguoiGiaoHang::all()->sortByDesc("id");

        return view('back-end.carrier.index',[
            'carriers' => $carriers,
        ]);
    }

    public function create()
    {
        return view('back-end.carrier.create');
    }

    public function store(Request $request)
    {
//         dd($request);
        $this -> validate($request, [
            'ngh_Ten' => 'required',
            'email' => 'required|email|unique:nguoi_giao_hangs',
            'ngh_DiaChi' => 'required',
            'password' => 'required|min:6',
            'password_again' => 'required|same:password',
            'ngh_SoDienThoai' => 'required',
            'trangthai' => 'required',
            'avatar' => 'required',
        ],
            [
                'ngh_Ten.required' => 'Vui lòng nhập họ tên',
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Không đúng định dạng email',
                'email.unique' => 'Email đã được đăng kí',
                'ngh_DiaChi.required' => 'Vui lòng nhập địa chỉ cụ thể',
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.min' => 'Mật khẩu ít nhất 5 kí tự',
                'password_again.required' => 'Vui lòng nhập lại mật khẩu',
                'password_again.same' => 'Mật khẩu không giống nhau',
                'ngh_SoDienThoai.required' => 'Vui lòng nhập số điện thoại',
                'trangthai.required' => 'Vui lòng chọn trạng thái',
                'avatar.required' => 'Vui lòng chọn avatar',
            ]);

        $nguoigiaohang = NguoiGiaoHang::create([
            'ngh_Ten' => $request->ngh_Ten,
            'ngh_SoDienThoai' => $request->ngh_SoDienThoai,
            'ngh_DiaChi' => $request->ngh_DiaChi,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'trangthai' => $request->trangthai,
        ]);

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $image_name = $image->getClientOriginalName();
            $destination_path = 'public/images/avatar/carriers';
            $path = $image->storeAs($destination_path, $image_name);

            // Gán giá trị của trường avatar là tên file hình ảnh
            $updateData = [
                'avatar' => $image_name,
            ];
        } else {
            // Không có hình ảnh được tải lên, giữ nguyên giá trị của trường avatar
            $updateData = [
                'avatar' => $nguoigiaohang->avatar,
            ];
        }

        $nguoigiaohang->update($updateData);

        Session::flash('flash_message', 'Thêm người giao hàng thành công!');
        return redirect('/admin/carriers');
    }

    public function active($id)
    {
        $nguoigiaohang = NguoiGiaoHang::find($id)
            ->update(
                ['trangthai' => 1],
            );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/carriers');
    }

    public function unactive($id)
    {
        $nguoigiaohang = NguoiGiaoHang::find($id)
            ->update(
                ['trangthai' => 0],
            );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/carriers');
    }
}
