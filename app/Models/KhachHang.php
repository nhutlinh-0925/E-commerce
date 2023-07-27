<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table ='khach_hangs';

    protected $fillable = [
    	'tai_khoan_id',
        'kh_Ten',
        'kh_SoDienThoai',
        'kh_SoTienDaMua',
    ];

    public function taikhoan()
    {
        return $this->hasOne(TaiKhoan::class, 'id', 'tai_khoan_id')
            ->withDefault(['email' => ''])
            ->withDefault(['avatar' => '']);
    }

    public function diachi()
    {
        return $this->hasMany(DiaChi::class);
    }

}
