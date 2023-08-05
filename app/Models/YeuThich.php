<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YeuThich extends Model
{
    use HasFactory;

    protected $fillable = [
        'khach_hang_id',
        'san_pham_id',
    ];

    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}
