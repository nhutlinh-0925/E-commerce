<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinhThanhPho extends Model
{
    use HasFactory;

    public $timestamps = false; //set time to false
    protected $fillable = [
        'tp_Ten', 'tp_Loai'
    ];
    protected $primaryKey = 'id';
    protected $table = 'tinh_thanh_phos';
}
