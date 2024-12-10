<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");
require "../../config/db.php";

// Kiểm tra kết nối cơ sở dữ liệu
if (!$pdo) {
    echo json_encode(["status" => "error", "message" => "Không thể kết nối đến cơ sở dữ liệu"]);
    exit;
}

// Nhận dữ liệu POST từ request AJAX
$data = json_decode(file_get_contents("php://input"), true);

// Kiểm tra dữ liệu
$fullname = htmlspecialchars($data['fullname']);
$email = htmlspecialchars($data['email']);
$phone = htmlspecialchars($data['phone']);
$address = htmlspecialchars($data['address']);
$paymentMethod = htmlspecialchars($data['paymentMethod']);
$totalMoney = intval($data['totalMoney']); // Chuyển đổi thành số nguyên
$notes = htmlspecialchars($data['notes']);
$cartItems = $data['cartItems']; // Mảng sản phẩm

// Kiểm tra dữ liệu đầu vào
if (empty($fullname) || empty($email) || empty($phone) || empty($address) || empty($paymentMethod) || $totalMoney <= 0 || empty($cartItems)) {
    echo json_encode(["status" => "error", "message" => "Vui lòng điền đầy đủ thông tin để thanh toán và giỏ hàng không được trống."]);
    exit;
}

// Xử lý thêm dữ liệu vào bảng order và order_detail
try {
    // Bắt đầu transaction để đảm bảo tính nhất quán của dữ liệu
    $pdo->beginTransaction();

    // Thêm dữ liệu vào bảng orders
    $sql_order = "INSERT INTO orders (user_id, fullname, email, phone_number, address, payment_methods, total_money, notes, order_date, exp_del_date)
                  VALUES (:user_id, :fullname, :email, :phone, :address, :paymentMethod, :totalMoney, :notes, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 3 DAY))";
    $stmt_order = $pdo->prepare($sql_order);
    $stmt_order->execute([
        ':user_id' => $_SESSION['user_id'],
        ':fullname' => $fullname,
        ':email' => $email,
        ':phone' => $phone,
        ':address' => $address,
        ':paymentMethod' => $paymentMethod,
        ':totalMoney' => $totalMoney,
        ':notes' => $notes
    ]);

    // Lấy ID của đơn hàng vừa thêm vào
    $order_id = $pdo->lastInsertId();

    // Thêm dữ liệu vào bảng order_detail
    $sql_order_detail = "INSERT INTO order_detail (order_id, product_id, price, quantity)
                         VALUES (:order_id, :product_id, :price, :quantity)";
    $stmt_order_detail = $pdo->prepare($sql_order_detail);

    foreach ($cartItems as $item) {
        $stmt_order_detail->execute([
            ':order_id' => $order_id,
            ':product_id' => $item['product_id'],
            ':price' => $item['price'],
            ':quantity' => $item['quantity']
        ]);
    }

    // Xóa giỏ hàng của người dùng sau khi đặt hàng thành công
    $sql_delete_cart = "DELETE FROM cart WHERE user_id = :user_id";
    $stmt_delete_cart = $pdo->prepare($sql_delete_cart);
    $stmt_delete_cart->execute([':user_id' => $_SESSION['user_id']]);

    // Commit transaction nếu không có lỗi
    $pdo->commit();

    echo json_encode(["status" => "success", "message" => "Đặt hàng thành công!"]);

} catch (Exception $e) {
    // Rollback transaction nếu có lỗi xảy ra
    $pdo->rollBack();

    echo json_encode(["status" => "error", "message" => "Có lỗi xảy ra trong quá trình đặt hàng.", "sqlError" => $e->getMessage()]);
}
?>
