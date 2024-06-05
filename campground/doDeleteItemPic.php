<?php
require_once("../db_connect.php");

if(!isset($_GET['item_id'])){
    echo "請循正常管道進入此頁";
    exit;
}

$camp_id = $_GET["camp_id"];
$area_id = $_GET["area_id"];
$item_id= $_GET['item_id'];

// echo $decode_id;

$sql="UPDATE area_item SET path='' WHERE id=$item_id";



if ($conn->query($sql) === TRUE) {
    echo "刪除成功";
} else {
    echo "刪除資料錯誤: " . $conn->error;
}

header("location: edit_item.php?camp_id=$camp_id&area_id=$area_id&item_id=$item_id");