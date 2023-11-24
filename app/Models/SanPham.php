<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    use HasFactory;

    protected $fillable = [
        'sp_TenSanPham',
        'sp_Gia',
        'danh_muc_san_pham_id',
        'thuong_hieu_id',
        'sp_MoTa',
        'sp_NoiDung',
        'sp_ChatLieu',
        'sp_TrangThai',
        'sp_SoLuongBan',
        'sp_AnhDaiDien',
        'sp_Video',
        'sp_LuotXem',
        'sp_Tag'
    ];

    public function danhmuc()
    {
        return $this->hasOne(DanhMucSanPham::class, 'id', 'danh_muc_san_pham_id')
                ->withDefault(['dmsp_TenDanhMuc' => '']);
    }

    public function thuonghieu()
    {
        return $this->hasOne(ThuongHieu::class, 'id', 'thuong_hieu_id')
                ->withDefault(['thsp_TenThuongHieu' => '']);
    }

    public function hinhanh()
    {
        return $this->hasMany(HinhAnh::class);
    }

    public function kichthuoc()
    {
        return $this->belongsToMany(KichThuoc::class, 'san_pham_kich_thuocs', 'san_pham_id', 'kich_thuoc_id');
    }

    public function sanphamkichthuoc()
    {
        return $this->hasMany(SanPhamKichThuoc::class, 'san_pham_id');
    }

    public function chitietphieunhaphang()
    {
        return $this->hasMany(ChiTietPhieuNhapHang::class, 'san_pham_id');
    }

//    Thông tin thêm sản phẩm
//Tên:       Solo Velocity Max Backpack 17.3” - ACV732
//Giá:       1250000
//Mô tả:     Solo Velocity Max Backpack 17.3” - ACV732 với thiết kế hiện đại, màu sắc sang trọng và những tính năng ưu việt túi laptop sẽ giúp bạn bảo vệ chiếc máy tính yêu quý của mình và là một sản phẩm mà bạn không nên bỏ qua trong mỗi chuyến đi.
//Nội dung:  Thiết kế hiện đại, sang trọng - Balo laptop Solo Velocity Max Backpack 17.3” - ACV732 được kết hợp phong cách hiện đại với nhiều chức năng hấp dẫn phù hợp với phong cách làm việc của bạn. - Với chất liệu Nylon/Polyeste hiện đại và sang trọng - Sản phẩm phù hợp với người sử dụng là nam giới. Chống thấm nước tối ưu - Chất liệu bên ngoài làm từ Nylon/Polyeste có khả năng hạn chế chống thấm nước tốt Nhiều tính năng tiện ích - Thiết kế 1 ngăn chính và 2 ngăn phụ phía trước đều được trang bị khóa kéo zip kháng nước - 2 bên hông đều có ngăn lưới tiện dụng để bạn bỏ đồ - Mặt dây lưng có dây đai mang vào hành lý Vali khi đi công tác - Dây đeo vai có thể tùy chỉnh kích thước theo nhu cầu
//Cất liệu:  Thiết kế hiện đại, sang trọng - Balo laptop Solo Velocity Max Backpack 17.3” - ACV732 được kết hợp phong cách hiện đại với nhiều chức năng hấp dẫn phù hợp với phong cách làm việc của bạn. - Với chất liệu Nylon/Polyeste hiện đại và sang trọng - Sản phẩm phù hợp với người sử dụng là nam giới.
//Tags:      balo du lich, solo
//Video:     https://www.youtube.com/watch?v=D1kOg2YixCg


}
