<?php
// Thông tin kết nối đến cơ sở dữ liệu
$host = 'localhost'; // hoặc tên máy chủ của bạn
$db   = 'webbanhanganits'; // tên cơ sở dữ liệu
$user = 'root'; // tên người dùng của bạn
$pass = ''; // mật khẩu của bạn

// Thực hiện kết nối đến cơ sở dữ liệu
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
