<?php

namespace App\Http\Controllers;
use App\Http\Services\CartService;
use App\Models\PhieuDatHang;
use App\Models\PhiVanChuyen;
use App\Models\PhuongThucThanhToan;
use App\Models\SanPham;
use App\Models\SanPhamKichThuoc;
use App\Models\KhachHang;
use App\Models\MaGiamGia;
use App\Models\DiaChi;
use App\Models\YeuThich;
use App\Models\PhanHoi;
use App\Models\ThongKe;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mail;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use DataTables;
use Carbon\Carbon;

class CartController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    //Hàm thêm sp vào giỏ hàng ở trang chi tiết sp
    public function index(Request $request)
    {
        //dd($request);
        $qty = (int)$request->input('num_product');
        $product_id = (int)$request->input('product_id');
        $size = $request->product_size;

        $spkt = SanPhamKichThuoc::where('san_pham_id', $product_id)->where('kich_thuoc_id',$size)->first();
        $slh = $spkt->spkt_soLuongHang;

        if ($qty <= 0 || $product_id <= 0 || $qty > $slh) {
            Session::flash('flash_message_error_qty', 'Số lượng hoặc sản phẩm không chính xác!');
            return redirect()->back();
        }
        $carts = session()->get('carts');
        //dd($carts);

        if (is_null($carts)) {
            $product_info = [
                'product_id' => $product_id,
                'qty' => $qty,
                'size' => $size,
            ];
            $carts[] = $product_info;
            session()->put('carts', $carts);
        }

        $exists = false;
        foreach ($carts as $key => $item) {
            // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng dựa trên product_id và size
            if ($item['product_id'] == $product_id && $item['size'] == $size) {
                $exists = true;
                // Cập nhật số lượng nếu sản phẩm đã tồn tại
                $carts[$key]['qty'] += $qty;

                if ($carts[$key]['qty'] > $slh) {
                    session()->flash('flash_message_error', 'Số lượng sản phẩm lớn hơn trong kho');
                    return redirect()->back();
                }
                session()->put('carts', $carts);

            }
        }

        if (!$exists) {
            // Nếu sản phẩm không tồn tại trong giỏ hàng, thêm nó vào giỏ hàng
            $product_info = [
                'product_id' => $product_id,
                'qty' => $qty,
                'size' => $size,
            ];

            $carts[] = $product_info;
            session()->put('carts', $carts);
        }
        //dd($carts);

        return redirect('/carts');
    }

