<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMucBaiViet extends Model
{
    use HasFactory;

    protected $fillable = [
        'dmbv_TenDanhMuc',
        'dmbv_MoTa',
        'dmbv_TrangThai'
    ];

    protected $primaryKey = 'id';
    protected $table ='danh_muc_bai_viets';

    public function posts()
    {
        return $this->hasMany(BaiViet::class);
    }
}
