<?php
require_once("../db_connect.php");

if(!isset($_GET['img_id'])){
    echo "請循正常管道進入此頁";
    exit;
}

$camp_id = $_GET["camp_id"];
$img_id=$_GET["img_id"];

$sql="DELETE FROM images WHERE id = $img_id";


if ($conn->query($sql) === TRUE) {
    echo "刪除成功";
} else {
    echo "刪除資料錯誤: " . $conn->error;
}

header("location: cg_img_upload.php?camp_id=$camp_id");