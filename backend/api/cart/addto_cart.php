<?php
session_start();

$response = array('success' => false); // Khởi tạo phản hồi mặc định

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    echo json_encode($response);
    exit();
}

// Kết nối đến cơ sở dữ liệu
include '../../config/db.php';

// Lấy thông tin từ yêu cầu POST
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$user_id = $_SESSION['user_id'];

try {
    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    $sql = "SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cart_item) {
        // Nếu sản phẩm đã có trong giỏ hàng, cập nhật số lượng
        $new_quantity = $cart_item['quantity'] + $quantity;
        $sql = "UPDATE cart SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['quantity' => $new_quantity, 'user_id' => $user_id, 'product_id' => $product_id]);
    } else {
        // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
        $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'quantity' => $quantity]);
    }

    $response['success'] = true;
} catch (PDOException $e) {
    error_log('Error adding product to cart: ' . $e->getMessage());
}

echo json_encode($response);
?>
