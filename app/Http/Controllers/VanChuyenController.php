<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\PhiVanChuyen;
use Illuminate\Http\Request;
use App\Models\TinhThanhPho;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VanChuyenController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }
        $deliveries = PhiVanChuyen::all()->sortByDesc("id");
        return view('back-end.delivery.index',[
            'deliveries' => $deliveries,
            'nhanvien' => $nhanvien
        ]);
    }

    public function create()
    {
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }
        $cities = TinhThanhPho::all();
        return view('back-end.delivery.create',[
            'nhanvien' => $nhanvien,
            'cities' => $cities
        ]);
    }

    public function store(Request $request)
    {
//         dd($request);
        $this -> validate($request, [
            'pvc_PhiVanChuyen' => 'required',
            'thanh_pho_id' => 'required|unique:phi_van_chuyens'
        ],
            [
                'pvc_PhiVanChuyen.required' => 'Vui lòng nhập phí vận chuyển',
                'thanh_pho_id.required' => 'Vui lòng chọn thành phố',
                'thanh_pho_id.unique' => 'Thành phố đã tồn tại'
            ]);

        $city = TinhThanhPho::all();
        $city_id = $request->thanh_pho_id;
        $city_name = TinhThanhPho::find($city_id)->tp_Ten;
//        dd($city_name);

        $pvc = new PhiVanChuyen();
        $pvc->thanh_pho_id = $request->thanh_pho_id;
        $pvc->pvc_ThanhPho = $city_name;
        $pvc->pvc_PhiVanChuyen = $request->pvc_PhiVanChuyen;
        $pvc->save();
//        dd($pvc);

        Session::flash('flash_message', 'Thêm phí vận chuyển thành công!');
        return redirect('/admin/deliveries');
    }

    public function edit($id)
    {
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }

        $delivery = PhiVanChuyen::find($id);
        $cities = TinhThanhPho::all();

        return view('back-end.delivery.edit',[
            'delivery' => $delivery,
            'nhanvien' => $nhanvien,
            'cities' => $cities
        ]);
    }

    public function update(Request $request, $id){
        //dd($request);
        $this -> validate($request, [
            'pvc_PhiVanChuyen' => 'required',
        ],
            [
                'pvc_PhiVanChuyen.required' => 'Vui lòng nhập phí vận chuyển',
            ]);

        $delivery = PhiVanChuyen::find($id);
        //dd($delivery);

        $delivery->thanh_pho_id = $delivery->thanh_pho_id;
        $delivery->pvc_ThanhPho = $delivery->pvc_ThanhPho;
        $delivery->pvc_PhiVanChuyen = $request->pvc_PhiVanChuyen;
        $delivery->save();
        //dd($delivery);

        Session::flash('flash_message', 'Cập nhật phí vận chuyển thành công !');
        return redirect('/admin/deliveries');
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            PhiVanChuyen::destroy($id);
            DB::commit();
            Session::flash('flash_message', 'Xoá phí vận chuyển thành công!');
            return redirect('/admin/deliveries');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('flash_message_error', 'Xóa phí vận chuyển thất bại!');
            return redirect()->back();
        }
    }


}
