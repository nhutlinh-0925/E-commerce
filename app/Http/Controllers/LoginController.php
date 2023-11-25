<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KhachHang;

use App\Http\Services\CartService;

use App\Social;
//use Laravel\Socialite\Facades\Socialite;
//use Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Socialite;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Mail;

class LoginController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function doLogin(Request $request)
    {
        // dd($request);
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ],
        [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Không đúng định dạng email',
            'password.required' => 'Vui lòng nhập passwod',
            'password.min' => 'Mật khẩu ít nhất 5 kí tự',
        ]);

         if(Auth::guard('web')->attempt([
             'email' => $request->input(key: 'email'),
             'password' => $request->input(key: 'password'),
         ], $request->input(key: 'remember'))){
             $user = Auth::guard('web')->user();
            // Kiểm tra giá trị trangthai của người dùng
            if ($user->trangthai == 0) {
                // Tài khoản bị khóa, hiển thị thông báo và đăng xuất
                Auth::guard('web')->logout();
                session()->flash('error', 'Tài khoản của bạn đã bị khóa');
                return redirect()->back();
            }
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
            'email' => 'required|email|unique:khach_hangs',
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

        $khachhang = KhachHang::create([
            'kh_Ten' => $request->kh_Ten,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'trangthai' => 1,
            'vip' => 0
        ]);

        if ($khachhang->id)
        {
            return redirect()->route('user.login');
        }

        return redirect()->back();
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
//        $request->session()->invalidate();
//        $request->session()->regenerateToken();
        if (Session::get('coupon') == true) {
            Session::forget('coupon');
        }
        session()->forget('carts');
        return redirect('/user/login');
    }

//    public function login_facebook(){
//        return Socialite::driver('facebook')->redirect();
//    }
//
//    public function callback_facebook()
//    {
//        try {
//
//            $user = Socialite::driver('facebook')->user();
////            dd($user);
//            $finduser = KhachHang::where('provider_id', $user->id)->first();
//
//            if($finduser){
//
//                Auth::login($finduser);
//
//                return redirect()->route('user.home');
//
//            }else{
//                $newUser = KhachHang::create([
//                    'kh_Ten' => $user->name,
//                    'email' => $user->email,
//                    'provider' => 'Facebook',
//                    'provider_id'=> $user->id,
//                    'password' => encrypt('facebook123'),
//                    'trangthai' => 1,
//                    'vip' => 0
//                ]);
//
//                Auth::login($newUser);
//
//                return redirect()->route('user.home');
//            }
//
//        } catch (Exception $e) {
//            dd($e->getMessage());
//        }
//    }

    public function login_google(){
        return Socialite::driver('google')->redirect();
    }

    public function callback_google()
    {
        try {

            $user = Socialite::driver('google')->stateless()->user();
//            dd($user);
            $finduser = KhachHang::where('provider_id', $user->id)->first();

            if($finduser){

                Auth::login($finduser);

                return redirect()->route('user.home');

            }else{
                $newUser = KhachHang::create([
                    'kh_Ten' => $user->name,
                    'email' => $user->email,
                    'provider' => 'Google',
                    'provider_id'=> $user->id,
                    'password' => encrypt('google123'),
                    'trangthai' => 1,
                    'vip' => 0
                ]);

                Auth::login($newUser);

                return redirect()->route('user.home');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function forgot_password(){
        return view('front-end.login.forgot_password');
    }

    public function post_forget_password(Request $request){
        $request->validate([
            'email' => 'required|exists:khach_hangs',
        ],
            [
                'email.required' => 'Vui lòng nhập email',
                'email.exists' => 'Email không tồn tại trên hệ thống',
            ]);

        $email = $request->email;

        $token = Str::random(64);
        //dd($token);
        $today = Carbon::now();

        $update_token = KhachHang::where('email',$email)
            ->update([
                'email_verified_at' => $today,
                'email_verified_code' => $token
            ]);

        Mail::send('front-end.login.email_reset_password', ['token' => $token], function ($email) use ($request){
            $email->subject('Đặt lại mật khẩu');
            $email->to($request->email);
        });

        return redirect()->to(route('user.forgot_password'))
               ->with('success','Vui lòng kiểm tra email của bạn để đặt lại mật khẩu');

    }

    public function reset_password($token){
        return view('front-end.login.reset_password',[
            'token' => $token
        ]);
    }

    public function post_reset_password(Request $request){
        $request->validate([
            'email' => 'required|email|exists:tai_khoans',
            'password' => 'required|min:6|max:15',
            're_password' => 'required|same:password'
        ],
            [
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Không đúng định dạng email',
                'email.unique' => 'Email đã được đăng kí',
                'email.exists' => 'Email không tồn tại trên hệ thống',
                'password.min' => 'Mật khẩu ít nhất 5 kí tự',
                're_password.required'=> 'Vui lòng nhập lại password',
                're_password.same' => 'Mật khẩu không giống nhau',
            ]);

        KhachHang::where('email',$request->email)
            ->update(['password' => Hash::make($request->password)]);

        return redirect()->to(route('user.login'))
            ->with('success','Mật khẩu đã được cập nhật');
    }

}
