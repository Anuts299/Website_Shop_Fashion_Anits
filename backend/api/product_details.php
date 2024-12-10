<?php
// Kết nối cơ sở dữ liệu
include '../config/db.php';

// Bật hiển thị lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Lấy product_id từ tham số URL
$product_id = isset($_GET['id']) ? $_GET['id'] : die('products_id not found');
    // Lấy thông tin chi tiết của sản phẩm từ cơ sở dữ liệu dựa trên id
    $sql = "SELECT id, fullname, mota, price, discount, brand_id, thumbnail FROM products WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$product_id]);
    $product_details = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra xem có thông tin sản phẩm không
    if ($product_details) {
        // Trả về dữ liệu dạng JSON
        echo json_encode($product_details);
    } else {
        // Trả về lỗi nếu không tìm thấy sản phẩm
        echo json_encode(array('error' => 'Sản phẩm không tồn tại'));
    }

?>
