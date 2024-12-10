<?php
session_start();

// Kết nối đến cơ sở dữ liệu
require "../../config/db.php";

// Khởi tạo biến thông báo lỗi
$error_msg = '';
$user_id = $_SESSION['user_id'];
// Xử lý thông tin cập nhật thông tin cá nhân
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form cập nhật thông tin và loại bỏ các ký tự đặc biệt
    $fullname = htmlspecialchars($_POST['fullname_user']);
    $email = htmlspecialchars($_POST['email_user']);
    $phone_number = htmlspecialchars($_POST['phone_user']);
    $gender = htmlspecialchars($_POST['gender_user']);
    $city = htmlspecialchars($_POST['city_user']);
    $district = htmlspecialchars($_POST['district_user']);
    $ward = htmlspecialchars($_POST['ward_user']);
    $address = htmlspecialchars($_POST['specific_address_user']);
    $birthday = htmlspecialchars($_POST['birthday_user']);

    $sql_update = "UPDATE user SET fullname = ?, email = ?, phone_number = ?, gender = ?, city= ?, district = ?, ward= ?, specific_address = ?, birthday = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql_update);
    $stmt->execute([$fullname, $email, $phone_number, $gender, $city, $district, $ward, $address, $birthday, $user_id]);

    // Kiểm tra xem cập nhật thành công hay không và trả về kết quả tương ứng
    if ($stmt->rowCount() > 0) {
        $response = array(
            'success' => true,
            'message' => 'Thông tin cá nhân đã được cập nhật thành công!'
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Có lỗi xảy ra khi cập nhật thông tin cá nhân!'
        );
    }

    echo json_encode($response); // Trả về dưới dạng JSON
    exit();
}
?>
