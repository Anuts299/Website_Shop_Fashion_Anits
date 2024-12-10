<?php
// Kết nối đến cơ sở dữ liệu
include '../config/db.php';

// Bật hiển thị lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Kiểm tra xem có id được truyền vào không
if (isset($_GET['id'])) {
    // Nếu có id, thực hiện hành động tương ứng
    $id = $_GET['id'];
    $sql = "SELECT id, title FROM blog_category WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($category);
} else {
    // Nếu không có id, thực hiện hành động mặc định
    $sql = "SELECT id, title FROM blog_category";
    $stmt = $pdo->query($sql);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($categories);
}
?>
