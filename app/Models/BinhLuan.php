<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'bai_viet_id',
        'khach_hang_id',
        'bl_NoiDung',
        'bl_TrangThai',
    ];

    public function khachhang()
    {
        return $this->hasOne(KhachHang::class, 'id', 'khach_hang_id')
            ->withDefault(['kh_Ten' => '']);
    }

    public function baiviet()
    {
        return $this->hasOne(BaiViet::class, 'id', 'bai_viet_id')
            ->withDefault(['bv_TieuDeBaiViet' => '']);
    }
}
