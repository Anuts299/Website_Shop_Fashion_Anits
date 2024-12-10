<?php
//Kết nối cơ sở dữ liệu
include '../config/db.php';

//Bật hiển thị lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Lấy 3 bài blogs mới nhất
$sql= "SELECT id, title_blog, author, content_blog, blog_category_id, publish_date, thumbnail FROM blogs ORDER BY id DESC LIMIT 3";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$blogs_new = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Trả về dữ liệu dạng JSON
echo json_encode($blogs_new);
?>