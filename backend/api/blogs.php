<?php
// Kết nối đến cơ sở dữ liệu
include '../config/db.php';

// Bật hiển thị lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Lấy blog_category_id từ tham số URL
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : die('category_id not found');

// Lấy danh sách các bài viết từ cơ sở dữ liệu dựa trên blog_category_id
$sql = "SELECT id, title_blog, author, content_blog, publish_date, thumbnail FROM blogs WHERE blog_category_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$category_id]);
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Trả về dữ liệu dạng JSON
echo json_encode($blogs);
?>
