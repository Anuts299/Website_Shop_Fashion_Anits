
// const Capnhat_ttcn = document.getElementById('Capnhat_ttcn');
// if (Capnhat_ttcn) {
//     Capnhat_ttcn.addEventListener('click', function (e) {
//         e.preventDefault();
//         // Lấy dữ liệu từ các trường input
//         var fullnameInput = document.getElementById('fullname_user');
//         var phone_numberInput = document.getElementById('phone_user');
//         var emailInput = document.getElementById('email_user');
//         // Lấy các trường thông tin khác tương tự

//         // Gửi dữ liệu lên máy chủ bằng Ajax
//         const xhr = new XMLHttpRequest();
//         xhr.open('POST', '/luu-thong-tin', true);
//         xhr.setRequestHeader('Content-Type', 'application/json');

//         // Dữ liệu gửi đi dưới dạng JSON
//         const data = {
//             fullname: fullname,
//             // Thêm các trường thông tin khác vào đây
//         };

//         // Gửi dữ liệu dưới dạng JSON
//         xhr.send(JSON.stringify(data));

//         // Xử lý phản hồi từ máy chủ
//         xhr.onload = function () {
//             if (xhr.status === 200) {
//                 alert('Thông tin đã được lưu thành công!');
//             } else {
//                 alert('Có lỗi xảy ra khi lưu thông tin!');
//             }
//         };
//     });
// }


