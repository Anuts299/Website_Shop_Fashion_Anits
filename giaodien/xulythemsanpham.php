<?php
//Kết nối cơ sở dữ liệu
$ketnoi=mysqli_connect("localhost","root","","webbanhanganits");
if(!$ketnoi){
    exit("Kết nối cơ sở dữ liệu thất bại!");
}
    //Nhận dữ liệu từ người dùng nhập form
    $fullname=$_POST['f_fullname'];
    $desc=$_POST['f_description'];
    $price=$_POST['f_price'];
    $discount=$_POST['f_discount'];
    $category=$_POST['f_category'];
    $brand=$_POST['f_brand'];
    $stock_quantity=$_POST['f_stock_quantity'];
    $status=$_POST['f_status'];
    $created_day=$_POST['f_created'];
    $updated_day=$_POST['f_updated'];
    $deleted=$_POST['f_deleted'];
    //upload file
    move_uploaded_file($_FILES['f_thumbnail']['tmp_name'],'./image/'.$_FILES['f_thumbnail']['name']);
    $img=$_FILES['f_thumbnail']['name'];
    //Tạo câu truy vấn
    $sql="INSERT INTO sanpham(fullname,'description',price,discount,name_category,name_brand,stock_quantity,name_status,created_day,updated_day,deleted)
    values ('$fullname','$desc',$price,$discount,'$category','$brand',$stock_quantity,' $status','$created_day',$updated_day','$deleted')";
    //Thực hiện câu truy vấn kết quả trả về lưu trong biến kết quả
    $ketqua=mysqli_query($ketnoi,$sql);
    echo "<script>";
        if($ketqua){
            echo "alert(\"Thêm thành công\");";
        }
        else{
            echo "alert(\"Thêm không thành công\");";
        }
        echo "window.location=\"trangchu.php\";";
    "</script>";

?>