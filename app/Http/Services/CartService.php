<?php

namespace App\Http\Services;

use App\Models\DiaChi;
use App\Models\PhiVanChuyen;
use App\Models\User;
use App\Models\SanPham;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PhieuDatHang;
use App\Models\KhachHang;

use Mail;

use Illuminate\Support\Facades\Session;

use Carbon\Carbon;
use App\Models\MaGiamGia;
use Illuminate\Support\Facades\Redirect;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;

class CartService
{
    //Hàm tạo giỏ hàng
    public function create($request)
    {
        $qty = (int)$request->input('num_product');
        $product_id = (int)$request->input('product_id');
        $sp = SanPham::find($product_id);
        $slh = $sp->sp_SoLuongHang;

        if ($qty <= 0 || $product_id <= 0 || $qty > $slh) {
            session()->flash('flash_message_error', 'Số lượng hoặc sản phẩm không chính xác');
            return false;
        }
        $carts = session()->get('carts');

        if (is_null($carts)) {
            session()->put('carts', [$product_id => $qty]);
            return true;
        }

        // dd($carts);
    $exists = Arr::exists($carts, $product_id);
    if ($exists) {
        $carts[$product_id] = $carts[$product_id] + $qty;
        //dd($carts[$product_id]);
        if($carts[$product_id] > $slh){
            session()->flash('flash_message_error', 'Số lượng sản phẩm lớn hơn trong kho');
            return false;
        }

        session()->put('carts',$carts);
        return true;
    }
    $carts[$product_id] = $qty;
    // dd($carts);
    session()->put('carts', $carts);
    return true;

    // dd($carts);
    }

    //Hàm lấy sản phẩm cho giỏ hàng
    public function getProduct()
    {
        $carts = session()->get('carts');
        if (is_null($carts)) return [];
        // dd($carts);

        $productId = array_keys($carts);
        // dd($productId);
        return SanPham::select('id', 'sp_TenSanPham', 'sp_Gia', 'sp_AnhDaiDien')
        ->where('sp_TrangThai', 1)
        ->whereIn('id', $productId)
        ->get();
    }

    //Hàm cập nhập số lượng giỏ hàng
    public function update($request)
    {
        $numProductArray = $request->input('num_product');
        // Lấy giỏ hàng hiện tại từ session
        $carts = session()->get('carts');

        foreach ($numProductArray as $product_id => $newQuantity) {
            $product = SanPham::find($product_id);
            $slh = $product->sp_SoLuongHang;

            if ($product) {
                if (isset($carts[$product_id])) {
                    //dd($carts[$product_id]);
                    if($newQuantity > $slh){
                        session()->flash('flash_message_error_err', 'Số lượng sản phẩm ' . $product->sp_TenSanPham .' lớn hơn trong kho');
                        return false;
                    }else{
                        // Cập nhật số lượng sản phẩm trong giỏ hàng
                        $carts[$product_id] = $newQuantity;
                    }

                } else {
                    // Sản phẩm không tồn tại trong giỏ hàng, có thể xử lý lỗi tại đây hoặc bỏ qua
                }
            } else {
                // Sản phẩm không tồn tại, có thể xử lý lỗi tại đây hoặc bỏ qua
            }
        }
        // Cuối cùng, bạn cập nhật lại giỏ hàng mới vào session
        session()->put('carts', $carts);
        return true;
    }

    //Hàm xóa sản phẩm trong giỏ hàng
    public function remove($id)
    {
        $carts = session()->get('carts');
        unset($carts[$id]);
        session()->put('carts', $carts);
        return true;
    }

    public function getUser()
    {
        return User::orderByDesc('id')->paginate(15);
    }

