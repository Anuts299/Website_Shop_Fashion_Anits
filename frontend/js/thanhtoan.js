$(document).ready(function () {
    // Lấy giá trị tổng tiền từ localStorage
    var cartTotal = localStorage.getItem('cartTotal');
    if (cartTotal !== null) {
        document.getElementById('cartTotal').innerText = parseFloat(cartTotal).toLocaleString('en');
    } else {
        document.getElementById('cartTotal').innerText = '0';
    }

    // Quay lại giỏ hàng khi nhấn nút "Quay lại giỏ hàng"
    $("#QuayLaiGioHang").click(function (e) {
        e.preventDefault();
        $('#Thanhtoan').hide();
        $('#noidung').load('pages/giohang.php', function () {
            $.getScript("js/giohang.js");
        });
    });

    // Hàm cập nhật phương thức thanh toán
    function updatePaymentMethod() {
        var paymentMethods = document.getElementById('payment_methods');
        var selectedOption = paymentMethods.options[paymentMethods.selectedIndex].text;
        document.querySelector('.phuongthucthanhtoan .right').innerText = selectedOption;
    }

    // Lắng nghe sự kiện thay đổi của select
    document.getElementById('payment_methods').addEventListener('change', updatePaymentMethod);

    // Hiển thị các sản phẩm từ LocalStorage vào bảng sản phẩm
    var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    var cartTableBody = document.getElementById('cart-items');

    // Kiểm tra và làm trống `tbody` trước khi thêm sản phẩm mới
    if (cartTableBody) {
        cartTableBody.innerHTML = '';

        if (cartItems.length > 0) {
            var html = '';

            cartItems.forEach(function (item, index) {
                html += `
                    <tr>
                        <th scope="row">${index + 1}</th>
                        <td><img src="${item.image}" alt="${item.name}" width="50"></td>
                        <td>${item.name}</td>
                        <td>${item.price}</td>
                        <td>${item.quantity}</td>
                        <td>${item.total}</td>
                    </tr>
                `;
            });

            cartTableBody.innerHTML = html;
            console.log(cartTableBody);
        } else {
            console.log("Không tìm thấy sản phẩm trong giỏ hàng");
        }
    } else {
        console.error("Không tìm thấy phần tử `cart-items`");
    }

    // Kiểm tra thông tin khi người dùng xác nhận thanh toán
    $("#xacnhanthanhtoan").click(function (e) {
        e.preventDefault();

        var fullname = document.getElementById("fullname_user_order").value.trim();
        var email = document.getElementById("email_user_order").value.trim();
        var phone = document.getElementById("phone_user_order").value.trim();
        var city = document.getElementById("city_user_order").options[document.getElementById("city_user_order").selectedIndex].innerHTML;
        var district = document.getElementById("district_user_order").options[document.getElementById("district_user_order").selectedIndex].innerHTML;
        var ward = document.getElementById("ward_user_order").options[document.getElementById("ward_user_order").selectedIndex].innerHTML;
        var specificAddress = document.getElementById("specific_address_user_order").value.trim();
        var paymentMethod = document.getElementById("payment_methods").options[document.getElementById("payment_methods").selectedIndex].innerHTML;
        var notes = document.getElementById("notes_user_order").value;

        // Kiểm tra các trường thông tin nhập liệu
        if (!fullname || !email || !phone || !city || !district || !ward || !specificAddress || !paymentMethod) {
            alert("Vui lòng điền đầy đủ thông tin để thanh toán.");
            return;
        }

        // Kiểm tra họ tên không chứa số
        if (/\d/.test(fullname)) {
            alert("Họ và tên không được chứa số.");
            return;
        }

        // Kiểm tra định dạng email
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            alert("Email không hợp lệ.");
            return;
        }

        // Kiểm tra số điện thoại có đúng 10 chữ số hay không
        if (!/^\d{10}$/.test(phone)) {
            alert("Số điện thoại phải có 10 chữ số.");
            return;
        }

        // Nối các địa chỉ thành một chuỗi duy nhất
        var address = specificAddress + ', ' + ward + ', ' + district + ', ' + city;

        // Nếu các điều kiện nhập liệu đều hợp lệ, gửi thông tin đơn hàng bằng AJAX
        var orderData = {
            fullname: fullname,
            email: email,
            phone: phone,
            address: address,
            paymentMethod: paymentMethod,
            totalMoney: cartTotal,
            notes: notes,
            cartItems: JSON.parse(localStorage.getItem('cartItems')) || []
        };

        $.ajax({
            url: 'http://localhost/baibaocao/backend/api/auth/xulythanhtoan.php',
            type: 'POST',
            data: JSON.stringify(orderData),
            contentType: 'application/json; charset=utf-8',
            success: function (response) {
                // Xóa giỏ hàng và tổng tiền từ localStorage khi đặt hàng thành công
                localStorage.removeItem('cartItems');
                localStorage.removeItem('cartTotal');
                alert("Bạn đã đặt hàng thành công!");
            },
            error: function (xhr, status, error) {
                alert("Có lỗi xảy ra trong quá trình đặt hàng. Vui lòng thử lại.");
            }
        });
    });

});
