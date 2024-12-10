<?php
require '../php/connect(place).php';

// Kiểm tra kết nối cơ sở dữ liệu
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

    
$sql = "SELECT * FROM province";
$ketqua = mysqli_query($connection, $sql);

if (!$ketqua) {
    die("Query failed: " . mysqli_error($connection));
}

if (isset($_POST['add_sale'])) {
    echo "<pre>";
    print_r($_POST);
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/96addb123b.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/thanhtoan.css">
</head>

<body>
    <section id="Thanhtoan">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center dh">
                <p id="status-text">THÔNG TIN ĐƠN HÀNG</p>
            </div>
            <div class="row">
                <div class="col-9" id="thongtinthanhtoan-bang">
                    <form action="xulythanhtoan.php" method="post" class="d-flex justify-content-between align-items-center flex-wrap ps-3 pe-2 rounded" id="orderForm">
                        <div class="mb-3 me-2 box-tttt">
                            <label for="fullname_user_order" class="form-label text-tttt">Họ và tên</label>
                            <input type="text" class="form-control" id="fullname_user_order" name="fullname_user_order" placeholder="Nhập họ và tên bạn" required>
                        </div>
                        <div class="mb-3 me-2 box-tttt">
                            <label for="email_user_order" class="form-label text-tttt">Email</label>
                            <input type="email" class="form-control" id="email_user_order" name="email_user_order" placeholder="Nhập email của bạn" required>
                        </div>
                        <div class="mb-3 me-2 box-tttt">
                            <label for="phone_user_order" class="form-label text-tttt">Số điện thoại</label>
                            <input type="tel" class="form-control" id="phone_user_order" name="phone_user_order" placeholder="Nhập số điện thoại của bạn" maxlength="10" pattern="\d{10}" required>
                        </div>
                        <div class="address d-flex flex-wrap">
                            <div class="mb-3 me-2 box-tttt">
                                <label for="city_user_order" class="form-label text-tttt">Tỉnh/Thành phố</label>
                                <select name="city_user_order" id="city_user_order" class="form-control" required>
                                    <option value="">Chọn tỉnh/thành phố</option>
                                    <?php while ($row = mysqli_fetch_assoc($ketqua)) { ?>
                                        <option value="<?php echo $row['province_id']; ?>">
                                            <?php echo $row['name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3 me-2 box-tttt">
                                <label for="district_user_order" class="form-label text-tttt">Quận/Huyện</label>
                                <select name="district_user_order" id="district_user_order" class="form-control" required>
                                    <option value="">Chọn quận/huyện</option>
                                </select>
                            </div>
                            <div class="mb-3 me-2 box-tttt">
                                <label for="ward_user_order" class="form-label text-tttt">Phường/Xã</label>
                                <select name="ward_user_order" id="ward_user_order" class="form-control" required>
                                    <option value="">Chọn phường/xã</option>
                                </select>
                            </div>
                            <div class="mb-3 me-2 box-tttt">
                                <label for="specific_address_user_order" class="form-label text-tttt">Địa chỉ cụ thể</label>
                                <input type="text" class="form-control" id="specific_address_user_order" name="specific_address_user_order" required>
                            </div>
                        </div>
                        <div class="mb-3 me-2 box-tttt">
                            <label for="notes_user_order" class="form-label text-tttt">Ghi chú đơn hàng</label>
                            <textarea class="form-control" id="notes_user_order" name="notes_user_order" rows="4" cols="95" placeholder="Nhập ghi chú"></textarea>
                        </div>
                        <div class="mb-3 me-2 box-tttt">
                            <label for="payment_methods" class="form-label text-tttt">Phương thức thanh toán</label>
                            <select name="payment_methods" id="payment_methods" class="form-control" required>
                                <option value="">Chọn phương thức thanh toán</option>
                                <option value="1">Thanh toán khi nhận hàng</option>
                            </select>
                        </div>                
                    </form>
                </div>
                <div class="col-3 ghichuthanhtoan rounded">
                    <p>ĐƠN HÀNG</p>
                    <div class="phivanchuyen">
                        <p><span class="left">Phí vận chuyển:</span><span class="right">Miễn phí</span>
                        </p>
                    </div>
                    <div class="phuongthucthanhtoan">
                        <p><span class="left">PT-TT:</span><span class="right"></span>
                        </p>
                    </div>
                    <hr>
                    <div class="tongthanhtien">
                        <p><span class="left">Tổng thành tiền:</span><span class="right" id="cartTotal"></span>
                        </p>
                    </div>
                    <hr>
                    <button type="button" class="btn xacnhanthanhtoan" id="xacnhanthanhtoan"> XÁC NHẬN THANH TOÁN</button>
                    <button type="button" class="btn rounded" id="QuayLaiGioHang">Quay lại giỏ hàng</button>
                </div>
            </div>
            <div class="row giohangdachon my-3">
                <div class="col-9">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col" style="color: #554dde">STT</th>
                                <th scope="col" style="color: #554dde">Ảnh</th>
                                <th scope="col" style="color: #554dde">Sản Phẩm</th>
                                <th scope="col" style="color: #554dde">Giá</th>
                                <th scope="col" style="color: #554dde">Số Lượng</th>
                                <th scope="col" style="color: #554dde">Thành Tiền</th>
                            </tr>
                        </thead>
                        <tbody id="cart-items">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/address_place.js"></script>

</body>

</html>
