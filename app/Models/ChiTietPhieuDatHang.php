<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuDatHang extends Model
{
    use HasFactory;

    protected $fillable = [
    	'phieu_dat_hang_id',
        'san_pham_id',
        'ctpdh_SoLuong',
        'ctpdh_Gia',
    ];

    public function sanpham() {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}
