<?php

namespace App\Http\Controllers;

use App\Models\ChiTietQuyen;
use App\Models\Quyen;

use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class NhanVienController extends Controller
{
    public function index(){
        $employees = NhanVien::all()->sortByDesc("id");

        return view('back-end.employee.index',[
            'employees' => $employees,
        ]);
    }

    public function create()
    {
        return view('back-end.employee.create');
    }

    public function store(Request $request)
    {
//         dd($request);
        $this -> validate($request, [
            'nv_Ten' => 'required',
            'email' => 'required|email|unique:nhan_viens',
            'nv_DiaChi' => 'required',
            'password' => 'required|min:6',
            'password_again' => 'required|same:password',
            'nv_SoDienThoai' => 'required',
            'trangthai' => 'required',
            'avatar' => 'required',
        ],
            [
                'nv_Ten.required' => 'Vui lòng nhập họ tên',
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Không đúng định dạng email',
                'email.unique' => 'Email đã được đăng kí',
                'nv_DiaChi.required' => 'Vui lòng nhập địa chỉ cụ thể',
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.min' => 'Mật khẩu ít nhất 5 kí tự',
                'password_again.required' => 'Vui lòng nhập lại mật khẩu',
                'password_again.same' => 'Mật khẩu không giống nhau',
                'nv_SoDienThoai.required' => 'Vui lòng nhập số điện thoại',
                'trangthai.required' => 'Vui lòng chọn trạng thái',
                'avatar.required' => 'Vui lòng chọn avatar',
            ]);

        $nhanvien = NhanVien::create([
            'nv_Ten' => $request->nv_Ten,
            'nv_SoDienThoai' => $request->nv_SoDienThoai,
            'nv_DiaChi' => $request->nv_DiaChi,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'loai' => 0,
            'trangthai' => $request->trangthai,
        ]);

        $nhanvienId = $nhanvien->id;
        $quyen = $request->quyen;
        for ($quyenId = 1; $quyenId <= 5; $quyenId++) {
            $ctqCoQuyen = isset($quyen[$quyenId]) ? $quyen[$quyenId] : 0;
            // Tạo bản ghi ChiTietQuyen
            ChiTietQuyen::create([
                'quyen_id' => $quyenId,
                'nhan_vien_id' => $nhanvienId,
                'ctq_CoQuyen' => $ctqCoQuyen,
            ]);
        }

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $image_name = $image->getClientOriginalName();
            $destination_path = 'public/images/avatar/employees';
            $path = $image->storeAs($destination_path, $image_name);

            // Gán giá trị của trường avatar là tên file hình ảnh
            $updateData = [
                'avatar' => $image_name,
            ];
        } else {
            // Không có hình ảnh được tải lên, giữ nguyên giá trị của trường avatar
            $updateData = [
                'avatar' => $nhanvien->avatar,
            ];
        }

        $nhanvien->update($updateData);

        Session::flash('flash_message', 'Thêm nhân viên thành công!');
        return redirect('/admin/employees');
    }

    public function active($id)
    {
        $nhanvien = NhanVien::find($id)
            ->update(
                ['trangthai' => 1],
            );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/employees');
    }

    public function unactive($id)
    {
        $nhanvien = NhanVien::find($id)
            ->update(
                ['trangthai' => 0],
            );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/employees');
    }

    public function permissions(){
        $employees = NhanVien::all()->sortByDesc("id");

        return view('back-end.employee.permission',[
            'employees' => $employees,
        ]);
    }

    public function edit_permission($id){
        $employee = NhanVien::find($id);
        $permission = ChiTietQuyen::find($id);

        return view('back-end.employee.edit_permission',[
            'permission' => $permission,
            'employee' => $employee,
        ]);
    }

    public function auth($id)
    {
        $quyen = ChiTietQuyen::find($id);
        $id_nv = $quyen->nhan_vien_id;

        $quyen = ChiTietQuyen::find($id)
            ->update(
                ['ctq_CoQuyen' => 0],
            );

        Session::flash('flash_message', 'Thay đổi quyền thành công!');
        return redirect()->route('admin.edit_permission', ['id' => $id_nv]);
    }

    public function unauth($id)
    {
        $quyen = ChiTietQuyen::find($id);
        $id_nv = $quyen->nhan_vien_id;
        $quyen = ChiTietQuyen::find($id)
            ->update(
                ['ctq_CoQuyen' => 1],
            );
        Session::flash('flash_message', 'Thay đổi quyền thành công!');
        return redirect()->route('admin.edit_permission', ['id' => $id_nv]);
    }
}
