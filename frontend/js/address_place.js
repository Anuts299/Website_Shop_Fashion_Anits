$(document).ready(function () {
    //Lắng nghe sự thay đổi trong hộp chọn city_user_order
    $('#city_user_order,#city_user').on('change', function () {
        var province_id = $(this).val();
        if (province_id) {
            //Nếu có một tỉnh/ thành phố được chọn, ta tìm nạp các huyện cho tỉnh đó bằng cách sử dụng AJAX
            $.ajax({

                url: 'php/ajax_get_district.php',
                method: 'GET',
                dataType: "json",
                data: {
                    province_id: province_id
                },
                success: function (data) {
                    // console.log('oooooo');
                    // Xóa các tùy chọn hiện tại trong hộp chọn "quận"
                    $('#district_user_order,#district_user').empty();
                    // Thêm tùy chọn mới cho các huyện cho tỉnh đã chọn
                    $.each(data, function (i, district) {
                        //console.log(district);
                        $('#district_user_order,#district_user').append($('<option>', {
                            value: district.id,
                            text: district.name
                        }));
                    });
                    //Xóa các lựa chọn xã đã chọn hiện tại
                    $('#ward_user_order,#ward_user').empty();
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log('Error: ' + errorThrown);
                }
            });
            $('#ward_user_order,#ward_user').empty();
        } else {
            //nếu ko có lựa chọn tỉnh/ thành phố nào thì xóa lựa chọn tại quận huyện và xã
            $('#district_user_order,#district_user').empty();
            $('#ward_user_order,#ward_user').empty();
        }
    });
    //Lắng nghe sự thay đổi trong lựa chọn quận/huyện
    $('#district_user_order,#district_user').on('change', function () {
        var district_id = $(this).val();
        //console.log(district_id);
        if (district_id) {
            //Nếu có một quận/huyện được chọn, ta tìm nạp các phường/xã cho quận/ huyện đó bằng cách sử dụng AJAX
            $.ajax({
                url: 'php/ajax_get_wards.php',
                method: 'GET',
                dataType: "json",
                data: {
                    district_id: district_id
                },
                success: function (data) {
                    //Xóa các sựa chọn hiện tại trên hộp chọn phường xã
                    $('#ward_user_order,#ward_user').empty();
                    // Thêm tùy chọn mới cho các huyện đã chọn
                    $.each(data, function (i, wards) {
                        $('#ward_user_order,#ward_user').append($('<option>', {
                            value: wards.id,
                            text: wards.name
                        }));
                    });
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log('Error: ' + errorThrown);
                }
            });
        } else {
            //nếu chưa có quận huyện nào được chọn, xóa các lựa chọn tại phường xã
            $('#ward_user_order,#ward_user').empty();
        }
    });
});