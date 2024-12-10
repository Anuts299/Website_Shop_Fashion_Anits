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

$user_id = $_SESSION['user_id'];

try {
    $sql = "SELECT c.product_id, p.fullname, p.thumbnail, p.price, c.quantity
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($cartItems) {
        $response['success'] = true;
        $response['cart'] = $cartItems;
    } else {
        $response['message'] = 'No cart items found for this user.';
    }
} catch (PDOException $e) {
    error_log('Error fetching cart items: ' . $e->getMessage());
    $response = array('success' => false, 'message' => 'Error fetching cart items.');
}

echo json_encode($response);
?>
