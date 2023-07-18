<?php

namespace App\Http\Services;

use App\Models\User;
use App\Models\SanPham;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Models\PhieuDatHang;
use App\Models\KhachHang;

 use Mail;

use Illuminate\Support\Facades\Session;

class CartService
{
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

    public function update($request)
    {
        session()->put('carts', $request->input('num_product'));
        return true;
    }

    public function remove($id)
    {
        $carts = session()->get('carts');
        // dd($carts);
        unset($carts[$id]);
        session()->put('carts', $carts);

        return true;
    }

//    public function addCart($request)
//    {
//        try {
//            DB::beginTransaction();
//            $carts = session()->get('carts');
//            dd($carts);
//            if (is_null($carts)) return false;
//            // dd($customer);
//
//            // $this->infoProductCart($carts, $customer->id);
//            DB::commit();
//            session()->flash('success', 'Đặt hàng thành công');
//
//            session()->forget('carts');
//
//        } catch (\Exception $err){
//            DB::rollBack();
//            session()->flash('error', 'Đặt hàng lỗi, vui lòng thử lại');
//            return false;
//
//        }
//        return true;
//    }

    // protected function infoProductCart($carts, $user_id)
    // {
    //     $productId = array_keys($carts);
    //     $products =  Product::select('id', 'name', 'price', 'price_sale', 'thumb')
    //     ->where('active', 1)
    //     ->whereIn('id', $productId)
    //     ->get();

    //     $data = [];
    //     foreach ($products as $product){
    //         $data[] = [
    //             'user_id' => $user_id,
    //             'product_id' => $product->id,
    //             'pty' => $carts[$product->id],
    //             'price' => $product->price_sale != 0 ? $product->price_sale : $product->price
    //         ];
    //     }

    //     return Cart::insert($data);
    // }

    public function getUser()
    {
        return User::orderByDesc('id')->paginate(15);
    }


//    public function getProductForCart($user)
//    {
//        return $user->carts()->with(['product' => function ($query) {
//            $query->select('id', 'name', 'thumb');
//        }])->get();
//    }

    public function getCart($request)
    {
        try{
            DB::beginTransaction();
            $total = 0;
            $carts = Session::get('carts');
             dd($carts);
            $coupons = Session::get('coupon');
//        dd($coupons);
            $productId = array_keys($carts);

            $products =  SanPham::select('id', 'SP_TenSanPham', 'sp_Gia', 'sp_AnhDaiDien')
            ->where('sp_TrangThai', 1)
            ->whereIn('id', $productId)
            ->get();
//             dd($products);

            // $name = 'Nhựt Linh';
            // Mail::send('emails.test', compact('name'), function($email) use($name){
            // $email->subject('Balo OUTLET');
            // $email->to('linhb1910248@student.ctu.edu.vn', $name);
            // });

            foreach ($products as $product){
                $price = $product->sp_Gia;
                $priceEnd = $price * $carts[$product->id];
                $total += $priceEnd;
//                dd($total);
            }

            $id_tk = $request->user()->id;
            //dd($id_tk);
            $id_kh = KhachHang::where('tai_khoan_id',$id_tk)->get();
//            dd($id_kh);
            $id = $id_kh->first()->id;

            $cart = new PhieuDatHang;
            $cart->khach_hang_id = $id;
//            dd($cart);
            $cart->pdh_TongTien = $total;
//            dd($cart);
            $cart->pdh_TrangThai = 1;
//            dd($cart);
            $cart->save();
//            dd($cart);



            $customer = KhachHang::find($id);
//            dd($customer);
            $customer->kh_Ten = $request->kh_Ten;
//            dd($customer);
//            $request->validate([
//                'kh_SoDienThoai' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/']
//            ], [
//                'kh_SoDienThoai.required' => 'Vui lòng nhập số điện thoại',
//                'kh_SoDienThoai.regex' => 'Số điện thoại không đúng định dạng'
//            ]);

            $customer->kh_SoDienThoai = $request->kh_SoDienThoai;

            $tien = $customer->kh_TongTienDaMua;
            $customer->kh_TongTienDaMua = $tien + $total;
//            dd($customer);
            $customer->save();


//            $cart->email = $request->email;


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
