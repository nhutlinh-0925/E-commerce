@extends('back-end.main2')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="pagetitle text-center">
                <h1 class="card-title"
                    style="border-bottom: 3px solid blue; display: inline-block; padding-bottom: 5px; "; >
                    GỬI MÃ GIẢM GIÁ THEO NHÓM KHÁCH HÀNG
                </h1>
                <p class="text-center" style="font-size: 12px">Vui lòng kiểm tra kỹ thông tin trước khi gửi</p>
            </div>
            <!-- Vertical Form -->
            <form class="row g-3">
                <div class="row">
                    <div class="col-md-4">
                        <label for="inputNanme4" class="form-label"><strong>Loại gửi <span class="text-danger">(*)</span></strong></label>
                        <select class="form-control" name="mgg_GuiMa">
                            <option value="1">Gửi toàn bộ</option>
                            <option value="2">Gửi khách hàng vip</option>
                            <option value="3">Gửi khách hàng thông thường</option>
                        </select>
                        @error ('mgg_GuiMa')
                        <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="card">
                        <h5 class="card-title" style="font-size: 25px; color: blue;text-align: center">Xem lại thông tin mã giảm giá</h5>

                        <div class="row">
                            <div class="col-6">
                                <label><b>Id mã giảm giá : </b>{{ $coupon->id }}</label>
                            </div>
                            <div class="col-6">
                                <label><b>Tên mã giảm giá : </b>{{ $coupon->mgg_TenGiamGia }}</label>
                            </div>

                            <div class="col-6">
                                <label><b>Mã giảm giá :</b>{{ $coupon->mgg_MaGiamGia }}</label>
                            </div>
                            <div class="col-6">
                                <label><b>Số lượng mã: </b>{{ $coupon->mgg_SoLuongMa }}</label>
                            </div>

                            <div class="col-6">
                                <label>
                                    <b>Loại giảm giá : </b>
                                    @if ($coupon->mgg_LoaiGiamGia == 1)
                                        Giảm theo tiền
                                    @elseif ($coupon->mgg_LoaiGiamGia == 2)
                                        Giảm theo phần trăm
                                    @endif
                                </label>
                            </div>

                            <div class="col-6">
                                <label>
                                    <b>Giá trị được giảm : </b>
                                    @if ($coupon->mgg_LoaiGiamGia == 1)
                                        {{ number_format($coupon->mgg_GiaTri, 0, '', '.') }} đ
                                    @elseif ($coupon->mgg_LoaiGiamGia == 2)
                                        {{ $coupon->mgg_GiaTri }} %
                                    @endif
                                </label>
                            </div>

                            <div class="col-6">
                                <label><b>Ngày bắt đầu :</b> {{ \Carbon\Carbon::parse($coupon->mgg_NgayBatDau)->format('d-m-Y H:i:s') }}</label>
                            </div>
                            <div class="col-6">
                                <label><b>Ngày kết thúc :</b> {{ \Carbon\Carbon::parse($coupon->mgg_NgayKetThuc)->format('d-m-Y H:i:s') }}</label>
                            </div>
                        </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary" style="width: 10%;" id="submitButton">Gửi</button>
                    <a href="/admin/coupons" class="btn btn-danger" style="width: 12%;">Quay lại</a>
                </div>
            </form>
        </div>
    </div>

@endsection

  @section('footer')
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              var select = document.querySelector('select[name="mgg_GuiMa"]');
              var form = document.querySelector('form');
              var submitButton = document.getElementById('submitButton');

              submitButton.addEventListener('click', function(event) {
                  var selectedValue = select.value;
                  if (selectedValue === '1') {
                      // Chuyển hướng đến '/admin/coupons/send_coupon_all' khi giá trị là 1.
                      window.location.href = '/admin/coupons/send_coupon_all/{{ $coupon->id }}';
                  } else if (selectedValue === '2') {
                      // Chuyển hướng đến '/admin/coupons/send_coupon_vip' khi giá trị là 2.
                      window.location.href = '/admin/coupons/send_coupon_vip/{{ $coupon->id }}';
                  } else if (selectedValue === '3') {
                      // Chuyển hướng đến '/admin/coupons/send_coupon' khi giá trị là 3.
                      window.location.href = '/admin/coupons/send_coupon/{{ $coupon->id }}';
                  }
                  event.preventDefault(); // Ngăn chặn sự kiện mặc định của form
              });
          });
      </script>

  @endsection

