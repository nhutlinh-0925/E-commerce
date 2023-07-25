<?php

namespace App\Http\Services;

use App\Models\DiaChi;
use App\Models\PhiVanChuyen;
use App\Models\User;
use App\Models\SanPham;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Models\PhieuDatHang;
use App\Models\KhachHang;

use Mail;

use Illuminate\Support\Facades\Session;

use Carbon\Carbon;
class CartService
{
    //Hàm tạo giỏ hàng
    public function create($request)
    {
        $qty = (int)$request->input('num_product');
        // dd($qty);
        $product_id = (int)$request->input('product_id');
        // dd($product_id);
        if ($qty <= 0 || $product_id <= 0) {
            session()->flash('error', 'Số lượng hoặc sản phẩm không chính xác');
            return false;
        }
        $carts = session()->get('carts');
                        // dd($carts);
        if (is_null($carts)) {
            session()->put('carts', [$product_id => $qty]);
            return true;
        }

        // dd($carts);
    $exists = Arr::exists($carts, $product_id);
    if ($exists) {
        $carts[$product_id] = $carts[$product_id] + $qty;

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
        session()->put('carts', $request->input('num_product'));
        return true;
    }

    //Hàm xóa sản phẩm trong giỏ hàng
    public function remove($id)
    {
        $carts = session()->get('carts');
        // dd($carts);
        unset($carts[$id]);
        session()->put('carts', $carts);

        return true;
    }

    public function getUser()
    {
        return User::orderByDesc('id')->paginate(15);
    }

    //hàm post checkout
    public function getCart($request)
    {
//        dd($request);

        try{
            DB::beginTransaction();
            $total = 0;
            $carts = Session::get('carts');
//            dd($carts);
            $coupons = Session::get('coupon');
            //dd($coupons);
            $productId = array_keys($carts);

            $products =  SanPham::select('id', 'SP_TenSanPham', 'sp_Gia', 'sp_AnhDaiDien')
            ->where('sp_TrangThai', 1)
            ->whereIn('id', $productId)
            ->get();
             //dd($products);

            // $name = 'Nhựt Linh';
            // Mail::send('emails.test', compact('name'), function($email) use($name){
            // $email->subject('Balo OUTLET');
            // $email->to('linhb1910248@student.ctu.edu.vn', $name);
            // });

            foreach ($products as $product){
                $price = $product->sp_Gia;
                $priceEnd = $price * $carts[$product->id];
                $total += $priceEnd;
                //dd($total);
            }

            // Đặt múi giờ
            date_default_timezone_set('Asia/Ho_Chi_Minh');

            $id_tk = $request->user()->id;
            $id_kh = KhachHang::where('tai_khoan_id',$id_tk)->get();
            $id = $id_kh->first()->id;

            $id_dc = $request->dc_DiaChi;
            $dc = DiaChi::find($id_dc);
            //dd($dc);
            $pdh_DiaChiGiao = $dc->dc_DiaChi;

            $id_tp= $dc->tinh_thanh_pho_id;
            //dd($id_tp);
            $pvc = PhiVanChuyen::where('thanh_pho_id', $id_tp)->get();
            //dd($pvc);
            $phi = $pvc[0]['pvc_PhiVanChuyen'];
            //dd($phi);

            $today =  Carbon::now()->toDateString();
            //dd($today);

            if($coupons){
                //dd($coupons);
                foreach($coupons as $key => $cou)
                    if($cou['mgg_LoaiGiamGia'] == 2){
                        $total_coupon = ($total * $cou['mgg_GiaTri'])/100;
                        $tien_end = $total - $total_coupon + $phi;
                        //dd($tien_end);
                    }elseif($cou['mgg_LoaiGiamGia'] == 1){
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
                $cart->pdh_PhuongThucThanhToan = $request->pdh_PhuongThucThanhToan;
                $cart->save();
                //dd($cart);
            }else{
                $tien_end = $total + $phi;
                //dd($tien_end);

                $cart = new PhieuDatHang;
                $cart->khach_hang_id = $id;
                $cart->pdh_GhiChu = $request->pdh_GhiChu;
                $cart->pdh_DiaChiGiao = $pdh_DiaChiGiao;
                $cart->pdh_NgayDat = $today;
                $cart->pdh_TongTien = $tien_end;
                $cart->pdh_TrangThai = 1;
                $cart->pdh_PhuongThucThanhToan = $request->pdh_PhuongThucThanhToan;
                $cart->save();
                //dd($cart);
            }


            $customer = KhachHang::find($id);
            $customer->kh_Ten = $request->kh_Ten;
//            $request->validate([
//                'kh_SoDienThoai' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/']
//            ], [
//                'kh_SoDienThoai.required' => 'Vui lòng nhập số điện thoại',
//                'kh_SoDienThoai.regex' => 'Số điện thoại không đúng định dạng'
//            ]);
            $customer->kh_SoDienThoai = $request->kh_SoDienThoai;

            $tien = $customer->kh_TongTienDaMua;
            $customer->kh_TongTienDaMua = $tien + $tien_end;
            //dd($customer);
            $customer->save();


            //$cart->email = $request->email;


            foreach ($products as $product){
                DB::table('chi_tiet_phieu_dat_hangs')->insert([
                    'phieu_dat_hang_id' =>$cart->id,
                    'san_pham_id'=>$product->id,
                    'ctpdh_SoLuong' => $carts[$product->id],
                    'ctpdh_Gia' => $product->sp_Gia
                ]);
            }

            $name = "Nhựt Linh";
            Mail::send('front-end.email_order', compact('name'), function($email) use($name){
                $email->subject('Balo');
                $email->to('trannhutlinh0925@gmail.com', $name);
            });

            if($coupons == true){
                Session::forget('coupon');
            }

            DB::commit();
            session()->flash('flash_message', 'Đặt hàng thành công');
            session()->forget('carts');

        } catch (\Exception $err){
            DB::rollBack();
            session()->flash('flash_message_error', 'Đặt hàng lỗi, vui lòng thử lại');
            return false;

        }

        return true;
    }
}
