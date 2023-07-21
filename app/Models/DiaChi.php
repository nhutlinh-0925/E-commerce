<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaChi extends Model
{
    use HasFactory;

    protected $fillable = [
    	'khach_hang_id',
        'tinh_thanh_pho_id',
        'quan_huyen_id',
        'xa_phuong_thi_tran_id',
        'dc_DiaChi',
        'dc_TrangThai'
    ];
}
