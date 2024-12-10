// Hàm để gán sự kiện
function attachEventListeners() {
    // Xóa tất cả các sự kiện trước khi gán mới để tránh gán nhiều lần
    $('#Chitietsanpham .decrease').off('click');
    $('#Chitietsanpham .increase').off('click');

    // Lấy tất cả các nút giảm số lượng, tăng số lượng, ô nhập số lượng
    var decreaseButtons = document.querySelectorAll('#Chitietsanpham .decrease');
    var increaseButtons = document.querySelectorAll('#Chitietsanpham .increase');
    var quantityInputs = document.querySelectorAll('#Chitietsanpham .quantity-input');

    // Gán sự kiện click cho các nút giảm số lượng
    decreaseButtons.forEach(function (button, index) {
        button.addEventListener('click', function () {
            var quantity = parseInt(quantityInputs[index].value);
            // Giảm số lượng nếu lớn hơn 1
            if (quantity > 1) {
                quantityInputs[index].value = quantity - 1;
            }
        });
    });

    // Gán sự kiện click cho các nút tăng số lượng
    increaseButtons.forEach(function (button, index) {
        button.addEventListener('click', function () {
            var quantity = parseInt(quantityInputs[index].value);
            // Tăng số lượng
            quantityInputs[index].value = quantity + 1;
        });
    });
    //Nhấn vào thêm giỏ hàng

    $('.themvaogiohang').on('click', function () {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        $.ajax({
            url: 'http://localhost/baibaocao/backend/api/auth/kiemtradangnhap.php',
            method: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Nếu đăng nhập thành công, tiến hành thêm sản phẩm vào giỏ hàng
                    themSanPhamVaoGioHang();
                } else {
                    // Nếu chưa đăng nhập, thông báo người dùng cần phải đăng nhập trước
                    alert('Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.');
                }
            },
            error: function (error) {
                console.error('Lỗi khi kiểm tra đăng nhập:', error);
            }
        });
    });
}

// Hàm để lấy id sản phẩm từ sessionStorage
function selectedproductId() {
    return sessionStorage.getItem('selectedproductId');
}

// Hàm để gửi yêu cầu đến API để lấy thông tin chi tiết sản phẩm
function fetchProduct_details() {
    const productdetail_id = selectedproductId();
    if (!productdetail_id) {
        console.error('Product ID không tồn tại trong sessionStorage');
        return;
    }

    $.ajax({
        url: `http://localhost/baibaocao/backend/api/product_details.php?id=${productdetail_id}`,
        method: 'GET',
        cache: false,
        dataType: 'json',
        success: function (product_details) {
            renderDetailsProducts(product_details);
            attachEventListeners(); // Gọi sau khi nội dung được render
        },
        error: function (error) {
            console.error('Lỗi khi lấy bài viết', error);
        }
    });
}

// Hàm để định dạng giá tiền
function formatPrice(price) {
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " vnđ";
}

// Hàm để hiển thị các hình ảnh khác của sản phẩm
function loadAdditionalImages(product_id) {
    $.ajax({
        url: `http://localhost/baibaocao/backend/api/multipe_image.php?product_id=${product_id}`,
        method: 'GET',
        cache: false,
        dataType: 'json',
        success: function (images) {
            try {
                // Xóa nội dung cũ để tránh chèn lặp lại
                const multipeImageContainer = $('.multipe-image');
                multipeImageContainer.empty();

                // Thêm các hình ảnh vào container
                images.forEach(image => {
                    const imgElement = $('<img>').attr('src', image.thumbnail).attr('alt', '');
                    multipeImageContainer.append(imgElement);
                });
            } catch (error) {
                console.error('Lỗi khi phân tích JSON:', error);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Lỗi khi lấy danh sách hình ảnh:', textStatus, errorThrown);
        }
    });
}

// Hàm để hiển thị chi tiết sản phẩm trên trang web
function renderDetailsProducts(product_details) {
    const product_detailsContainer = $('.thongtinsp');
    product_detailsContainer.empty(); // Xóa nội dung cũ để tránh chèn lặp lại

    if (product_details) {
        $.ajax({
            url: `http://localhost/baibaocao/backend/api/brand.php?brand_id=${product_details.brand_id}`,
            method: 'GET',
            cache: false,
            dataType: 'json',
            success: function (brandResponse) {
                try {
                    const brandName = brandResponse.name;
                    const formattedPrice = formatPrice(product_details.price);
                    const formattedDiscount = formatPrice(product_details.discount);

                    const productDetail = $(`
                        <div class="row">
                            <div class="col-1 multipe-image">
                            </div>
                            <div class="col-4" id="thumbnail">
                                <img src="${product_details.thumbnail}" alt="">
                            </div>
                            <div class="col-1"></div>
                            <div class="col-6" id="thongtindh_sp">
                                <div id="tensp"><p>${product_details.fullname}</p></div>
                                <div id="thuonghieu"><p>Thương hiệu: <span>${brandName}</span></p></div>
                                <div id="giaban">${formattedPrice}<span>${formattedDiscount}</span></div>
                                <hr>
                                <div id="mota"><p>Mô tả sản phẩm: <span>${product_details.mota}</span></p></div>
                                <div class="quantity">
                                    <div><p>Số lượng đặt</p></div>
                                    <div class="input-group">
                                        <button class="btn decrease" type="button"><i class="fa-solid fa-minus"></i></button>
                                        <input type="text" class="form-control quantity-input" value="1">
                                        <button class="btn increase" type="button"><i class="fa-solid fa-plus"></i></button>
                                    </div>
                                </div>
                                <hr>
                                <button type="button" class="btn themvaogiohang">Thêm vào giỏ hàng<i class="fa-solid fa-cart-shopping"></i></button>
                            </div>
                        </div>
                    `);
                    product_detailsContainer.append(productDetail);
                    attachEventListeners(); // Gọi sau khi nội dung được render
                } catch (error) {
                    console.error('Lỗi khi phân tích JSON:', error, brandResponse);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Lỗi khi lấy thông tin chi tiết:', textStatus, errorThrown);
            }
        });
    } else {
        product_detailsContainer.html('<p>Không có thông tin sản phẩm.</p>');
    }
    loadAdditionalImages(product_details.id);
}

fetchProduct_details();

function themSanPhamVaoGioHang() {
    var productdetail_id = selectedproductId();
    var quantity = parseInt($('.quantity-input').val());

    $.ajax({
        url: 'http://localhost/baibaocao/backend/api/cart/addto_cart.php',
        method: 'POST',
        data: {
            product_id: productdetail_id,
            quantity: quantity
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                alert('Sản phẩm đã được thêm vào giỏ hàng.');
            } else {
                alert('Có lỗi xảy ra, vui lòng thử lại.');
            }
        },
        error: function (error) {
            console.error('Lỗi khi thêm sản phẩm vào giỏ hàng:', error);
        }
    });
}

