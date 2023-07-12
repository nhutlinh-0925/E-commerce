<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMucSanPham extends Model
{
    use HasFactory;

    protected $fillable = [
        'dmsp_TenDanhMuc',
        'dmsp_MoTa',
        'dmsp_TrangThai'
    ];

    protected $primaryKey = 'id';
    protected $table ='danh_muc_san_phams';

    public function products()
    {
        return $this->hasMany(SanPham::class);
    }
}
