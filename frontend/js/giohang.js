// Tải nội dung của trang giỏ hàng và định nghĩa các hàm trong callback
$("#noidung").load("pages/giohang.php", function () {

    // Hàm để lấy dữ liệu giỏ hàng từ máy chủ
    function fetchCart() {
        $.ajax({
            url: 'http://localhost/baibaocao/backend/api/cart/get_cart.php', // URL để lấy dữ liệu giỏ hàng
            method: 'GET', // Phương thức HTTP
            dataType: 'json', // Kiểu dữ liệu mong đợi từ máy chủ
            success: function (response) {
                if (response.success) {
                    renderCart(response.cart); // Hiển thị các mục giỏ hàng
                    attachEventListeners(); // Gắn các sự kiện cho các tương tác với giỏ hàng
                } else {
                    alert('Không thể lấy thông tin giỏ hàng.'); // Thông báo nếu không thể lấy dữ liệu giỏ hàng
                }
            },
            error: function (error) {
                console.error('Lỗi khi lấy giỏ hàng:', error); // Ghi lỗi nếu yêu cầu thất bại
            }
        });
    }

    // Hàm để hiển thị các mục giỏ hàng trên trang
    function renderCart(cartItems) {
        const cartItemsContainer = $('#cart-items'); // Container chứa các mục giỏ hàng
        cartItemsContainer.empty(); // Xóa sạch các mục hiện có

        let totalAmount = 0; // Khởi tạo tổng số tiền

        // Vòng lặp qua các mục giỏ hàng và tạo HTML cho mỗi mục
        cartItems.forEach((item, index) => {
            const itemTotal = item.price * item.quantity; // Tính tổng giá cho mục này
            totalAmount += itemTotal; // Thêm tổng giá của mục vào tổng giỏ hàng

            const cartItem = $(`
                <tr data-product-id="${item.product_id}">
                    <th scope="row">${index + 1}</th>
                    <th><img src="${item.thumbnail}" alt=""></th>
                    <th>${item.fullname}</th>
                    <th class="price">${item.price.toLocaleString()} vnđ</th>
                    <th class="quantity">
                        <div class="input-group">
                            <button class="btn btn-outline-secondary decrease" type="button">-</button>
                            <input type="text" class="form-control quantity-input" value="${item.quantity}">
                            <button class="btn btn-outline-secondary increase" type="button">+</button>
                        </div>
                    </th>
                    <th class="total">${itemTotal.toLocaleString()} vnđ <button type="button" class="btn xoasp"><i class="fa-solid fa-trash"></i></button></th>
                </tr>
            `);
            cartItemsContainer.append(cartItem); // Thêm mục giỏ hàng vào container
        });

        $('#card-total').text(totalAmount.toLocaleString() + ' vnđ'); // Hiển thị tổng số tiền của giỏ hàng
    }

    // Hàm xử lý sự kiện khi tăng/giảm số lượng
    function attachEventListeners() {
        var decreaseButtons = document.querySelectorAll('#Giohang .decrease'); // Các nút giảm số lượng
        var increaseButtons = document.querySelectorAll('#Giohang .increase'); // Các nút tăng số lượng
        var quantityInputs = document.querySelectorAll('#Giohang .quantity-input'); // Các ô nhập số lượng
        var deleteButtons = document.querySelectorAll('#Giohang .xoasp'); // Các nút xóa sản phẩm

        // Gắn sự kiện cho các nút giảm số lượng
        decreaseButtons.forEach(function (button, index) {
            button.addEventListener('click', function () {
                var quantity = parseInt(quantityInputs[index].value);
                if (quantity > 1) {
                    quantityInputs[index].value = quantity - 1; // Giảm số lượng
                    updateTotal(index); // Cập nhật tổng giá cho mục này
                    updateCartTotal(); // Cập nhật tổng giá giỏ hàng
                    updateCartItemQuantity(quantityInputs[index].closest('tr').dataset.productId, quantity - 1); // Cập nhật số lượng mục giỏ hàng
                }
            });
        });

        // Gắn sự kiện cho các nút tăng số lượng
        increaseButtons.forEach(function (button, index) {
            button.addEventListener('click', function () {
                var quantity = parseInt(quantityInputs[index].value);
                quantityInputs[index].value = quantity + 1; // Tăng số lượng
                updateTotal(index); // Cập nhật tổng giá cho mục này
                updateCartTotal(); // Cập nhật tổng giá giỏ hàng
                updateCartItemQuantity(quantityInputs[index].closest('tr').dataset.productId, quantity + 1); // Cập nhật số lượng mục giỏ hàng
            });
        });

        // Gắn sự kiện cho các nút xóa sản phẩm
        deleteButtons.forEach(function (button, index) {
            button.addEventListener('click', function () {
                var productId = button.closest('tr').dataset.productId; // Lấy ID sản phẩm
                removeFromCart(productId, function () {
                    button.closest('tr').remove(); // Xóa mục giỏ hàng khỏi HTML
                    updateCartTotal(); // Cập nhật tổng giá giỏ hàng
                    updateSTT(); // Cập nhật số thứ tự
                    attachEventListeners(); // Gắn lại các sự kiện

                    // Lưu lại các mục giỏ hàng còn lại vào localStorage
                    var cartItems = [];
                    document.querySelectorAll('#Giohang tr[data-product-id]').forEach(function (row) {
                        var id = row.dataset.productId;
                        var qty = localStorage.getItem(`cartItem_${id}`);
                        cartItems.push({
                            product_id: id,
                            quantity: qty
                        });
                    });
                    saveCartToDatabase(cartItems); // Lưu giỏ hàng vào cơ sở dữ liệu
                });
            });
        });
    }

    // Hàm cập nhật số lượng sản phẩm trong giỏ hàng
    function updateCartItemQuantity(productId, quantity) {
        // Lưu số lượng sản phẩm vào localStorage
        localStorage.setItem(`cartItem_${productId}`, quantity);

        // Lấy toàn bộ giỏ hàng từ localStorage
        var cartItems = [];
        document.querySelectorAll('#Giohang tr[data-product-id]').forEach(function (row) {
            var id = row.dataset.productId;
            var qty = localStorage.getItem(`cartItem_${id}`);
            cartItems.push({
                product_id: id,
                quantity: qty
            });
        });

        // Lưu giỏ hàng vào cơ sở dữ liệu
        saveCartToDatabase(cartItems);
    }
    // Hàm gọi để cập nhật số lượng sản phẩm trong cơ sở dữ liệu
    function saveCartToDatabase(cartItems) {
        $.ajax({
            url: 'http://localhost/baibaocao/backend/api/cart/update_cart.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ cart_items: cartItems }),

            success: function (response) {
                if (response.success) {
                    console.log('Cập nhật giỏ hàng thành công.');
                } else {
                    console.error('Không thể cập nhật giỏ hàng:', response.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Lỗi khi cập nhật giỏ hàng:', textStatus, errorThrown);
            }
        });
    };


    // Hàm xóa sản phẩm khỏi giỏ hàng
    function removeFromCart(productId, callback) {
        $.ajax({
            url: 'http://localhost/baibaocao/backend/api/cart/remove_from_cart.php', // URL để xóa sản phẩm khỏi giỏ hàng
            method: 'POST', // Phương thức HTTP
            data: { product_id: productId }, // Dữ liệu gửi đi
            dataType: 'json', // Kiểu dữ liệu mong đợi từ máy chủ
            success: function (response) {
                if (response.success) {
                    callback(); // Gọi callback nếu xóa thành công
                } else {
                    alert('Không thể xóa sản phẩm khỏi giỏ hàng.'); // Thông báo nếu không thể xóa
                }
            },
            error: function (error) {
                console.error('Lỗi khi xóa sản phẩm khỏi giỏ hàng:', error); // Ghi lỗi nếu yêu cầu thất bại
            }
        });
    }

    // Hàm cập nhật tổng giá cho một mục giỏ hàng
    function updateTotal(index) {
        var priceElements = document.querySelectorAll('.price'); // Các phần tử giá
        var quantityInputs = document.querySelectorAll('.quantity-input'); // Các ô nhập số lượng
        var totalElements = document.querySelectorAll('.total'); // Các phần tử tổng giá

        if (index < priceElements.length && index < quantityInputs.length && index < totalElements.length) {
            var price = parseFloat(priceElements[index].innerText.replace(/,/g, '')); // Lấy giá
            var quantity = parseInt(quantityInputs[index].value); // Lấy số lượng
            var totalElement = totalElements[index]; // Lấy phần tử hiển thị tổng giá
            totalElement.childNodes[0].nodeValue = (price * quantity).toLocaleString('en') + " vnđ"; // Cập nhật tổng giá cho mục giỏ hàng
        }
    }

    // Hàm cập nhật tổng giá của toàn bộ giỏ hàng
    function updateCartTotal() {
        var cartTotal = 0;
        document.querySelectorAll('#Giohang .total').forEach(function (element) {
            cartTotal += parseFloat(element.innerText.replace(/,/g, '')); // Cộng dồn tổng giá của tất cả các mục giỏ hàng
        });
        // Lưu tổng tiền vào localStorage
        localStorage.setItem('cartTotal', cartTotal);
        document.querySelector('.tongthanhtien .right').innerText = cartTotal.toLocaleString('en') + ' vnđ'; // Hiển thị tổng giá của giỏ hàng
    }

    // Hàm cập nhật số thứ tự của các mục giỏ hàng
    function updateSTT() {
        var sttElements = document.querySelectorAll('#Giohang th[scope="row"]');
        sttElements.forEach(function (element, index) {
            element.innerText = (index + 1).toString().padStart(2, '0'); // Cập nhật số thứ tự
        });
    }

    // Xử lý sự kiện khi nhấn nút "Thanh toán"
    $("#Thanhtoan").click(function (e) {
        e.preventDefault();
        if ($("#giohang-bang tbody tr").length === 0) {
            alert("Giỏ hàng của bạn đang rỗng. Hãy mua thêm sản phẩm."); // Thông báo nếu giỏ hàng rỗng
            return;
        }
        $("#giohang-bang").hide(); // Ẩn bảng giỏ hàng
        $(".ghichugiohang").hide(); // Ẩn phần ghi chú giỏ hàng
        $("#status-text").hide(); // Ẩn phần trạng thái

        // Lưu lại các mục giỏ hàng vào localStorage
        var cartItems = [];
        document.querySelectorAll('#Giohang tr[data-product-id]').forEach(function (row, index) {
            var id = row.dataset.productId;
            var qty = localStorage.getItem(`cartItem_${id}`);
            var img = row.querySelector('img').src;
            var name = row.cells[2].innerText;
            var priceText = row.querySelector('.price').innerText;
            var price = parseInt(priceText.replace(/\D/g, ''));
            // Tính tổng giá cho mục giỏ hàng
            var total = (price * qty);
            cartItems.push({
                product_id: id,
                quantity: qty,
                image: img,
                name: name,
                price: price,
                total: total
            });
        });
        localStorage.setItem('cartItems', JSON.stringify(cartItems));

        saveCartToDatabase(cartItems); // Lưu giỏ hàng vào cơ sở dữ liệu
        $('#thongtintt').load('pages/thanhtoan.php', function () {
            $.getScript("js/thanhtoan.js"); // Tải và thực thi script "thanhtoan.js"
        });
    });

    fetchCart(); // Gọi hàm lấy dữ liệu giỏ hàng khi trang được tải
});

