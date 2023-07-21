<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuanHuyen extends Model
{
    use HasFactory;

    public $timestamps = false; //set time to false
    protected $fillable = [
        'qh_Ten', 'qh_Loai','thanh_pho_id'
    ];
    protected $primaryKey = 'id';
    protected $table = 'quan_huyens';
}
