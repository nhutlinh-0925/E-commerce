<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ThanhTruotController extends Controller
{
    public function index()
    {
        $sliders = Slider::all()->sortByDesc("id");
        return view('back-end.slider.index',[
            'sliders' => $sliders,
        ]);
    }

    public function create()
    {
        return view('back-end.slider.create');
    }

    public function store(Request $request)
    {
        //dd($request);
        $this -> validate($request, [
            'sl_TieuDe' => 'required',
            'sl_TrangThai' => 'required',
            'sl_HinhAnh' => 'required'
        ],
            [
                'sl_TieuDe.required' => 'Vui lòng nhập tiêu đề',
                'sl_TrangThai.required' => 'Vui lòng chọn trạng thái',
                'sl_HinhAnh.required' => 'Vui lòng chọn hình ảnh'
            ]);

            $input = $request->all();

            if($request->hasFile('sl_HinhAnh'))
            {
                $destination_path = 'public/images/sliders';
                $image = $request->file('sl_HinhAnh');
                $image_name = $image->getClientOriginalName();
                $path = $request->file('sl_HinhAnh')->storeAs($destination_path,$image_name);

                $input['sl_HinhAnh'] = $image_name;
            }


            Slider::create($input);

            Session::flash('flash_message', 'Thêm slider thành công!');
            return redirect('/admin/sliders');
        }

    public function edit($id)
    {
        $slider = Slider::find($id);
        return view('back-end.slider.edit', [
            'slider' => $slider
        ]);
    }

    public function update(Request $request, $id)
    {
        $slider = Slider::find($id);
        $input = $request->all();
        if($request->hasFile('sl_HinhAnh'))
        {
            $destination = 'public/images/sliders'.$slider->sl_HinhAnh;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $destination_path = 'public/images/sliders';
            $image = $request->file('sl_HinhAnh');
            $image_name = $image->getClientOriginalName();
            $path = $request->file('sl_HinhAnh')->storeAs($destination_path,$image_name);

            $input['sl_HinhAnh'] = $image_name;
        }

        Slider::find($id)->update($input);

        Session::flash('flash_message', 'Cập nhật slider thành công!');
        return redirect('/admin/sliders');
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            Slider::destroy($id);
            DB::commit();
            Session::flash('flash_message', 'Xoá slider thành công!');
            return redirect('/admin/sliders');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('flash_message_error', 'Xóa slider thất bại!');
            return redirect()->back();
        }
    }

    public function active($id)
    {
        $slider = Slider::find($id)
            ->update(
                ['sl_TrangThai' => 0],
            );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/sliders');
    }

    public function unactive($id)
    {
        $slider = Slider::find($id)
            ->update(
                ['sl_TrangThai' => 1],
            );
        Session::flash('flash_message', 'Thay đổi trạng thái thành công!');
        return redirect('/admin/sliders');
    }
}
