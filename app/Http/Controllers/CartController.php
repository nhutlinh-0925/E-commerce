<?php

namespace App\Http\Controllers;
use App\Http\Services\CartService;
use App\Models\PhieuDatHang;
use App\Models\PhiVanChuyen;
use App\Models\PhuongThucThanhToan;
use App\Models\SanPham;
use App\Models\TaiKhoan;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\KhachHang;

use DataTables;

use App\Models\MaGiamGia;

use App\Models\DiaChi;
use App\Models\YeuThich;
use App\Models\PhanHoi;
use Carbon\Carbon;
use Mail;
use App\Models\ThongKe;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class CartController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $result = $this->cartService->create($request);
        // dd($result);
        // dd(session()->get('carts'));
        if ($result === false){
            return redirect()->back();
        }
        return redirect('/carts');
    }

    public function add_cart_shop(Request $request)
    {
        $result = $this->cartService->create($request);
        // dd($result);
        // dd(session()->get('carts'));
        if ($result === false){
            return redirect()->back();
        }
        // Lưu thông báo vào Session
        Session::flash('success_message', 'Thêm giỏ hàng thành công!');
        return redirect()->back();
    }



    public function show()
    {
        if(Auth::check()){
            $id_tk = Auth::user()->id;
            //dd($id_kh);8
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            //dd($khachhang);
            $id_kh = $khachhang->id;
            //dd($id_kh);
            $products = $this->cartService->getProduct();
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();
            //dd($wish_count);
            return view('front-end.cart', [
                // 'title' => 'Giỏ Hàng',
                'products' => $products,
                'carts' => session()->get('carts'),
                'khachhang' => $khachhang,
                'coupons' => session()->get('coupon'),
                'wish_count' => $wish_count
            ]);
        }else{
            $products = $this->cartService->getProduct();
            return view('front-end.cart', [
                // 'title' => 'Giỏ Hàng',
                'products' => $products,
                'carts' => session()->get('carts'),
                'coupons' => session()->get('coupon'),
            ]);
        }
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $this->cartService->update($request);
        return redirect('/carts');
    }

    public function remove($id = 0)
    {
        $this->cartService->remove($id);

        $products = $this->cartService->getProduct();
        if (count ($products) == 0){
            $coupon = Session::get('coupon');
            if($coupon == true){
                Session::forget('coupon');
                return redirect()->back();
            }
        }

        return redirect('/carts');
    }


    //Hàm get checkout
    public function showcheckout()
    {
//        dd($request);
        if(Auth::check()){
            $id = Auth::user()->id;
            //dd($id);
            $khachhang = KhachHang::where('tai_khoan_id', $id)->first();
            $id_kh = $khachhang->id;

            $products = $this->cartService->getProduct();

            $address = DiaChi::where('khach_hang_id', $id_kh)->get();
            //dd($address);
            //$dc_md = DiaChi::where('khach_hang_id', $id)->where('dc_TrangThai', 1)->get();
            //dd($dc_md);
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();
            //dd($wish_count);

            $payments = PhuongThucThanhToan::all();

            return view('front-end.checkout', [
                // 'title' => 'Giỏ Hàng',
                'products' => $products,
                'carts' => session()->get('carts'),
                'khachhang' => $khachhang,
                'coupons' => session()->get('coupon'),
                'address' => $address,
//                'dc_md' => $dc_md,
//                'pvc' => session()->get('pvc'),
                'wish_count' => $wish_count,
                'payments' => $payments
            ]);
        }else{
            Session::flash('flash_message_error', 'Vui lòng đăng nhập để thanh toán!');
            Session::put('flash_message_error_link', '/user/login');
            return redirect('/carts');
        }
    }

    public function get_ship(Request $request)
    {
        // Lấy id địa chỉ từ yêu cầu AJAX
        $addressId = $request->input('address_id');
        //dd($addressId);
        $address = DiaChi::find($addressId);

        if ($address) {
            // Lấy id của tỉnh/thành phố từ địa chỉ
            $thanhPhoId = $address->tinh_thanh_pho_id;

            // Tìm thông tin phí vận chuyển từ bảng `phi_van_chuyens`
            $shippingFee = PhiVanChuyen::where('thanh_pho_id', $thanhPhoId)->value('pvc_PhiVanChuyen');
        } else {
            // Nếu không tìm thấy địa chỉ, mặc định phí vận chuyển là 0 (hoặc giá trị tùy ý)
            $shippingFee = 25000;
        }

        // Trả về kết quả dưới dạng JSON
        return response()->json(['pvc_PhiVanChuyen' => $shippingFee]);
    }

    public function getCart(Request $request) {
        //dd($request);
        $this->validate($request, [
            'kh_SoDienThoai' => 'required',
            'dc_DiaChi' => 'required',
            'phuong_thuc_thanh_toan_id' => 'required',
        ],
            [
                'kh_SoDienThoai.required' => 'Vui lòng nhập số điện thoại',
                'dc_DiaChi.required' => 'Vui lòng chọn địa chỉ',
                'phuong_thuc_thanh_toan_id.required' => 'Vui lòng chọn phương thức thanh toán',
            ]);

        //$this->cartService->getCart($request);

        try {
            DB::beginTransaction();
            $total = 0;
            $carts = Session::get('carts');
            $coupons = Session::get('coupon');
            $productId = array_keys($carts);
            //dd($productId);
            $data = $request->input();
            //dd($data);
            $data_input = session()->put('data', $data);

            // Lấy giá trị từ session với key là 'data'
            $data_get = session('data');

            // Lấy thông tin sản phẩm từ giỏ hàng
            foreach ($carts as $product_id => $quantity_purchased) {
                // Bước 1: Truy xuất thông tin sản phẩm từ cơ sở dữ liệu
                $product = SanPham::find($product_id);
                if ($product) {
                    // Bước 2: Cập nhật số lượng sản phẩm
                    $new_quantity_in_stock = max(0, $product->sp_SoLuongHang - $quantity_purchased);
                    $new_quantity_sold = $product->sp_SoLuongBan + $quantity_purchased;
                    // Bước 3: Lưu thông tin sản phẩm đã cập nhật trở lại cơ sở dữ liệu
                    $product->sp_SoLuongHang = $new_quantity_in_stock;
                    $product->sp_SoLuongBan = $new_quantity_sold;
                    $product->save();
                    // Cập nhật giỏ hàng với số lượng đã mua (có thể giữ nguyên hoặc xóa sản phẩm khỏi giỏ hàng tùy theo yêu cầu của bạn)
                    $carts[$product_id] = $quantity_purchased;
                }
            }

            // Lưu giỏ hàng đã cập nhật vào session
            session()->put('carts', $carts);

            $products = SanPham::select('id', 'SP_TenSanPham', 'sp_Gia', 'sp_AnhDaiDien', 'sp_SoLuongHang', 'sp_SoLuongBan')
                ->where('sp_TrangThai', 1)
                ->whereIn('id', $productId)
                ->get();
            //dd($products);

            foreach ($products as $product) {
                $price = $product->sp_Gia;
                $priceEnd = $price * $carts[$product->id];
                $total += $priceEnd;
            }

            // Đặt múi giờ
            date_default_timezone_set('Asia/Ho_Chi_Minh');

            $id_tk = $request->user()->id;
            $id_kh = KhachHang::where('tai_khoan_id', $id_tk)->get();
            $id = $id_kh->first()->id;

            $id_dc = $request->dc_DiaChi;
            $dc = DiaChi::find($id_dc);
            $pdh_DiaChiGiao = $dc->dc_DiaChi;

            $id_tp = $dc->tinh_thanh_pho_id;
            $pvc = PhiVanChuyen::where('thanh_pho_id', $id_tp)->get();
            $phi = $pvc[0]['pvc_PhiVanChuyen'];

            $today = Carbon::now()->toDateString();

            $phuong_thuc_thanh_toan_id = $request->input('phuong_thuc_thanh_toan_id');
            $submitButtonName = '';

            switch ($phuong_thuc_thanh_toan_id) {
                case 1:
                    $submitButtonName = 'cod';
                    break;
                case 2:
                    $submitButtonName = 'paypal';
                    break;
                case 3:
                    $submitButtonName = 'redirect';
                    break;
                case 4:
                    $submitButtonName = 'onepay';
                    break;
                default:
                    // Xử lý mặc định nếu không khớp với bất kỳ giá trị nào
                    break;
            }
            // Kiểm tra xem nút `submit` có tên là 'cod' đã được bấm hay không
            if ($submitButtonName === 'cod') {
                //dd('cod');
                if ($coupons) {
                    foreach ($coupons as $key => $cou)
                        if ($cou['mgg_LoaiGiamGia'] == 2) {
                            $total_coupon = ($total * $cou['mgg_GiaTri']) / 100;
                            $tien_end = $total - $total_coupon + $phi;
                            //dd($tien_end);
                        } elseif ($cou['mgg_LoaiGiamGia'] == 1) {
                            $tien_end = $total - $cou['mgg_GiaTri'] + $phi;
                            //dd($tien_end);
                        }
                    $cart = new PhieuDatHang;
                    $cart->khach_hang_id = $id;
                    $cart->ma_giam_gia_id = $coupons[0]['id'];
                    $cart->pdh_GhiChu = $request->pdh_GhiChu;
                    $cart->pdh_GiamGia = $coupons[0]['mgg_MaGiamGia'];
                    $cart->pdh_DiaChiGiao = $pdh_DiaChiGiao;
                    $cart->pdh_NgayDat = $today;
                    $cart->pdh_TongTien = $tien_end;
                    $cart->pdh_TrangThai = 1;
                    $cart->phuong_thuc_thanh_toan_id = $request->phuong_thuc_thanh_toan_id;
                    $cart->save();
                    //dd($cart);

                    // Cập nhật trường mgg_SoLuongMa
                    $newSoLuongMa = $cou['mgg_SoLuongMa'] - 1;
                    //dd($newSoLuongMa);
                    MaGiamGia::where('id', $cou['id'])
                        ->update(['mgg_SoLuongMa' => $newSoLuongMa]);

                } else {
                    $tien_end = $total + $phi;

                    $cart = new PhieuDatHang;
                    $cart->khach_hang_id = $id;
                    $cart->pdh_GhiChu = $request->pdh_GhiChu;
                    $cart->pdh_DiaChiGiao = $pdh_DiaChiGiao;
                    $cart->pdh_NgayDat = $today;
                    $cart->pdh_TongTien = $tien_end;
                    $cart->pdh_TrangThai = 1;
                    $cart->phuong_thuc_thanh_toan_id = $request->phuong_thuc_thanh_toan_id;
                    $cart->save();
                    //dd($cart);
                }

                $customer = KhachHang::find($id);
                //$customer->kh_Ten = $customer->kh_Ten;
                $customer->kh_SoDienThoai = $request->kh_SoDienThoai;
                //$tien = $customer->kh_TongTienDaMua;
                //$customer->kh_TongTienDaMua = $tien + $tien_end;
                $customer->save();

                foreach ($products as $product) {
                    DB::table('chi_tiet_phieu_dat_hangs')->insert([
                        'phieu_dat_hang_id' => $cart->id,
                        'san_pham_id' => $product->id,
                        'ctpdh_SoLuong' => $carts[$product->id],
                        'ctpdh_Gia' => $product->sp_Gia
                    ]);
                }

//                $name = "Nhựt Linh";
//                Mail::send('front-end.email_order', compact('name'), function ($email) use ($name) {
//                    $email->subject('Balo');
//                    $email->to('trannhutlinh0925@gmail.com', $name);
//                });

                if ($coupons == true) {
                    Session::forget('coupon');
                }

                DB::commit();
                session()->forget('carts');
                session()->forget('total_paypal');
                session()->forget('data_get');
            } elseif ($submitButtonName === 'paypal') {
                //dd('paypal');
                $total = Session::get('total_paypal');
                $provider = new PayPalClient;
                $provider->setApiCredentials(config('paypal'));
                $paypalToken = $provider->getAccessToken();

                $response = $provider->createOrder([
                    "intent" => "CAPTURE",
                    "application_context" => [
                        "return_url" => route('user.successTransaction'),
                        "cancel_url" => route('user.cancelTransaction'),
                    ],
                    "purchase_units" => [
                        [
                            "amount" => [
                                "currency_code" => "USD",
                                "value" => $total
                            ]
                        ]
                    ]
                ]);
                //dd($response);

                if (isset($response['id']) && $response['id'] != null) {
                    foreach ($response['links'] as $links) {
                        //dd($links);
                        if ($links['rel'] == 'approve') {
                            //dd($links['href']);
                            return redirect()->away($links['href']);
                            }
                        }

                        return redirect()
                            ->route('user.checkout')
                            ->with('flash_message_error', 'Lỗi thanh toán.');

                    } else {
                        return redirect()
                            ->route('user.checkout')
                            ->with('flash_message_error', $response['message'] ?? 'Lỗi thanh toán.');
                    }
            } elseif ($submitButtonName === 'redirect') {
                //dd('vnpay');
                $data = $request->all();
                $code_cart = rand(00, 9999);
                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                // Lấy thông tin "dc_DiaChi" từ biến $data
                $dc_DiaChi = isset($data['dc_DiaChi']) ? $data['dc_DiaChi'] : '';
                // Tạo một mảng chứa các thông tin từ biến $data và thông tin "dc_DiaChi"
                $queryData = array_merge($data, ['dc_DiaChi' => $dc_DiaChi]);
                // Chuyển đổi mảng thông tin thành query string
                $queryString = http_build_query($queryData);
                // Cập nhật biến $vnp_Returnurl bằng cách thêm query string vào URL
                $vnp_Returnurl = "http://127.0.0.1:8000/user/vnpay-callback?" . $queryString;
                //$vnp_Returnurl = "http://127.0.0.1:8000/vnpay-callback";
                $vnp_TmnCode = "JZXSHR5X";//Mã website tại VNPAY
                $vnp_HashSecret = "TQWUZAKGSAQBBWMNDTMZXINTWDJYXPBA"; //Chuỗi bí mật
                $vnp_TxnRef = $code_cart; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
                $vnp_OrderInfo = 'Thanh toán đơn hàng';
                $vnp_OrderType = 'billpayment';
                $vnp_Amount = $data['total_vnpay'] * 100;
                $vnp_Locale = 'vn';
                $vnp_BankCode = 'NCB';
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef,
                );
                //dd($inputData);

                if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }

                if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                    $inputData['vnp_Bill_State'] = $vnp_Bill_State;
                }

                //var_dump($inputData);
                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }

                $vnp_Url = $vnp_Url . "?" . $query;
                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }
                $returnData = array('code' => '00'
                , 'message' => 'success'
                , 'data' => $vnp_Url);
                //if (isset($_POST['redirect'])) {
                if ($phuong_thuc_thanh_toan_id == 3) {
                    header('Location: ' . $vnp_Url);
                    die();
                    //return redirect()->away($vnp_Url);
                } else {
                    return redirect()->route('user.showcheckout');
                    //echo json_encode($returnData);
                }

            }

        }

        catch (\Exception $err){
            DB::rollBack();
            session()->flash('flash_message_error', 'Đặt hàng lỗi, vui lòng thử lại');
            return false;
        }

        Session::flash('flash_message_checkout', 'Đặt hàng thành công!');
        return redirect('/shop');

    }

    public function successTransaction(Request $request){
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $total = 0;
            $carts = Session::get('carts');
            $coupons = Session::get('coupon');
            $productId = array_keys($carts);
            $data_get = session('data');
            //dd($data_get);

            // Lấy thông tin sản phẩm từ giỏ hàng
            foreach ($carts as $product_id => $quantity_purchased) {
                $product = SanPham::find($product_id);
                if ($product) {
                    $new_quantity_in_stock = max(0, $product->sp_SoLuongHang - $quantity_purchased);
                    $new_quantity_sold = $product->sp_SoLuongBan + $quantity_purchased;
                    $product->sp_SoLuongHang = $new_quantity_in_stock;
                    $product->sp_SoLuongBan = $new_quantity_sold;
                    $product->save();
                    $carts[$product_id] = $quantity_purchased;
                }
            }

            // Lưu giỏ hàng đã cập nhật vào session
            session()->put('carts', $carts);

            $products = SanPham::select('id', 'SP_TenSanPham', 'sp_Gia', 'sp_AnhDaiDien', 'sp_SoLuongHang', 'sp_SoLuongBan')
                ->where('sp_TrangThai', 1)
                ->whereIn('id', $productId)
                ->get();

            foreach ($products as $product) {
                $price = $product->sp_Gia;
                $priceEnd = $price * $carts[$product->id];
                $total += $priceEnd;
            }

            // Đặt múi giờ
            date_default_timezone_set('Asia/Ho_Chi_Minh');

            $id_tk = $request->user()->id;
            $id_kh = KhachHang::where('tai_khoan_id', $id_tk)->get();
            $id = $id_kh->first()->id;

            $dc = DiaChi::find($data_get['dc_DiaChi']);
            $pdh_DiaChiGiao = $dc->dc_DiaChi;

            $id_tp = $dc->tinh_thanh_pho_id;
            $pvc = PhiVanChuyen::where('thanh_pho_id', $id_tp)->get();
            $phi = $pvc[0]['pvc_PhiVanChuyen'];

            $today = Carbon::now()->toDateString();

            if ($coupons) {
                foreach ($coupons as $key => $cou)
                    if ($cou['mgg_LoaiGiamGia'] == 2) {
                        $total_coupon = ($total * $cou['mgg_GiaTri']) / 100;
                        $tien_end = $total - $total_coupon + $phi;
                    } elseif ($cou['mgg_LoaiGiamGia'] == 1) {
                        $tien_end = $total - $cou['mgg_GiaTri'] + $phi;
                    }
                $cart = new PhieuDatHang;
                $cart->khach_hang_id = $id;
                $cart->ma_giam_gia_id = $coupons[0]['id'];
                $cart->pdh_GhiChu = $data_get['pdh_GhiChu'];
                $cart->pdh_GiamGia = $coupons[0]['mgg_MaGiamGia'];
                $cart->pdh_DiaChiGiao = $pdh_DiaChiGiao;
                $cart->pdh_NgayDat = $today;
                $cart->pdh_TongTien = $tien_end;
                $cart->pdh_TrangThai = 1;
                $cart->phuong_thuc_thanh_toan_id = $data_get['phuong_thuc_thanh_toan_id'];
                $cart->save();
                //dd($cart);

                // Cập nhật trường mgg_SoLuongMa
                $newSoLuongMa = $cou['mgg_SoLuongMa'] - 1;
                MaGiamGia::where('id', $cou['id'])
                    ->update(['mgg_SoLuongMa' => $newSoLuongMa]);

            } else {
                $tien_end = $total + $phi;

                $cart = new PhieuDatHang;
                $cart->khach_hang_id = $id;
                $cart->pdh_GhiChu = $data_get['pdh_GhiChu'];
                $cart->pdh_DiaChiGiao = $pdh_DiaChiGiao;
                $cart->pdh_NgayDat = $today;
                $cart->pdh_TongTien = $tien_end;
                $cart->pdh_TrangThai = 1;
                $cart->phuong_thuc_thanh_toan_id = $data_get['phuong_thuc_thanh_toan_id'];
                $cart->save();
                //dd($cart);
            }

            $customer = KhachHang::find($id);
            //$customer->kh_Ten = $customer->kh_Ten;
            $customer->kh_SoDienThoai = $data_get['kh_SoDienThoai'];
            //$tien = $customer->kh_TongTienDaMua;
            //$customer->kh_TongTienDaMua = $tien + $tien_end;
            $customer->save();

            foreach ($products as $product) {
                DB::table('chi_tiet_phieu_dat_hangs')->insert([
                    'phieu_dat_hang_id' => $cart->id,
                    'san_pham_id' => $product->id,
                    'ctpdh_SoLuong' => $carts[$product->id],
                    'ctpdh_Gia' => $product->sp_Gia
                ]);
            }

//            $name = "Nhựt Linh";
//            Mail::send('front-end.email_order', compact('name'), function ($email) use ($name) {
//                $email->subject('Balo');
//                $email->to('trannhutlinh0925@gmail.com', $name);
//            });

            if ($coupons == true) {
                Session::forget('coupon');
            }

            DB::commit();
            session()->forget('carts');
            session()->forget('total_paypal');
            session()->forget('data_get');
        } else {
            return redirect()
                ->route('user.checkout')
                ->with('flash_message_error', $response['message'] ?? 'Lỗi thanh toán.');
        }

        Session::flash('flash_message_checkout', 'Đặt hàng thành công!');
        return redirect('/shop');
    }

    public function cancelTransaction(Request $request){
        return redirect()->route('user.showcheckout');
    }

    public function handleVnPayCallback(Request $request){
        //dd($request);
        $postData = $request->all();
        //dd($postData);
        $total = 0;
        $carts = Session::get('carts');
        $coupons = Session::get('coupon');
        $productId = array_keys($carts);

        // Lấy thông tin sản phẩm từ giỏ hàng
        foreach ($carts as $product_id => $quantity_purchased) {
            $product = SanPham::find($product_id);
            if ($product) {
                $new_quantity_in_stock = max(0, $product->sp_SoLuongHang - $quantity_purchased);
                $new_quantity_sold = $product->sp_SoLuongBan + $quantity_purchased;
                $product->sp_SoLuongHang = $new_quantity_in_stock;
                $product->sp_SoLuongBan = $new_quantity_sold;
                $product->save();
                $carts[$product_id] = $quantity_purchased;
            }
        }
        session()->put('carts', $carts);

        $products = SanPham::select('id', 'SP_TenSanPham', 'sp_Gia', 'sp_AnhDaiDien', 'sp_SoLuongHang', 'sp_SoLuongBan')
            ->where('sp_TrangThai', 1)
            ->whereIn('id', $productId)
            ->get();

        foreach ($products as $product) {
            $price = $product->sp_Gia;
            $priceEnd = $price * $carts[$product->id];
            $total += $priceEnd;
        }

        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $id_tk = $request->user()->id;
        $id_kh = KhachHang::where('tai_khoan_id', $id_tk)->get();
        $id = $id_kh->first()->id;

        $id_dc = $postData['dc_DiaChi'];
        $dc = DiaChi::find($id_dc);
        $pdh_DiaChiGiao = $dc->dc_DiaChi;

        $id_tp = $dc->tinh_thanh_pho_id;
        $pvc = PhiVanChuyen::where('thanh_pho_id', $id_tp)->get();
        $phi = $pvc[0]['pvc_PhiVanChuyen'];

        $today = Carbon::now()->toDateString();

        // Xử lý callback từ VNPAY
        if (isset($_GET['vnp_ResponseCode'])) {
            $vnp_ResponseCode = $_GET['vnp_ResponseCode'];
            // Kiểm tra xem thanh toán VNPAY có thành công hay không (mã trạng thái 00 là thành công)
            if ($vnp_ResponseCode === '00') {
                if ($coupons) {
                    foreach ($coupons as $key => $cou)
                        if ($cou['mgg_LoaiGiamGia'] == 2) {
                            $total_coupon = ($total * $cou['mgg_GiaTri']) / 100;
                            $tien_end = $total - $total_coupon + $phi;
                        } elseif ($cou['mgg_LoaiGiamGia'] == 1) {
                            $tien_end = $total - $cou['mgg_GiaTri'] + $phi;
                        }
                    $cart = new PhieuDatHang;
                    $cart->khach_hang_id = $id;
                    $cart->ma_giam_gia_id = $coupons[0]['id'];
                    $cart->pdh_GhiChu = $request->pdh_GhiChu;
                    $cart->pdh_GiamGia = $coupons[0]['mgg_MaGiamGia'];
                    $cart->pdh_DiaChiGiao = $pdh_DiaChiGiao;
                    $cart->pdh_NgayDat = $today;
                    $cart->pdh_TongTien = $tien_end;
                    $cart->pdh_TrangThai = 1;
                    $cart->phuong_thuc_thanh_toan_id = $request->phuong_thuc_thanh_toan_id;
                    $cart->save();

                    // Cập nhật trường mgg_SoLuongMa
                    $newSoLuongMa = $cou['mgg_SoLuongMa'] - 1;
                    MaGiamGia::where('id', $cou['id'])
                        ->update(['mgg_SoLuongMa' => $newSoLuongMa]);

                } else {
                    $tien_end = $total + $phi;

                    $cart = new PhieuDatHang;
                    $cart->khach_hang_id = $id;
                    $cart->pdh_GhiChu = $request->pdh_GhiChu;
                    $cart->pdh_DiaChiGiao = $pdh_DiaChiGiao;
                    $cart->pdh_NgayDat = $today;
                    $cart->pdh_TongTien = $tien_end;
                    $cart->pdh_TrangThai = 1;
                    $cart->phuong_thuc_thanh_toan_id = $request->phuong_thuc_thanh_toan_id;
                    $cart->save();
                }
                $customer = KhachHang::find($id);
                //$customer->kh_Ten = $customer->kh_Ten;
                $customer->kh_SoDienThoai = $request->kh_SoDienThoai;
                //$tien = $customer->kh_TongTienDaMua;
                //$customer->kh_TongTienDaMua = $tien + $tien_end;
                $customer->save();

                foreach ($products as $product) {
                    DB::table('chi_tiet_phieu_dat_hangs')->insert([
                        'phieu_dat_hang_id' => $cart->id,
                        'san_pham_id' => $product->id,
                        'ctpdh_SoLuong' => $carts[$product->id],
                        'ctpdh_Gia' => $product->sp_Gia
                    ]);
                }

//                $name = "Nhựt Linh";
//                Mail::send('front-end.email_order', compact('name'), function ($email) use ($name) {
//                    $email->subject('Balo');
//                    $email->to('trannhutlinh0925@gmail.com', $name);
//                });

                if ($coupons == true) {
                    Session::forget('coupon');
                }

                DB::commit();
                //session()->flash('flash_message', 'Đặt hàng thành công');
                session()->forget('carts');
                session()->forget('total_paypal');
                session()->forget('data_get');
            }
        }
//        else{
//            return redirect()->route('showcheckout');
//        }

        Session::flash('flash_message_checkout', 'Đặt hàng thành công!');
        return redirect('/shop');
    }

    public function check_coupon(Request $request){
    //dd($request);
        $now = \Carbon\Carbon::now('Asia/Ho_Chi_Minh');
        $data = $request->all();
        $coupon = MaGiamGia::where('mgg_MaGiamGia',$data['coupon'])
                            ->where(\DB::raw('DATE(mgg_NgayKetThuc)'), '>=', $now->toDateString())
                           ->first();
        //dd($coupon);
        if($coupon){
            $count_coupon = $coupon->count();
            //dd($count_coupon);
            if($count_coupon>0){
                $coupon_session = Session::get('coupon');
                //dd($coupon_session);
                if($coupon_session == true){
                    $is_avaiable = 0;
                    if($is_avaiable==0){
                        $cou[] = array(
                            'id' => $coupon->id,
                            'mgg_MaGiamGia' => $coupon->mgg_MaGiamGia,
                            'mgg_SoLuongMa' => $coupon->mgg_SoLuongMa,
                            'mgg_LoaiGiamGia' => $coupon->mgg_LoaiGiamGia,
                            'mgg_GiaTri' => $coupon->mgg_GiaTri,
                        );
                        //dd($cou);
                        session()->put('coupon',$cou);
                    }
                }else{
                    $cou[] = array(
                        'id' => $coupon->id,
                        'mgg_MaGiamGia' => $coupon->mgg_MaGiamGia,
                        'mgg_SoLuongMa' => $coupon->mgg_SoLuongMa,
                        'mgg_LoaiGiamGia' => $coupon->mgg_LoaiGiamGia,
                        'mgg_GiaTri' => $coupon->mgg_GiaTri,
                    );
                    //dd($cou);
                      session()->put('coupon',$cou);

                }
                Session::save();
                Session::flash('flash_message', 'Thêm mã giảm giá thành công');
                return redirect()->back();
            }

        }else{
            Session::flash('flash_message_error', 'Mã giảm giá không đúng hoặc hết hạn');
            return redirect()->back();
        }
    }

    public function delete_coupon(){
        $coupon = Session::get('coupon');
        if($coupon == true){
            Session::forget('coupon');
            Session::flash('flash_message', 'Xóa mã giảm giá thành công');
            return redirect()->back();
        }
    }

     public function show_DonHang(Request $request, $id){
//        dd($request);
         if(Auth::check()){
             $id_kh = Auth::user()->id;
             $khachhang = KhachHang::where('tai_khoan_id', $id_kh)->first();
             $id_kh = $khachhang->id;
             $carts = $this->cartService->getProduct();
             $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();

             if ($request->ajax())
             {
                 $khach_hang_id = $id;
                 $data = DB::table('phieu_dat_hangs')
                     ->where('khach_hang_id','=',$khach_hang_id)
//                     ->orderby('id','desc')
                     ->get();
                 //dd($data);
                 return Datatables::of($data)
                     ->addIndexColumn()
                     ->make(true);
             }

             return view('front-end.purchase_order',[
                 'khachhang' => $khachhang,
                 'carts' => $carts,
                 'gh' => session()->get('carts'),
//                 'get_cart' => $get_cart,
                 'wish_count' => $wish_count,
             ]);
         }
     }



    public function show_ChitietDonhang($id){
        if(Auth::check()) {
            $id_tk = Auth::user()->id;
            //dd($id_kh);8
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            //dd($khachhang);
            $id_kh = $khachhang->id;
            //dd($id_kh);
            $carts = $this->cartService->getProduct();
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();
            //dd($wish_count);

            $pdh = PhieuDatHang::find($id);

            $kh = KhachHang::find($id_kh);

            $id_mgg = $pdh->ma_giam_gia_id;
            //dd($id_mgg);
            $mgg = MaGiamGia::find($id_mgg);
            //dd($mgg);

            $dc = PhieuDatHang::join('khach_hangs', 'khach_hangs.id', '=', 'phieu_dat_hangs.khach_hang_id')
                ->join('dia_chis','khach_hangs.id','=', 'dia_chis.khach_hang_id')
                ->select('dia_chis.*')
                ->where('phieu_dat_hangs.khach_hang_id', '=', $id_kh)
                ->whereColumn('phieu_dat_hangs.pdh_DiaChiGiao', '=', 'dia_chis.dc_DiaChi')
                ->get();
            //dd($dc);

            $id_tp = $dc[0]['tinh_thanh_pho_id'];
            //dd($id_tp);
            $phiVanChuyen = PhiVanChuyen::where('thanh_pho_id', $id_tp)->first();
            $phi = $phiVanChuyen->pvc_PhiVanChuyen;

            $cart_id = DB::table('chi_tiet_phieu_dat_hangs')
                ->join('san_phams', 'chi_tiet_phieu_dat_hangs.san_pham_id', '=', 'san_phams.id')
                ->select('chi_tiet_phieu_dat_hangs.*', 'san_phams.*')
                ->where('chi_tiet_phieu_dat_hangs.phieu_dat_hang_id', '=', $id)
                ->get();
        }

        return view('front-end.detail_order2',[
            'khachhang' => $khachhang,
            'carts' => $carts,
            'gh' => session()->get('carts'),
            'wish_count' => $wish_count,

            'pdh' => $pdh,
            'kh' => $kh,
            'cart_id' => $cart_id,
            'mgg' => $mgg,
            'phi' => $phi,
            'id_kh' => $id_kh
        ]);
    }

    public function order_update(Request $request, $id){
        $data = $request->all();
        $order = PhieuDatHang::find($id);
        //dd($order);

        $order_date = $order->pdh_NgayDat;
        $thongke = ThongKe::where('tk_Ngay',$order_date)->get();

        if($thongke){
            $thongke_dem = $thongke->count();
        }else{
            $thongke_dem = 0;
        }

        $newStatus = $request->input('pdh_TrangThai');

        if($newStatus == 5){
            foreach ($order->chitietphieudathang as $detail) {
                $product = $detail->sanpham;
                //dd($product);
                if ($product) {
                    $product->sp_SoLuongHang += $detail->ctpdh_SoLuong;
                    $product->sp_SoLuongBan -= $detail->ctpdh_SoLuong;
                    $product->save();
                }
            }
            //$order->save();
            $order->pdh_TrangThai = $newStatus;
            $order->save();
        }elseif($newStatus == 4) {
            $total_order = 0; //tong so luong don
            $sales = 0; //doanh thu
            $profit = 0; //loi nhuan
            $quantity = 0; //so luong

            foreach ($order->chitietphieudathang as $detail){
                $product = $detail->sanpham;
                //dd($product);
                $quantity += $detail->ctpdh_SoLuong;
                //dd($quantity);
                $sales += $detail->ctpdh_Gia * $detail->ctpdh_SoLuong;
                //dd($sales);
                $profit = $sales - 100000;
            }
            $total_order += 1;

            if($thongke_dem > 0){
                $thongke_capnhat = ThongKe::where('tk_Ngay',$order_date)->first();
                $thongke_capnhat->tk_TongTien = $thongke_capnhat->tk_TogTien + $sales;
                $thongke_capnhat->tk_LoiNhuan = $thongke_capnhat->tk_LoiNhuan + $profit;
                $thongke_capnhat->tk_SoLuong = $thongke_capnhat->tk_SoLuong + $quantity;
                $thongke_capnhat->tk_TongDonHang = $thongke_capnhat->tk_TongDonHang + $total_order;
                $thongke_capnhat->save();
            }else{
                $thongke_moi = new ThongKe();
                $thongke_moi->tk_Ngay = $order_date;
                $thongke_moi->tk_SoLuong = $quantity;
                $thongke_moi->tk_TongTien = $sales;
                $thongke_moi->tk_LoiNhuan = $profit;
                $thongke_moi->tk_TongDonHang = $total_order;
                $thongke_moi->save();
            }

            $order->pdh_TrangThai = $newStatus;
            $order->save();

            $id_kh = $order->khach_hang_id;
            $tien_hang = $order->pdh_TongTien;
            $customer = KhachHang::find($id_kh);
            $tien = $customer->kh_TongTienDaMua;
            $customer->kh_TongTienDaMua = $tien + $tien_hang;
            $customer->save();


        }else{

        }
        Session::flash('flash_message', 'Cập nhật trạng thái thành công!');
        return redirect()->back();
    }

    public function cancel(Request $request, $id){
        $order = PhieuDatHang::find($id);
            foreach ($order->chitietphieudathang as $detail) {
                $product = $detail->sanpham;
                //dd($product);
                if ($product) {
                    $product->sp_SoLuongHang += $detail->ctpdh_SoLuong;
                    $product->sp_SoLuongBan -= $detail->ctpdh_SoLuong;
                    $product->save();
                }
            }
            $order->pdh_TrangThai = 5;
            $order->save();
        Session::flash('flash_message', 'Cập nhật trạng thái thành công!');
        return redirect()->back();
    }

    public function success(Request $request, $id){
        $order = PhieuDatHang::find($id);
        //dd($order);

        $order_date = $order->pdh_NgayDat;
        $thongke = ThongKe::where('tk_Ngay',$order_date)->get();

        if($thongke){
            $thongke_dem = $thongke->count();
        }else{
            $thongke_dem = 0;
        }

        $total_order = 0; //tong so luong don
        $sales = 0; //doanh thu
        $profit = 0; //loi nhuan
        $quantity = 0; //so luong

        foreach ($order->chitietphieudathang as $detail){
            $product = $detail->sanpham;
            //dd($product);
            $quantity += $detail->ctpdh_SoLuong;
            //dd($quantity);
            $sales += $detail->ctpdh_Gia * $detail->ctpdh_SoLuong;
            //dd($sales);
            $profit = $sales - 100000;
        }
        $total_order += 1;

        if($thongke_dem > 0){
            $thongke_capnhat = ThongKe::where('tk_Ngay',$order_date)->first();
            $thongke_capnhat->tk_TongTien = $thongke_capnhat->tk_TogTien + $sales;
            $thongke_capnhat->tk_LoiNhuan = $thongke_capnhat->tk_LoiNhuan + $profit;
            $thongke_capnhat->tk_SoLuong = $thongke_capnhat->tk_SoLuong + $quantity;
            $thongke_capnhat->tk_TongDonHang = $thongke_capnhat->tk_TongDonHang + $total_order;
            $thongke_capnhat->save();
            //dd($thongke_capnhat);
        }else{
            $thongke_moi = new ThongKe();
            $thongke_moi->tk_Ngay = $order_date;
            $thongke_moi->tk_SoLuong = $quantity;
            $thongke_moi->tk_TongTien = $sales;
            $thongke_moi->tk_LoiNhuan = $profit;
            $thongke_moi->tk_TongDonHang = $total_order;
            $thongke_moi->save();
            //dd($thongke_moi);
        }

        $order->pdh_TrangThai = 4;
        $order->save();

        $id_kh = $order->khach_hang_id;
        $tien_hang = $order->pdh_TongTien;
        $customer = KhachHang::find($id_kh);
        $tien = $customer->kh_TongTienDaMua;
        $customer->kh_TongTienDaMua = $tien + $tien_hang;
        //dd($customer);
        $customer->save();

        $pdh = PhieuDatHang::find($id);
        $id_kh = $pdh->khach_hang_id;
//        $kh = KhachHang::find($id_kh);
        $id_tk = $customer->tai_khoan_id;
        $tk = TaiKhoan::find($id_tk);
        $email = $tk->email;
        $title_mail = "Thông báo giao hàng thành công";

        $mailData = [
            'id_pdh' => $pdh->id,
            'kh_Ten' => $customer->kh_Ten,
        ];

        Mail::send('front-end.email_delivery', [$email,'mailData' => $mailData], function ($message) use ($email,$title_mail) {
            $message->to($email)->subject($title_mail);
            $message->from($email, $title_mail);
        });

        Session::flash('flash_message', 'Cập nhật trạng thái thành công!');
        return redirect()->back();
    }

    public function add_feedback(Request $request, $id){
        //dd($request);

        $this -> validate($request, [
            'ph_MucPhanHoi' => 'required|max:255',
        ],
            [
                'ph_MucPhanHoi.required' => 'Vui lòng nhập nội dung phản hồi',
//                'dg_MucDanhGia.min' => 'Đánh giá phải lớn hơn 1 kí tự',
                'ph_MucPhanHoi.max' => 'Phản hồi phải nhỏ hơn 255 kí tự',
            ]);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        if(Auth::check()){
            $id = Auth::user()->id;
            //dd($id);
            $khachhang = KhachHang::where('tai_khoan_id', $id)->first();
            $id_kh = $khachhang->id;

            $ph = new PhanHoi();
            $ph->khach_hang_id = $id_kh;
            $ph->phieu_dat_hang_id = $request->id_pdh;
            $ph->ph_MucPhanHoi = $request->ph_MucPhanHoi;
            $ph->ph_TrangThai = 1;
            $ph->save();
            //dd($ph);

            Session::flash('success_message_feedback', 'Thêm phản hồi thành công!');
            return redirect()->back();
        }
    }




}
