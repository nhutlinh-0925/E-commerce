<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaiViet;
use App\Models\KhachHang;
use App\Models\PhieuDatHang;
use App\Models\SanPham;
use App\Models\ThongKe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use App\Models\NhanVien;
use Carbon\Carbon;

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
            $product_tk = SanPham::all()->count();
            $product_views = SanPham::orderBy('sp_LuotXem','desc')->take(10)->get();
            $post_tk = BaiViet::all()->count();
            $post_views = BaiViet::orderBy('bv_LuotXem','desc')->take(10)->get();
            $order_tk = PhieuDatHang::all()->count();
            $employess_tk = NhanVien::all()->count();
            $customer_tk = KhachHang::all()->count();
        }
        return view('back-end.home2',[
            'nhanvien' => $nhanvien,
            'product_tk' => $product_tk,
            'product_views' => $product_views,
            'post_tk' => $post_tk,
            'post_views' => $post_views,
            'order_tk' => $order_tk,
            'employess_tk' => $employess_tk,
            'customer_tk' => $customer_tk
        ]);
    }
    public function days_order(Request $request){
        $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(30)->toDateString();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get =ThongKe::whereBetween('tk_Ngay',[$sub30days,$now])->orderBy('tk_Ngay','asc')->get();

        foreach ($get as $key => $val){
            $chart_data[] = array(
                'period' => $val->tk_Ngay,
                'order' => $val->tk_TongDonHang,
                'sales' => $val->tk_TongTien,
                'profit' => $val->tk_LoiNhuan,
                'quantity' => $val->tk_SoLuong
            );
        }
        return response()->json($chart_data);
//        echo $data = json_encode($chart_data);
    }

    public function dashboard_filter(Request $request){
        $data = $request->all();
        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dauthangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoithangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
//        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if($data['dashboard_value'] == '7ngay'){
            $get = ThongKe::whereBetween('tk_Ngay',[$sub7days,$now])->orderBy('tk_Ngay','asc')->get();
        }elseif ($data['dashboard_value'] == 'thangtruoc'){
            $get = ThongKe::whereBetween('tk_Ngay',[$dauthangtruoc,$cuoithangtruoc])->orderBy('tk_Ngay','asc')->get();
        }elseif ($data['dashboard_value'] == 'thangnay'){
            $get = ThongKe::whereBetween('tk_Ngay',[$dauthangnay,$now])->orderBy('tk_Ngay','asc')->get();
//        }elseif ($data['dashboard_value'] == '365ngayqua'){
//            $get = ThongKe::whereBetween('tk_Ngay',[$sub365days,$now])->orderBy('tk_Ngay','asc')->get();
        }

        foreach ($get as $key => $val){
            $chart_data[] = array(
                'period' => $val->tk_Ngay,
                'order' => $val->tk_TongDonHang,
                'sales' => $val->tk_TongTien,
                'profit' => $val->tk_LoiNhuan,
                'quantity' => $val->tk_SoLuong
            );
        }
        echo $data = json_encode($chart_data);
//        return response()->json($chart_data);
    }

//    public function filter_by_date(Request $request){
//        $data = $request->all();
//        $from_date = $data['from_date'];
//        $to_date = $data['to_date'];
//
//        $get = ThongKe::whereBetween('tk_Ngay',[$from_date,$to_date])->orderBy('tk_Ngay','asc')->get();
//
//        foreach ($get as $key => $val){
//            $chart_data1[] = array(
//                'period' => $val->tk_Ngay,
//                'order' => $val->tk_TongDonHang,
//                'sales' => $val->tk_TongTien,
//                'profit' => $val->tk_LoiNhuan,
//                'quantity' => $val->tk_SoLuong
//            );
//        }
//        echo $data = json_encode($chart_data1);
////        return response()->json($chart_data);
//    }

    public function filter_by_date(Request $request){
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];

        $get = ThongKe::whereBetween('tk_Ngay', [$from_date, $to_date])->orderBy('tk_Ngay', 'asc')->get();

        $chart_data = []; // Khai báo và khởi tạo biến $chart_data

        foreach ($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->tk_Ngay,
                'order' => $val->tk_TongDonHang,
                'sales' => $val->tk_TongTien,
                'profit' => $val->tk_LoiNhuan,
                'quantity' => $val->tk_SoLuong
            );
        }

        return response()->json($chart_data); // Trả về dữ liệu JSON
    }



}
