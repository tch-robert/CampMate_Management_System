<?php
require_once("../db_connect.php");

$coupon_name = $_POST['coupon_name'];
$category = $_POST['category'];
$discount = $_POST['discount'];
$min_cost = $_POST['min_cost'];
$max_discount_amount = $_POST['max_discount_amount'];
$coupon_num = $_POST['coupon_num'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$status = $_POST['status'];

$sql = "INSERT INTO coupon (coupon_name, category, discount, min_cost, max_discount_amount, coupon_num, start_date, end_date, status, valid)
        VALUES ('$coupon_name', '$category', '$discount', '$min_cost', '$max_discount_amount', '$coupon_num', '$start_date', '$end_date', '$status', 1)";

if ($conn->query($sql) === TRUE) {
    echo "新增成功";
} else {
    echo "新增失敗: " . $conn->error;
}

$conn->close();
