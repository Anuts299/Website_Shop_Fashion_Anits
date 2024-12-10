<?php
// Kết nối đến cơ sở dữ liệu
include '../config/db.php';

// Bật hiển thị lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
// Lấy brand_id từ tham số URL
$brand_id = isset($_GET['brand_id']) ? $_GET['brand_id'] : die(json_encode(['error' => 'brand_id not found']));

// Lấy thông tin thương hiệu từ cơ sở dữ liệu dựa trên brand_id
$sql = "SELECT id, name FROM brand WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$brand_id]);
$brand = $stmt->fetch(PDO::FETCH_ASSOC);

if ($brand) {
    // Trả về dữ liệu dạng JSON
    echo json_encode($brand);
} else {
    echo json_encode(['error' => 'Brand not found']);
}
?>
