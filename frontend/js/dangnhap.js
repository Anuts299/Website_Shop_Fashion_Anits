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

var passwordButton = document.querySelector('.show-password-btn');
if (passwordButton) {
    passwordButton.addEventListener('click', togglePasswordVisibility);
}
//Xử lý nhấn nút Đăng kí tại đây
$("#nutDangki").click(function (e) {
    e.preventDefault();
    $("#noidung").load("pages/dangki.php", function () {
        $.getScript("js/dangki.js");
    });
});
// Thêm sự kiện submit cho form
var loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Ngăn form submit mặc định

        var emailInput = document.getElementById('email_user_login');
        var passwordInput = document.getElementById('password_user_login');
        var errorMsg = document.getElementById('error_msg');

        if (!emailInput.value || !passwordInput.value) {
            errorMsg.textContent = 'Hãy nhập đủ thông tin.';
        } else {
            errorMsg.textContent = '';
            // Gửi dữ liệu đăng nhập đến máy chủ bằng AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../backend/api/auth/xulydangnhap.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('email_user_login=' + encodeURIComponent(emailInput.value) + '&password_user_login=' + encodeURIComponent(passwordInput.value));

            xhr.onload = function () {
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

