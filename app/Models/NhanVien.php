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

     protected $guard = 'admin';

//     protected $fillable = [
//         'name',
//         'email',
//         'password',
//     ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
     protected $hidden = [
         'password',
         'remember_token',
     ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
     protected $casts = [
         'email_verified_at' => 'datetime',
     ];

    protected $primaryKey = 'id';
    protected $table ='nhan_viens';

    protected $fillable = [
//    	'tai_khoan_id',
        'nv_Ten',
        'nv_SoDienThoai',
        'nv_DiaChi',
        'email',
        'password',
        'trangthai',
        'loai',
        'avatar'
    ];

//    public function taikhoan()
//    {
//        return $this->hasOne(TaiKhoan::class, 'id', 'tai_khoan_id')
//            ->withDefault(['email' => ''])
//            ->withDefault(['avatar' => '']);
//    }

    public function chitietquyen()
    {
        return $this->hasMany(ChiTietQuyen::class);
    }

//    public function hasPermission($permission)
//    {
//        return $this->quyens->contains('q_TenQuyen', $permission);
//    }

//    public function quyens()
//    {
//        return $this->belongsToMany(Quyen::class, 'chi_tiet_quyens', 'nhan_vien_id', 'quyen_id');
//    }
}
