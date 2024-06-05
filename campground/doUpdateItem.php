<?php

require_once("../db_connect.php");

if(!isset($_POST["item_id"])){
    echo "請循正常管道進入此頁";
    exit;
}

$camp_id = $_GET["camp_id"];
$area_id = $_GET["area_id"];
$item_id = $_GET["item_id"];


$item_ame = $_POST["item_name"];
$status = $_POST["status"];
$itemPrice = $_POST["itemPrice"];
$pic_name=$_FILES["file"]["name"];

$path = "./upload/$pic_name";

if($_FILES["file"]["error"]==0){
    if(move_uploaded_file($_FILES["file"]["tmp_name"], "./upload/".$_FILES["file"]["name"])){
        echo "upload success";
    }else{
        echo "upload failed";
    }
}


if(empty($pic_name)){
    echo "請上傳圖片";
    header("location: edit_item.php?camp_id=$camp_id&area_id=$area_id&item_id=$item_id");
    exit;
}



$sql="UPDATE area_item SET item_name='$item_ame', price= '$itemPrice', path= '$path' WHERE id=$item_id";

// echo $sql;

if($conn->query($sql)===TRUE){
    echo "更新成功";
}else {
    echo "更新資料錯誤: ".$conn->error;
}

$sql="UPDATE camp_area_item SET status='$status' WHERE item_id=$item_id";

if($conn->query($sql)===TRUE){
    echo "更新成功";
}else {
    echo "更新資料錯誤: ".$conn->error;
}


header("location: edit_item.php?camp_id=$camp_id&area_id=$area_id&item_id=$item_id");

$conn->close();