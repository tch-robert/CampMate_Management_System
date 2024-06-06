<?php
require_once("../db_connect.php");

if(!isset($_GET['img_id'])){
    echo "請循正常管道進入此頁";
    exit;
}

$camp_id = $_GET["camp_id"];
$area_id = $_GET["area_id"];
$item_id = $_GET["item_id"];
$img_id=$_GET["img_id"];

$decode_id = str_replace("%20", " ", $img_id);
// echo $decode_id;

$sql="DELETE FROM images WHERE id = '$decode_id'";


if ($conn->query($sql) === TRUE) {
    echo "刪除成功";
} else {
    echo "刪除資料錯誤: " . $conn->error;
}

header("location: item_img_upload.php?camp_id=$camp_id&area_id=$area_id&item_id=$item_id");