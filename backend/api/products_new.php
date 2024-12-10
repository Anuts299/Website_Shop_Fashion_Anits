<?php
// Kết nối đến cơ sở dữ liệu
include '../config/db.php';

// Bật hiển thị lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Lấy danh sách các sản phẩm mới từ cơ sở dữ liệu
$sql = "SELECT id, fullname, mota, price, discount, brand_id, stock_quantity, status_products, thumbnail FROM products ORDER BY id DESC LIMIT 8";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products_new = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Trả về dữ liệu dạng JSON
echo json_encode($products_new);
?>
