<?php
//Kết nối cơ sở dữ liệu
include '../config/db.php';

//Bật hiển thị lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Lấy danh sách các danh mục sản phẩm từ cơ sở dữ liệu
$sql = "SELECT id, name_category, thumbnail FROM product_category";
$stmt = $pdo->query($sql);
$product_category = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Trả về dữ liệu dạng JSON
echo json_encode($product_category);
?>