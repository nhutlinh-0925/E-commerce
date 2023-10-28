<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NguoiGiaoHang;

class ShipperController extends Controller
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
//            'email.unique' => 'Email đã được đăng kí',
                'password.required' => 'Vui lòng nhập passwod',
                'password.min' => 'Mật khẩu ít nhất 5 kí tự',
            ]);

        if(Auth::guard('shipper')->attempt([
            'email' => $request->input(key: 'email'),
            'password' => $request->input(key: 'password'),
        ], $request->input(key: 'remember'))){
            $user = Auth::guard('shipper')->user();
            // Kiểm tra giá trị trangthai của người dùng
            if ($user->trangthai == 0) {
                // Tài khoản bị khóa, hiển thị thông báo và đăng xuất
                Auth::guard('shipper')->user()->logout();
                session()->flash('error', 'Tài khoản của bạn đã bị khóa');
                return redirect()->back();
            }
            return redirect()->route('shipper.home');
        }
        session()->flash('error', 'Email hoặc password không đúng !!!');
        return redirect()->back();
    }

    public function logout(Request $request)
    {
        Auth::guard('shipper')->logout();
//        $request->session()->invalidate();
//        $request->session()->regenerateToken();
        return redirect('/shipper/login');
    }

    public function getUser()
    {
        return view('back-end.login.shipper.home');
    }


}
