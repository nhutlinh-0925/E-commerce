<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuDatHang extends Model
{
    use HasFactory;

    protected $fillable = [
        'khach_hang_id',
        'nhan_vien_id',
        'pdh_DiaChiGiao',
        'thuong_hieu_id',
        'pdh_GhiChu',
        'pdh_GiamGia',
        'pdh_TrangThai',
        'pdh_PhuongThucThanhToan',
        'pdh_NgayDat',
        'pdh_TongTien',
    ];

}
