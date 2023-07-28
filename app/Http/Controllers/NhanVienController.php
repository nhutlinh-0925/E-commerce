<?php

namespace App\Http\Controllers;

use App\Models\ChiTietQuyen;
use App\Models\Quyen;

use App\Models\NhanVien;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class NhanVienController extends Controller
{
    public function index(){
        if(Auth::check()){
            $id = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id)->first();
            // dd($nhanvien);
        }
        $employees = NhanVien::all()->sortByDesc("id");

        return view('back-end.employee.index',[
            'employees' => $employees,
            'nhanvien' => $nhanvien
        ]);
    }

    public function create()
    {
        if(Auth::check()){
            $id = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id)->first();
            // dd($nhanvien);
        }
        return view('back-end.employee.create',[
            'nhanvien' => $nhanvien,
        ]);
    }

    public function store(Request $request)
    {
//         dd($request);
        $this -> validate($request, [
            'nv_Ten' => 'required',
            'email' => 'required|email',
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
                'nv_DiaChi.required' => 'Vui lòng nhập địa chỉ cụ thể',
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.min' => 'Mật khẩu ít nhất 5 kí tự',
                'password_again.required' => 'Vui lòng nhập lại mật khẩu',
                'password_again.same' => 'Mật khẩu không giống nhau',
                'nv_SoDienThoai.required' => 'Vui lòng nhập số điện thoại',
                'trangthai.required' => 'Vui lòng chọn trạng thái',
                'avatar.required' => 'Vui lòng chọn avatar',
            ]);

        $taikhoan = TaiKhoan::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'loai' => 0,
            'trangthai' => $request->trangthai,
            'vip' => 0
        ]);

        $nv = NhanVien::create([
            'tai_khoan_id' =>$taikhoan->id,
            'nv_Ten' => $request->nv_Ten,
            'nv_SoDienThoai' => $request->nv_SoDienThoai,
            'nv_DiaChi' => $request->nv_DiaChi,
        ]);

        for ($quyenId = 1; $quyenId <= 5; $quyenId++) {
            ChiTietQuyen::create([
                'quyen_id' => $quyenId,
                'nhan_vien_id' => $nv->id,
                'ctq_CoQuyen' => 0,
            ]);
        }

        $account = TaiKhoan::find($taikhoan->id);

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
                'avatar' => $account->avatar,
            ];
        }

        // Cập nhật thông tin vào Model TaiKhoan
        $account->update($updateData);

        Session::flash('flash_message', 'Thêm nhân viên thành công!');
        return redirect('/admin/employees');
    }

    public function active($id)
    {
        //        dd($id);
        $account = TaiKhoan::find($id)
            ->update(
                ['trangthai' => 1],
            );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/employees');
    }

    public function unactive($id)
    {
//        dd($id);
        $account = TaiKhoan::find($id)
            ->update(
                ['trangthai' => 0],
            );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/employees');
    }

    public function permissions(){
        if(Auth::check()){
            $id = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id)->first();
            // dd($nhanvien);
        }

        $employees = NhanVien::all()->sortByDesc("id");

        return view('back-end.employee.permission',[
            'employees' => $employees,
            'nhanvien' => $nhanvien
        ]);
    }

    public function edit_permission($id){
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }
        //dd($id);
        //$ctq = ChiTietQuyen::find($id);
        //$id_nv = $ctq->nhan_vien_id;

        $employee = NhanVien::find($id);
        //dd($employee);
        $id_nv = $employee->tai_khoan_id;
        //dd($id_nv);
        $taikhoan = TaiKhoan::find($id_nv);
        //dd($taikhoan);
        $permission = ChiTietQuyen::find($id);
        //dd($permission);

        return view('back-end.employee.edit_permission',[
            'permission' => $permission,
            'nhanvien' => $nhanvien,
            'employee' => $employee,
            'taikhoan' => $taikhoan
        ]);
    }

    public function auth($id)
    {
        //dd($id);
        $quyen = ChiTietQuyen::find($id);
        //dd($quyen);
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
        //dd($id);
        $quyen = ChiTietQuyen::find($id);
        //dd($quyen);
        $id_nv = $quyen->nhan_vien_id;
        $quyen = ChiTietQuyen::find($id)
            ->update(
                ['ctq_CoQuyen' => 1],
            );
        Session::flash('flash_message', 'Thay đổi quyền thành công!');
        return redirect()->route('admin.edit_permission', ['id' => $id_nv]);
    }
}
