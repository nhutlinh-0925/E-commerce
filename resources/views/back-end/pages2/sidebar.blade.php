<!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        @php
            if(Auth::check()){
                // Lấy id của người dùng đăng nhập
                $id_nv = Auth::user()->id;
                // Tìm nhân viên tương ứng với id người dùng đăng nhập
                $nhanvien = App\Models\NhanVien::where('tai_khoan_id', $id_nv)->first();
                // Kiểm tra xem người dùng có tương ứng với nhân viên không
                if($nhanvien){
                    // Nếu có, lấy id của nhân viên để lấy quyền từ bảng chi_tiet_quyens và quyens
                    $nhanVienId = $nhanvien->id;
                    $permissions = DB::table('chi_tiet_quyens')
                        ->join('quyens', 'chi_tiet_quyens.quyen_id', '=', 'quyens.id')
                        ->where('chi_tiet_quyens.nhan_vien_id', $nhanVienId)
                        ->where('chi_tiet_quyens.ctq_CoQuyen', 1)
                        ->select('quyens.q_TenQuyen')
                        ->get();
                } else {
                    // Nếu không tương ứng với nhân viên, thực hiện xử lý hoặc hiển thị thông báo lỗi
                }
            } else {
                // Nếu chưa đăng nhập, thực hiện xử lý hoặc hiển thị thông báo yêu cầu đăng nhập
            }
        @endphp
            <!-- Kiểm tra và hiển thị menu tương ứng -->
        @foreach ($permissions as $permission)
            @if ($permission->q_TenQuyen == 'donhang')
                <li class="nav-item">
                    <a class="nav-link " href="/admin/home">
                      <i class="bi bi-grid"></i>
                      <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#order-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-layout-text-window-reverse"></i><span>Đơn hàng</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="order-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="/admin/orders">
                                <i class="bi bi-circle"></i><span>Danh sách đơn hàng</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <hr>
                @elseif ($permission->q_TenQuyen == 'sanpham')
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#products-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-bar-chart"></i><span>Sản phẩm</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="products-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="/admin/products/add">
                                <i class="bi bi-circle"></i><span>Thêm sản phẩm</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/products">
                                <i class="bi bi-circle"></i><span>Danh sách sản phẩm</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#evaluate-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-bar-chart"></i><span>Đánh giá</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="evaluate-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="">
                                <i class="bi bi-circle"></i><span>Thêm đánh giá</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="bi bi-circle"></i><span>Danh sách đánh giá</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#category-products-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-layout-text-window-reverse"></i><span>Danh mục sản phẩm</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="category-products-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="/admin/category-products/add">
                                <i class="bi bi-circle"></i><span>Thêm danh mục</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/category-products">
                                <i class="bi bi-circle"></i><span>Danh sách danh mục</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#producer-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-bar-chart"></i><span>Nhà sản xuất</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="producer-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="">
                                <i class="bi bi-circle"></i><span>Thêm nhà sản xuất</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="bi bi-circle"></i><span>Danh sách nhà sản xuất</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#brands-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-journal-text"></i><span>Thương hiệu sản phẩm</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="brands-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="/admin/brands/add">
                                <i class="bi bi-circle"></i><span>Thêm thương hiệu</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/brands">
                                <i class="bi bi-circle"></i><span>Danh sách thương hiệu</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#coupon-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-layout-text-window-reverse"></i><span>Mã giảm giá</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="coupon-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="/admin/coupons/add">
                                <i class="bi bi-circle"></i><span>Thêm mã giảm giá</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/coupons">
                                <i class="bi bi-circle"></i><span>Danh sách mã giảm giá</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#delivery-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-layout-text-window-reverse"></i><span>Phí vận chuyển</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="delivery-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="/admin/deliveries/add">
                                <i class="bi bi-circle"></i><span>Thêm phí vận chuyển</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/deliveries">
                                <i class="bi bi-circle"></i><span>Danh sách phí vận chuyển</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <hr>
                @elseif ($permission->q_TenQuyen == 'nhansu')
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#customer-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-gem"></i><span>Khách hàng</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="customer-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="/admin/user1">
                                <i class="bi bi-circle"></i><span>Test 1</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/users2">
                                <i class="bi bi-circle"></i><span>Test 2</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/test3">
                                <i class="bi bi-circle"></i><span>Test 3</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/customers/add">
                                <i class="bi bi-circle"></i><span>Thêm khách hàng</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/customers">
                                <i class="bi bi-circle"></i><span>Danh sách khách hàng</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#employee-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-layout-text-window-reverse"></i><span>Nhân viên</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="employee-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="/admin/employees/add">
                                <i class="bi bi-circle"></i><span>Thêm nhân viên</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/employees">
                                <i class="bi bi-circle"></i><span>Danh sách nhân viên</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/employees/permissions">
                                <i class="bi bi-circle"></i><span>Phân quyền nhân viên</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <hr>
                @elseif ($permission->q_TenQuyen == 'baiviet')
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#category-posts-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-bar-chart"></i><span>Danh mục bài viết</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="category-posts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="/admin/category-posts/add">
                                <i class="bi bi-circle"></i><span>Thêm danh mục</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/category-posts">
                                <i class="bi bi-circle"></i><span>Danh sách danh mục</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#posts-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-bar-chart"></i><span>Bài viết</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="posts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="/admin/posts/add">
                                <i class="bi bi-circle"></i><span>Thêm bài viết</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/posts">
                                <i class="bi bi-circle"></i><span>Danh sách bài viết</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <hr>
                @elseif ($permission->q_TenQuyen == 'nhapkho')
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#warehouse-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-bar-chart"></i><span>Nhập kho</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="warehouse-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="">
                                <i class="bi bi-circle"></i><span>Nhập kho</span>
                            </a>
                        </li>
                    </ul>
                </li>
               @endif
            @endforeach
        </ul>
    </aside>
<!-- End Sidebar-->
