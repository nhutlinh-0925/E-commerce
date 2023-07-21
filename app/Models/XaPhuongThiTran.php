<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XaPhuongThiTran extends Model
{
    use HasFactory;

    public $timestamps = false; //set time to false
    protected $fillable = [
        'xptt_Ten', 'xptt_Loai', 'quan_huyen_id'
    ];
    protected $primaryKey = 'id';
    protected $table = 'xa_phuong_thi_trans';
}
