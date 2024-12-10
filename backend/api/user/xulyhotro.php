<?php
header("Content-Type: application/json; charset=UTF-8");
require "../../config/db.php";

// Kiểm tra kết nối cơ sở dữ liệu
if (!$pdo) {
    echo json_encode(["status" => "error", "message" => "Không thể kết nối đến cơ sở dữ liệu"]);
    exit;
}

// Lấy dữ liệu từ yêu cầu POST và sử dụng htmlspecialchars để ngăn XSS
$fullname = htmlspecialchars($_POST['fullname_user_connect']);
$email = htmlspecialchars($_POST['email_user_connect']);
$phone = htmlspecialchars($_POST['phone_user_connect']);
$title = htmlspecialchars($_POST['title_user_connect']);
$notes = htmlspecialchars($_POST['notes_user_connect']);

// Kiểm tra dữ liệu đầu vào
if (empty($fullname) || empty($email) || empty($phone) || empty($title)) {
    echo json_encode(["status" => "error", "message" => "Vui lòng điền đầy đủ thông tin"]);
    exit;
}

// Chuẩn bị và thực thi truy vấn SQL để lưu dữ liệu
try {
    $sql = "INSERT INTO contact (fullname, email, phone_number, title, content) VALUES (:fullname, :email, :phone, :title, :notes)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':fullname' => $fullname,
        ':email' => $email,
        ':phone' => $phone,
        ':title' => $title,
        ':notes' => $notes
    ]);

    echo json_encode(["status" => "success", "message" => "Gửi liên hệ thành công!"]);
} catch (Exception $e) {
    // Lấy thông tin lỗi chi tiết từ PDO
    $errorInfo = $stmt->errorInfo();
    echo json_encode(["status" => "error", "message" => "Có lỗi xảy ra: " . $e->getMessage(), "sqlError" => $errorInfo]);
}
?>
