<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPhamKichThuoc extends Model
{
    use HasFactory;

    protected $fillable = [
        'san_pham_id',
        'kich_thuoc_id',
        'spkt_SoLuongHang'
    ];

    public function kichthuoc()
    {
        return $this->belongsTo(KichThuoc::class, 'kich_thuoc_id');
    }
}
