<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaGiamGia extends Model
{
    use HasFactory;

    protected $fillable = [
        'mgg_TenGiamGia',
        'mgg_MaGiamGia',
        'mgg_SoLuongMa',
        'mgg_LoaiGiamGia',
        'mgg_GiaTri',
        'mgg_NgayBatDau',
        'mgg_NgayKetThuc',
    ];
}
