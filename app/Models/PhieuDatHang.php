<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuDatHang extends Model
{
    use HasFactory;

    protected $fillable = [
        'khach_hang_id',
        'nhan_vien_id',
        'ma_giam_gia_id',
        'phuong_thuc_thanh_toan_id',
        'pdh_DiaChiGiao',
        //'thuong_hieu_id',
        'pdh_GhiChu',
        'pdh_GiamGia',
        'pdh_TrangThai',
        //'pdh_PhuongThucThanhToan',
        'pdh_NgayDat',
        'pdh_TongTien',
    ];

    public function khachhang()
    {
        return $this->hasOne(KhachHang::class, 'id', 'khach_hang_id')
            ->withDefault(['kh_Ten' => '']);
    }

    public function nhanvien()
    {
        return $this->hasOne(NhanVien::class, 'id', 'nhan_vien_id')
            ->withDefault(['nv_Ten' => '']);
    }

    public function phuongthucthanhtoan()
    {
        return $this->hasOne(PhuongThucThanhToan::class, 'id', 'phuong_thuc_thanh_toan_id')
            ->withDefault(['pttt_MoTa' => '','pttt_TenPhuongThucThanhToan']);
    }

    public function chitietphieudathang() {
        return $this->hasMany(ChiTietPhieuDatHang::class, 'phieu_dat_hang_id');
    }

}
