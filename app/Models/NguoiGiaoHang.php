<?php

namespace App\Models;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class NguoiGiaoHang extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'shipper';
    protected $primaryKey = 'id';
    protected $table ='nguoi_giao_hangs';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $fillable = [
        'ngh_Ten',
        'ngh_SoDienThoai',
        'ngh_DiaChi',
        'email',
        'password',
        'trangthai',
        'avatar'
    ];
}
