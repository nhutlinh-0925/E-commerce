<?php

namespace App\Http\Controllers;

use App\Http\Services\AddressService;
use App\Http\Services\CartService;
use App\Models\DiaChi;
use App\Models\KhachHang;
use App\Models\QuanHuyen;
use App\Models\TaiKhoan;
use App\Models\TinhThanhPho;
use App\Models\XaPhuongThiTran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    protected $cartService;
    protected $addressService;

    public function __construct(CartService $cartService, AddressService $addressService)
    {
        $this->cartService = $cartService;
        $this->addressService = $addressService;
    }

    public function setting($id)
    {
        if (Auth::check()) {
            $id_tk = Auth::user()->id;
            //dd($id_kh);8
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            //dd($khachhang);
            $id_kh = $khachhang->id;
            //dd($id_kh);
            $carts = $this->cartService->getProduct();
            // dd($carts);
            $account = TaiKhoan::find($id_tk);
            //dd($account);
            $address = DiaChi::where('khach_hang_id', $id_kh)->get();
            //dd($address);
            $dc_md = DiaChi::where('khach_hang_id', $id)->where('dc_TrangThai', 1)->get();
            //dd($dc_md);
            $cities = TinhThanhPho::all();
            $districts = QuanHuyen::all();
            $wards = XaPhuongThiTran::all();

            return view('front-end.setting', [
                'khachhang' => $khachhang,
                'carts' => $carts,
                'gh' => session()->get('carts'),
                'account' => $account,
                'address' => $address,
                'dc_md' => $dc_md,
                'cities' => $cities,
                'districts' => $districts,
                'wards' => $wards
            ]);
        }
    }

    public function account(Request $request)
    {
//        dd($request);
        if (Auth::check()) {
            $id_tk = Auth::user()->id;
            //dd($id_tk);8
            $khachhang = KhachHang::where('tai_khoan_id', $id_tk)->first();
            //dd($khachhang);3
            $id_kh = $khachhang->id;

            $account = TaiKhoan::find($id_tk);

            $input = $request->all();

            $request->validate([
                'avatar' => 'required',
                'kh_Ten' => 'required',
                'email' => 'required',
                'kh_SoDienThoai' => 'required'
            ],
                [
                    'avatar.required' => 'Vui lòng chọn ảnh đại diện',
                    'kh_Ten.required' => 'Vui lòng nhập tên',
                    'email.required' => 'Vui lòng nhập email',
                    'kh_SoDienThoai.required' => 'Vui lòng nhập số điện thoại',
                ]);

            if ($request->hasFile('avatar')) {
                $destination = 'public/images/avatar/customers' . $account->avatar;
                if (File::exists($destination)) {
                    File::delete($destination);
                }

                $destination_path = 'public/images/avatar/customers';
                $image = $request->file('avatar');
                $image_name = $image->getClientOriginalName();
                $path = $request->file('avatar')->storeAs($destination_path, $image_name);

                $avatar = $image_name; // Gán giá trị mới cho biến $avatar
            } else {
                $avatar = $account->avatar; // Giữ nguyên giá trị của avatar hiện tại
            }

            // Chuẩn bị mảng dữ liệu cần cập nhật
            $updateData = [
                'email' => $request->email,
                'avatar' => $avatar,
            ];

            // Cập nhật thông tin vào Model TaiKhoan
            $account->update($updateData);

            // Cập nhật thông tin vào Model KhachHang
            $kh = KhachHang::find($id_kh);
            //dd($kh);
            $kh->update([
                'kh_Ten' => $request->kh_Ten,
                'kh_SoDienThoai' => $request->kh_SoDienThoai,
            ]);

//            $address = DiaChi::where('khach_hang_id', $id)->get();
            //dd($address);
//            foreach ($address as $ad) {
//                $ad->dc_TrangThai = ($ad->id == $request->dc_DiaChi) ? 1 : 0;
//                $ad->save();
//            }

            Session::flash('flash_message', 'Cập nhật hồ sơ thành công!');
            return redirect()->route('user.setting', ['id' => $id_kh]);
        }
    }

    public function add_address(Request $request)
    {
//        dd($request);
        if (Auth::check()) {
            $id = Auth::user()->id;
            $khachhang = KhachHang::where('tai_khoan_id', $id)->first();
            $id_kh = $khachhang->id;
            //dd($id_kh);
            $request->validate([
                'city' => 'required',
                'province' => 'required',
                'wards' => 'required',
                'dc_DiaChi' => 'required'
            ],
                [
                    'city.required' => 'Vui lòng chọn thành phố',
                    'province.required' => 'Vui lòng chọn quận huyện',
                    'wards.required' => 'Vui lòng chọn xã phường',
                    'dc_DiaChi.required' => 'Vui lòng nhập địa chỉ cụ thể',
                ]);

            $dc = new DiaChi();
            $dc->khach_hang_id = $id_kh;
            $dc->tinh_thanh_pho_id = $request->city;
            $dc->quan_huyen_id = $request->province;
            $dc->xa_phuong_thi_tran_id = $request->wards;
            $dc->dc_DiaChi = $request->dc_DiaChi;
            //$dc->dc_TrangThai = 0;
            $dc->save();
            //dd($dc);

            Session::flash('flash_message', 'Thêm địa chỉ thành công!');
            return redirect()->route('user.setting', ['id' => $id]);
        }
    }

    public function select_city(Request $request)
    {
        $data = $request->all();
        if ($data['action']) {
            $output = '';
            if ($data['action'] == "city") {
                $select_province = QuanHuyen::where('thanh_pho_id', $data['ma_id'])->orderby('id', 'ASC')->get();
                $output .= '<option>---Chọn quận huyện---</option>';
                foreach ($select_province as $key => $province) {
                    $output .= '<option value="' . $province->id . '">' . $province->qh_Ten . '</option>';
                }

            } else {

                $select_wards = XaPhuongThiTran::where('quan_huyen_id', $data['ma_id'])->orderby('id', 'ASC')->get();
                $output .= '<option>---Chọn xã phường---</option>';
                foreach ($select_wards as $key => $ward) {
                    $output .= '<option value="' . $ward->id . '">' . $ward->xptt_Ten . '</option>';
                }
            }
            echo $output;
        }

    }

    public function destroy_address(Request $request)
    {
        $result = $this->addressService->destroy($request);
        Session::flash('flash_message', 'Xóa địa chỉ thành công!');
    }

}


