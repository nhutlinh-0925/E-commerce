<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ĐanhGia extends Model
{
    use HasFactory;

    protected $fillable = [
        'khach_hang_id',
        'san_pham_id',
        'phieu_dat_hang_id',
        'dg_SoSao',
        'dg_MucDanhGia',
        'kichthuoc',
        'dg_TrangThai'
    ];

    public function khachhang()
    {
        return $this->hasOne(KhachHang::class, 'id', 'khach_hang_id')
            ->withDefault(['kh_Ten' => '']);
    }

    public function sanpham()
    {
        return $this->hasOne(SanPham::class, 'id', 'san_pham_id')
            ->withDefault(['sp_TenSanPham' => '']);
    }


}
