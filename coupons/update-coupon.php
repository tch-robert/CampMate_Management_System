<?php
require_once("../db_connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $coupon_name = $_POST['coupon_name'];
    $category = $_POST['category'];
    $discount = $_POST['discount'];
    $min_cost = $_POST['min_cost'];
    $max_discount_amount = $_POST['max_discount_amount'];
    $coupon_num = $_POST['coupon_num'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];

    $sql = "UPDATE coupon SET 
            coupon_name = '$coupon_name', 
            category = '$category', 
            discount = '$discount', 
            min_cost = '$min_cost', 
            max_discount_amount = '$max_discount_amount', 
            coupon_num = '$coupon_num', 
            start_date = '$start_date', 
            end_date = '$end_date', 
            status = '$status' 
            WHERE id = $id AND valid = 1";

    if ($conn->query($sql) === TRUE) {
        echo "更新成功";
    } else {
        echo "更新失敗: " . $conn->error;
    }

    $conn->close();
}
