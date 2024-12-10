<?php
require 'connect(place).php';

$district_id = $_GET['district_id']; 

$sql = "SELECT * FROM `wards` WHERE `district_id` = {$district_id}"; 

$result = mysqli_query($connection, $sql);

$data[0] = [
    'id' => null,
    'name' => 'Chọn phường/xã'
];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'id' => $row['wards_id'],
        'name' => $row['name']
    ];
}
echo json_encode($data);
?>
