<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "unitop_db_place";

// Tạo kết nối
$connection = new mysqli($host, $username, $password, $dbname);

// Kiểm tra kết nối
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
