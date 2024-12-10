
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/lienhe.css">
</head>
<body>
<section id="Lienhe">
    <div class="container">
        <div class="row lh">
            <p>THÔNG TIN LIÊN HỆ</p>
        </div>
        <div class="row">
            <div class="col-9" id="thongtinlienhe-bang">
                <form id="Guihotro" method="post" class="d-flex justify-content-between align-items-center flex-wrap ps-3 pe-2 rounded">
                    <div class="mb-3 me-2 box-ttlh">
                        <label for="fullname_user_connect" class="form-label text-ttlh">Họ và tên</label>
                        <input type="text" class="form-control" id="fullname_user_connect" name="fullname_user_connect" placeholder="Nhập họ và tên bạn" required>
                    </div>
                    <div class="mb-3 me-2 box-ttlh">
                        <label for="email_user_connect" class="form-label text-ttlh">Email</label>
                        <input type="email" class="form-control" id="email_user_connect" name="email_user_connect" placeholder="Nhập email của bạn" required>
                    </div>
                    <div class="mb-3 me-2 box-ttlh">
                        <label for="phone_user_connect" class="form-label text-ttlh">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone_user_connect" name="phone_user_connect" placeholder="Nhập số điện thoại của bạn" maxlength="10" pattern="\d{10}" required>
                    </div>
                    <div class="mb-3 me-2 box-ttlh">
                        <label for="title_user_connect" class="form-label text-ttlh">Tiêu đề</label>
                        <input type="text" class="form-control" id="title_user_connect" name="title_user_connect" placeholder="Nhập tiêu đề" maxlength="200"  required>
                    </div>
                    <div class="mb-3 me-2 box-ttlh">
                        <label for="notes_user_connect" class="form-label text-ttlh">Nội dung liên hệ</label>
                        <textarea class="form-control" id="notes_user_connect" name="notes_user_connect" rows="4" cols="95" placeholder="Nhập nội dung"></textarea>
                    </div>
                    <Button type="submit" class="btn xacnhanguilienhe" id="xacnhanguilienhe"> GỬI </Button>
                </form>
            </div>
            <div class="col-3 ghichulienhe rounded" >
                <h2>MỘT SỐ LƯU Ý NHỎ</h2>
                <p>Việc phản hồi liên hệ sẽ được gửi qua email do bạn cung cấp và thời gian phản hồi sẽ sớm nhất có thể</p>
                <p>Nếu bạn cần liên hệ gấp xin vui lòng gọi theo số điện thoại:</p>
                <p class="dthotro">1900 1508</p>
            </div>
        </div>
    </div>
</section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
         $(document).ready(function() {
            $('#Guihotro').submit(function(e) {
                e.preventDefault(); // Ngăn chặn hành vi gửi form mặc định

                var formData = $(this).serialize(); // Thu thập dữ liệu từ form

                $.ajax({
                    type: 'POST',
                    url: '../backend/api/user/xulyhotro.php',
                    data: formData,
                    success: function(response) {
                        console.log(response); // In ra phản hồi từ máy chủ
                        if (response.status === 'success') {
                            alert('Gửi liên hệ thành công!');
                        } else {
                            alert('Lỗi: ' + response.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Có lỗi xảy ra khi gửi dữ liệu:', textStatus, errorThrown);
                    }
                });
            });
        });
    </script>
</body>
</html>