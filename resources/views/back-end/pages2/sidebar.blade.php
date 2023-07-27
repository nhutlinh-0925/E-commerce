<!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="/admin/home">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
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
            </ul>
        </li>

    </ul>

  </aside>
<!-- End Sidebar-->