    //hàm post checkout
//    public function getCart(Request $request)
//    {
//        //dd($request);
//        try {
////            if (Auth::check()) {
//                DB::beginTransaction();
//                $total = 0;
//                $carts = Session::get('carts');
//                $coupons = Session::get('coupon');
//                $productId = array_keys($carts);
//                //dd($productId);
//
//                // Lấy thông tin sản phẩm từ giỏ hàng
//                foreach ($carts as $product_id => $quantity_purchased) {
//                    // Bước 1: Truy xuất thông tin sản phẩm từ cơ sở dữ liệu
//                    $product = SanPham::find($product_id);
//                    if ($product) {
//                        // Bước 2: Cập nhật số lượng sản phẩm
//                        $new_quantity_in_stock = max(0, $product->sp_SoLuongHang - $quantity_purchased);
//                        $new_quantity_sold = $product->sp_SoLuongBan + $quantity_purchased;
//                        // Bước 3: Lưu thông tin sản phẩm đã cập nhật trở lại cơ sở dữ liệu
//                        $product->sp_SoLuongHang = $new_quantity_in_stock;
//                        $product->sp_SoLuongBan = $new_quantity_sold;
//                        $product->save();
//                        // Cập nhật giỏ hàng với số lượng đã mua (có thể giữ nguyên hoặc xóa sản phẩm khỏi giỏ hàng tùy theo yêu cầu của bạn)
//                        $carts[$product_id] = $quantity_purchased;
//                    }
//                }
//
//                // Lưu giỏ hàng đã cập nhật vào session
//                session()->put('carts', $carts);
//
//                $products = SanPham::select('id', 'SP_TenSanPham', 'sp_Gia', 'sp_AnhDaiDien', 'sp_SoLuongHang', 'sp_SoLuongBan')
//                    ->where('sp_TrangThai', 1)
//                    ->whereIn('id', $productId)
//                    ->get();
//
//                //dd($products);
//
//                foreach ($products as $product) {
//                    $price = $product->sp_Gia;
//                    $priceEnd = $price * $carts[$product->id];
//                    $total += $priceEnd;
//                }
//
//                // Đặt múi giờ
//                date_default_timezone_set('Asia/Ho_Chi_Minh');
//
//                $id_tk = $request->user()->id;
//                $id_kh = KhachHang::where('tai_khoan_id', $id_tk)->get();
//                $id = $id_kh->first()->id;
//
//                $id_dc = $request->dc_DiaChi;
//                $dc = DiaChi::find($id_dc);
//                $pdh_DiaChiGiao = $dc->dc_DiaChi;
//
//                $id_tp = $dc->tinh_thanh_pho_id;
//                $pvc = PhiVanChuyen::where('thanh_pho_id', $id_tp)->get();
//                $phi = $pvc[0]['pvc_PhiVanChuyen'];
//
//                $today = Carbon::now()->toDateString();
//
//                $phuong_thuc_thanh_toan_id = $request->input('phuong_thuc_thanh_toan_id');
//                $submitButtonName = '';
//
//                switch ($phuong_thuc_thanh_toan_id) {
//                    case 1:
//                        $submitButtonName = 'cod';
//                        break;
//                    case 2:
//                        $submitButtonName = 'paypal';
//                        break;
//                    case 3:
//                        $submitButtonName = 'redirect';
//                        break;
//                    case 4:
//                        $submitButtonName = 'onepay';
//                        break;
//                    default:
//                        // Xử lý mặc định nếu không khớp với bất kỳ giá trị nào
//                        break;
//                }
//                //dd($submitButtonName);
//                // Kiểm tra xem nút `submit` có tên là 'cod' đã được bấm hay không
//                if ($submitButtonName === 'cod') {
//                    //dd('cod');
//                    if ($coupons) {
//                        //dd($coupons);
//                        foreach ($coupons as $key => $cou)
//                            if ($cou['mgg_LoaiGiamGia'] == 2) {
//                                $total_coupon = ($total * $cou['mgg_GiaTri']) / 100;
//                                $tien_end = $total - $total_coupon + $phi;
//                                //dd($tien_end);
//                            } elseif ($cou['mgg_LoaiGiamGia'] == 1) {
//                                $tien_end = $total - $cou['mgg_GiaTri'] + $phi;
//                                //dd($tien_end);
//                            }
//                        $cart = new PhieuDatHang;
//                        $cart->khach_hang_id = $id;
//                        $cart->ma_giam_gia_id = $coupons[0]['id'];
//                        $cart->pdh_GhiChu = $request->pdh_GhiChu;
//                        $cart->pdh_GiamGia = $coupons[0]['mgg_MaGiamGia'];
//                        $cart->pdh_DiaChiGiao = $pdh_DiaChiGiao;
//                        $cart->pdh_NgayDat = $today;
//                        $cart->pdh_TongTien = $tien_end;
//                        $cart->pdh_TrangThai = 1;
//                        $cart->phuong_thuc_thanh_toan_id = $request->phuong_thuc_thanh_toan_id;
//                        $cart->save();
//
//                        // Cập nhật trường mgg_SoLuongMa
//                        $newSoLuongMa = $cou['mgg_SoLuongMa'] - 1;
//                        //dd($newSoLuongMa);
//                        MaGiamGia::where('id', $cou['id'])
//                            ->update(['mgg_SoLuongMa' => $newSoLuongMa]);
//
//                    } else {
//                        $tien_end = $total + $phi;
//
//                        $cart = new PhieuDatHang;
//                        $cart->khach_hang_id = $id;
//                        $cart->pdh_GhiChu = $request->pdh_GhiChu;
//                        $cart->pdh_DiaChiGiao = $pdh_DiaChiGiao;
//                        $cart->pdh_NgayDat = $today;
//                        $cart->pdh_TongTien = $tien_end;
//                        $cart->pdh_TrangThai = 1;
//                        $cart->phuong_thuc_thanh_toan_id = $request->phuong_thuc_thanh_toan_id;
//                        $cart->save();
//                    }
//                    $customer = KhachHang::find($id);
//                    $customer->kh_Ten = $request->kh_Ten;
//                    $customer->kh_SoDienThoai = $request->kh_SoDienThoai;
//                    $tien = $customer->kh_TongTienDaMua;
//                    $customer->kh_TongTienDaMua = $tien + $tien_end;
//                    $customer->save();
//
//                    foreach ($products as $product) {
//                        DB::table('chi_tiet_phieu_dat_hangs')->insert([
//                            'phieu_dat_hang_id' => $cart->id,
//                            'san_pham_id' => $product->id,
//                            'ctpdh_SoLuong' => $carts[$product->id],
//                            'ctpdh_Gia' => $product->sp_Gia
//                        ]);
//                    }
//
//                    $name = "Nhựt Linh";
//                    Mail::send('front-end.email_order', compact('name'), function ($email) use ($name) {
//                        $email->subject('Balo');
//                        $email->to('trannhutlinh0925@gmail.com', $name);
//                    });
//
//                    if ($coupons == true) {
//                        Session::forget('coupon');
//                    }
//
//                    DB::commit();
//                    //session()->flash('flash_message', 'Đặt hàng thành công');
//                    session()->forget('carts');
//                    session()->forget('total_paypal');
//                } elseif ($submitButtonName === 'paypal') {
//                    //dd('paypal');
////                    $total = Session::get('total_paypal');
////                    $provider = new PayPalClient;
////                    $provider->setApiCredentials(config('paypal'));
////                    $paypalToken = $provider->getAccessToken();
////
////                    $response = $provider->createOrder([
////                        "intent" => "CAPTURE",
////                        "application_context" => [
////                            "return_url" => route('successTransaction'),
////                            "cancel_url" => route('cancelTransaction'),
////                        ],
////                        "purchase_units" => [
////                            [
////                                "amount" => [
////                                    "currency_code" => "USD",
////                                    "value" => $total
////                                ]
////                            ]
////                        ]
////                    ]);
////                    //dd($response);
////
////                    if (isset($response['id']) && $response['id'] != null) {
////                        // redirect to approve href
////                        foreach ($response['links'] as $links) {
////                            //dd($links);
////                            if ($links['rel'] == 'approve') {
////                                //dd($links['href']);
////                                return redirect()->away($links['href']);
//////                                return redirect('https://www.sandbox.paypal.com/checkoutnow?token=27515427R9424541W');
////
////                            }
////                            //dd('111');
////                        }
////                        dd('1233');
////
////                        return redirect()
////                            ->route('checkout')
////                            ->with('flash_message_error', 'Lỗi thanh toán.');
////
////                    } else {
////                        return redirect()
////                            ->route('checkout')
////                            ->with('flash_message_error', $response['message'] ?? 'Lỗi thanh toán.');
////                    }
//                } elseif ($submitButtonName === 'redirect') {
//                    //dd('vnpay');
//                    $data = $request->all();
//                    $code_cart = rand(00, 9999);
//                    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
//                    // Lấy thông tin "dc_DiaChi" từ biến $data
//                    $dc_DiaChi = isset($data['dc_DiaChi']) ? $data['dc_DiaChi'] : '';
//                    // Tạo một mảng chứa các thông tin từ biến $data và thông tin "dc_DiaChi"
//                    $queryData = array_merge($data, ['dc_DiaChi' => $dc_DiaChi]);
//                    // Chuyển đổi mảng thông tin thành query string
//                    $queryString = http_build_query($queryData);
//                    // Cập nhật biến $vnp_Returnurl bằng cách thêm query string vào URL
//                    $vnp_Returnurl = "http://127.0.0.1:8000/vnpay-callback?" . $queryString;
//                    //$vnp_Returnurl = "http://127.0.0.1:8000/vnpay-callback";
//                    $vnp_TmnCode = "JZXSHR5X";//Mã website tại VNPAY
//                    $vnp_HashSecret = "TQWUZAKGSAQBBWMNDTMZXINTWDJYXPBA"; //Chuỗi bí mật
//                    $vnp_TxnRef = $code_cart; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
//                    $vnp_OrderInfo = 'Thanh toán đơn hàng';
//                    $vnp_OrderType = 'billpayment';
//                    $vnp_Amount = $data['total_vnpay'] * 100;
//                    $vnp_Locale = 'vn';
//                    $vnp_BankCode = 'NCB';
//                    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
//
//                    $inputData = array(
//                        "vnp_Version" => "2.1.0",
//                        "vnp_TmnCode" => $vnp_TmnCode,
//                        "vnp_Amount" => $vnp_Amount,
//                        "vnp_Command" => "pay",
//                        "vnp_CreateDate" => date('YmdHis'),
//                        "vnp_CurrCode" => "VND",
//                        "vnp_IpAddr" => $vnp_IpAddr,
//                        "vnp_Locale" => $vnp_Locale,
//                        "vnp_OrderInfo" => $vnp_OrderInfo,
//                        "vnp_OrderType" => $vnp_OrderType,
//                        "vnp_ReturnUrl" => $vnp_Returnurl,
//                        "vnp_TxnRef" => $vnp_TxnRef,
//                    );
//                    //dd($inputData);
//
//                    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
//                        $inputData['vnp_BankCode'] = $vnp_BankCode;
//                    }
//
//                    if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
//                        $inputData['vnp_Bill_State'] = $vnp_Bill_State;
//                    }
//
//                    //var_dump($inputData);
//                    ksort($inputData);
//                    $query = "";
//                    $i = 0;
//                    $hashdata = "";
//                    foreach ($inputData as $key => $value) {
//                        if ($i == 1) {
//                            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
//                        } else {
//                            $hashdata .= urlencode($key) . "=" . urlencode($value);
//                            $i = 1;
//                        }
//                        $query .= urlencode($key) . "=" . urlencode($value) . '&';
//                    }
//
//                    $vnp_Url = $vnp_Url . "?" . $query;
//                    if (isset($vnp_HashSecret)) {
//                        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
//                        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
//                    }
//                    $returnData = array('code' => '00'
//                    , 'message' => 'success'
//                    , 'data' => $vnp_Url);
//                    //if (isset($_POST['redirect'])) {
//                    if ($phuong_thuc_thanh_toan_id == 3) {
//                        header('Location: ' . $vnp_Url);
//                        die();
//                    } else {
//                        echo json_encode($returnData);
//                    }
//
//                }
//
//            }
////        }
//
//
//        catch
//            (\Exception $err){
//                DB::rollBack();
//                session()->flash('flash_message_error', 'Đặt hàng lỗi, vui lòng thử lại');
//                return false;
//
//            }
//
//        return true;
//
//    }
//
//    public function successTransaction(Request $request)
//    {
//        $provider = new PayPalClient;
//        //dd($provider);
//        $provider->setApiCredentials(config('paypal'));
//        $provider->getAccessToken();
//        $response = $provider->capturePaymentOrder($request['token']);
//
//        dd($response);
//
//        $total = 0;
//        $carts = Session::get('carts');
//        $coupons = Session::get('coupon');
//        $productId = array_keys($carts);
//        //dd($productId);
//
//        // Lấy thông tin sản phẩm từ giỏ hàng
//        foreach ($carts as $product_id => $quantity_purchased) {
//            // Bước 1: Truy xuất thông tin sản phẩm từ cơ sở dữ liệu
//            $product = SanPham::find($product_id);
//            if ($product) {
//                // Bước 2: Cập nhật số lượng sản phẩm
//                $new_quantity_in_stock = max(0, $product->sp_SoLuongHang - $quantity_purchased);
//                $new_quantity_sold = $product->sp_SoLuongBan + $quantity_purchased;
//                // Bước 3: Lưu thông tin sản phẩm đã cập nhật trở lại cơ sở dữ liệu
//                $product->sp_SoLuongHang = $new_quantity_in_stock;
//                $product->sp_SoLuongBan = $new_quantity_sold;
//                $product->save();
//                // Cập nhật giỏ hàng với số lượng đã mua (có thể giữ nguyên hoặc xóa sản phẩm khỏi giỏ hàng tùy theo yêu cầu của bạn)
//                $carts[$product_id] = $quantity_purchased;
//            }
//        }
//
//        // Lưu giỏ hàng đã cập nhật vào session
//        session()->put('carts', $carts);
//
//        $products = SanPham::select('id', 'SP_TenSanPham', 'sp_Gia', 'sp_AnhDaiDien', 'sp_SoLuongHang', 'sp_SoLuongBan')
//            ->where('sp_TrangThai', 1)
//            ->whereIn('id', $productId)
//            ->get();
//
//        //dd($products);
//
//        foreach ($products as $product) {
//            $price = $product->sp_Gia;
//            $priceEnd = $price * $carts[$product->id];
//            $total += $priceEnd;
//        }
//
//        // Lấy các thông tin từ request
//        $pdh_GhiChu = $request->input('pdh_GhiChu'); // null
//        $dc_DiaChi = $request->input('dc_DiaChi'); // "19"
//        $phuong_thuc_thanh_toan_id = $request->input('phuong_thuc_thanh_toan_id'); // "2"
//
//        // Đặt múi giờ
//        date_default_timezone_set('Asia/Ho_Chi_Minh');
//
//        $id_tk = $request->user()->id;
//        $id_kh = KhachHang::where('tai_khoan_id', $id_tk)->get();
//        $id = $id_kh->first()->id;
//        //dd($id);
//
//        //$id_dc = $postData['dc_DiaChi'];
//        //dd($id_dc);
//        $dc = DiaChi::find($dc_DiaChi);
//        $pdh_DiaChiGiao = $dc->dc_DiaChi;
//
//        $id_tp = $dc->tinh_thanh_pho_id;
//        $pvc = PhiVanChuyen::where('thanh_pho_id', $id_tp)->get();
//        $phi = $pvc[0]['pvc_PhiVanChuyen'];
//
//        $today = Carbon::now()->toDateString();
//        //dd($today);
//
//        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
//            if ($coupons) {
//                //dd($coupons);
//                foreach ($coupons as $key => $cou)
//                    if ($cou['mgg_LoaiGiamGia'] == 2) {
//                        $total_coupon = ($total * $cou['mgg_GiaTri']) / 100;
//                        $tien_end = $total - $total_coupon + $phi;
//                        //dd($tien_end);
//                    } elseif ($cou['mgg_LoaiGiamGia'] == 1) {
//                        $tien_end = $total - $cou['mgg_GiaTri'] + $phi;
//                        //dd($tien_end);
//                    }
//                $cart = new PhieuDatHang;
//                $cart->khach_hang_id = $id;
//                $cart->ma_giam_gia_id = $coupons[0]['id'];
//                $cart->pdh_GhiChu = $pdh_GhiChu;
//                $cart->pdh_GiamGia = $coupons[0]['mgg_MaGiamGia'];
//                $cart->pdh_DiaChiGiao = $pdh_DiaChiGiao;
//                $cart->pdh_NgayDat = $today;
//                $cart->pdh_TongTien = $tien_end;
//                $cart->pdh_TrangThai = 1;
//                $cart->phuong_thuc_thanh_toan_id = $phuong_thuc_thanh_toan_id;
//                $cart->save();
//                dd($cart);
//
//                // Cập nhật trường mgg_SoLuongMa
//                $newSoLuongMa = $cou['mgg_SoLuongMa'] - 1;
//                //dd($newSoLuongMa);
//                MaGiamGia::where('id', $cou['id'])
//                    ->update(['mgg_SoLuongMa' => $newSoLuongMa]);
//
//            } else {
//                $tien_end = $total + $phi;
//                //dd($tien_end);
//
//                $cart = new PhieuDatHang;
//                $cart->khach_hang_id = $id;
//                $cart->pdh_GhiChu = $pdh_GhiChu;
//                $cart->pdh_DiaChiGiao = $pdh_DiaChiGiao;
//                $cart->pdh_NgayDat = $today;
//                $cart->pdh_TongTien = $tien_end;
//                $cart->pdh_TrangThai = 1;
//                $cart->phuong_thuc_thanh_toan_id = $phuong_thuc_thanh_toan_id;
//                $cart->save();
//                dd($cart);
//            }
//            $customer = KhachHang::find($id);
//            $customer->kh_Ten = $request->kh_Ten;
//            $customer->kh_SoDienThoai = $request->kh_SoDienThoai;
//            $tien = $customer->kh_TongTienDaMua;
//            $customer->kh_TongTienDaMua = $tien + $tien_end;
//            $customer->save();
//
//            foreach ($products as $product) {
//                DB::table('chi_tiet_phieu_dat_hangs')->insert([
//                    'phieu_dat_hang_id' => $cart->id,
//                    'san_pham_id' => $product->id,
//                    'ctpdh_SoLuong' => $carts[$product->id],
//                    'ctpdh_Gia' => $product->sp_Gia
//                ]);
//            }
//
//            $name = "Nhựt Linh";
//            Mail::send('front-end.email_order', compact('name'), function ($email) use ($name) {
//                $email->subject('Balo');
//                $email->to('trannhutlinh0925@gmail.com', $name);
//            });
//
//            if ($coupons == true) {
//                Session::forget('coupon');
//            }
//
//            DB::commit();
//            //session()->flash('flash_message', 'Đặt hàng thành công');
//            session()->forget('carts');
//            session()->forget('total_paypal');
////            return redirect()
////                ->route('shop')
////                ->with('flash_message_checkout', 'Thanh toán PayPal thành công');
//        } else {
//            return redirect()
//                ->route('checkout')
//                ->with('flash_message_error', $response['message'] ?? 'Lỗi thanh toán.');
//        }
//    }
//
//    public function cancelTransaction(Request $request)
//    {
//        return redirect()
//            ->route('checkout')
//            ->with('flash_message_error', $response['message'] ?? 'Bạn đã đóng giao dịch PayPal.');
//    }
//
//    public function handleVnPayCallback(Request $request){
//        //dd($request);
//        $postData = $request->all();
//        //dd($postData);
//        $total = 0;
//        $carts = Session::get('carts');
//        $coupons = Session::get('coupon');
//        $productId = array_keys($carts);
//
//        // Lấy thông tin sản phẩm từ giỏ hàng
//        foreach ($carts as $product_id => $quantity_purchased) {
//            $product = SanPham::find($product_id);
//            if ($product) {
//                $new_quantity_in_stock = max(0, $product->sp_SoLuongHang - $quantity_purchased);
//                $new_quantity_sold = $product->sp_SoLuongBan + $quantity_purchased;
//                $product->sp_SoLuongHang = $new_quantity_in_stock;
//                $product->sp_SoLuongBan = $new_quantity_sold;
//                $product->save();
//                $carts[$product_id] = $quantity_purchased;
//            }
//        }
//        session()->put('carts', $carts);
//
//        $products = SanPham::select('id', 'SP_TenSanPham', 'sp_Gia', 'sp_AnhDaiDien', 'sp_SoLuongHang', 'sp_SoLuongBan')
//            ->where('sp_TrangThai', 1)
//            ->whereIn('id', $productId)
//            ->get();
//
//        foreach ($products as $product) {
//            $price = $product->sp_Gia;
//            $priceEnd = $price * $carts[$product->id];
//            $total += $priceEnd;
//        }
//
//        date_default_timezone_set('Asia/Ho_Chi_Minh');
//
//        $id_tk = $request->user()->id;
//        $id_kh = KhachHang::where('tai_khoan_id', $id_tk)->get();
//        $id = $id_kh->first()->id;
//
//        $id_dc = $postData['dc_DiaChi'];
//        $dc = DiaChi::find($id_dc);
//        $pdh_DiaChiGiao = $dc->dc_DiaChi;
//
//        $id_tp = $dc->tinh_thanh_pho_id;
//        $pvc = PhiVanChuyen::where('thanh_pho_id', $id_tp)->get();
//        $phi = $pvc[0]['pvc_PhiVanChuyen'];
//
//        $today = Carbon::now()->toDateString();
//
//        // Xử lý callback từ VNPAY
//        if (isset($_GET['vnp_ResponseCode'])) {
//            $vnp_ResponseCode = $_GET['vnp_ResponseCode'];
//            // Kiểm tra xem thanh toán VNPAY có thành công hay không (mã trạng thái 00 là thành công)
//            if ($vnp_ResponseCode === '00') {
//                if ($coupons) {
//                    //dd($coupons);
//                    foreach ($coupons as $key => $cou)
//                        if ($cou['mgg_LoaiGiamGia'] == 2) {
//                            $total_coupon = ($total * $cou['mgg_GiaTri']) / 100;
//                            $tien_end = $total - $total_coupon + $phi;
//                            //dd($tien_end);
//                        } elseif ($cou['mgg_LoaiGiamGia'] == 1) {
//                            $tien_end = $total - $cou['mgg_GiaTri'] + $phi;
//                            //dd($tien_end);
//                        }
//                    $cart = new PhieuDatHang;
//                    $cart->khach_hang_id = $id;
//                    $cart->ma_giam_gia_id = $coupons[0]['id'];
//                    $cart->pdh_GhiChu = $request->pdh_GhiChu;
//                    $cart->pdh_GiamGia = $coupons[0]['mgg_MaGiamGia'];
//                    $cart->pdh_DiaChiGiao = $pdh_DiaChiGiao;
//                    $cart->pdh_NgayDat = $today;
//                    $cart->pdh_TongTien = $tien_end;
//                    $cart->pdh_TrangThai = 1;
//                    $cart->phuong_thuc_thanh_toan_id = $request->phuong_thuc_thanh_toan_id;
//                    $cart->save();
//
//                    // Cập nhật trường mgg_SoLuongMa
//                    $newSoLuongMa = $cou['mgg_SoLuongMa'] - 1;
//                    MaGiamGia::where('id', $cou['id'])
//                        ->update(['mgg_SoLuongMa' => $newSoLuongMa]);
//
//                } else {
//                    $tien_end = $total + $phi;
//
//                    $cart = new PhieuDatHang;
//                    $cart->khach_hang_id = $id;
//                    $cart->pdh_GhiChu = $request->pdh_GhiChu;
//                    $cart->pdh_DiaChiGiao = $pdh_DiaChiGiao;
//                    $cart->pdh_NgayDat = $today;
//                    $cart->pdh_TongTien = $tien_end;
//                    $cart->pdh_TrangThai = 1;
//                    $cart->phuong_thuc_thanh_toan_id = $request->phuong_thuc_thanh_toan_id;
//                    $cart->save();
//                }
//                $customer = KhachHang::find($id);
//                $customer->kh_Ten = $request->kh_Ten;
//                $customer->kh_SoDienThoai = $request->kh_SoDienThoai;
//                $tien = $customer->kh_TongTienDaMua;
//                $customer->kh_TongTienDaMua = $tien + $tien_end;
//                $customer->save();
//
//                foreach ($products as $product) {
//                    DB::table('chi_tiet_phieu_dat_hangs')->insert([
//                        'phieu_dat_hang_id' => $cart->id,
//                        'san_pham_id' => $product->id,
//                        'ctpdh_SoLuong' => $carts[$product->id],
//                        'ctpdh_Gia' => $product->sp_Gia
//                    ]);
//                }
//
//                $name = "Nhựt Linh";
//                Mail::send('front-end.email_order', compact('name'), function ($email) use ($name) {
//                    $email->subject('Balo');
//                    $email->to('trannhutlinh0925@gmail.com', $name);
//                });
//
//                if ($coupons == true) {
//                    Session::forget('coupon');
//                }
//
//                DB::commit();
//                //session()->flash('flash_message', 'Đặt hàng thành công');
//                session()->forget('carts');
//                session()->forget('total_paypal');
//            }
//        }
//    }
}
