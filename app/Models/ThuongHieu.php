<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThuongHieu extends Model
{
    use HasFactory;

    protected $fillable = [
        'thsp_TenThuongHieu',
        'thsp_MoTa',
        'thsp_TrangThai'
    ];

    protected $primaryKey = 'id';
    protected $table ='thuong_hieus';

    public function products()
    {
        return $this->hasMany(SanPham::class);
    }
}
