<?php
// Kết nối đến cơ sở dữ liệu
include '../config/db.php';

// Bật hiển thị lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Lấy status_id từ tham số URL
$status_id = isset($_GET['status_id']) ? $_GET['status_id'] : die(json_encode(['error' => 'status_id not found']));

// Lấy thông tin trạng thái sản phẩm từ cơ sở dữ liệu dựa trên status_id
$sql = "SELECT id, name FROM status_products WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$status_id]);
$status_products = $stmt->fetch(PDO::FETCH_ASSOC);

if ($status_products) {
    // Trả về dữ liệu dạng JSON
    echo json_encode($status_products);
} else {
    echo json_encode(['error' => 'Status not found']);
}
?>
