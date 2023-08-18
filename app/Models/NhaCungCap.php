<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhaCungCap extends Model
{
    use HasFactory;

    protected $fillable = [
        'ncc_TenNhaCungCap',
        'ncc_Email',
        'ncc_SoDienThoai',
        'ncc_DiaChi',
        'ncc_TrangThai'
    ];
}
