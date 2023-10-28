<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $primaryKey = 'id';
    protected $table ='khach_hangs';

    protected $fillable = [
    	//'tai_khoan_id',
        'kh_Ten',
        'kh_SoDienThoai',
        'kh_TongTienDaMua',
        'email',
        'provider',
        'provider_id',
        'password',
        'avatar',
        'trangthai',
        'vip'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
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
