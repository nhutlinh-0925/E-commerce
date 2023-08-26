<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\MaGiamGia;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MaGiamGiaController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }

        $coupons = MaGiamGia::all()->sortByDesc("id");
        return view('back-end.coupon.index',[
            'coupons' => $coupons,
            'nhanvien' => $nhanvien,
        ]);
    }

    public function create()
    {
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }
        return view('back-end.coupon.create',[
            'nhanvien' => $nhanvien
        ]);
    }

    public function store(Request $request)
    {
//         dd($request);
        $this -> validate($request, [
            'mgg_TenGiamGia' => 'required',
            'mgg_MaGiamGia' => 'required',
            'mgg_SoLuongMa' => 'required',
            'mgg_LoaiGiamGia' => 'required',
            'mgg_NgayBatDau' => [
                'required',
                'date', // Đảm bảo định dạng ngày tháng hợp lệ
                'before:mgg_NgayKetThuc', // mgg_NgayBatDau phải trước mgg_NgayKetThuc
                'after_or_equal:' . now()->format('Y-m-d\TH:i'), // mgg_NgayBatDau phải sau hoặc bằng ngày và giờ hiện tại
            ],
            'mgg_NgayKetThuc' => [
                'required',
                'date', // Đảm bảo định dạng ngày tháng hợp lệ
                'after:' . now()->format('Y-m-d\TH:i'), // mgg_NgayKetThuc phải sau ngày và giờ hiện tại
            ],
            'mgg_GiaTri' => 'required',
        ],
            [
                'mgg_TenGiamGia.required' => 'Vui lòng nhập tên mã giảm giá',
                'mgg_MaGiamGia.required' => 'Vui lòng nhập mã giảm giá',
                'mgg_SoLuongMa.required' => 'Vui lòng nhập số lượng mã',
                'mgg_LoaiGiamGia.required' => 'Vui lòng chọn loại giảm giá',
                'mgg_NgayBatDau.required' => 'Vui lòng chọn ngày bắt đầu',
                'mgg_NgayBatDau.date' => 'Định dạng ngày không hợp lệ',
                'mgg_NgayBatDau.before' => 'Ngày bắt đầu phải trước ngày kết thúc',
                'mgg_NgayBatDau.after_or_equal' => 'Ngày bắt đầu phải sau hoặc bằng ngày và giờ hiện tại',
                'mgg_NgayKetThuc.required' => 'Vui lòng chọn ngày hết hạn',
                'mgg_NgayKetThuc.date' => 'Định dạng ngày không hợp lệ',
                'mgg_NgayKetThuc.after' => 'Ngày kết thúc phải sau ngày hiện tại',
                'mgg_GiaTri.required' => 'Vui lòng nhập giá trị giảm',
            ]);

        $mgg = new MaGiamGia();
        $mgg->mgg_TenGiamGia = $request->mgg_TenGiamGia;
        $mgg->mgg_MaGiamGia = $request->mgg_MaGiamGia;
        $mgg->mgg_SoLuongMa = $request->mgg_SoLuongMa;
        $mgg->mgg_LoaiGiamGia = $request->mgg_LoaiGiamGia;
        $mgg->mgg_NgayBatDau = $request->mgg_NgayBatDau;
        $mgg->mgg_NgayKetThuc = $request->mgg_NgayKetThuc;
        $mgg->mgg_GiaTri = $request->mgg_GiaTri;
        $mgg->save();

        Session::flash('flash_message', 'Thêm mã giảm giá thành công!');
        return redirect('/admin/coupons');
    }

    public function edit($id)
    {
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }
        $coupon = MaGiamGia::find($id);
        //dd($coupon);
        return view('back-end.coupon.edit',[
            'coupon' => $coupon,
            'nhanvien' => $nhanvien
        ]);
    }

    public function update(Request $request, $id)
    {
        //dd($requestData);
        $this -> validate($request, [
            'mgg_TenGiamGia' => 'required',
            'mgg_MaGiamGia' => 'required',
            'mgg_SoLuongMa' => 'required',
            'mgg_LoaiGiamGia' => 'required',
            'mgg_NgayBatDau' => [
                'required',
                'date', // Đảm bảo định dạng ngày tháng hợp lệ
                'before:mgg_NgayKetThuc', // mgg_NgayBatDau phải trước mgg_NgayKetThuc
                'after_or_equal:' . now()->format('Y-m-d\TH:i'), // mgg_NgayBatDau phải sau hoặc bằng ngày và giờ hiện tại
            ],
            'mgg_NgayKetThuc' => [
                'required',
                'date', // Đảm bảo định dạng ngày tháng hợp lệ
                'after:' . now()->format('Y-m-d\TH:i'), // mgg_NgayKetThuc phải sau ngày và giờ hiện tại
            ],
            'mgg_GiaTri' => 'required',
        ],
            [
                'mgg_TenGiamGia.required' => 'Vui lòng nhập tên mã giảm giá',
                'mgg_MaGiamGia.required' => 'Vui lòng nhập mã giảm giá',
                'mgg_SoLuongMa.required' => 'Vui lòng nhập số lượng mã',
                'mgg_LoaiGiamGia.required' => 'Vui lòng chọn loại giảm giá',
                'mgg_NgayBatDau.required' => 'Vui lòng chọn ngày bắt đầu',
                'mgg_NgayBatDau.date' => 'Định dạng ngày không hợp lệ',
                'mgg_NgayBatDau.before' => 'Ngày bắt đầu phải trước ngày kết thúc',
                'mgg_NgayBatDau.after_or_equal' => 'Ngày bắt đầu phải sau hoặc bằng ngày và giờ hiện tại',
                'mgg_NgayKetThuc.required' => 'Vui lòng chọn ngày hết hạn',
                'mgg_NgayKetThuc.date' => 'Định dạng ngày không hợp lệ',
                'mgg_NgayKetThuc.after' => 'Ngày kết thúc phải sau ngày hiện tại',
                'mgg_GiaTri.required' => 'Vui lòng nhập giá trị giảm',
            ]);
        $coupon = MaGiamGia::find($id);

        // Cập nhật thông tin mã giảm giá từ dữ liệu form
        $coupon->mgg_TenGiamGia = $request->mgg_TenGiamGia;
        $coupon->mgg_MaGiamGia = $request->mgg_MaGiamGia;
        $coupon->mgg_SoLuongMa = $request->mgg_SoLuongMa;
        $coupon->mgg_LoaiGiamGia = $request->mgg_LoaiGiamGia;
        $coupon->mgg_NgayBatDau = $request->mgg_NgayBatDau;
        $coupon->mgg_NgayKetThuc = $request->mgg_NgayKetThuc;
        $coupon->mgg_GiaTri = $request->mgg_GiaTri;
        $coupon->save();

        Session::flash('flash_message', 'Cập nhật mã giảm giá thành công!');
        return redirect('/admin/coupons');
    }

    public function show($id)
    {
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }

        $coupon = MaGiamGia::find($id);

        return view('back-end.coupon.show',[
            'nhanvien' => $nhanvien,
            'coupon' => $coupon,
        ]);
    }

    public function send_coupon_all($id){
        $customer = TaiKhoan::where('loai',2)->where('vip', '!=', 3)->get();
        //dd($customer);
        $title_mail = "Mã khuyến mãi shop BALO VIỆT";

        $data = [];
        foreach ($customer as $vip){
            $data['email'][] = $vip->email;
        }
        //dd($data);

        $coupon = MaGiamGia::find($id);
        //dd($coupon);

        $mailData = [
            'mgg_MaGiamGia' => $coupon->mgg_MaGiamGia,
            'mgg_SoLuongMa' => $coupon->mgg_SoLuongMa,
            'mgg_LoaiGiamGia' => $coupon->mgg_LoaiGiamGia,
            'mgg_GiaTri' => $coupon->mgg_GiaTri,
            'mgg_NgayBatDau' => $coupon->mgg_NgayBatDau,
            'mgg_NgayKetThuc' => $coupon->mgg_NgayKetThuc
        ];

        Mail::send('back-end.coupon.send_email', [$data,'mailData' => $mailData], function($message) use ($title_mail,$data,$mailData){
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'],$title_mail);
        });

        Session::flash('flash_message', 'Gửi mã giảm giá thành công!');
        return redirect('/admin/coupons');
    }

    public function send_coupon_vip($id){
        $customer_vip = TaiKhoan::where('loai',2)->where('vip','=',1)->get();
        //dd($customer_vip);
        //$now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        $title_mail = "Mã khuyến mãi shop BALO VIỆT";

        $data = [];
        foreach ($customer_vip as $vip){
            $data['email'][] = $vip->email;
        }
        //dd($data);

        $coupon = MaGiamGia::find($id);
        //dd($coupon);

        $mailData = [
            'mgg_MaGiamGia' => $coupon->mgg_MaGiamGia,
            'mgg_SoLuongMa' => $coupon->mgg_SoLuongMa,
            'mgg_LoaiGiamGia' => $coupon->mgg_LoaiGiamGia,
            'mgg_GiaTri' => $coupon->mgg_GiaTri,
            'mgg_NgayBatDau' => $coupon->mgg_NgayBatDau,
            'mgg_NgayKetThuc' => $coupon->mgg_NgayKetThuc
        ];

        Mail::send('back-end.coupon.send_email', [$data,'mailData' => $mailData], function($message) use ($title_mail,$data,$mailData){
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'],$title_mail);
        });

        Session::flash('flash_message', 'Gửi mã giảm giá thành công!');
        return redirect('/admin/coupons');
    }

    public function send_coupon($id){
        $customer_tt = TaiKhoan::where('loai',2)->where('vip','=','0')->get();
        //dd($customer_tt);

        $title_mail = "Mã khuyến mãi shop BALO VIỆT";

        $data = [];
        foreach ($customer_tt as $vip){
            $data['email'][] = $vip->email;
        }
        //dd($data);

        $coupon = MaGiamGia::find($id);
        //dd($coupon);

        $mailData = [
            'mgg_MaGiamGia' => $coupon->mgg_MaGiamGia,
            'mgg_SoLuongMa' => $coupon->mgg_SoLuongMa,
            'mgg_LoaiGiamGia' => $coupon->mgg_LoaiGiamGia,
            'mgg_GiaTri' => $coupon->mgg_GiaTri,
            'mgg_NgayBatDau' => $coupon->mgg_NgayBatDau,
            'mgg_NgayKetThuc' => $coupon->mgg_NgayKetThuc
        ];

        Mail::send('back-end.coupon.send_email', [$data,'mailData' => $mailData], function($message) use ($title_mail,$data,$mailData){
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'],$title_mail);
        });

        Session::flash('flash_message', 'Gửi mã giảm giá thành công!');
        return redirect('/admin/coupons');
    }

    public function destroy($id)
    {
        $coupon = MaGiamGia::find($id);
        // dd($coupon);
        try {
            DB::beginTransaction();

            $coupon->destroy($coupon->id);

            DB::commit();
            Session::flash('flash_message', 'Xóa mã giảm giá thành công!');
            return redirect('/admin/coupons');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('flash_message_error', 'Xóa mã giảm giá thất bại !');
            return redirect()->back();
        }
    }


}
