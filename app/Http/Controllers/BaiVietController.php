<?php

namespace App\Http\Controllers;

use App\Models\DanhMucBaiViet;
use App\Models\NhanVien;
use App\Models\BaiViet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class BaiVietController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }
        $posts = BaiViet::all()->sortByDesc("id");
        return view('back-end.post.index',[
            'posts' => $posts,
            'nhanvien' => $nhanvien
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }
        $category_posts = DanhMucBaiViet::all();
        // dd($category_posts);
        $data = [
            'category_posts' => $category_posts,
            'nhanvien' => $nhanvien
        ];

        return view('back-end.post.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::check()){
//            $id_nv = Auth::user()->id;
            //        dd($request);
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $this -> validate($request, [
                'bv_TieuDeBaiViet' => 'required',
                'bv_NoiDungNgan' => 'required',
                'bv_NoiDungChiTiet' => 'required',
                'danh_muc_bai_viet_id' => 'required',
                'bv_AnhDaiDien' => 'required'
            ],
                [
                    'bv_TieuDeBaiViet.required' => 'Vui lòng nhập tiêu đề bài viết',
                    'bv_NoiDungNgan.required' => 'Vui lòng nhập mô tả',
                    'bv_NoiDungChiTiet.required' => 'Vui lòng mô tả chi tiết',
                    'danh_muc_bai_viet_id.required' => 'Vui lòng chọn danh mục',
                    'bv_AnhDaiDien.required' => 'Vui lòng chọn hình ảnh'
                ]);

            $today =  Carbon::now()->toDateString();

            $input = $request->all();

            if($request->hasFile('bv_AnhDaiDien'))
            {
                $destination_path = 'public/images/posts';
                $image = $request->file('bv_AnhDaiDien');
                $image_name = $image->getClientOriginalName();
                $path = $request->file('bv_AnhDaiDien')->storeAs($destination_path,$image_name);

                $input['bv_AnhDaiDien'] = $image_name;
            }
            $id_tk = $request->user()->id;
            //dd($id_tk);
            $nhanvien = NhanVien::where('tai_khoan_id', $id_tk)->first();
            //dd($nhanvien);
            $id_nv = $nhanvien->id;

            $input['nhan_vien_id'] = $id_nv;
            $input['bv_LuotXem'] = 0;
            $input['bv_NgayTao'] = $today;

            $bv = BaiViet::create($input);

            Session::flash('flash_message', 'Thêm bài viết thành công!');
            return redirect('/admin/posts');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::check()){
            $id_nv = Auth::user()->id;
            $nhanvien = NhanVien::where('tai_khoan_id', $id_nv)->first();
            // dd($nhanvien);
        }
        $post = BaiViet::find($id);
        $category_posts = DanhMucBaiViet::all();
        return view('back-end.post.edit',[
            'post' => $post,
            'category_posts' => $category_posts,
            'nhanvien' => $nhanvien
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//         dd($request);
//        dd($id);
        $post = BaiViet::find($id);
        $input = $request->all();
        if($request->hasFile('bv_AnhDaiDien'))
        {
            $destination = 'public/images/posts'.$post->bv_AnhDaiDien;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $destination_path = 'public/images/posts';
            $image = $request->file('bv_AnhDaiDien');
            $image_name = $image->getClientOriginalName();
            $path = $request->file('bv_AnhDaiDien')->storeAs($destination_path,$image_name);

            $input['bv_AnhDaiDien'] = $image_name;
        }

        BaiViet::find($id)->update($input);

        Session::flash('flash_message', 'Cập nhật bài viết thành công!');
        return redirect('/admin/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            BaiViet::destroy($id);
            DB::commit();
            Session::flash('flash_message', 'Xoá bài viết thành công!');
            return redirect('/admin/posts');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('flash_message_error', 'Xóa bài viết thất bại!');
            return redirect()->back();
        }
    }
}
