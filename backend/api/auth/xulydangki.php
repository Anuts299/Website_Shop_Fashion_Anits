<?php
session_start();

// Kết nối đến cơ sở dữ liệu
include '../../config/db.php';

// Xử lý thông tin đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form đăng ký và loại bỏ các ký tự đặc biệt
    $fullname = htmlspecialchars($_POST['fullname_user_register']);
    $phone_number = htmlspecialchars($_POST['phone_number_user_register']);
    $email = htmlspecialchars($_POST['email_user_register']);
    $password = htmlspecialchars($_POST['password_user_register']);


    // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu chưa
    $sql = "SELECT id, fullname, email, phone_number, password FROM user WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode(['success' => false, 'errorMsg' => 'Email đã tồn tại.']);
        exit();
    }
    

    // Lưu thông tin người dùng vào cơ sở dữ liệu
    $sql = "INSERT INTO user (fullname, phone_number, email, password) VALUES (:fullname, :phone_number, :email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['fullname' => $fullname, 'phone_number' => $phone_number, 'email' => $email, 'password' => $password]);

    // Tạo phiên đăng nhập
    $_SESSION['user_id'] = $pdo->lastInsertId();
    // $sql = "SELECT * FROM user WHERE id = :id";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute(['id' => $_SESSION['user_id']]);
    // $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // $_SESSION['email_new'] = $user['email'];
    // $_SESSION['fullname_new'] = $user['fullname'];
    // $_SESSION['phone_number_new'] = $user['phone_number'];
    // $_SESSION['address_new'] = $user['address'];
    // $_SESSION['birthday_new'] = $user['birthday'];
    // $_SESSION['gender_new'] = $user['gender'];


    // Chuyển hướng người dùng đến trang đăng nhập
    $redirectUrl = 'dangnhap';
    echo json_encode(['success' => true, 'redirectUrl' => $redirectUrl]);
    exit();
}
?>
