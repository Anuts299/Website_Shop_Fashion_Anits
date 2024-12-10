<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/dangnhap.css">
</head>
<body>
    <section id="Login">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <h2 class="text-center">ĐĂNG NHẬP TÀI KHOẢN</h2>
                    <h4 class="text-center">Bạn chưa có tài khoản? <a href="#" id="nutDangki">Đăng kí tại đây</a></h4>
                    <p id="error_msg" class="text-center text-danger"></p>
                    <form method="POST" id="loginForm">
                        <div class="mb-3">
                            <label for="email_user_login" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email_user_login" name="email_user_login" placeholder="Nhập email của bạn" maxlength="100">
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="password_user_login" class="form-label">Mật khẩu</label>
                            
                                <input type="password" class="form-control" id="password_user_login" name="password_user_login" placeholder="Nhập mật khẩu của bạn" maxlength="50">
                                <button type="button" class="btn show-password-btn" onclick="togglePasswordVisibility()">
                                    <i class="fa-solid fa-eye fa-lg"></i>
                                </button>
                            
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn_dangnhap">ĐĂNG NHẬP</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom JavaScript -->
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password_user_login');
            var passwordButton = document.querySelector('.show-password-btn');
            if (passwordInput && passwordButton) {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordButton.querySelector('i').classList.remove('fa-eye');
                    passwordButton.querySelector('i').classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    passwordButton.querySelector('i').classList.remove('fa-eye-slash');
                    passwordButton.querySelector('i').classList.add('fa-eye');
                }
            }
        }

        // Thêm sự kiện click cho nút hiển thị mật khẩu
        var passwordButton = document.querySelector('.show-password-btn');
        if (passwordButton) {
            passwordButton.addEventListener('click', togglePasswordVisibility);
        }

        // Thêm sự kiện submit cho form
        var loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Ngăn form submit mặc định

                var emailInput = document.getElementById('email_user_login');
                var passwordInput = document.getElementById('password_user_login');
                var errorMsg = document.getElementById('error_msg');

                if (!emailInput.value || !passwordInput.value) {
                    errorMsg.textContent = 'Hãy nhập đủ thông tin.';
                } else {
                    errorMsg.textContent = '';
                    // Gửi dữ liệu đăng nhập đến xulydangnhap bằng AJAX
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '../backend/api/auth/xulydangnhap.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.send('email_user_login=' + encodeURIComponent(emailInput.value) + '&password_user_login=' + encodeURIComponent(passwordInput.value));

                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                // Đăng nhập thành công, chuyển hướng người dùng
                                window.location.href = response.redirectUrl;
                            } else {
                                // Đăng nhập thất bại, hiển thị thông báo lỗi
                                errorMsg.textContent = response.errorMsg;
                            }
                        } else {
                            // Lỗi khi gửi yêu cầu, hiển thị thông báo lỗi
                            errorMsg.textContent = 'Có lỗi xảy ra khi đăng nhập. Vui lòng thử lại.';
                        }
                    };
                }
            });
        }

    </script>
</body>
</html>
