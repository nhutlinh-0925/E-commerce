
const slidePage = document.querySelector(".slide-page");
const nextBtnFirst = document.querySelector(".firstNext");

const prevBtnSec = document.querySelector(".prev-1");
const nextBtnSec = document.querySelector(".next-1");
const prevBtnThird = document.querySelector(".prev-2");
const nextBtnThird = document.querySelector(".next-2");
const prevBtnFourth = document.querySelector(".prev-3");
const submitBtn = document.querySelector(".submit");
const progressText = document.querySelectorAll(".step p");
const progressCheck = document.querySelectorAll(".step .check");
const bullet = document.querySelectorAll(".step .bullet");
let current = 1;


//Button Tiếp Theo bước 1
nextBtnFirst.addEventListener("click", function(event){
  event.preventDefault();
  $('#nameError').html('');
  $('#priceError').html('');
  $('#categoryError').html('');
  $('#brandError').html('');
  $('#descError').html('');
  $('#contentError').html('');
  if($('#sp_TenSanPham').val() == ''){
    $('#nameError').html('Vui lòng nhập tên');
    return false;
  } else if($('#sp_Gia').val() == ''){
    $('#priceError').html('Vui lòng nhập giá');
    return false;
  } else if(isNaN($('#sp_Gia').val())){
    $('#priceError').html('Vui lòng nhập chữ số');
    return false;
  } else if (parseFloat($('#sp_Gia').val()) <= 0) {
      $('#priceError').html('Giá phải lớn hơn 0');
      return false;
  } else if($('#danh_muc_san_pham_id').val() == ''){
    $('#categoryError').html('Vui lòng chọn danh mục');
    return false;

  } else if($('#thuong_hieu_id').val() == ''){
    $('#brandError').html('Vui lòng chọn thương hiệu');
    return false;
  } else if($('#sp_MoTa').val() == ''){
    $('#descError').html('Vui lòng nhập mô tả');
    return false;
  } else if($('#sp_NoiDung').val() == ''){
    $('#contentError').html('Vui lòng nhập nộp dung');
    return false;
  }
  else{
    slidePage.style.marginLeft = "-25%";
    bullet[current - 1].classList.add("active");
    progressCheck[current - 1].classList.add("active");
    progressText[current - 1].classList.add("active");
    current += 1;
    }
});
//Button Tiếp Theo bước 2
nextBtnSec.addEventListener("click", function(event){
  event.preventDefault();
  $('#materialError').html('');
  $('#pictureError').html('');
  $('#videoError').html('');

  if($('#sp_ChatLieu').val() == ''){
    $('#materialError').html('Vui lòng nhập nội dung chất liệu');
    return false;
  } else if($('#sp_AnhDaiDien').val() == ''){
    $('#pictureError').html('Vui lòng chọn hình ảnh');
  } else if($('#sp_Video').val() == ''){
      $('#videoError').html('Vui lòng copy link video vào đây');
    return false;
  }
  else{
  slidePage.style.marginLeft = "-50%";
  bullet[current - 1].classList.add("active");
  progressCheck[current - 1].classList.add("active");
  progressText[current - 1].classList.add("active");
  current += 1;
  }
});
//Button Tiếp Theo bước 3
nextBtnThird.addEventListener("click", function(event) {
    event.preventDefault();

    // Kiểm tra từng phần tử tạo động
    for (let i = 1; i <= 2; i++) {
        // Xóa thông báo lỗi trước khi kiểm tra cho từng phần tử
        $('#picture_detailError_' + i).html('');

        // Kiểm tra nếu không có hình ảnh được chọn cho từng phần tử
        if ($('#ha_AnhChiTiet_' + i).val() == '') {
            $('#picture_detailError_' + i).html('Vui lòng chọn hình ảnh');
            return false; // Nếu có lỗi, dừng vòng lặp và không thực hiện việc chuyển trang
        }
    }

    // Nếu không có lỗi, tiến hành chuyển trang
    slidePage.style.marginLeft = "-75%";
    bullet[current - 1].classList.add("active");
    progressCheck[current - 1].classList.add("active");
    progressText[current - 1].classList.add("active");
    current += 1;
});

//Button Xác Nhận
submitBtn.addEventListener("click", function(){
  bullet[current - 1].classList.add("active");
  progressCheck[current - 1].classList.add("active");
  progressText[current - 1].classList.add("active");
  current += 1;
  setTimeout(function(){
    alert("Bạn đã chắc chắn kiểm tra các bước ");
    // location.reload();
  },800);
});
//Button Quay Lại bước 2
prevBtnSec.addEventListener("click", function(event){
  event.preventDefault();
  slidePage.style.marginLeft = "0%";
  bullet[current - 2].classList.remove("active");
  progressCheck[current - 2].classList.remove("active");
  progressText[current - 2].classList.remove("active");
  current -= 1;
});
//Button Quay Lại bước 3
prevBtnThird.addEventListener("click", function(event){
  event.preventDefault();
  slidePage.style.marginLeft = "-25%";
  bullet[current - 2].classList.remove("active");
  progressCheck[current - 2].classList.remove("active");
  progressText[current - 2].classList.remove("active");
  current -= 1;
});
//Button Quay Lại bước 4
prevBtnFourth.addEventListener("click", function(event){
  event.preventDefault();
  slidePage.style.marginLeft = "-50%";
  bullet[current - 2].classList.remove("active");
  progressCheck[current - 2].classList.remove("active");
  progressText[current - 2].classList.remove("active");
  current -= 1;
});



