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
}
