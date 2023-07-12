<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KhachHang;
use App\Models\TaiKhoan;

use App\Http\Services\CartService;

class LoginController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function home(){
        if(Auth::check()){
            $id = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id)->first();
            // dd($khachhang);
            $carts = $this->cartService->getProduct();
            // dd($carts);
            return view('front-end.home',[
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
            ]);
        }else{
            $carts = $this->cartService->getProduct();
            return view('front-end.home',[
                'carts' => $carts,
                'gh' => session()->get('carts'),
            ]);
        }
    }


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
        // if(Auth::guard('web')->attempt($check)){
        //     return redirect()->route('user.home')->with('success','welcom to dashboard');
        // }else{
        //     return redirect()->route('user.login')->with('error','dang nhap that bai');
        // }
        if(Auth::attempt([
            'email' => $request->input(key: 'email'),
            'password' => $request->input(key: 'password'),
            'loai' => 2
        ], $request->input(key: 'remember'))){
            return redirect()->route('user.home');

        }
        session()->flash('error', 'Email hoặc password không đúng !!!');
        return redirect()->back();

    }

    public function doRegister(Request $request)
    {
        // dd($request);
        $request->validate([
            'kh_Ten' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|max:15',
            're_password' => 'required|same:password'
        ],
        [
            'kh_Ten.required' => 'Vui lòng nhập tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Không đúng định dạng email',
            'email.unique' => 'Email đã được đăng kí',
            'password.required' => 'Vui lòng nhập passwod',
            'password.min' => 'Mật khẩu ít nhất 5 kí tự',
            're_password.required'=> 'Vui lòng nhập lại password',
            're_password.same' => 'Mật khẩu không giống nhau',
        ]);

        $taikhoan = TaiKhoan::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'loai' => 2,
            'trangthai' => 1,
            'vip' => 0
        ]);

        $kh = KhachHang::create([
            'tai_khoan_id' =>$taikhoan->id,
            'kh_Ten' => $request->kh_Ten,
        ]);

        if ($taikhoan->id)
        {
            return redirect()->route('user.login');
        }

        return redirect()->back();





    }


    // public function logout() {

    //     Auth::guard('web')->logout();
    //     return  ;

    // }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/user/login');
    }

}
