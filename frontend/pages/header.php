<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/96addb123b.js" crossorigin="anonymous"></script>
    <!--Bootstrap CSS  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Spartan:wght@100;200;300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Spartan', sans-serif;
        }

        h1 {
            font-size: 50px;
            line-height: 64px;
            color: #222;
        }

        h2 {
            font-size: 46px;
            line-height: 54px;
            color: #222;
        }

        h4 {
            font-size: 20px;
            color: #222;
        }

        h6 {
            font-size: 12px;
            font-weight: 700;
        }

        #header p {
            font-size: 16px;
            color: #465b52;
            margin: 15px 0 20px 0;
        }

        .section-p1 {
            padding: 40px 80px;
        }

        .section-m1 {
            margin: 40px 0;
        }

        body {
            width: 100%;
        }


        /*Header*/

        #header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #EAF7CF;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            width: 100%;
        }

        #navbar {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
            width: fit-content;
        }

        #navbar li {
            list-style: none;
            padding: 0 30px;
            position: relative;
        }

        #navbar li a {
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
            color: #588eee;
            transition: 0.3s ease;
        }

        #navbar li a i {
            padding-right: 10px;
        }

        #navbar li a:hover,
        #navbar li a.active {
            color: #554dde;
        }

        #navbar li:active {
            transform: scale(0.8);
        }


        #navbar li a.active::after,
        #navbar li a:hover::after {
            content: "";
            width: 80%;
            height: 2px;
            position: absolute;
            background-color: #554dde;
            bottom: -4px;
            left: 20px;
        }

        #button-login {
            font-weight: 600;
            background-image: linear-gradient(to right, #554dde, #59d3fc);
            border: none;
            padding-top: 10px;
            border-radius: 10px;
            transition: 0.3s ease;
            width: 100%;
        }

        #button-login a {
            color: white;
            font-size: 20px;
        }

        #button-login:hover {
            background-image: linear-gradient(to right, #59d3fc, #554dde);
        }

        #button-login:active {
            transform: scale(0.8);
        }
        #header #dropdownMenuButton{
            font-weight: 600;
            background-image: linear-gradient(to right, #554dde, #59d3fc);
            border: none;
            padding-top: 10px;
            border-radius: 10px;
            transition: 0.3s ease;
            width: 100%;
        }
        #header #dropdownMenuButton:hover {
            background-image: linear-gradient(to right, #59d3fc, #554dde);
        }

        #header #dropdownMenuButton:active {
            transform: scale(0.8);
        }
        .form-search .btn {
            width: 20%;
            border: solid 1px;
            border-color: #554dde;
            color: #554dde;
        }

        .form-search .btn:hover {
            color: white;
            background-color: #554dde;
            border: none;
        }

        .form-search .btn:active {
            transform: scale(0.8);
            background-color: #554dde;
        }
    </style>
</head>

<body>
    <section id="header">
        <div class="container-md">
            <div class="row mt-3">
                <div class="col-2"><a href="#" id="Trangchu2"><img src="../image/logo.png" class="logo" alt=""></a></div>
                <div class="col-8 ">
                    <form class="d-flex form-search" role="search">
                        <input class="form-control me-2" type="search" placeholder="Nhập sản phẩm tại đây..."
                            aria-label="Search">
                        <button class="btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>
                <div class="col-2 ">
                    <div id="login-menu" class="dropdown">
                        <button type="button" id="button-login" class="btn btn-primary"><a href="#">ĐĂNG NHẬP</a></button>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <ul id="navbar">
                        <li><a href="#" id="Trangchu"><i class="fa-solid fa-house"></i>Trang
                                chủ</a></li>
                        <li><a href="#" id="Taikhoan"><i class="fa-solid fa-user"></i>Tài khoản</a>
                        </li>
                        <li><a href="#" id="Donhang"><i class="fa-solid fa-box"></i>Đơn hàng</a>
                        </li>
                        <li><a href="#" id="Giohang"><i class="fa-solid fa-cart-shopping"></i>Giỏ
                                hàng</a>
                        </li>
                        <li><a href="#" id="Baiviet"><i class="fa-solid fa-pen-nib"></i>Bài viết</a></li>
                        <li><a href="#" id="Lienhe"><i class="fa-solid fa-envelope"></i>Liên hệ</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (<?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>) {
            // Nếu người dùng đã đăng nhập, thay đổi nút "Đăng nhập" thành dropdown menu
            var buttonLogin = document.getElementById('button-login');
            buttonLogin.id = 'dropdownMenuButton';
            buttonLogin.classList.add('dropdown-toggle');
            buttonLogin.setAttribute('data-bs-toggle', 'dropdown');
            buttonLogin.innerHTML = <?php echo json_encode($_SESSION['fullname']); ?>;

            // Tạo dropdown menu
            var dropdownMenu = document.createElement('ul');
            dropdownMenu.classList.add('dropdown-menu');
            dropdownMenu.setAttribute('aria-labelledby', 'dropdownMenuButton');

            // Tạo các lựa chọn trong dropdown menu
            var item1 = document.createElement('li');
            var link1 = document.createElement('a');
            link1.classList.add('dropdown-item');
            link1.id = "ttcn-link";
            link1.href = '#';
            link1.textContent = 'Thông tin cá nhân';
            item1.appendChild(link1);

            var item2 = document.createElement('li');
            var link2 = document.createElement('a');
            link2.classList.add('dropdown-item');
            link2.id = 'logout-link';
            link2.href = '#';
            link2.textContent = 'Đăng xuất';
            item2.appendChild(link2);

            // Thêm các lựa chọn vào dropdown menu
            dropdownMenu.appendChild(item1);
            dropdownMenu.appendChild(item2);

            // Thêm dropdown menu vào nút
            buttonLogin.parentNode.appendChild(dropdownMenu);
        }
        document.getElementById('logout-link').addEventListener('click', function(e) {
            e.preventDefault();

            //Hiển thị hộp thoại xác nhận
            var xacnhandx = confirm('Bạn có chắc chắn muốn đăng xuất không?');
            // Gửi yêu cầu AJAX đến tệp logout.php
            if(xacnhandx){
                var xhr = new XMLHttpRequest();
            xhr.open('GET', '../backend/api/auth/logout.php', true);
            xhr.onload = function() {
                if (this.status == 200) {
                    // Nếu yêu cầu thành công, chuyển hướng người dùng về trang chủ
                    window.location.href = '../frontend/index.html';
                }
            };
            xhr.send();
            }
        });
        document.getElementById('ttcn-link').addEventListener('click', function(e) {
            e.preventDefault();
            $("#noidung").load("pages/taikhoan.php", function(){
                $.getScript("js/taikhoan.js");
            });
            
        });
    </script>
    
</body>

</html>