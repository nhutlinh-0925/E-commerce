<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'sl_TieuDe',
        'sl_HinhAnh',
        'sl_TrangThai'
    ];
}
