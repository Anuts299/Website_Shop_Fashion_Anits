<?php
include("function.php");
$ketnoi=mysqli_connect("localhost","root","","webbanhanganits");
if(!$ketnoi){
    exit("Kết nối cơ sở dữ liệu thất bại!");
}
$sql="SELECT fullname,price,discount,brand,status,thumbnail from sanpham";
$ketqua = mysqli_query($ketnoi,$sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/96addb123b.js" crossorigin="anonymous"></script>
    <!--Bootstrap CSS  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="trangchu.css">

</head>

<body>
    <section id="noidung-trangchu">
        <div class="container">
            <div class="row slider">
                <div class="list">
                    <div class="item">
                        <img src="image/1.jpg" alt="">
                    </div>
                    <div class="item">
                        <img src="image/2.jpg" alt="">
                    </div>
                    <div class="item">
                        <img src="image/3.jpg" alt="">
                    </div>
                    <div class="item">
                        <img src="image/4.jpg" alt="">
                    </div>
                    <div class="item">
                        <img src="image/5.jpg" alt="">
                    </div>
                </div>
                <!--Button prev và next-->
                <div class="buttons">
                    <div id="prev">
                        <i class="fa-solid fa-angle-left"></i>
                    </div>
                    <div id="next"><i class="fa-solid fa-angle-right"></i></div>
                </div>
                <!--dots 5 dot-->
                <ul class="dots">
                    <li class="active">
                    </li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
            <div class="row after-slider mt-3 gx-3 mb-5">
                <div class="col gx-5 border border-2 border-black d-flex flex-column align-items-center rounded">
                    <img src="image/delivery-truck.png" alt="">
                    <p>Miễn phí vẫn chuyển</p>
                    <span>Nhận hàng trong 3 ngày</span>
                </div>
                <div class="col gx-5 border border-2 border-black d-flex flex-column align-items-center rounded">
                    <img src="image/surprise.png" alt="">
                    <p>Quà tặng hấp dẫn</p>
                    <span>Nhiều ưu đãi khuyến mãi hot</span>
                </div>
                <div class="col gx-5 border border-2 border-black d-flex flex-column align-items-center rounded">
                    <img src="image/quality-service.png" alt="">
                    <p>Đảm bảo chất lượng</p>
                    <span>Sản phẩm đã được kiểm định</span>
                </div>
                <div class="col gx-5 border border-2 border-black d-flex flex-column align-items-center rounded">
                    <img src="image/help-desk.png" alt="">
                    <p>Hotline: <span style="color:#554dde;font-weight: 700;">1900 1508</span></p>
                    <span>Dịch vụ hỗ trợ bạn 24/7</span>
                </div>
            </div>
            <div class="row nutdssp mt-5">
                <div class="col-auto"><button type="button" class="btn mb-3" id="Danhsachsanpham">Danh Mục
                        Sản Phẩm</button>
                </div>
            </div>
            <div class="row danhsachsanpham gx-1 align-items-stretch mb-5">
                <div class="col ">
                    <a href="#" class="d-flex flex-column align-items-center text-center rounded">
                        <img src="image/danhsachsanpham/shirt.png" alt="">
                        <p>Áo Sơ Mi</p>
                    </a>
                </div>
                <div class="col ">
                    <a href="#" class="d-flex flex-column align-items-center text-center rounded">
                        <img src="image/danhsachsanpham/jeans.png" alt="">
                        <p>Quần Jeans</p>
                    </a>
                </div>
                <div class="col ">
                    <a href="#" class="d-flex flex-column align-items-center text-center rounded">
                        <img src="image/danhsachsanpham/dress.png" alt="">
                        <p>Váy / Đầm</p>
                    </a>
                </div>
                <div class="col">
                    <a href="#" class="d-flex flex-column align-items-center text-center rounded">
                        <img src="image/danhsachsanpham/sneakers.png" alt="">
                        <p>Giày / Dép</p>
                    </a>
                </div>
                <div class="col ">
                    <a href="#" class="d-flex flex-column align-items-center text-center rounded">
                        <img src="image/danhsachsanpham/bag.png" alt="">
                        <p>Phụ Kiện Thời Trang</p>
                    </a>
                </div>
                <div class="col ">
                    <a href="#" class="d-flex flex-column align-items-center text-center rounded">
                        <img src="image/danhsachsanpham/overalls.png" alt="">
                        <p>Thời Trang Trẻ Em</p>
                    </a>
                </div>
                <div class="col ">
                    <a href="#" class="d-flex flex-column align-items-center text-center rounded">
                        <img src="image/danhsachsanpham/sport-wear.png" alt="">
                        <p>Thời Trang Thể Thao</p>
                    </a>
                </div>
                <div class="col ">
                    <a href="#" class="d-flex flex-column align-items-center text-center rounded">
                        <img src="image/danhsachsanpham/raincoat.png" alt="">
                        <p>Áo Khoát</p>
                    </a>
                </div>
            </div>
            <div class="row nutsphot mt-5">
                <div class="col-auto"><button type="button" class="btn mb-3" id="Sanphamhot">Sản Phẩm Hot</button>
                </div>
            </div>
            <div class="row gx-3 sanphamhot">
               <?php
                which($row=mysqli_fetch_array($ketqua)){
                    echo "inSanPham($row['thumbnail'],$row['fullname'],$row['name_brand'],$row['price'],$row['discount'],$row['name_status'];)";
                }
               ?>
            </div>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!--Script slider-->
    <script src="trangchu.js"></script>
</body>

</html>