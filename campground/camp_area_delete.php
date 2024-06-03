<?php
require_once("../db_connect.php");

if(!isset($_GET['area_id'])){
    echo "請循正常管道進入此頁";
    exit;
}

$camp_id = $_GET["camp_id"];
$area_id = $_GET["area_id"];

$sql="DELETE FROM camp_area WHERE id = $area_id";


if ($conn->query($sql) === TRUE) {
    echo "刪除成功";
} else {
    echo "刪除資料錯誤: " . $conn->error;
}

header("location: camp_area_list.php?camp_id=$camp_id&area_id=$area_id");