<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    use HasFactory;

    protected $fillable = [
        'sp_TenSanPham',
        'sp_Gia',
        'danh_muc_san_pham_id',
        'thuong_hieu_id',
        'sp_MoTa',
        'sp_NoiDung',
        'sp_VatLieu',
        'sp_TrangThai',
        'sp_SoLuongHang',
        'sp_SoLuongBan',
        'sp_AnhDaiDien',
        'sp_LuotXem',
        'sp_MauSac',
        'sp_KichCo',
        'sp_Tag'

    ];

    public function danhmuc()
    {
        return $this->hasOne(DanhMucSanPham::class, 'id', 'danh_muc_san_pham_id')
                ->withDefault(['dmsp_TenDanhMuc' => '']);
    }

    public function thuonghieu()
    {
        return $this->hasOne(ThuongHieu::class, 'id', 'thuong_hieu_id')
                ->withDefault(['thsp_TenThuongHieu' => '']);
    }
}
