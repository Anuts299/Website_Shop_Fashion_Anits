<?php
session_start();
require "../php/connect(place).php";
require "../php/db.php";

// Kiểm tra kết nối cơ sở dữ liệu của địa chỉ
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
$sql = "SELECT * FROM province";
$ketqua = mysqli_query($connection, $sql);

if (!$ketqua) {
    die("Query failed: " . mysqli_error($connection));
}

// Kiểm tra kết nối cơ sở dữ liệu user
if ($pdo) {
    // Kiểm tra xem user_id có tồn tại trong session hay không
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM user WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Dữ liệu người dùng đã được lấy thành công
            // Tiếp tục xử lý dữ liệu ở đây
            echo "Người dùng được tìm thấy: ";
            print_r($user);
        } else {
            echo "Không tìm thấy người dùng";
        }
    } else {
        // echo "user_id không tồn tại trong session";
    }
} else {
    // echo "Không thể kết nối đến cơ sở dữ liệu";
}
?>

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
    <link rel="stylesheet" href="css/taikhoan.css">
</head>

<body>
    <section id="account" style="margin-top: 170px;">
        <div class="container">
            <div class="row">
                <div class="col-3 d-flex justify-content-end align-items-end">
                    <p class="text-ttcn">Thông Tin Cá Nhân</p>
                </div>
            </div>
            <form method="post" id="Capnhat_ttcn">
                <div class="row form-ttcn rounded mx-5">
                    <div class="col d-flex justify-content-between align-items-center flex-wrap">
                        <div class="mb-3 me-2 box-ttcn">
                            <label for="fullname_user" class="form-label text-ttct">Họ và tên</label>
                            <input type="text" class="form-control" id="fullname_user" name="fullname_user"
                                placeholder="Nhập họ và tên bạn" value="<?php echo isset($user['fullname']) ? $user['fullname'] : ""; ?>">
                        </div>
                        <div class="mb-3 me-2 box-ttcn">
                            <label for="email_user" class="form-label text-ttct">Email</label>
                            <input type="email" class="form-control" id="email_user" name="email_user"
                                placeholder="Nhập email của bạn"  value="<?php echo isset($user['email']) ? $user['email'] : ""; ?>">
                        </div>
                        <div class="mb-3 me-2 box-ttcn">
                            <label for="phone_user" class="form-label text-ttct">Số điện thoại</label>
                            <input type="tel" class="form-control" id="phone_user" name="phone_user"
                                placeholder="Nhập số điện thoại của bạn"  value="<?php echo isset($user['phone_number']) ? $user['phone_number'] : ""; ?>">
                        </div>
                        <div class="mb-3 me-2 box-ttcn gioitinh">
                            <label class="form-label text-ttct">Giới tính</label>
                            <div class="pe-5">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender_user" id="male_option"
                                    value="male" <?php if (isset($user['gender']) && $user['gender'] === 'male') echo 'checked'; ?>>
                                    <label class="form-check-label" for="male_option">Nam</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender_user" id="female_option"
                                    value="female" <?php if (isset($user['gender']) && $user['gender'] === 'female') echo 'checked'; ?>>
                                    <label class="form-check-label" for="female_option">Nữ</label>
                                </div>
                            </div>
                        </div>
                        <div class="address d-flex flex-wrap">
                            <div class="mb-3 me-2 box-ttcn">
                                <label for="city_user" class="form-label text-ttct">Tỉnh/Thành phố</label>
                                    <select name="city_user" id="city_user" class="form-control">
                                        <option value="">Chọn tỉnh/thành phố</option>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($ketqua)) {
                                            $selected = isset($user['city']) && $user['city'] == $row['province_id'] ? 'selected' : '';
                                        ?>
                                            <option value="<?php echo $row['province_id']; ?>" <?php echo $selected; ?>>
                                                <?php echo $row['name']; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                            </div>
                            <div class="mb-3 me-2 box-ttcn">
                                <label for="district_user" class="form-label text-ttct">Quận/Huyện</label>
                                <select name="district_user" id="district_user" class="form-control">
                                    <option value="">Chọn quận/huyện</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($ketqua)) {
                                        $selected = isset($user['district']) && $user['district'] == $row['district_id'] ? 'selected' : '';
                                    ?>
                                        <option value="<?php echo $row['district_id']; ?>" <?php echo $selected; ?>>
                                            <?php echo $row['name']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3 me-2 box-ttcn">
                                <label for="ward_user" class="form-label text-ttct">Phường/Xã</label>
                                <select name="ward_user" id="ward_user" class="form-control">
                                    <option value="">Chọn phường/xã</option>
                                    <?php
                                    // Duyệt qua danh sách các phường/xã và tạo option cho mỗi phường/xã
                                    while ($row = mysqli_fetch_assoc($ketqua)) {
                                        $selected = isset($user['ward']) && $user['ward'] == $row['ward_id'] ? 'selected' : '';
                                    ?>
                                        <option value="<?php echo $row['ward_id']; ?>" <?php echo $selected; ?>>
                                            <?php echo $row['name']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3 me-2 box-ttcn">
                                <label for="specific_address_user" class="form-label text-ttct">Địa chỉ cụ thể</label>
                                <input type="text" class="form-control" id="specific_address_user"
                                    name="specific_address_user" placeholder="Địa chỉ cụ thể" value="<?php echo isset($user['specific_address']) ? $user['specific_address'] : ""; ?>">
                            </div>
                        </div>
                        <div class="mb-3 me-2 box-ttcn">
                            <label for="birthday_user" class="form-label text-ttct">Ngày sinh</label>
                            <input type="date" class="form-control" id="birthday_user" name="birthday_user" value="<?php echo isset($user['birthday']) ? $user['birthday'] : ''; ?>">
                        </div>
                        <button type="submit" id="saveButton" class="btn rounded btn-rounded">Lưu Thông Tin</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/taikhoan.js"></script>
    <script src="js/address_place.js"></script>
    <script>
        $(document).ready(function() {
            $('#Capnhat_ttcn').submit(function(e) {
                e.preventDefault(); // Ngăn chặn hành vi gửi form mặc định

                // Lấy giá trị từ các trường input và select box
                var formData = {
                    fullname_user: $('#fullname_user').val(),
                    email_user: $('#email_user').val(),
                    phone_user: $('#phone_user').val(),
                    gender_user: $('input[name="gender_user"]:checked').val(),
                    city_user: $('#city_user option:selected').text(),
                    district_user: $('#district_user option:selected').text(),
                    ward_user: $('#ward_user option:selected').text(),
                    specific_address_user: $('#specific_address_user').val(),
                    birthday_user: $('#birthday_user').val()
                };
                $.ajax({
                    type: 'POST',
                    url: '../backend/api/user/xulycapnhat_ttcn.php',
                    data: formData,
                    success: function(response) {
                        // Hiển thị thông báo khi thành công
                        alert('Cập nhật thông tin cá nhân thành công!');
                        
                    },
                    error: function() {
                        // Xử lý lỗi khi không thể gửi dữ liệu
                        console.log('Có lỗi xảy ra khi gửi dữ liệu');
                    }
                });
            });
        });

    </script>
</body>

</html>