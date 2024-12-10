<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $response = array('success' => false, 'message' => 'User ID not found in session.');
    echo json_encode($response);
    exit();
}

include '../../config/db.php';

$user_id = $_SESSION['user_id'];

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->cart_items)) {
    try {
        $pdo->beginTransaction();

        $sql = "DELETE FROM cart WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);

        foreach ($data->cart_items as $item) {
            $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'user_id' => $user_id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity
            ]);
        }

        $pdo->commit();

        $response = array('success' => true, 'message' => 'Cart updated successfully.');
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log('Error updating cart items: ' . $e->getMessage());
        $response = array('success' => false, 'message' => 'Error updating cart items.');
    }
} else {
    $response = array('success' => false, 'message' => 'No cart items provided.');
}

echo json_encode($response);
?>
