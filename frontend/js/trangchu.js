

// Hàm để khôi phục trạng thái slider từ localStorage khi tải trang
function restoreSliderState() {
    let activeIndex = localStorage.getItem('sliderActiveIndex');
    // Kiểm tra xem có trạng thái được lưu trữ trong localStorage không
    if (activeIndex !== null) {
        // Cập nhật trạng thái slider
        active = parseInt(activeIndex); // Chuyển đổi activeIndex từ chuỗi sang số nguyên
        reloadSlider(); // Gọi hàm reloadSlider để cập nhật slider
    }
}

$(document).ready(function () {
    // Lấy các phần tử DOM cần thiết
    let list = document.querySelector('.slider .list');
    let items = document.querySelectorAll('.slider .list .item');
    let dots = document.querySelectorAll('.slider .dots li');
    let prev = document.getElementById('prev');
    let next = document.getElementById('next');

    // Khởi tạo biến active và lengthItems
    let active = 0;
    let lengthItems = items.length - 1;


    // Xử lý sự kiện khi nhấn nút next
    next.onclick = function () {
        if (active + 1 > lengthItems) {
            active = 0;
        } else {
            active = active + 1;
        }
        reloadSlider(); // Gọi hàm reloadSlider để cập nhật slider
    }

    // Xử lý sự kiện khi nhấn nút prev
    prev.onclick = function () {
        if (active - 1 < 0) {
            active = lengthItems
        } else {
            active = active - 1;
        }
        reloadSlider(); // Gọi hàm reloadSlider để cập nhật slider
    }

    // Tự động chuyển slider sau mỗi 5 giây
    let refreshSlider = setInterval(() => { next.click() }, 5000);

    // Hàm để cập nhật slider
    function reloadSlider() {
        let checkLeft = items[active].offsetLeft;
        list.style.left = -checkLeft + 'px';
        let lastActiveDot = document.querySelector('.slider .dots li.active');

        // Kiểm tra xem lastActiveDot có tồn tại không
        if (lastActiveDot) {
            lastActiveDot.classList.remove('active');
        }

        // Kiểm tra xem dots[active] có tồn tại không
        if (dots[active]) {
            dots[active].classList.add('active');
        }
        clearInterval(refreshSlider);
        refreshSlider = setInterval(() => { next.click() }, 5000);
    }

    // Xử lý sự kiện khi nhấn vào các chấm tròn để chuyển slider
    dots.forEach((li, key) => {
        li.addEventListener('click', function () {
            active = key;
            reloadSlider(); // Gọi hàm reloadSlider để cập nhật slider
        })
    });

    // Gọi hàm khôi phục trạng thái slider từ localStorage khi tải trang
    restoreSliderState();
})





// Xử lý sự kiện click cho nút "Xem tất cả"
document.getElementById('Xemtatca').addEventListener('click', function () {
    var hiddenCols = document.querySelectorAll('.sanphamhot > .col:nth-last-child(-n+4)');

    hiddenCols.forEach(function (col) {
        col.style.display = 'block';  // Hoặc dùng '' để trả về giá trị mặc định của display
    });

    this.style.display = 'none';
});