//    public function add_cart_shop(Request $request)
//    {
//        $result = $this->cartService->create($request);
//        // dd($result);
//        // dd(session()->get('carts'));
//        if ($result === false){
//            return redirect()->back();
//        }
//        // Lưu thông báo vào Session
//        Session::flash('success_message', 'Thêm giỏ hàng thành công!');
//        return redirect()->back();
//    }

    public function show()
    {
        if(Auth::check()){
            $id_kh = Auth('web')->user()->id;
            $products = $this->cartService->getProduct();
            $gh = session()->get('carts');
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();

            return view('front-end.cart', [
                // 'title' => 'Giỏ Hàng',
                'products' => $products,
                'gh' => $gh,
                'coupons' => session()->get('coupon'),
                'wish_count' => $wish_count
            ]);
        }else{
            $products = $this->cartService->getProduct();
            $gh = session()->get('carts');
            return view('front-end.cart', [
                // 'title' => 'Giỏ Hàng',
                'products' => $products,
                'gh' => $gh,
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

    public function remove($id = 0,$size = 0)
    {
        $this->cartService->remove($id,$size);

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
            $id_kh = Auth('web')->user()->id;
            $khachhang = KhachHang::find($id_kh);
            $products = $this->cartService->getProduct();

            $address = DiaChi::where('khach_hang_id', $id_kh)->get();
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();

            $payments = PhuongThucThanhToan::all();

            return view('front-end.checkout', [
                // 'title' => 'Giỏ Hàng',
                'products' => $products,
                'gh' => session()->get('carts'),
                'khachhang' => $khachhang,
                'coupons' => session()->get('coupon'),
                'address' => $address,
                'wish_count' => $wish_count,
                'payments' => $payments,
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
            foreach ($carts as $cart) {
                // Lấy thông tin từ mảng cart
                $product_id = $cart['product_id'];
                $quantity_purchased = $cart['qty'];

                // Truy vấn sản phẩm dựa trên $product_id
                $sanPham = SanPham::find($product_id);

                if ($sanPham) {
                    // Cập nhật sp_SoLuongBan trong model SanPham
                    $sanPham->sp_SoLuongBan += $quantity_purchased;
                    $sanPham->save();
                    $kichThuocId = $cart['size']; // Thay 'size' bằng trường chứa id kích thước
                    $spkt = SanPhamKichThuoc::where('san_pham_id', $product_id)
                        ->where('kich_thuoc_id', $kichThuocId)
                        ->first();

                    if ($spkt) {
                        $spkt->spkt_soLuongHang -= $quantity_purchased;
                        $spkt->save();
                    }
                }
            }

            // Lưu giỏ hàng đã cập nhật vào session
            session()->put('carts', $carts);

            $products = $this->cartService->getProduct();
            //dd($products);

            foreach ($products as $product) {
                $price = $product->sp_Gia;
                $quantity = $product->qty;
                $priceEnd = $price * $quantity;
                $total += $priceEnd;
            }

            // Đặt múi giờ
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $id_kh = Auth('web')->user()->id;

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
                    $submitButtonName = 'momo';
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
                        } elseif ($cou['mgg_LoaiGiamGia'] == 1) {
                            $tien_end = $total - $cou['mgg_GiaTri'] + $phi;
                        }
                    $cart = new PhieuDatHang;
                    $cart->khach_hang_id = $id_kh;
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
                    $cart->khach_hang_id = $id_kh;
                    $cart->pdh_GhiChu = $request->pdh_GhiChu;
                    $cart->pdh_DiaChiGiao = $pdh_DiaChiGiao;
                    $cart->pdh_NgayDat = $today;
                    $cart->pdh_TongTien = $tien_end;
                    $cart->pdh_TrangThai = 1;
                    $cart->phuong_thuc_thanh_toan_id = $request->phuong_thuc_thanh_toan_id;
                    $cart->save();
                    //dd($cart);
                }

                $customer = KhachHang::find($id_kh);
                $customer->kh_SoDienThoai = $request->kh_SoDienThoai;
                $customer->save();

                foreach ($products as $product) {
                    DB::table('chi_tiet_phieu_dat_hangs')->insert([
                        'phieu_dat_hang_id' => $cart->id,
                        'san_pham_id' => $product->id,
                        'kich_thuoc_id' => $product->kich_thuoc_id,
                        'ctpdh_SoLuong' => $product->qty,
                        'ctpdh_Gia' => $product->sp_Gia
                    ]);
                }

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
                            ->route('checkout')
//                            ->route('user.checkout')
                            ->with('flash_message_error', 'Lỗi thanh toán.');

                    } else {
                        return redirect()
//                            ->route('user.checkout')
                            ->route('checkout')
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
                    return redirect()->route('showcheckout');
//                    return redirect()->route('user.showcheckout');
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
            foreach ($carts as $cart) {
                // Lấy thông tin từ mảng cart
                $product_id = $cart['product_id'];
                $quantity_purchased = $cart['qty'];

                // Truy vấn sản phẩm dựa trên $product_id
                $sanPham = SanPham::find($product_id);

                if ($sanPham) {
                    // Cập nhật sp_SoLuongBan trong model SanPham
                    $sanPham->sp_SoLuongBan += $quantity_purchased;
                    $sanPham->save();
                    $kichThuocId = $cart['size']; // Thay 'size' bằng trường chứa id kích thước
                    $spkt = SanPhamKichThuoc::where('san_pham_id', $product_id)
                        ->where('kich_thuoc_id', $kichThuocId)
                        ->first();

                    if ($spkt) {
                        $spkt->spkt_soLuongHang -= $quantity_purchased;
                        $spkt->save();
                    }
                }
            }

            // Lưu giỏ hàng đã cập nhật vào session
            session()->put('carts', $carts);

            $products = $this->cartService->getProduct();

            foreach ($products as $product) {
                $price = $product->sp_Gia;
                $quantity = $product->qty;
                $priceEnd = $price * $quantity;
                $total += $priceEnd;
            }

            // Đặt múi giờ
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $id_kh = Auth('web')->user()->id;

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
                $cart->khach_hang_id = $id_kh;
                $cart->ma_giam_gia_id = $coupons[0]['id'];
                $cart->pdh_GhiChu = $data_get['pdh_GhiChu'];
                $cart->pdh_GiamGia = $coupons[0]['mgg_MaGiamGia'];
                $cart->pdh_DiaChiGiao = $pdh_DiaChiGiao;
                $cart->pdh_NgayDat = $today;
                $cart->pdh_TongTien = $tien_end;
                $cart->pdh_TrangThai = 1;
                $cart->phuong_thuc_thanh_toan_id = $data_get['phuong_thuc_thanh_toan_id'];
                $cart->save();

                // Cập nhật trường mgg_SoLuongMa
                $newSoLuongMa = $cou['mgg_SoLuongMa'] - 1;
                MaGiamGia::where('id', $cou['id'])
                    ->update(['mgg_SoLuongMa' => $newSoLuongMa]);

            } else {
                $tien_end = $total + $phi;

                $cart = new PhieuDatHang;
                $cart->khach_hang_id = $id_kh;
                $cart->pdh_GhiChu = $data_get['pdh_GhiChu'];
                $cart->pdh_DiaChiGiao = $pdh_DiaChiGiao;
                $cart->pdh_NgayDat = $today;
                $cart->pdh_TongTien = $tien_end;
                $cart->pdh_TrangThai = 1;
                $cart->phuong_thuc_thanh_toan_id = $data_get['phuong_thuc_thanh_toan_id'];
                $cart->save();
            }

            $customer = KhachHang::find($id_kh);
            $customer->kh_SoDienThoai = $data_get['kh_SoDienThoai'];
            $customer->save();

            foreach ($products as $product) {
                DB::table('chi_tiet_phieu_dat_hangs')->insert([
                    'phieu_dat_hang_id' => $cart->id,
                    'san_pham_id' => $product->id,
                    'kich_thuoc_id' => $product->kich_thuoc_id,
                    'ctpdh_SoLuong' => $product->qty,
                    'ctpdh_Gia' => $product->sp_Gia
                ]);
            }

            if ($coupons == true) {
                Session::forget('coupon');
            }

            DB::commit();
            session()->forget('carts');
            session()->forget('total_paypal');
            session()->forget('data_get');
        } else {
            return redirect()
//                ->route('user.checkout')
                ->route('checkout')
                ->with('flash_message_error', $response['message'] ?? 'Lỗi thanh toán.');
        }

        Session::flash('flash_message_checkout', 'Đặt hàng thành công!');
        return redirect('/shop');
    }

    public function cancelTransaction(Request $request){
        return redirect()->route('showcheckout');
//        return redirect()->route('user.showcheckout');
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
        foreach ($carts as $cart) {
            // Lấy thông tin từ mảng cart
            $product_id = $cart['product_id'];
            $quantity_purchased = $cart['qty'];

            // Truy vấn sản phẩm dựa trên $product_id
            $sanPham = SanPham::find($product_id);

            if ($sanPham) {
                // Cập nhật sp_SoLuongBan trong model SanPham
                $sanPham->sp_SoLuongBan += $quantity_purchased;
                $sanPham->save();
                $kichThuocId = $cart['size']; // Thay 'size' bằng trường chứa id kích thước
                $spkt = SanPhamKichThuoc::where('san_pham_id', $product_id)
                    ->where('kich_thuoc_id', $kichThuocId)
                    ->first();

                if ($spkt) {
                    $spkt->spkt_soLuongHang -= $quantity_purchased;
                    $spkt->save();
                }
            }
        }
        session()->put('carts', $carts);

        $products = $this->cartService->getProduct();

        foreach ($products as $product) {
            $price = $product->sp_Gia;
            $quantity = $product->qty;
            $priceEnd = $price * $quantity;
            $total += $priceEnd;
        }

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $id_kh = Auth('web')->user()->id;

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
                    $cart->khach_hang_id = $id_kh;
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
                    $cart->khach_hang_id = $id_kh;
                    $cart->pdh_GhiChu = $request->pdh_GhiChu;
                    $cart->pdh_DiaChiGiao = $pdh_DiaChiGiao;
                    $cart->pdh_NgayDat = $today;
                    $cart->pdh_TongTien = $tien_end;
                    $cart->pdh_TrangThai = 1;
                    $cart->phuong_thuc_thanh_toan_id = $request->phuong_thuc_thanh_toan_id;
                    $cart->save();
                }
                $customer = KhachHang::find($id_kh);
                $customer->kh_SoDienThoai = $request->kh_SoDienThoai;
                $customer->save();

                foreach ($products as $product) {
                    DB::table('chi_tiet_phieu_dat_hangs')->insert([
                        'phieu_dat_hang_id' => $cart->id,
                        'san_pham_id' => $product->id,
                        'kich_thuoc_id' => $product->kich_thuoc_id,
                        'ctpdh_SoLuong' => $product->qty,
                        'ctpdh_Gia' => $product->sp_Gia
                    ]);
                }

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

        if($coupon){
            $count_coupon = $coupon->count();
            if($count_coupon>0){
                $coupon_session = Session::get('coupon');
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
             $id_kh = Auth('web')->user()->id;
             $carts = $this->cartService->getProduct();
             $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();

             if ($request->ajax())
             {
                 $khach_hang_id = $id;
                 $data = DB::table('phieu_dat_hangs')
                     ->where('khach_hang_id','=',$khach_hang_id)
                     ->get();

                 return Datatables::of($data)
                     ->addIndexColumn()
                     ->make(true);
             }

             return view('front-end.purchase_order',[
                 'carts' => $carts,
                 'gh' => session()->get('carts'),
                 'wish_count' => $wish_count,
             ]);
         }
     }

    public function show_ChitietDonhang($id){
        if(Auth::check()) {
            $id_kh = Auth('web')->user()->id;

            $carts = $this->cartService->getProduct();
            $wish_count = YeuThich::where('khach_hang_id', $id_kh)->get();

            $pdh = PhieuDatHang::find($id);
            $kh = KhachHang::find($id_kh);
            $id_mgg = $pdh->ma_giam_gia_id;
            $mgg = MaGiamGia::find($id_mgg);

            $dc = PhieuDatHang::join('khach_hangs', 'khach_hangs.id', '=', 'phieu_dat_hangs.khach_hang_id')
                ->join('dia_chis','khach_hangs.id','=', 'dia_chis.khach_hang_id')
                ->select('dia_chis.*')
                ->where('phieu_dat_hangs.khach_hang_id', '=', $id_kh)
                ->whereColumn('phieu_dat_hangs.pdh_DiaChiGiao', '=', 'dia_chis.dc_DiaChi')
                ->get();

            $id_tp = $dc[0]['tinh_thanh_pho_id'];
            $phiVanChuyen = PhiVanChuyen::where('thanh_pho_id', $id_tp)->first();
            $phi = $phiVanChuyen->pvc_PhiVanChuyen;

            $feedback = PhanHoi::where('phieu_dat_hang_id',$pdh->id)->first();

            $cart_id = DB::table('chi_tiet_phieu_dat_hangs')
                ->join('san_phams', 'chi_tiet_phieu_dat_hangs.san_pham_id', '=', 'san_phams.id')
                ->join('kich_thuocs', 'chi_tiet_phieu_dat_hangs.kich_thuoc_id', '=', 'kich_thuocs.id')
                ->select('chi_tiet_phieu_dat_hangs.*', 'san_phams.*', 'kich_thuocs.*')
                ->where('chi_tiet_phieu_dat_hangs.phieu_dat_hang_id', '=', $id)
                ->get();
//            dd($cart_id);
        }

        return view('front-end.detail_order2',[
            'carts' => $carts,
            'gh' => session()->get('carts'),
            'wish_count' => $wish_count,
            'pdh' => $pdh,
            'kh' => $kh,
            'cart_id' => $cart_id,
            'mgg' => $mgg,
            'phi' => $phi,
            'id_kh' => $id_kh,
            'feedback' => $feedback,
            'order_id' => $id,
        ]);
    }

    public function cancel(Request $request, $id){
        $order = PhieuDatHang::find($id);
            foreach ($order->chitietphieudathang as $detail) {
                $product = $detail->sanpham;
                if ($product) {
                    $product->sp_SoLuongBan -= $detail->ctpdh_SoLuong;
                    $product->save();

                    // Truy vấn dữ liệu trong bảng san_pham_kich_thuocs
                    $spkt = SanPhamKichThuoc::where('san_pham_id', $product->id)
                        ->where('kich_thuoc_id', $detail->kichthuoc->id) // Thay kichthuoc bằng tên quan hệ trong model PhieuDatHang
                        ->first();

                    if ($spkt) {
                        // Cập nhật spkt_SoLuongHang bằng cách trừ đi ctpdh_SoLuong
                        $spkt->spkt_soLuongHang += $detail->ctpdh_SoLuong;
                        $spkt->save();
                        //dd($spkt);
                    }
                }
            }
            $order->pdh_TrangThai = 5;
            $order->save();
        Session::flash('flash_message', 'Cập nhật trạng thái thành công!');
        return redirect()->back();
    }

    public function success(Request $request, $id){
        $order = PhieuDatHang::find($id);

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
            $quantity += $detail->ctpdh_SoLuong;
            $sales += $detail->ctpdh_Gia * $detail->ctpdh_SoLuong;
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

        $order->pdh_TrangThai = 4;
        $order->pdh_TrangThaiGiaoHang = 2;
        $order->save();

        $id_kh = $order->khach_hang_id;
        $tien_hang = $order->pdh_TongTien;
        $customer = KhachHang::find($id_kh);
        $tien = $customer->kh_TongTienDaMua;
        $customer->kh_TongTienDaMua = $tien + $tien_hang;
        if ($customer->kh_TongTienDaMua > 5000000){
            $customer->vip = 1;
        }elseif($customer->kh_TongTienDaMua < 5000000){
            $customer->vip = 1;
        }
        $customer->save();

        $pdh = PhieuDatHang::find($id);
        $email = $customer->email;
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
            'ph_SoSao' => 'required',
            'ph_MucPhanHoi' => 'required|max:255',
        ],
            [
                'ph_SoSao.required' => 'Vui lòng chọn sao',
                'ph_MucPhanHoi.required' => 'Vui lòng nhập nội dung phản hồi',
//                'dg_MucDanhGia.min' => 'Đánh giá phải lớn hơn 1 kí tự',
                'ph_MucPhanHoi.max' => 'Phản hồi phải nhỏ hơn 255 kí tự',
            ]);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        if(Auth::check()){
            $id_kh = Auth('web')->user()->id;

            $ph = new PhanHoi();
            $ph->khach_hang_id = $id_kh;
            $ph->phieu_dat_hang_id = $request->id_pdh;
            $ph->ph_SoSao = $request->ph_SoSao;
            $ph->ph_MucPhanHoi = $request->ph_MucPhanHoi;
            $ph->ph_TrangThai = 1;
            $ph->save();

            Session::flash('success_message_feedback', 'Thêm phản hồi thành công!');
            return redirect()->back();
        }
    }

}
