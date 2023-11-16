<?php

namespace App\Http\Controllers;

use App\Models\DiaChi;
use App\Models\KhachHang;
use App\Models\PhieuDatHang;
use App\Models\YeuThich;
use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;

use App\Models\ThuongHieu;
use Illuminate\Support\Facades\Auth;
use App\Models\NhanVien;
use Illuminate\Support\Facades\Session;

use App\Models\TinhThanhPho;
use App\Models\QuanHuyen;
use App\Models\XaPhuongThiTran;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
class KhachhangController extends Controller
{
    public function index(){
        $customers = KhachHang::all()->sortByDesc("id");

        return view('back-end.customer.index',[
            'customers' => $customers,
        ]);
    }

    public function create()
    {
        $cities = TinhThanhPho::all();
        $districts = QuanHuyen::all();
        $wards = XaPhuongThiTran::all();
        return view('back-end.customer.create',[
            'cities' => $cities,
            'districts' => $districts,
            'wards' => $wards
        ]);
    }

    public function store(Request $request)
    {
//         dd($request);
        $this -> validate($request, [
            'kh_Ten' => 'required',
            'email' => 'required|email',
            'city' => 'required',
            'province' => 'required',
            'wards' => 'required',
            'dc_DiaChi' => 'required',
            'password' => 'required|min:6',
            'password_again' => 'required|same:password',
            'kh_SoDienThoai' => 'required',
            'trangthai' => 'required',
            'avatar' => 'required',
        ],
            [
                'kh_Ten.required' => 'Vui lòng nhập họ tên',
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Không đúng định dạng email',
//                'email.unique' => 'Email đã được đăng kí',
                'city.required' => 'Vui lòng chọn thành phố',
                'province.required' => 'Hãy chọn quận huyện',
                'wards.required' => 'Vui lòng chọn xã phường',
                'dc_DiaChi.required' => 'Vui lòng nhập địa chỉ cụ thể',
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.min' => 'Mật khẩu ít nhất 5 kí tự',
                'password_again.required' => 'Vui lòng nhập lại mật khẩu',
                'password_again.same' => 'Mật khẩu không giống nhau',
                'kh_SoDienThoai.required' => 'Vui lòng nhập số điện thoại',
                'trangthai.required' => 'Vui lòng chọn trạng thái',
                'avatar.required' => 'Vui lòng chọn avatar',
            ]);

        $khachhang = KhachHang::create([
            'kh_Ten' => $request->kh_Ten,
            'kh_SoDienThoai' => $request->kh_SoDienThoai,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'trangthai' => $request->trangthai,
            'vip' => 0
        ]);

        $dc = DiaChi::create([
            'khach_hang_id' => $khachhang->id,
            'tinh_thanh_pho_id' => $request->city,
            'dc_DiaChi' => $request->dc_DiaChi,
        ]);

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $image_name = $image->getClientOriginalName();
            $destination_path = 'public/images/avatar/customers';
            $path = $image->storeAs($destination_path, $image_name);

            // Gán giá trị của trường avatar là tên file hình ảnh
            $updateData = [
                'avatar' => $image_name,
            ];
        } else {
            // Không có hình ảnh được tải lên, giữ nguyên giá trị của trường avatar
            $updateData = [
                'avatar' => $khachhang->avatar,
            ];
        }

        $khachhang->update($updateData);

        Session::flash('flash_message', 'Thêm khách hàng thành công!');
        return redirect('/admin/customers');
    }

    public function active($id)
    {
        //        dd($id);
        $customer = KhachHang::find($id)
            ->update(
                ['trangthai' => 1],
            );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/customers');
    }

    public function unactive($id)
    {
//        dd($id);
        $customer = KhachHang::find($id)
            ->update(
                ['trangthai' => 0],
            );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/customers');
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

    public function show($id){
        $customer = KhachHang::find($id);
        $address = DiaChi::where('khach_hang_id', $id)->get();
        $order = PhieuDatHang::where('khach_hang_id', $id)->orderBy('id', 'desc')->get();
        $wish = YeuThich::where('khach_hang_id',$id)->with('sanpham')->orderBy('id', 'desc')->get();

        return view('back-end.customer.show',[
            'customer' => $customer,
            'address' => $address,
            'order' => $order,
            'wish' => $wish
        ]);
    }

//    public function index1(){
//        if(Auth::check()){
//            $id_nv = Auth::user()->id;
//            $nhanvien = NhanVien::->first();
//            // dd($nhanvien);
//        }
//        $brands = ThuongHieu::all()->sortByDesc("id");
//        return view('back-end.user.index2',[
//            'brands' => $brands,
//            'nhanvien' => $nhanvien
//            ]);
//    }

//    public function index2(){
//
//        return view('back-end.user.index');
//    }

    // public function getUsers(UsersDataTable $dataTable){
    //     return $dataTable->render('back-end.user.index');
    // }
    }
