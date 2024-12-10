<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/dangki.css">
</head>
<body>
    <section id="Dangki">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <h2 class="text-center">ĐĂNG KÍ TÀI KHOẢN</h2>
                    <h4 class="text-center">Bạn đã có tài khoản? <a href="#" id="nutDangnhap">Đăng nhập tại đây</a></h4>
                    <p id="error_msg" class="text-center text-danger"></p>
                    <form method="post" id="registerForm">
                    <div class="mb-3">
                            <label for="fullname_user_register" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="fullname_user_register" name="fullname_user_register" placeholder="Nhập họ tên của bạn" maxlength="50">
                        </div>
                        <div class="mb-3">
                            <label for="phone_number_user_register" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone_number_user_register" name="phone_number_user_register" placeholder="Nhập số điện thoại của bạn" maxlength="10">
                        </div>
                        <div class="mb-3">
                            <label for="email_user_register" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email_user_register" name="email_user_register" placeholder="Nhập email của bạn" maxlength="100">
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="password_user_register" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="password_user_register" name="password_user_register" placeholder="Nhập mật khẩu của bạn" maxlength="50">
                                <button type="button" class="btn show-password-btn" onclick="togglePasswordVisibility()">
                                    <i class="fa-solid fa-eye fa-lg"></i>
                                </button>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="password_repeat" class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" id="password_repeat" name="password_repeat" placeholder="Nhập lại mật khẩu" maxlength="50">
                                <button type="button" class="btn show-password_repeat-btn" onclick="togglePassword_repeatVisibility()">
                                    <i class="fa-solid fa-eye fa-lg"></i>
                                </button>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn_dangki">ĐĂNG KÍ NGAY</button>
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
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password_user_register');
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

        var passwordButton = document.querySelector('.show-password-btn');
        if (passwordButton) {
            passwordButton.addEventListener('click', togglePasswordVisibility);
        }

        function togglePassword_repeatVisibility(){
            var password_repeatInput = document.getElementById('password_repeat');
            var password_repeatButton = document.querySelector('.show-password_repeat-btn');
            if(password_repeatInput && password_repeatButton){
                if(password_repeatInput.type === 'password'){
                    password_repeatInput.type = 'text';
                    password_repeatButton.querySelector('i').classList.remove('fa-eye');
                    password_repeatButton.querySelector('i').classList.add('fa-eye-slash');
                }
                else{
                    password_repeatInput.type = 'password';
                    password_repeatButton.querySelector('i').classList.remove('fa-eye-slash');
                    password_repeatButton.querySelector('i').classList.add('fa-eye');
                }
            }
        }
        var password_repeatButton = document.querySelector('.show-password_repeat-btn');
        if ( password_repeatButton) {
            password_repeatButton.addEventListener('click', togglePassword_repeatVisibility);
        }
        function loadPage(pageName) {
                $("#noidung").load("pages/" + pageName + ".php", function () {
                    $.getScript("js/" + pageName + ".js");
                });
            }
        var registerForm = document.getElementById('registerForm');
        if(registerForm){
            registerForm.addEventListener('submit', function(e){
                e.preventDefault();

                var fullnameInput = document.getElementById('fullname_user_register');
                var phone_numberInput = document.getElementById('phone_number_user_register');
                var emailInput = document.getElementById('email_user_register');
                var passwordInput = document.getElementById('password_user_register');
                var password_repeatInput = document.getElementById('password_repeat');
                var errorMsg = document.getElementById('error_msg');
                
                if(!fullnameInput.value || !phone_numberInput.value || !emailInput.value || !passwordInput.value || !password_repeatInput.value){
                    errorMsg.textContent = 'Hãy nhập đủ thông tin.';
                }else if(passwordInput.value !== password_repeatInput.value){
                    errorMsg.textContent = 'Mật khẩu xác nhận không khớp.';
                }else{
                    errorMsg.textContent = '';
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST','../backend/api/auth/xulydangki.php', true);
                    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
                    xhr.send('fullname_user_register='+ encodeURIComponent(fullnameInput.value) + '&phone_number_user_register=' + encodeURIComponent(phone_numberInput.value)
                    + '&email_user_register=' + encodeURIComponent(emailInput.value) + '&password_user_register=' + encodeURIComponent(passwordInput.value) )
                
                    xhr.onload = function(){
                        if(xhr.status === 200){
                            var response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                loadPage(response.redirectUrl);
                            }else{
                                errorMsg.textContent = response.errorMsg;
                            }
                        }else{
                            errorMsg.textContent = 'Có lỗi xảy ra khi đăng kí. Vui lòng thử lại.';
                        }
                    }
                }
            })
        }
    </script>
</body>
</html>
