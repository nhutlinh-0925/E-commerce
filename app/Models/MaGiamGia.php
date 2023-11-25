<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaGiamGia extends Model
{
    use HasFactory;

    protected $fillable = [
        'mgg_TenGiamGia',
        'mgg_MaGiamGia',
        'mgg_SoLuongMa',
        'mgg_LoaiGiamGia',
        'mgg_GiaTri',
        'mgg_DonToiThieu',
        'mgg_GiamToiDa',
        'mgg_DaSuDung',
        'mgg_NgayBatDau',
        'mgg_NgayKetThuc',
    ];

    //Giảm theo phần trăm
    //Phần trăm:        5     10    15
    //Đơn tối thiểu:    1tr   1tr   1tr
    //Giảm tối đa:      50k   100k  150k


    //Giảm theo tiền
    //Số tiền:        100k    150k   200k
    //Đơn tối thiểu:  2tr     3tr    4tr
    //Giảm tối đa:    100k    150k   200k
}
