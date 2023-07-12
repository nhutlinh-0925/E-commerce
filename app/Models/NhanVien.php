<?php

namespace App\Models;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// class NhanVien extends Model
// {
//     use HasFactory;
// }

class NhanVien extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // protected $guard = 'admin';

    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    protected $primaryKey = 'id';
    protected $table ='nhan_viens';

    protected $fillable = [
    	'tai_khoan_id',
        'nv_Ten',
        'nv_SoDienThoai',
        'nv_DiaChi',
    ];
}
