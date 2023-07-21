<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhiVanChuyen extends Model
{
    use HasFactory;

    protected $fillable = [
        'pvc_ThanhPho',
        'pvc_PhiVanChuyen',
        'thanh_pho_id',
    ];
}
