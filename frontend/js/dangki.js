$("#nutDangnhap").click(function (e) {
    e.preventDefault();
    $("#noidung").load("pages/dangnhap.php", function () {
        $.getScript("js/dangnhap.js");
    });
});
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
function togglePassword_repeatVisibility() {
    var password_repeatInput = document.getElementById('password_repeat');
    var password_repeatButton = document.querySelector('.show-password_repeat-btn');
    if (password_repeatInput && password_repeatButton) {
        if (password_repeatInput.type === 'password') {
            password_repeatInput.type = 'text';
            password_repeatButton.querySelector('.show-password_repeat-btn i').classList.remove('fa-eye');
            password_repeatButton.querySelector('.show-password_repeat-btn i').classList.add('fa-eye-slash');
        }
        else {
            password_repeatInput.type = 'password';
            password_repeatButton.querySelector('.show-password_repeat-btn i').classList.remove('fa-eye-slash');
            password_repeatButton.querySelector('.show-password_repeat-btn i').classList.add('fa-eye');
        }
    }
}
var password_repeatButton = document.querySelector('.show-password_repeat-btn');
if (password_repeatButton) {
    password_repeatButton.addEventListener('click', togglePassword_repeatVisibility);
}