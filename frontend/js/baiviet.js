// Hàm để gửi yêu cầu GET đến API để lấy danh sách các danh mục bài viết
function fetchCategories() {
    $.ajax({
        url: 'http://localhost/baibaocao/backend/api/blog_category.php',
        method: 'GET',
        success: function (categories) {
            categories = JSON.parse(categories); // Chuyển đổi chuỗi JSON thành đối tượng JavaScript
            renderCategories(categories); // Gọi hàm hiển thị các danh mục
        },
        error: function (error) {
            console.error('Lỗi khi lấy danh mục:', error);
        }
    });
}

// Hàm để hiển thị các danh mục bài viết trên trang web
function renderCategories(categories) {
    const navPills = $('#myTab');
    const tabContent = $('#myTabContent');
    navPills.empty();
    tabContent.empty();

    // Kiểm tra xem categories có tồn tại và có phải là mảng không
    if (Array.isArray(categories) && categories.length > 0) {
        categories.forEach((category, index) => {
            const navItem = $(`
                <li class="nav-item">
                    <a class="nav-link ${index === 0 ? 'active' : ''}" id="${category.id}-tab" data-bs-toggle="pill" href="#${category.id}" role="tab" aria-controls="${category.id}" aria-selected="${index === 0}">
                        ${category.title}
                    </a>
                </li>
            `);
            navPills.append(navItem);

            const tabPane = $(`
                <div class="tab-pane fade ${index === 0 ? 'show active' : ''}" id="${category.id}" role="tabpanel" aria-labelledby="${category.id}-tab">
                    <div class="blog-posts"></div> <!-- Khu vực sẽ hiển thị các bài viết -->
                </div>
            `);
            tabContent.append(tabPane);
        });

        // Đăng ký sự kiện click cho các tab
        navPills.find('.nav-link').on('shown.bs.tab', function (e) {
            const categoryId = $(e.target).attr('href').substring(1); // Lấy id của danh mục
            fetchBlogs(categoryId); // Gọi hàm lấy bài viết theo danh mục
        });

        // Tải các bài viết của danh mục đầu tiên
        if (categories.length > 0) {
            fetchBlogs(categories[0].id);
        }
    } else {
        console.error('Không có dữ liệu danh mục.');
    }
}

// Hàm để gửi yêu cầu GET đến API để lấy danh sách các bài viết theo danh mục
function fetchBlogs(categoryId) {
    $.ajax({
        url: `http://localhost/baibaocao/backend/api/blogs.php?category_id=${categoryId}`, // Cập nhật đường dẫn đúng
        method: 'GET',
        success: function (blogs) {
            blogs = JSON.parse(blogs); // Chuyển đổi chuỗi JSON thành đối tượng JavaScript
            renderBlogs(categoryId, blogs); // Gọi hàm hiển thị các bài viết
        },
        error: function (error) {
            console.error('Lỗi khi lấy bài viết:', error);
        }
    });
}

// Hàm để hiển thị các bài viết trên trang web
function renderBlogs(categoryId, blogs) {
    const blogContainer = $(`#${categoryId} .blog-posts`);
    blogContainer.empty();

    // Kiểm tra xem blogs có tồn tại và có phải là mảng không
    if (Array.isArray(blogs) && blogs.length > 0) {
        blogs.forEach(blog => {
            const blogPost = $(`
                <div class="blog-post">
                    <img src="${blog.thumbnail}">
                    <h5>${blog.title_blog}</h5>
                    <small>By ${blog.author} on ${blog.publish_date}</small>
                    <p>${blog.content_blog}</p>
                </div>
            `);
            blogContainer.append(blogPost);
        });
    } else {
        blogContainer.html('<p>Không có bài viết nào trong danh mục này.</p>');
    }
}

// Gọi hàm fetchCategories để lấy danh sách các danh mục khi trang được tải
fetchCategories();