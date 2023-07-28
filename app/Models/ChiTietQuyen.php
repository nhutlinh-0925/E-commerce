<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietQuyen extends Model
{
    use HasFactory;

    protected $fillable = [
        'quyen_id',
        'nhan_vien_id',
        'ctq_CoQuyen',
    ];
}
