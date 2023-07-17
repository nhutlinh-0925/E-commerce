<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KhachHang;
use App\Models\TaiKhoan;

use App\Http\Services\CartService;

use App\Social;
//use Laravel\Socialite\Facades\Socialite;
//use Socialite;
use Socialite;
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

//    public function login_facebook(){
//        return Socialite::driver('facebook')->redirect();
//    }

//    public function callback_facebook(){
//        $provider = Socialite::driver('facebook')->user();
//        dd($provider);
//        $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
////        if($account){
////            //login in vao trang quan tri
////            $account_name = Login::where('admin_id',$account->user)->first();
////            Session::put('admin_name',$account_name->admin_name);
////            Session::put('admin_id',$account_name->admin_id);
////            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
////        }else{
////
////            $hieu = new Social([
////                'provider_user_id' => $provider->getId(),
////                'provider' => 'facebook'
////            ]);
////
////            $orang = Login::where('admin_email',$provider->getEmail())->first();
////
////            if(!$orang){
////                $orang = Login::create([
////                    'admin_name' => $provider->getName(),
////                    'admin_email' => $provider->getEmail(),
////                    'admin_password' => '',
////                    'admin_phone' => ''
////
////                ]);
////            }
////            $hieu->login()->associate($orang);
////            $hieu->save();
////
////            $account_name = Login::where('admin_id',$account->user)->first();
////            Session::put('admin_name',$account_name->admin_name);
////            Session::put('admin_id',$account_name->admin_id);
////            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
////        }
//    }

    public function login_google(){
        return Socialite::driver('google')->redirect();
    }

    public function callback_google()
    {
        try {

            $user = Socialite::driver('google')->stateless()->user();
//            dd($user);
            $finduser = TaiKhoan::where('provider_id', $user->id)->first();

            if($finduser){

                Auth::login($finduser);

                return redirect()->route('user.home');

            }else{
                $newUser = TaiKhoan::create([
                    'email' => $user->email,
                    'provider' => 'Google',
                    'provider_id'=> $user->id,
                    'password' => encrypt('google123'),
                    'loai' => 2,
                    'trangthai' => 1,
                    'vip' => 0
                ]);
//                dd($newUser);

                $kh = KhachHang::create([
                    'tai_khoan_id' => $newUser->id,
                    'kh_Ten' => $user->name,
                ]);
//                dd($kh);

                Auth::login($newUser);

                return redirect()->route('user.home');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
