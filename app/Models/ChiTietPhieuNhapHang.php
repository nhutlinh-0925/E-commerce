<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuNhapHang extends Model
{
    use HasFactory;

    protected $fillable = [
        'phieu_nhap_hang_id',
        'san_pham_id',
        'kich_thuoc_id',
        'ctpnh_SoLuongNhap',
        'ctpnh_GiaNhap'
    ];

    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }

    public function kichthuoc()
    {
        return $this->belongsTo(KichThuoc::class, 'kich_thuoc_id');
    }
}