// Hàm để gửi yêu cầu GET đến API để lấy danh sách các danh mục sản phẩm
function fetchProductcategory() {

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

// Hàm để hiển thị các danh mục sản phẩm trên trang web
function renderCategories(product_category) {
    const danhSachSanPham = document.querySelector('.danhsachsanpham');

    // Xóa các danh mục cũ trước khi thêm các danh mục mới
    danhSachSanPham.innerHTML = '';

    // Duyệt qua danh sách sản phẩm và tạo các phần tử HTML cho mỗi danh mục
    product_category.forEach(category => {
        const col = $('<div class="col"></div>');
        const link = $('<a href="#' + category.id + '" class="d-flex flex-column align-items-center text-center rounded"></a>');

        link.click(function (event) {
            event.preventDefault();
            sessionStorage.setItem('selectedCategory', category.id);
            $('#noidung').load('pages/sanpham.php', function () {
                $.getScript("js/sanpham.js", function () {
                    // Gọi hàm loadProductsByCategory ngay sau khi sanpham.js được tải
                    loadProductsByCategory();
                });
            });
        });

        const img = $('<img>');
        img.attr('src', category.thumbnail);
        img.attr('alt', category.name_category);

        const p = $('<p></p>').text(category.name_category);

        link.append(img);
        link.append(p);

        col.append(link);

        danhSachSanPham.append(col[0]);
    });
}

// Gọi hàm để lấy danh mục sản phẩm
fetchProductcategory();



// Hàm để gửi yêu cầu GET đến API để lấy các sản phẩm mới nhất
function fetchProductsNew() {

    $.ajax({
        url: `http://localhost/baibaocao/backend/api/products_new.php`,
        method: 'GET',
        cache: false,
        success: function (products_new) {
            products_new = JSON.parse(products_new);
            const products_newContainer = $('.sanphamhot');
            products_newContainer.empty();
            renderNewProducts(products_new);
        },
        error: function (error) {
            console.error('Lỗi khi lấy sản phẩm:', error);
        }
    });
}

// Hàm để định dạng giá tiền
function formatPrice(price) {
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " vnđ";
}
// Hàm để hiển thị các sản phẩm mới nhất trên trang web
function renderNewProducts(products_new) {
    const products_newContainer = $('.sanphamhot');
    if (Array.isArray(products_new) && products_new.length > 0) {
        products_new.forEach(product => {
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
                                <div class="card" style="width: 19rem;">
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
                        products_newContainer.append(productCard);
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
        products_newContainer.html('<p>Không có sản phẩm mới nào.</p>');
    }
}
fetchProductsNew();

//Hàm để gủi yêu cầu đến API để lấy các bài viết mới nhất
function fetchBlogsNew() {
    $.ajax({
        url: `http://localhost/baibaocao/backend/api/blogs_new.php`,
        method: 'GET',
        cache: false,
        success: function (blogs_new) {
            blogs_new = JSON.parse(blogs_new);
            const blogs_newContainer = $('.baivietthoitrang');
            blogs_newContainer.empty();
            renderNewBlogs(blogs_new);
        },
        error: function (error) {
            console.error('Lỗi khi lấy bài viết', error);
        }
    });
}
//Hàm để hiển thị 3 bài viết mới nhất trên trang web
function renderNewBlogs(blogs_new) {
    const blogs_newContainer = $('.baivietthoitrang');
    blogs_newContainer.empty();
    if (Array.isArray(blogs_new) && blogs_new.length > 0) {
        blogs_new.forEach(blog => {
            // Gửi yêu cầu AJAX để lấy tên danh mục bài viết
            $.ajax({
                url: `http://localhost/baibaocao/backend/api/blog_category.php?id=${blog.blog_category_id}`,
                method: 'GET',
                cache: false,
                dataType: 'json', // Đảm bảo phản hồi được xử lý như JSON
                success: function (category) {
                    const categoryName = category.title;
                    const blogPost = $(`
                        <div class="col">
                            <div class="card" style="width: 25.5rem;height: 532px;" href="#">
                                <img class="card-img-top thumbnail" style="height: 320px;"src="${blog.thumbnail}">
                                <div class="card-body d-flex justify-content-between flex-column">
                                    <p class="card-text category_blog">${categoryName}</p>
                                    <h5 class="card-title mb-1 title_blog">${blog.title_blog}</h5>
                                    <p class="card-text auther_blog">${blog.author}<span class="publish_date">${blog.publish_date}</span>
                                    </p>
                                    <a href="#" class="btn chitietbaiviet">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    `);
                    blogs_newContainer.append(blogPost);
                },
                error: function (error) {
                    console.error('Lỗi khi lấy danh mục:', error);
                }
            });
        });
    } else {
        blogs_newContainer.html('<p>Không có bài viết mới nào.</p>')
    }
}
fetchBlogsNew();
