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
    $created_at=$_POST['f_created'];
    $updated_at=$_POST['f_updated'];
    //upload file
    move_uploaded_file($_FILES['f_thumbnail']['tmp_name'],'../../image/'.$_FILES['f_thumbnail']['name']);
    $img=$_FILES['f_thumbnail']['name'];
    //Tạo câu truy vấn
    $sql="INSERT INTO products(fullname, mota, price, discount, category_products, brand_id,thumbnail, stock_quantity,status_products,created_at,update_at)
    values ('$fullname','$desc',$price,$discount,'$category','$brand','$img','$stock_quantity',' $status','$created_at',$updated_at')";
    //Thực hiện câu truy vấn kết quả trả về lưu trong biến kết quả
    $ketqua=mysqli_query($ketnoi,$sql);
    echo "<script>";
        if($ketqua){
            echo "alert(\"Thêm thành công\");";
        }
        else{
            echo "alert(\"Thêm không thành công\");";
        }
        echo "window.location=\"../index.php\";";
    echo "</script>";

?>