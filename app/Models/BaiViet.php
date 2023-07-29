<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    use HasFactory;

    protected $fillable = [
        'danh_muc_bai_viet_id',
        'nhan_vien_id',
        'bv_TieuDeBaiViet',
        'bv_NoiDungNgan',
        'bv_NoiDungChiTiet',
        'bv_AnhDaiDien',
        'bv_LuotXem',
        'bv_TrangThai',
        'bv_Tag',
        'bv_NgayTao'
    ];

    public function nguoidang()
    {
        return $this->hasOne(NhanVien::class, 'id', 'nhan_vien_id')
            ->withDefault(['nv_Ten' => '']);
    }
}
