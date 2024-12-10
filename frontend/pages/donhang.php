<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/96addb123b.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/donhang.css">
</head>

<body>
    <section id="Donhang">
        <div class="container">
            <div class="row">
                <div class="col d-flex justify-content-center align-items-center dh">
                    <p>Đơn Hàng Của Bạn</p>
                </div>
            </div>
            <div class="row">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col" style="color: #554dde">Mã đơn hàng</th>
                            <th scope="col" style="color: #554dde">Ngày đặt hàng</th>
                            <th scope="col" style="color: #554dde">Ngày giao dự kiến</th>
                            <th scope="col" style="color: #554dde">Trạng thái</th>
                            <th scope="col" style="color: #554dde">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="table-striped bangdonhang">
                        <?php
                        session_start();
                        // Include file kết nối PDO
                        include '../php/db.php';
                        $user_id = $_SESSION['user_id'];
                        // Truy vấn dữ liệu đơn hàng với join để lấy tên trạng thái
                        $sql = "SELECT o.id, o.order_date, o.exp_del_date, s.name AS status_name
                                FROM orders o
                                JOIN status_order s ON o.status_order_id = s.id
                                WHERE o.user_id = :user_id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute(['user_id' => $user_id]);
                        // Duyệt kết quả truy vấn và hiển thị dữ liệu
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <tr>
                                <th scope="row"><?php echo htmlspecialchars($row['id']); ?></th>
                                <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($row['order_date']))); ?></td>
                                <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($row['exp_del_date']))); ?></td>
                                <td><?php echo htmlspecialchars($row['status_name']); ?></td>
                                <td><button class="btn btn-detail" type="button" data-id="<?php echo htmlspecialchars($row['id']); ?>">Chi Tiết</button></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailModalLabel">Chi Tiết Đơn Hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Nội dung chi tiết đơn hàng sẽ được đổ vào đây -->
                    <div id="orderDetailContent"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Load jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Load Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('.btn-detail').click(function() {
                var orderId = $(this).data('id');

                // Gửi yêu cầu AJAX để lấy chi tiết đơn hàng
                $.ajax({
                    url: '../backend/api/order_detail.php',
                    type: 'GET',
                    data: { order_id: orderId },
                    success: function(response) {
                        // Đổ nội dung chi tiết đơn hàng vào modal
                        $('#orderDetailContent').html(response);
                        // Hiển thị modal
                        $('#orderDetailModal').modal('show');
                    },
                    error: function() {
                        alert('Không thể lấy chi tiết đơn hàng.');
                    }
                });
            });
        });
    </script>
</body>

</html>
