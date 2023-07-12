<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use App\Models\NhanVien;

class AdminController extends Controller
{
    public function doLogin(Request $request)
    {
        // dd($request);
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|max:15'
        ],
        [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Không đúng định dạng email',
            'email.unique' => 'Email đã được đăng kí',
            'password.required' => 'Vui lòng nhập passwod',
            'password.min' => 'Mật khẩu ít nhất 5 kí tự',
        ]);

        // $check = $request->only('email','password');
        // if(Auth::guard('admin')->attempt($check)){
        //     return redirect()->route('admin.home')->with('success','welcom to admin');
        // }else{
        //     return redirect()->back()->with('error','dang nhap that bai');
        // }

        if (Auth::attempt([
            'email' => $request->input(key: 'email'),
            'password' => $request->input(key: 'password'),
            'loai' => 0
        ], $request->input(key: 'remember'))){
            return redirect()->route('admin.home');

        }
        session()->flash('error', 'Email hoặc password không đúng !!!');
        return redirect()->back();

    }

    // public function logout() {

    //     Auth::guard('admin')->logout();
    //     return redirect('/admin/login');

    // }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function getUser(){
        if(Auth::check()){
            $id = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id)->first();
            // dd($nhanvien);
        }
        return view('back-end.home2',[
            'nhanvien' => $nhanvien
        ]);
    }



}
