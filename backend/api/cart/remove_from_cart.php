<?php
session_start();

// Debug: Log session và các giá trị quan trọng
error_log('Session user_id: ' . $_SESSION['user_id']);

// Bạn cần chắc chắn rằng $_SESSION['user_id'] có giá trị hợp lệ trước khi tiếp tục
if (!isset($_SESSION['user_id'])) {
    $response = array('success' => false, 'message' => 'User ID not found in session.');
    echo json_encode($response);
    exit();
}

include '../../config/db.php';
// Kiểm tra kết nối cơ sở dữ liệu
if (!$pdo) {
    $response = array('success' => false, 'message' => 'Unable to connect to database');
    exit;
}
$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];

if ($product_id) {
    try {
        $sql = "DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);

        $response = array('success' => true, 'message' => 'Product removed from cart.');
    } catch (PDOException $e) {
        error_log('Error removing cart item: ' . $e->getMessage());
        $response = array('success' => false, 'message' => 'Error removing cart item.');
    }
} else {
    $response = array('success' => false, 'message' => 'Product ID not provided.');
}

echo json_encode($response);
?>
