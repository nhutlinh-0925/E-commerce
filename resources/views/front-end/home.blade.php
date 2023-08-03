<!DOCTYPE html>
<html lang="zxx">

<head>
	<!-- head -->
	@include('front-end.pages.head')
</head>

<body>
    @include('front-end.pages.header')

    @include('front-end.header_cart')


    @include('front-end.pages.banner')

    @include('front-end.pages.product-section')

    @include('front-end.pages.categories-section')

    @include('front-end.pages.instagram-section')

    @include('front-end.pages.blog')

    @include('front-end.pages.footer')
    @if(session()->has('success_message'))
        <style>
            .my-custom-icon {
                color: #ff0000; /* Màu đỏ */
                font-size: 5px; /* Kích thước nhỏ hơn (16px) */
            }
        </style>

        <script>
            Swal.fire({
                title: 'Cảm ơn bạn!!!', // Tiêu đề của thông báo
                text: 'Đã thêm sản phẩm vào giỏ hàng!', // Nội dung của thông báo
                icon: 'success', // Icon của thông báo (success, error, warning, info, question)
                showConfirmButton: false, // Không hiển thị nút xác nhận
                timer: 2000, // Thời gian hiển thị thông báo (tính theo milliseconds)
                showCloseButton: true, // Hiển thị nút X để tắt thông báo
                customClass: {
                    icon: 'my-custom-icon' // Sử dụng lớp CSS tùy chỉnh cho icon
                },
                // background: '#ff0000', // Màu nền của thông báo
                padding: '3rem', // Khoảng cách lề bên trong thông báo
                borderRadius: '10px' // Độ cong của góc thông báo
            });
        </script>
    @endif

</body>

</html>
