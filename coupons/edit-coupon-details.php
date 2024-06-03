<?php
require_once("../db_connect.php");

if (isset($_GET['id'])) {
    $couponId = (int)$_GET['id'];
    $sql = "SELECT * FROM coupon WHERE id = $couponId AND valid = 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $coupon = $result->fetch_assoc();
        echo json_encode($coupon);
    } else {
        echo json_encode(['error' => '找不到優惠券資料']);
    }
} else {
    echo json_encode(['error' => '無效的優惠券ID']);
}
