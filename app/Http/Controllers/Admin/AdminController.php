<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaiViet;
use App\Models\KhachHang;
use App\Models\PhieuDatHang;
use App\Models\ChiTietPhieuDatHang;
use App\Models\PhieuNhapHang;
use App\Models\ChiTietPhieuNhapHang;
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
            'password.required' => 'Vui lòng nhập passwod',
            'password.min' => 'Mật khẩu ít nhất 5 kí tự',
        ]);

         if(Auth::guard('admin')->attempt([
             'email' => $request->input(key: 'email'),
             'password' => $request->input(key: 'password'),
         ], $request->input(key: 'remember'))){
             $user = Auth::guard('admin')->user();
             // Kiểm tra giá trị trangthai của người dùng
             if ($user->trangthai == 0) {
                 // Tài khoản bị khóa, hiển thị thông báo và đăng xuất
                 Auth::guard('admin')->logout();
                 session()->flash('error', 'Tài khoản của bạn đã bị khóa');
                 return redirect()->back();
             }
             return redirect()->route('admin.home');
         }
        session()->flash('error', 'Email hoặc password không đúng !!!');
        return redirect()->back();
    }


    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
//        $request->session()->invalidate();
//        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    public function getUser(Request $request){
        if(Auth::check()){
            $product_tk = SanPham::all()->count();
            $product_views = SanPham::orderBy('sp_LuotXem','desc')->take(10)->get();
            $post_tk = BaiViet::all()->count();
            $post_views = BaiViet::orderBy('bv_LuotXem','desc')->take(10)->get();
            $order_tk = PhieuDatHang::all()->count();
            $employess_tk = NhanVien::all()->count();
            $customer_tk = KhachHang::all()->count();

            // Mặc định hiển thị sản phẩm bán chạy trong 30 ngày
            $startDate = Carbon::now('Asia/Ho_Chi_Minh')->subdays(30)->toDateString();
            $endDate = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

            $product_tops = ChiTietPhieuDatHang::select('san_pham_id', \DB::raw('SUM(ctpdh_SoLuong) as totalQuantity'))
                ->join('phieu_dat_hangs', 'chi_tiet_phieu_dat_hangs.phieu_dat_hang_id', '=', 'phieu_dat_hangs.id')
                ->where('phieu_dat_hangs.pdh_TrangThai', 4)
                ->where('phieu_dat_hangs.pdh_NgayDat', '>=', $startDate)
                ->where('phieu_dat_hangs.pdh_NgayDat', '<=', $endDate)
                ->groupBy('san_pham_id')
                ->orderByDesc('totalQuantity')
                ->take(15) // Chọn 15 sản phẩm
                ->get();
        }
        return view('back-end.home2',[
            'product_tk' => $product_tk,
            'product_views' => $product_views,
            'post_tk' => $post_tk,
            'post_views' => $post_views,
            'order_tk' => $order_tk,
            'employess_tk' => $employess_tk,
            'customer_tk' => $customer_tk,

            'product_tops' => $product_tops,
        ]);
    }

    //Lấy thông tin các tháng doanh thu trong theo biểu đồ đường
    public function getChartData()
    {
        // Truy vấn để lấy tổng doanh thu theo tháng
        $data = ThongKe::selectRaw('MONTH(tk_Ngay) as thang, SUM(tk_DoanhThu) as tong_doanh_thu')
            ->groupByRaw('MONTH(tk_Ngay)')
            ->get();

        // Khởi tạo mảng có 12 phần tử, giá trị mặc định là 0
        $chartData = array_fill(0, 12, 0);

        // Đổ dữ liệu vào mảng
        foreach ($data as $row) {
            $month = $row->thang - 1; // Giảm đi 1 vì các tháng trong mảng bắt đầu từ 0
            $chartData[$month] = (int)$row->tong_doanh_thu;
        }

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($chartData);
    }

    //Lấy thông tin các tháng doanh thu trong năm khi select theo biểu đồ đường
    public function getChartDataByYear(Request $request)
    {
        // Lấy năm từ yêu cầu
        $selectedYear = $request->input('year');

        // Truy vấn để lấy tổng doanh thu theo tháng cho năm được chọn
        $data = ThongKe::selectRaw('MONTH(tk_Ngay) as thang, SUM(tk_DoanhThu) as tong_doanh_thu')
            ->whereYear('tk_Ngay', $selectedYear)
            ->groupByRaw('MONTH(tk_Ngay)')
            ->get();

        // Khởi tạo mảng có 12 phần tử, giá trị mặc định là 0
        $chartData = array_fill(0, 12, 0);

        // Đổ dữ liệu vào mảng
        foreach ($data as $row) {
            $month = $row->thang - 1; // Giảm đi 1 vì các tháng trong mảng bắt đầu từ 0
            $chartData[$month] = (int)$row->tong_doanh_thu;
        }

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($chartData);
    }

    //Lọc các sản phẩm bán chạy theo khoảng thời gian
    public function product_tops(Request $request)
    {
        $data = $request->all();
//
        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dauthangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoithangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $quy1_start = Carbon::now('Asia/Ho_Chi_Minh')->month(1)->startOfMonth()->toDateString();
        $quy1_end = Carbon::now('Asia/Ho_Chi_Minh')->month(3)->endOfMonth()->toDateString();

        $quy2_start = Carbon::now('Asia/Ho_Chi_Minh')->month(4)->startOfMonth()->toDateString();
        $quy2_end = Carbon::now('Asia/Ho_Chi_Minh')->month(6)->endOfMonth()->toDateString();

        $quy3_start = Carbon::now('Asia/Ho_Chi_Minh')->month(7)->startOfMonth()->toDateString();
        $quy3_end = Carbon::now('Asia/Ho_Chi_Minh')->month(9)->endOfMonth()->toDateString();

        $quy4_start = Carbon::now('Asia/Ho_Chi_Minh')->month(10)->startOfMonth()->toDateString();
        $quy4_end = Carbon::now('Asia/Ho_Chi_Minh')->month(12)->endOfMonth()->toDateString();

        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if($data['data_value'] == '7 ngày qua'){
            $product_tops = ChiTietPhieuDatHang::select('san_pham_id', \DB::raw('SUM(ctpdh_SoLuong) as totalQuantity'))
                ->join('phieu_dat_hangs', 'chi_tiet_phieu_dat_hangs.phieu_dat_hang_id', '=', 'phieu_dat_hangs.id')
                ->where('phieu_dat_hangs.pdh_TrangThai', 4)
                ->where('phieu_dat_hangs.pdh_NgayDat', '>=', $sub7days)
                ->where('phieu_dat_hangs.pdh_NgayDat', '<=', $now)
                ->groupBy('san_pham_id')
                ->orderByDesc('totalQuantity')
                ->take(15) // Chọn 15 sản phẩm
                ->with('sanpham')
                ->get();
        }
        elseif ($data['data_value'] == 'Tháng trước'){
            $product_tops = ChiTietPhieuDatHang::select('san_pham_id', \DB::raw('SUM(ctpdh_SoLuong) as totalQuantity'))
                ->join('phieu_dat_hangs', 'chi_tiet_phieu_dat_hangs.phieu_dat_hang_id', '=', 'phieu_dat_hangs.id')
                ->where('phieu_dat_hangs.pdh_TrangThai', 4)
                ->where('phieu_dat_hangs.pdh_NgayDat', '>=', $dauthangtruoc)
                ->where('phieu_dat_hangs.pdh_NgayDat', '<=', $cuoithangtruoc)
                ->groupBy('san_pham_id')
                ->orderByDesc('totalQuantity')
                ->take(15) // Chọn 15 sản phẩm
                ->with('sanpham')
                ->get();
        }elseif ($data['data_value'] == 'Tháng này'){
            $product_tops = ChiTietPhieuDatHang::select('san_pham_id', \DB::raw('SUM(ctpdh_SoLuong) as totalQuantity'))
                ->join('phieu_dat_hangs', 'chi_tiet_phieu_dat_hangs.phieu_dat_hang_id', '=', 'phieu_dat_hangs.id')
                ->where('phieu_dat_hangs.pdh_TrangThai', 4)
                ->where('phieu_dat_hangs.pdh_NgayDat', '>=', $dauthangnay)
                ->where('phieu_dat_hangs.pdh_NgayDat', '<=', $now)
                ->groupBy('san_pham_id')
                ->orderByDesc('totalQuantity')
                ->take(15) // Chọn 15 sản phẩm
                ->with('sanpham')
                ->get();
        }elseif ($data['data_value'] == 'Quý 1'){
            $product_tops = ChiTietPhieuDatHang::select('san_pham_id', \DB::raw('SUM(ctpdh_SoLuong) as totalQuantity'))
                ->join('phieu_dat_hangs', 'chi_tiet_phieu_dat_hangs.phieu_dat_hang_id', '=', 'phieu_dat_hangs.id')
                ->where('phieu_dat_hangs.pdh_TrangThai', 4)
                ->where('phieu_dat_hangs.pdh_NgayDat', '>=', $quy1_start)
                ->where('phieu_dat_hangs.pdh_NgayDat', '<=', $quy1_end)
                ->groupBy('san_pham_id')
                ->orderByDesc('totalQuantity')
                ->take(15) // Chọn 15 sản phẩm
                ->with('sanpham')
                ->get();
        }elseif ($data['data_value'] == 'Quý 2'){
            $product_tops = ChiTietPhieuDatHang::select('san_pham_id', \DB::raw('SUM(ctpdh_SoLuong) as totalQuantity'))
                ->join('phieu_dat_hangs', 'chi_tiet_phieu_dat_hangs.phieu_dat_hang_id', '=', 'phieu_dat_hangs.id')
                ->where('phieu_dat_hangs.pdh_TrangThai', 4)
                ->where('phieu_dat_hangs.pdh_NgayDat', '>=', $quy2_start)
                ->where('phieu_dat_hangs.pdh_NgayDat', '<=', $quy2_end)
                ->groupBy('san_pham_id')
                ->orderByDesc('totalQuantity')
                ->take(15) // Chọn 15 sản phẩm
                ->with('sanpham')
                ->get();
        }elseif ($data['data_value'] == 'Quý 3'){
            $product_tops = ChiTietPhieuDatHang::select('san_pham_id', \DB::raw('SUM(ctpdh_SoLuong) as totalQuantity'))
                ->join('phieu_dat_hangs', 'chi_tiet_phieu_dat_hangs.phieu_dat_hang_id', '=', 'phieu_dat_hangs.id')
                ->where('phieu_dat_hangs.pdh_TrangThai', 4)
                ->where('phieu_dat_hangs.pdh_NgayDat', '>=', $quy3_start)
                ->where('phieu_dat_hangs.pdh_NgayDat', '<=', $quy3_end)
                ->groupBy('san_pham_id')
                ->orderByDesc('totalQuantity')
                ->take(15) // Chọn 15 sản phẩm
                ->with('sanpham')
                ->get();
        }elseif ($data['data_value'] == 'Quý 4'){
            $product_tops = ChiTietPhieuDatHang::select('san_pham_id', \DB::raw('SUM(ctpdh_SoLuong) as totalQuantity'))
                ->join('phieu_dat_hangs', 'chi_tiet_phieu_dat_hangs.phieu_dat_hang_id', '=', 'phieu_dat_hangs.id')
                ->where('phieu_dat_hangs.pdh_TrangThai', 4)
                ->where('phieu_dat_hangs.pdh_NgayDat', '>=', $quy4_start)
                ->where('phieu_dat_hangs.pdh_NgayDat', '<=', $quy4_end)
                ->groupBy('san_pham_id')
                ->orderByDesc('totalQuantity')
                ->take(15) // Chọn 15 sản phẩm
                ->with('sanpham')
                ->get();
        }

        return response()->json(['product_tops' => $product_tops]);

    }

    //Hiện biểu đồ cột mặc định 30 ngày
    public function days_order(Request $request){
        $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(30)->toDateString();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get =ThongKe::whereBetween('tk_Ngay',[$sub30days,$now])->orderBy('tk_Ngay','asc')->get();

        foreach ($get as $key => $val){
            $chart_data[] = array(
                'period' => $val->tk_Ngay,
                'order' => $val->tk_TongDonHang,
//                'sales' => $val->tk_DoanhSo,
                'sales' => $val->tk_DoanhThu,
                'profit' => $val->tk_LoiNhuan,
                'quantity' => $val->tk_SoLuong
            );
        }
        return response()->json($chart_data);
//        echo $data = json_encode($chart_data);
    }

    //Thay đổi biểu đồ cột khi select
    public function dashboard_filter(Request $request){
        $data = $request->all();
        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dauthangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoithangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $quy1_start = Carbon::now('Asia/Ho_Chi_Minh')->month(1)->startOfMonth()->toDateString();
        $quy1_end = Carbon::now('Asia/Ho_Chi_Minh')->month(3)->endOfMonth()->toDateString();

        $quy2_start = Carbon::now('Asia/Ho_Chi_Minh')->month(4)->startOfMonth()->toDateString();
        $quy2_end = Carbon::now('Asia/Ho_Chi_Minh')->month(6)->endOfMonth()->toDateString();

        $quy3_start = Carbon::now('Asia/Ho_Chi_Minh')->month(7)->startOfMonth()->toDateString();
        $quy3_end = Carbon::now('Asia/Ho_Chi_Minh')->month(9)->endOfMonth()->toDateString();

        $quy4_start = Carbon::now('Asia/Ho_Chi_Minh')->month(10)->startOfMonth()->toDateString();
        $quy4_end = Carbon::now('Asia/Ho_Chi_Minh')->month(12)->endOfMonth()->toDateString();


        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
//        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if($data['dashboard_value'] == '7ngay'){
            $get = ThongKe::whereBetween('tk_Ngay',[$sub7days,$now])->orderBy('tk_Ngay','asc')->get();
        }elseif ($data['dashboard_value'] == 'thangtruoc'){
            $get = ThongKe::whereBetween('tk_Ngay',[$dauthangtruoc,$cuoithangtruoc])->orderBy('tk_Ngay','asc')->get();
        }elseif ($data['dashboard_value'] == 'thangnay'){
            $get = ThongKe::whereBetween('tk_Ngay',[$dauthangnay,$now])->orderBy('tk_Ngay','asc')->get();
        }elseif ($data['dashboard_value'] == 'quy1'){
            $get = ThongKe::whereBetween('tk_Ngay',[$quy1_start, $quy1_end])->orderBy('tk_Ngay','asc')->get();
        }elseif ($data['dashboard_value'] == 'quy2'){
            $get = ThongKe::whereBetween('tk_Ngay',[$quy2_start, $quy2_end])->orderBy('tk_Ngay','asc')->get();
        }elseif ($data['dashboard_value'] == 'quy3'){
            $get = ThongKe::whereBetween('tk_Ngay',[$quy3_start, $quy3_end])->orderBy('tk_Ngay','asc')->get();
        }elseif ($data['dashboard_value'] == 'quy4'){
            $get = ThongKe::whereBetween('tk_Ngay',[$quy4_start, $quy4_end])->orderBy('tk_Ngay','asc')->get();
//        }elseif ($data['dashboard_value'] == '365ngayqua'){
//            $get = ThongKe::whereBetween('tk_Ngay',[$sub365days,$now])->orderBy('tk_Ngay','asc')->get();
        }

        foreach ($get as $key => $val){
            $chart_data[] = array(
                'period' => $val->tk_Ngay,
                'order' => $val->tk_TongDonHang,
//                'sales' => $val->tk_DoanhSo,
                'sales' => $val->tk_DoanhThu,
                'profit' => $val->tk_LoiNhuan,
                'quantity' => $val->tk_SoLuong
            );
        }
        echo $data = json_encode($chart_data);
//        return response()->json($chart_data);
    }

    //Hiê biểu đồ cột khi chọn ngày - đến ngày
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
//                'sales' => $val->tk_DoanhSo,
                'sales' => $val->tk_DoanhThu,
                'profit' => $val->tk_LoiNhuan,
                'quantity' => $val->tk_SoLuong
            );
        }

        return response()->json($chart_data); // Trả về dữ liệu JSON
    }

}
