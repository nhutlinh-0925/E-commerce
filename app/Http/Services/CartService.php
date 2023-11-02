<?php

namespace App\Http\Services;

use App\Models\DiaChi;
use App\Models\PhiVanChuyen;
use App\Models\SanPhamKichThuoc;
use App\Models\User;
use App\Models\SanPham;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PhieuDatHang;
use App\Models\KhachHang;
use App\Models\KichThuoc;

use Mail;

use Illuminate\Support\Facades\Session;

use Carbon\Carbon;
use App\Models\MaGiamGia;
use Illuminate\Support\Facades\Redirect;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;

class CartService
{
    public function getProduct()
    {
        $carts = session()->get('carts');
        if (is_null($carts)) return [];

        $products = [];

        foreach ($carts as $cartItem) {
            $product = SanPham::select('san_phams.id', 'sp_TenSanPham', 'sp_Gia', 'sp_AnhDaiDien', 'kt_TenKichThuoc', 'kich_thuoc_id')
                ->join('san_pham_kich_thuocs', 'san_phams.id', '=', 'san_pham_kich_thuocs.san_pham_id')
                ->join('kich_thuocs', 'kich_thuocs.id', '=', 'san_pham_kich_thuocs.kich_thuoc_id')
                ->where('san_phams.id', $cartItem['product_id'])
                ->where('kich_thuocs.id', $cartItem['size'])
                ->first();

            if ($product) {
                $product->qty = $cartItem['qty'];
                $products[] = $product;
            }
        }

        return $products;
    }

    public function update(Request $request) {
        // Lấy giỏ hàng hiện tại từ session
        $carts = session()->get('carts');
        //dd($carts);
        $cart_qty = $request->input('cart_qty');
        //dd($cart_qty);

        foreach ($cart_qty as $product_id => $sizes) {
            foreach ($sizes as $size => $new_qty) {
                $product_id = (int)$product_id;
                $new_qty = (int)$new_qty;

                $spkt = SanPhamKichThuoc::where('san_pham_id', $product_id)->where('kich_thuoc_id',$size)->first();
                $slh = $spkt->spkt_soLuongHang;
                //dd($slh);
                if ($new_qty > $slh) {
                    Session::flash('flash_message_error_err', 'Số lượng sản phẩm lớn hơn trong kho!');
                    return redirect()->back();
                }

                // Tìm sản phẩm trong giỏ hàng dựa trên product_id và size
                foreach ($carts as $key => $item) {
                    //dd($item['size']);
                    if ($item['product_id'] == $product_id && $item['size'] == $size) {
                        $carts[$key]['qty'] = $new_qty;
                        session()->put('carts', $carts);
                        break;
                    }
                }
            }
        }
    }

    //Hàm xóa sản phẩm trong giỏ hàng
    public function remove($id, $size)
    {
        $carts = session()->get('carts');
        //dd($carts);
        // Tìm vị trí của phần tử cần xóa trong mảng
        $indexToRemove = null;
        foreach ($carts as $key => $cart) {
            if ($cart['product_id'] == $id && $cart['size'] == $size) {
                $indexToRemove = $key;
                break; // Đã tìm thấy phần tử cần xóa, dừng vòng lặp
            }
        }

        if ($indexToRemove !== null) {
            // Sử dụng array_splice để xóa phần tử khỏi mảng
            array_splice($carts, $indexToRemove, 1);

            // Lưu lại mảng đã chỉnh sửa vào session
            session()->put('carts', $carts);
            Session::flash('flash_message', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        }
        return true;
    }

    public function getUser()
    {
        return User::orderByDesc('id')->paginate(15);
    }

}
