<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    use HasFactory;

    protected $fillable = [
        'danh_muc_bai_viet_id',
        'nhan_vien_id',
        'bv_TieuDeBaiViet',
        'bv_NoiDungNgan',
        'bv_NoiDungChiTiet',
        'bv_AnhDaiDien',
        'bv_LuotXem',
        'bv_TrangThai',
        'bv_Tag',
        'bv_NgayTao'
    ];

    public function nguoidang()
    {
        return $this->hasOne(NhanVien::class, 'id', 'nhan_vien_id')
            ->withDefault(['nv_Ten' => '']);
    }

//    Thông tin bài viết
//Tiêu đề:          Xử lý balo vải bị mốc trong mùa mưa
//Mô tả ngắn:       Thời tiết ẩm mốc, mưa nắng thất thường và hầm bí độ ẩm không khí cao là những nguyên nhân làm chiếc balo vải của chúng ta bị mốc meo. Chiếc balo bị mốc sẽ tích tụ nhiều vi khuẩn và gây mùi khó chịu làm ảnh hưởng đến sức khoẻ chúng ta rất nhiều. Làm sạch mốc bằng xà phòng thôi chưa đủ, vì vi khuẩn vẫn còn bám chặt vào từng sớ vải do đó chúng ta phải có cách làm sạch triệt để lớp mốc và cả vi khuẩn bay mùi khó chịu nữa. Cần phải làm thật sạch chiếc balo rồi mới có thể tiếp tục sử dụng nếu không thì vừa ảnh hưởng đến sức khoẻ, các vết mốc lại dính vào đồ dùng, sách vỡ nữa.
//Mô tả chi tiết:   Đánh bay ẩm mốc bằng cách nào? Đa số các bạn đều nghĩ giặt các vết mốc bằng xà phồng là sạch rồi. Thật tế là không phải như vậy và các vi khuẩn gây mốc vẫn ở đó, bám vào các lớp vải bên dưới mà xà phòng không làm sạch được. Do đó chúng ta phải làm sạch vết mốc và đánh bay luôn cả các con vi khuẩn nữa. Như thế mới làm sạch hoàn toàn chiếc balo vải của chúng ta. Dùng tinh dầu hoặc dầu thông Tinh dầu trà hoặc tinh dầu thông có khả năng loại bỏ vi khuẩn triệt để và chúng ta có thể áp dụng nó để đánh bay vi khuẩn gây mốc. Có 2 cách để loại bỏ vết mốc trên balo vải của chúng ta.
//Tags:             mẹo hay, mùa mưa
}
