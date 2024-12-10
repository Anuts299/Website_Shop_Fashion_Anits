
// Hàm để lấy danh mục đã được lưu trữ trong sessionStorage
function getSelectedCategory() {
    return sessionStorage.getItem('selectedCategory');
}

// Hàm để lấy và hiển thị sản phẩm của danh mục đã được click
function loadProductsByCategory() {
    const selectedCategory = getSelectedCategory();
    if (selectedCategory) {
        // Gọi hàm lấy sản phẩm theo danh mục đã được click
        fetchProducts(selectedCategory);
        activateTab(selectedCategory);
    }
}

// Hàm để gửi yêu cầu GET đến API để lấy danh sách các danh mục sản phẩm
function fetchProduct_category() {
    $.ajax({
        url: `http://localhost/baibaocao/backend/api/product_category.php`,
        method: 'GET',
        cache: false,
        success: function (product_category) {
            product_category = JSON.parse(product_category);
            renderCategories(product_category);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Lỗi khi lấy danh mục:', textStatus, errorThrown);
        }
    });
}

// Hàm để hiển thị các danh mục bài viết trên trang web
function renderCategories(categories) {
    const navPills = $('#myTab');
    const tabContent = $('#myTabContent');
    navPills.empty();
    tabContent.empty();

    const selectedCategory = getSelectedCategory();

    // Kiểm tra xem categories có tồn tại và có phải là mảng không
    if (Array.isArray(categories) && categories.length > 0) {
        categories.forEach((category, index) => {
            const isActive = selectedCategory ? category.id == selectedCategory : index === 0;
            const navItem = $(`
                <li class="nav-item">
                    <a class="nav-link ${isActive ? 'active' : ''}" id="${category.id}-tab" data-bs-toggle="pill" href="#${category.id}" role="tab" aria-controls="${category.id}" aria-selected="${isActive}">
                        ${category.name_category}
                    </a>
                </li>
            `);
            navPills.append(navItem);

            const tabPane = $(`
                <div class="tab-pane fade ${isActive ? 'show active' : ''}" id="${category.id}" role="tabpanel" aria-labelledby="${category.id}-tab">
                    <div class="col"></div>
                </div>
            `);
            tabContent.append(tabPane);
        });

        // Đăng ký sự kiện click cho các tab
        navPills.find('.nav-link').on('shown.bs.tab', function (e) {
            const categoryId = $(e.target).attr('href').substring(1); // Lấy id của danh mục
            fetchProducts(categoryId); // Gọi hàm lấy bài viết theo danh mục
        });

        // Tải các bài viết của danh mục đã chọn hoặc danh mục đầu tiên
        if (selectedCategory) {
            fetchProducts(selectedCategory);
            activateTab(selectedCategory);
        } else if (categories.length > 0) {
            fetchProducts(categories[0].id);
        }
    } else {
        console.error('Không có dữ liệu danh mục.');
    }
}
fetchProduct_category();
// Hàm để gửi yêu cầu GET đến API để lấy danh sách các sản phẩm theo danh mục
function fetchProducts(categoryId) {
    $.ajax({
        url: `http://localhost/baibaocao/backend/api/products.php?category_id=${categoryId}`,
        method: 'GET',
        cache: false,
        success: function (products) {
            products = JSON.parse(products); // Chuyển đổi chuỗi JSON thành đối tượng JavaScript
            renderProducts(categoryId, products); // Gọi hàm hiển thị các sản phẩm
        },
        error: function (error) {
            console.error('Lỗi khi lấy sản phẩm:', error);
        }
    });
}

// Hàm để kích hoạt tab tương ứng với danh mục đã chọn
function activateTab(categoryId) {
    const tabLink = $(`#myTab a[href="#${categoryId}"]`);

    // Sử dụng thuộc tính data-bs-toggle để kích hoạt tab
    tabLink.attr('data-bs-toggle', 'tab');
    tabLink.attr('aria-selected', 'true');
    tabLink.addClass('active');
    $(`#${categoryId}`).addClass('show active');
}

// Hàm để định dạng giá tiền
function formatPrice(price) {
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " vnđ";
}

// Hàm để hiển thị các sản phẩm theo danh mục trên trang web
function renderProducts(categoryId, products) {
    const productsContainer = $(`#${categoryId} .col`);
    productsContainer.empty();

    if (Array.isArray(products) && products.length > 0) {
        products.forEach(product => {
            let status;
            switch (product.status_products) {
                case 1:
                    status = "Còn hàng";
                    break;
                case 2:
                    status = "Hết hàng";
                    break;
                case 3:
                    status = "Ngưng bán";
                    break;
                default:
                    status = "Không xác định";
            }
            $.ajax({
                url: `http://localhost/baibaocao/backend/api/brand.php?brand_id=${product.brand_id}`,
                method: 'GET',
                cache: false,
                dataType: 'json', // Đảm bảo phản hồi được xử lý như JSON
                success: function (brandResponse) {
                    try {
                        const brandName = brandResponse.name;

                        const formattedPrice = formatPrice(product.price);
                        const formattedDiscount = formatPrice(product.discount);
                        const productCard = $(`
                            <div class="col">
                                <div class="card" style="width: 17rem;">
                                    <img class="card-img-top" src="${product.thumbnail}">
                                    <div class="card-body">
                                        <p class="card-text brand">${brandName}</p>
                                        <h5 class="card-title mb-1">${product.fullname}</h5>
                                        <p class="card-text giathanh">${formattedPrice}<span>${formattedDiscount}</span></p>
                                        <p class="card-text tinhtrangsp">${status}</p>
                                        <a href="#" class="btn chitietsanpham" data-id="${product.id}">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        `);
                        productsContainer.append(productCard);
                    } catch (error) {
                        console.error('Lỗi khi phân tích JSON:', error, brandResponse);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Lỗi khi lấy thông tin chi tiết:', textStatus, errorThrown);
                }
            });
        });
    } else {
        productsContainer.html('<p>Không có sản phẩm nào trong danh mục này.</p>');
    }
}
