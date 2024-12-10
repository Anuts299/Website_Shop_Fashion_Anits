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

    // In ra một thông báo để kiểm tra
    console.log('fjufdufhudfhuf');

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
