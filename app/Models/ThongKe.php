<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongKe extends Model
{
    use HasFactory;

    protected $fillable = [
        'tk_Ngay',
        'tk_SoLuong',
        'tk_TongTien',
        'tk_LoiNhuan',
        'tk_TongDonHang',
    ];
}
