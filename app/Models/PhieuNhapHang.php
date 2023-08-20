<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuNhapHang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nhan_vien_id',
        'nha_cung_cap_id',
        'pnh_NgayLapPhieu',
        'pnh_NgayXacNhan',
        'pnh_TongTien',
        'pnh_GhiChu',
        'pnh_TrangThai'
    ];

    public function nguoinhap()
    {
        return $this->hasOne(NhanVien::class, 'id', 'nhan_vien_id')
            ->withDefault(['nv_Ten' => '']);
    }

    public function nhacungcap()
    {
        return $this->hasOne(NhaCungCap::class, 'id', 'nha_cung_cap_id')
            ->withDefault(['ncc_TenNhaCungCap' => '']);
    }

}
