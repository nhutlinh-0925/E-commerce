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
        'sp_ChatLieu',
        'sp_TrangThai',
        'sp_SoLuongBan',
        'sp_AnhDaiDien',
        'sp_Video',
        'sp_LuotXem',
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

    public function hinhanh()
    {
        return $this->hasMany(HinhAnh::class);
    }

    public function kichthuoc()
    {
        return $this->belongsToMany(KichThuoc::class, 'san_pham_kich_thuocs', 'san_pham_id', 'kich_thuoc_id');
    }

    public function sanphamkichthuoc()
    {
        return $this->hasMany(SanPhamKichThuoc::class, 'san_pham_id');
    }

    public function chitietphieunhaphang()
    {
        return $this->hasMany(ChiTietPhieuNhapHang::class, 'san_pham_id');
    }

}
