<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhanHoi extends Model
{
    use HasFactory;

    protected $fillable = [
        'khach_hang_id',
        'phieu_dat_hang_id',
        'ph_SoSao',
        'ph_MucPhanHoi',
        'ph_TrangThai'
    ];

    public function khachhang()
    {
        return $this->hasOne(KhachHang::class, 'id', 'khach_hang_id')
            ->withDefault(['kh_Ten' => '']);
    }
}
