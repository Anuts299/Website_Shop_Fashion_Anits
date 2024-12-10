<?php
require "../config/db.php";

// Kiểm tra xem có tham số order_id được gửi tới hay không
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Truy vấn thông tin đơn hàng
    $sql = "SELECT o.id, o.order_date, o.exp_del_date, s.name AS status_name,
                    o.fullname, o.phone_number, o.email, o.address,o.total_money
            FROM orders o
            JOIN status_order s ON o.status_order_id = s.id
            WHERE o.id = :order_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['order_id' => $order_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    // Truy vấn chi tiết sản phẩm trong đơn hàng
    $sql_items = "SELECT od.product_id, od.quantity, od.price, p.fullname AS product_name
                  FROM order_detail od
                  JOIN products p ON od.product_id = p.id
                  WHERE od.order_id = :order_id";
    $stmt_items = $pdo->prepare($sql_items);
    $stmt_items->execute(['order_id' => $order_id]);
    $order_items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);

    if ($order) {
        ?>
        <p><strong>Mã đơn hàng:</strong> <?php echo htmlspecialchars($order['id']); ?></p>
        <p><strong>Ngày đặt hàng:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($order['order_date']))); ?></p>
        <p><strong>Ngày giao dự kiến:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($order['exp_del_date']))); ?></p>
        <p><strong>Trạng thái:</strong> <?php echo htmlspecialchars($order['status_name']); ?></p>
        <p><strong>Tên người mua:</strong> <?php echo htmlspecialchars($order['fullname']); ?></p>
        <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['phone_number']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
        <p><strong>Địa chỉ đặt hàng:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
        <h5>Chi tiết sản phẩm:</h5>
        <ul>
        <?php foreach ($order_items as $item) { ?>
            <li>
                <?php echo htmlspecialchars($item['product_name']); ?> - Số lượng: <?php echo htmlspecialchars($item['quantity']); ?> - Giá: <?php echo number_format(htmlspecialchars($item['price']), 0, ',', '.'); ?> <span>vnđ</span>
            </li>
        <?php } ?>
        </ul>
        <p style="font-size: 18px;"><strong>Tổng tiền: <u><?php echo number_format($order['total_money'], 0, ',', '.'); ?> vnđ</u></strong></p>
        <?php
    } else {
        echo '<p>Không tìm thấy chi tiết đơn hàng.</p>';
    }
} else {
    echo '<p>Không có ID đơn hàng được cung cấp.</p>';
}
?>
