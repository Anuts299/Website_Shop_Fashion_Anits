<?php
session_start();

// Kết nối đến cơ sở dữ liệu
include '../../config/db.php';

// Khởi tạo biến thông báo lỗi
$error_msg = '';

// Xử lý thông tin đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form đăng nhập và loại bỏ các ký tự đặc biệt
    $email = htmlspecialchars($_POST['email_user_login']);
    $password = htmlspecialchars($_POST['password_user_login']);

    // Kiểm tra thông tin đăng nhập trong cơ sở dữ liệu
    $sql = "SELECT id, fullname, email, phone_number, specific_address, birthday, gender, password, role, city, district, ward FROM user WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['password']) { 
        // Đăng nhập thành công
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['phone_number'] = $user['phone_number'];
        $_SESSION['specific_address'] = $user['specific_address'];
        $_SESSION['birthday'] = $user['birthday'];
        $_SESSION['gender'] = $user['gender'];
        $_SESSION['city'] = $user['city'];
        $_SESSION['district'] = $user['district'];
        $_SESSION['ward'] = $user['ward'];

        // Chuyển hướng người dùng dựa trên quyền hạn
        $redirectUrl = $user['role'] == 0 ? '../frontend/index.html' : '../backend/index.php';
        echo json_encode(['success' => true, 'redirectUrl' => $redirectUrl]);
    } else {
        // Đăng nhập thất bại, gán thông báo lỗi
        echo json_encode(['success' => false, 'errorMsg' => 'Email hoặc mật khẩu không đúng.']);
    }
    exit();
}
?>
