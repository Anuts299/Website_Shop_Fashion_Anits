<?php
require 'connect(place).php';

$province_id = $_GET['province_id']; 

$sql = "SELECT * FROM `district` WHERE `province_id` = {$province_id}"; 

$result = mysqli_query($connection, $sql);
$data[0] = [
    'id' => null,
    'name' => 'Chọn quận/huyện'
];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'id' => $row['district_id'],
        'name' => $row['name']
    ];
}
echo json_encode($data);
?>
