<?php
// require_once("../db_connect.php");

// $activity_id = $_GET['id'];

// $sql = "DELETE FROM activities WHERE activity_id=$activity_id";

// if ($conn->query($sql) === TRUE) {
// echo "揪團刪除成功";
// } else {
// echo "揪團刪除錯誤: " . $conn->error;
// }

// $conn->close();
// header("Location: index.php"); // 重定向回主頁


require_once("../db_connect.php");

if (!isset($_GET["activity_id"])) {
    echo "請循正常管道進入此頁";
    exit;
}

$activity_id = $_GET["activity_id"];
$sql = "UPDATE activities SET valid=0 WHERE activity_id=$activity_id"; // 軟刪除

if ($conn->query($sql) === TRUE) :
    echo "揪團刪除成功";
else :
    echo "揪團刪除錯誤" . $conn->error;
endif;

header("location: activities_list.php");
