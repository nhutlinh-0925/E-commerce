<?php


namespace App\Http\Services;

use App\Models\User;
use App\Models\SanPham;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Models\PhieuDatHang;
// use Mail;

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

    public function addCart($request)
    {
        try {
            DB::beginTransaction();
            $carts = session()->get('carts');
            dd($carts);
            if (is_null($carts)) return false;
            // dd($customer);

            // $this->infoProductCart($carts, $customer->id);
            DB::commit();
            session()->flash('success', 'Đặt hàng thành công');

            session()->forget('carts');

        } catch (\Exception $err){
            DB::rollBack();
            session()->flash('error', 'Đặt hàng lỗi, vui lòng thử lại');
            return false;

        }
        return true;
    }

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


    public function getProductForCart($user)
    {
        return $user->carts()->with(['product' => function ($query) {
            $query->select('id', 'name', 'thumb');
        }])->get();
    }

    public function getCart($request)
    {
        try{
            DB::beginTransaction();

            $total = 0;
            $carts = Session::get('carts');
            // dd($carts);
            $productId = array_keys($carts);

            $products =  Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $productId)
            ->get();
            // dd($products);

            // $name = 'Nhựt Linh';
            // Mail::send('emails.test', compact('name'), function($email) use($name){
            // $email->subject('Balo OUTLET');
            // $email->to('linhb1910248@student.ctu.edu.vn', $name);
            // });

            foreach ($products as $product){
                $price = $product->price_sale != 0 ? $product->price_sale : $product->price;
                $priceEnd = $price * $carts[$product->id];
                $total += $priceEnd;
            }

            $cart = new Cart;
            $cart->user_id = $request->user()->id;
            $cart->name = $request->name;
            $cart->phone = $request->phone;
            $cart->address = $request->address;
            $cart->email = $request->email;
            $cart->total = $total;
            $cart->active = 1;
            $cart->save();


            foreach ($products as $product){
                DB::table('detail_carts')->insert([
                    'cart_id' =>$cart->id,
                    'product_id'=>$product->id,
                    'pty' => $carts[$product->id],
                    'price' => $product->price_sale != 0 ? $product->price_sale : $product->price
                ]);
            }
            DB::commit();
            session()->flash('success', 'Đặt hàng thành công');

            session()->forget('carts');

        } catch (\Exception $err){
            DB::rollBack();
            session()->flash('error', 'Đặt hàng lỗi, vui lòng thử lại');
            return false;

        }

        return true;

    }



}
