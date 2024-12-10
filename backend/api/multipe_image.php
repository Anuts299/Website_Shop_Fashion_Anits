<?php
// Include file kết nối PDO
include '../config/db.php';

// Lấy product_id từ tham số GET
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;

if (!$product_id) {
    http_response_code(400);
    echo json_encode(['message' => 'Product ID is required']);
    exit;
}

// Truy vấn để lấy danh sách các hình ảnh từ bảng multipe-image
$sql_images = "SELECT id, product_id, thumbnail FROM multipe_image WHERE product_id = :product_id";
$stmt_images = $pdo->prepare($sql_images);
$stmt_images->execute(['product_id' => $product_id]);
$images = $stmt_images->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($images);
?>
