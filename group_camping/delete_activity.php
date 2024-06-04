<?php
require_once("../db_connect.php");

$activity_id = $_GET['id'];

$sql = "DELETE FROM activities WHERE activity_id=$activity_id";

if ($conn->query($sql) === TRUE) {
    echo "活動刪除成功";
} else {
    echo "刪除活動錯誤: " . $conn->error;
}

$conn->close();
header("Location: index.php"); // 重定向回主頁
